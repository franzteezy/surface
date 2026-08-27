<?php

namespace App\Http\Controllers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Providers\TenantModel;
use App\Models\ChatRequest;
use App\Providers\Tenant;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Date;

class SocketController extends Controller implements MessageComponentInterface
{
    protected $clients;
    protected $user;
    protected $req;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
         // Store the new connection to send messages to later
        $this->clients->attach($conn);
         $headerArray = $conn->httpRequest->getHeaders();
         $header = $headerArray['Origin'];
         $origin = $header[0];
         $origin = explode('://', $origin)[1];
         $tenant_url = explode('.', $origin)[0];
         $querystring = $conn->httpRequest->getUri()->getQuery();
         parse_str($querystring, $queryarray);
         if(isset($queryarray['token']))
         {  
            $tenant = TenantModel::query()->where('tenant', $tenant_url)->first();
            Tenant::setTenantConnection($tenant);
            $token = $queryarray['token'];
            User::where('token', $token)->update([ 'connection_id' => $conn->resourceId, 'user_status' => 'Online' ]);
            $user = User::query()->where('token', $token)->first();

            $data['id'] = $user->id;
            $data['status'] = 'Online';

            foreach($this->clients as $client)
            {
                if($client->resourceId != $conn->resourceId)
                {
                    $client->send(json_encode($data));
                }
            }
         }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');



        $data = json_decode($msg);
        
        if(isset($data->type))
        {
            if($data->type == 'request_load_unconnected_user')
            {
                $user_data = User::select('id', 'first_name', 'last_name', 'user_status')
                                    ->where('id', '!=', $data->from_user_id)
                                    ->orderBy('first_name', 'ASC')
                                    ->get();

                $sub_data = array();

                foreach($user_data as $row)
                {
                    $sub_data[] = array(
                        'name'      =>  $row['first_name'] . ' ' . $row['last_name'],
                        'id'        =>   $row['id'],
                        'status'    =>  $row['user_status'],
                        // 'user_image'=>  $row['user_image']
                    );
                }

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                $send_data['data'] = $sub_data;

                $send_data['response_load_unconnected_user'] = true;

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $client->send(json_encode($send_data));
                    }
                }
            }
            if($data->type == 'request_search_user')
            {
                $user_data = User::select('id', 'first_name', 'user_status', 'user_image')
                                    ->where('id', '!=', $data->from_user_id)
                                    ->where('name', 'like', '%'.$data->search_query.'%')
                                    ->orderBy('name', 'ASC')
                                    ->get();

                $sub_data = array();

                foreach($user_data as $row)
                {

                    $chat_request = ChatRequest::select('id')
                                    ->where(function($query) use ($data, $row){
                                        $query->where('from_user_id', $data->from_user_id)->where('to_user_id', $row->id);
                                    })
                                    ->orWhere(function($query) use ($data, $row){
                                        $query->where('from_user_id', $row->id)->where('to_user_id', $data->from_user_id);
                                    })->get();

                    /*
                    SELECT id FROM chat_request 
                    WHERE (from_user_id = $data->from_user_id AND to_user_id = $row->id) 
                    OR (from_user_id = $row->id AND to_user_id = $data->from_user_id)
                    */

                    if($chat_request->count() == 0)
                    {
                        $sub_data[] = array(
                            'name'  =>  $row['name'],
                            'id'    =>  $row['id'],
                            'status'=>  $row['user_status'],
                            'user_image' => $row['user_image']
                        );
                    }

                    
                }

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                $send_data['data'] = $sub_data;

                $send_data['response_search_user'] = true;

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'request_chat_user')
            {
                $chat_request = new ChatRequest();

                $chat_request->from_user_id = $data->from_user_id;

                $chat_request->to_user_id = $data->to_user_id;

                $chat_request->status = 'Pending';

                $chat_request->save();

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['response_from_user_chat_request'] = true;

                        $client->send(json_encode($send_data));
                    }

                    if($client->resourceId == $receiver_connection_id[0]->connection_id)
                    {
                        $send_data['user_id'] = $data->to_user_id;

                        $send_data['response_to_user_chat_request'] = true;

                        $client->send(json_encode($send_data));
                    }
                }
            }
            if($data->type == 'request_unread_msgs'){
                $chat_data = Chat::select('id', 'from_user_id', 'to_user_id')->where('message_status', '!=', 'Read')->where('to_user_id', $data->from_user_id)->get();

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get(); //send number of unread message

                if($chat_data->count() > 0){
                    $send_data['response_unread_msgs'] = true;
                    $send_data['total_unread'] = $chat_data->count();
                }else{
                    $send_data = [];
                }

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'request_load_unread_notification')
            {
                $notification_data = ChatRequest::select('id', 'from_user_id', 'to_user_id', 'status')
                                        ->where('status', '!=', 'Approve')
                                        ->where(function($query) use ($data){
                                            $query->where('from_user_id', $data->user_id)->orWhere('to_user_id', $data->user_id);
                                        })->orderBy('id', 'ASC')->get();

                /*
                SELECT id, from_user_id, to_user_id, status FROM chat_requests
                WHERE status != 'Approve'
                AND (from_user_id = $data->user_id OR to_user_id = $data->user_id)
                ORDER BY id ASC
                */

                $sub_data = array();

                foreach($notification_data as $row)
                {
                    $user_id = '';

                    $notification_type = '';

                    if($row->from_user_id == $data->user_id)
                    {
                        $user_id = $row->to_user_id;

                        $notification_type = 'Send Request';
                    }
                    else
                    {
                        $user_id = $row->from_user_id;

                        $notification_type = 'Receive Request';
                    }

                    $user_data = User::select('first_name')->where('id', $user_id)->first();

                    $sub_data[] = array(
                        'id'            =>  $row->id,
                        'from_user_id'  =>  $row->from_user_id,
                        'to_user_id'    =>  $row->to_user_id,
                        'name'          =>  $user_data->name,
                        'notification_type' =>  $notification_type,
                        'status'           =>   $row->status,
                        // 'user_image'    =>  $user_data->user_image
                    );
                }

                $sender_connection_id = User::select('connection_id')->where('id', $data->user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['response_load_notification'] = true;

                        $send_data['data'] = $sub_data;

                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'request_process_chat_request')
            {
                ChatRequest::where('id', $data->chat_request_id)->update(['status' => $data->action]);

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get();

                foreach($this->clients as $client)
                {
                    $send_data['response_process_chat_request'] = true;

                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['user_id'] = $data->from_user_id;
                    }

                    if($client->resourceId == $receiver_connection_id[0]->connection_id)
                    {
                        $send_data['user_id'] = $data->to_user_id;
                    }
                    $client->send(json_encode($send_data));
                }
            }

            if($data->type == 'request_connected_chat_user')
            {
                $condition_1 = ['from_user_id' => $data->from_user_id, 'to_user_id' => $data->from_user_id];

                $user_id_data = ChatRequest::select('from_user_id', 'to_user_id')
                                            ->orWhere($condition_1)
                                            ->where('status', 'Approve')
                                            ->get();

                /*
                SELECT from_user id, to_user_id FROM chat_requests 
                WHERE (from_user_id = $data->from_user_id OR to_user_id = $data->from_user_id) 
                AND status = 'Approve'
                */

                $sub_data = array();

                foreach($user_id_data as $user_id_row)
                {
                    $chat_data = Chat::select('id', 'from_user_id', 'to_user_id', 'chat_message', 'message_status', 'created_at')
                    ->where(function($query) use ($user_id_row){
                        $query->where('from_user_id', $user_id_row->from_user_id)->where('to_user_id', $user_id_row->to_user_id);
                    })
                    ->orWhere(function($query) use ($user_id_row){
                        $query->where('from_user_id', $user_id_row->to_user_id)->where('to_user_id', $user_id_row->from_user_id);
                    })->orderBy('id', 'DESC')->first();

                    $dir = "";
                    $lastMessage = "";
                    $messageStatus = "";
                    $chat_timestamp = "";
                    if($chat_data != null){
                        $lastMessage = Crypt::decryptString($chat_data->chat_message);
                        $messageStatus = $chat_data->message_status;
                        $chat_timestamp = $chat_data->created_at;
                        if($chat_data->from_user_id == $data->from_user_id){
                            $dir = 'out';
                        }else{
                            $dir = 'in';
                        }
                    }


                    $user_id = '';

                    if($user_id_row->from_user_id != $data->from_user_id)
                    {
                        $user_id = $user_id_row->from_user_id;
                    }
                    else
                    {
                        $user_id = $user_id_row->to_user_id;
                    }

                    $user_data = User::select('id', 'first_name', 'last_name', 'user_status', 'updated_at')->where('id', $user_id)->first();

                    if(date('Y-m-d') == date('Y-m-d', strtotime($user_data->updated_at)))
                    {
                        $last_seen = date('H:i', strtotime($user_data->updated_at));
                    }
                    else
                    {
                        $last_seen = date('m.d.Y', strtotime($user_data->updated_at));
                    }

                    $sub_data[] = array(
                        'id'    =>  $user_data->id,
                        'name'  =>  $user_data->first_name . " " . $user_data->last_name,
                        'last_message' => $lastMessage,
                        'chat_timestamp' => $chat_timestamp,
                        'message_status' => $messageStatus,
                        'direction' => $dir,
                        // 'user_image'    =>  $user_data->user_image,
                        'user_status'   =>  $user_data->user_status,
                        'last_seen'     =>  $last_seen
                    );
                }

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['response_connected_chat_user'] = true;

                        $send_data['data'] = $sub_data;

                        $client->send(json_encode($send_data));
                    }
                }
            }
            if($data->type == 'request_send_message')
            {
                //save chat message in mysql

                $chat = new Chat;

                $chat->from_user_id = $data->from_user_id;

                $chat->to_user_id = $data->to_user_id;
                $text = Crypt::encryptString($data->message);
                echo($text);
                $chat->chat_message = $text;

                $chat->message_status = 'Not Send';

                $chat->save();

                $chat_message_id = $chat->id;

                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get();

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $receiver_connection_id[0]->connection_id || $client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['chat_message_id'] = $chat_message_id;
                        
                        $send_data['message'] = $data->message;

                        $send_data['from_user_id'] = $data->from_user_id;

                        $send_data['to_user_id'] = $data->to_user_id;
                        $send_data['created_at'] = $chat->created_at;

                        if($client->resourceId == $receiver_connection_id[0]->connection_id)
                        {
                            Chat::where('id', $chat_message_id)->update(['message_status' =>'Send']);

                            $send_data['message_status'] = 'Send';
                        }
                        else
                        {
                            $send_data['message_status'] = 'Not Send';
                        }
                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'request_chat_history')
            {
                $chat_data = Chat::select('id', 'from_user_id', 'to_user_id', 'chat_message', 'message_status', 'created_at', 'updated_at')
                                    ->where(function($query) use ($data){
                                        $query->where('from_user_id', $data->from_user_id)->where('to_user_id', $data->to_user_id);
                                    })
                                    ->orWhere(function($query) use ($data){
                                        $query->where('from_user_id', $data->to_user_id)->where('to_user_id', $data->from_user_id);
                                    })->orderBy('id', 'ASC')->get();
                foreach($chat_data as $chat){
                    $chat->chat_message = Crypt::decryptString($chat->chat_message);
                }
                $send_data['chat_history'] = $chat_data;
                $send_data['to_user_id'] = $data->to_user_id;
                $receiver_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $receiver_connection_id[0]->connection_id)
                    {
                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'update_chat_status')
            {
                //update chat status

                Chat::where('id', $data->chat_message_id)->update(['message_status' => $data->chat_message_status]);

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get();

                foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_connection_id[0]->connection_id)
                    {
                        $send_data['to_user_id'] = $data->to_user_id;
                        $send_data['update_message_status'] = $data->chat_message_status;

                        $send_data['chat_message_id'] = $data->chat_message_id;

                        $client->send(json_encode($send_data));
                    }
                }
            }

            if($data->type == 'check_unread_message')
            {
                $chat_data = Chat::select('id', 'from_user_id', 'to_user_id')->where('message_status', '!=', 'Read')->where('from_user_id', $data->to_user_id)->get();

                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get(); //send number of unread message

                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get(); //send message read status
            
                $num = 1;
                foreach($chat_data as $row)
                { 
                    $hasUnread = false;
                    if($row->to_user_id == $data->from_user_id){
                        Chat::where('id', $row->id)->update(['message_status' => 'Send']);
                        $hasUnread = true;
                    }
                    foreach($this->clients as $client)
                    {
                        if($client->resourceId == $sender_connection_id[0]->connection_id && $hasUnread)
                        {
                            $send_data['count_unread_message'] = 1;

                            $send_data['chat_message_id'] = $row->id;

                            $send_data['from_user_id'] = $row->from_user_id;

                            $send_data['update_message_status'] = 'Send';

                            $send_data['unread_msg'] = 1;

                            $client->send(json_encode($send_data));
                        }

                        // if($client->resourceId == $receiver_connection_id[0]->connection_id)
                        // {

                        //     $send_data['chat_message_id'] = $row->id;

                        //     $send_data['to_user_id'] = $row->to_user_id;

                        //     $send_data['from_user_id'] = $row->from_user_id;
                        // }
                    }
                }
            }

            if($data->type == 'typing'){
                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get(); //send message read status
                foreach($this->clients as $client)
                {
                    if($client->resourceId == $receiver_connection_id[0]->connection_id){
                        $send_data['typing'] = true;
                        $send_data['from_user_id'] = $data->from_user_id;
                        $client->send(json_encode(($send_data)));
                    }
                }
            }
            if($data->type == 'read_msgs'){

                $chat_data = Chat::select('id', 'from_user_id', 'to_user_id')->where('message_status', '!=', 'Read')->where('from_user_id', $data->to_user_id)->get();
                $sender_connection_id = User::select('connection_id')->where('id', $data->from_user_id)->get(); //send number of unread message
                $receiver_connection_id = User::select('connection_id')->where('id', $data->to_user_id)->get(); //send message read status
                foreach($chat_data as $row)
                {
                    if($row->to_user_id == $data->from_user_id){
                        Chat::where('id', $row->id)->update(['message_status' => 'Read']);
                    }
                    foreach($this->clients as $client)
                    {
                        if($client->resourceId == $receiver_connection_id[0]->connection_id)
                        {
                            $send_data['to_user_id'] = $row->to_user_id;
                            $send_data['update_message_status'] = 'Read';
                            $send_data['chat_message_id'] = $row->id;
                            $client->send(json_encode($send_data));
                        }
                    }
                }
            }
        }
        // foreach ($this->clients as $client) {
        //     if ($from !== $client) {
        //         // The sender is not the receiver, send to each client connected
        //         $client->send($msg);
        //     }
        // }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        User::where('connection_id', $conn->resourceId)->update(['user_status' => 'Offline' ]);
        $user = User::query()->where('connection_id', $conn->resourceId)->first();
        $send_data['status'] = 'Offline';
        $send_data['id'] = $user->id;
        foreach($this->clients as $client)
        {
            if($client->resourceId != $conn->resourceId)
            {
                $client->send(json_encode($send_data));
            }
        }
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
