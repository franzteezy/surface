<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\App;
use App\Http\Controllers\SocketController;
use App\Providers\Tenant;
use App\Providers\WebSocket;
use Illuminate\Support\Facades\Auth;
use Ratchet\Http\OriginCheck;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //return 0;
        $this->info("Server is Starting...");
        
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketController()
                )
            ),
            3000
        );
        // $server = new App('chat.stafflify.test', 3000, '172.18.0.3');
        // $server->route('/', new SocketController(), array('*'));
        $server->run();
    }
}