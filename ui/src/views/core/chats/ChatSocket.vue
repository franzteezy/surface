<template>

</template>
<script>
import moment from 'moment';
export default {
    computed: {
        userSocket(){
            return window.store.auth;
        },
        user(){
            return window.store.auth.single;
        },
        chat(){
            return window.store.chat.single;
        }
    },
    data(){
        return{
            openChat: false,
            currentIndex: null
        }
    },
    methods: {
        scroll_top()
        {
            this.$nextTick(()=> {
                var contentMsg = document.querySelector("#contentMsg");
                document.querySelector("#contentMsg").scrollTop = contentMsg.scrollHeight
            })
        },
        sortChat(){
            if(this.$route.fullPath.includes("chats")){
                this.chat.conversations.sort(function compare(a, b) {
                    var dateA = new Date(a.chatTimestamp);
                    var dateB = new Date(b.chatTimestamp);
                    return dateB - dateA;
                });
            }
        },
        setCurrentIndex(){
            if(this.$route.fullPath.includes("chats")){
                this.chat.currentIndex = this.chat.conversations.findIndex(x => x.id == this.$route.params.id);
            }
        },
        load_chat_data(from_user_id, to_user_id)
        {
            var data = {
                from_user_id : from_user_id,
                to_user_id : to_user_id,
                type : 'request_chat_history'
            };

            this.userSocket.socket.send(JSON.stringify(data));
        },
        load_unconnected_user(from_user_id)
        {
            var data = {
                from_user_id : from_user_id,
                type : 'request_load_unconnected_user'
            };

            this.userSocket.socket.send(JSON.stringify(data));
        },

        search_user(from_user_id, search_query)
        {
            if(search_query.length > 0)
            {
                var data = {
                    from_user_id : from_user_id,
                    search_query : search_query,
                    type : 'request_search_user'
                };

                this.userSocket.socket.send(JSON.stringify(data));
            }
            else
            {
                this.load_unconnected_user(from_user_id);
            }
        },

        send_request(element, from_user_id, to_user_id)
        {
            var data = {
                from_user_id : from_user_id,
                to_user_id : to_user_id,
                type : 'request_chat_user'
            };

            element.disabled = true;

            this.userSocket.socket.send(JSON.stringify(data));
        },

        load_unread_notification(user_id)
        {
            var data = {
                user_id : user_id,
                type : 'request_load_unread_notification'
            };
            console.log(this.$route.fullPath);
            this.userSocket.socket.send(JSON.stringify(data));
        },
        

        process_chat_request(chat_request_id, from_user_id, to_user_id, action)
        {
            var data = {
                chat_request_id : chat_request_id,
                from_user_id : from_user_id,
                to_user_id : to_user_id,
                action : action,
                type : 'request_process_chat_request'
            };

            this.userSocket.socket.send(JSON.stringify(data));
        },

        load_connected_chat_user(from_user_id)
        {
            var data = {
                from_user_id : from_user_id,
                type : 'request_connected_chat_user'
            };

            this.userSocket.socket.send(JSON.stringify(data));
        },
        close_chat()
        {
            document.getElementById('chat_header').innerHTML = 'Chat Area';

            document.getElementById('close_chat_area').innerHTML = '';

            document.getElementById('chat_area').innerHTML = '';

            to_user_id = '';
        },
        check_unread_message(from_user_id, to_user_id)
        {
                var data = {
                    from_user_id : from_user_id,
                    to_user_id : to_user_id,
                    type : 'check_unread_message'
                };

                this.userSocket.socket.send(JSON.stringify(data));
        },
        update_message_status(chat_message_id, from_user_id, to_user_id, chat_message_status)
        {
            var data = {
                chat_message_id : chat_message_id,
                from_user_id : from_user_id,
                to_user_id : to_user_id,
                chat_message_status : chat_message_status,
                type : 'update_chat_status'
            };
            this.userSocket.socket.send(JSON.stringify(data));
        },
        request_unread_msgs()
        {
            var data = {
                from_user_id : this.user.id,
                type : 'request_unread_msgs'
            };
            this.userSocket.socket.send(JSON.stringify(data));
        }
    },
    created: function(){

        this.userSocket.socket = new WebSocket("wss://chat.stafflify.test:3000/?token=" + this.user.token); 
        this.userSocket.socket.onopen = (e) => {  
            console.log("You are now Online!");
            this.request_unread_msgs();
            this.load_unread_notification(this.fromUserID);
            this.load_connected_chat_user(this.fromUserID);
        };
        var from_user_id = this.user.id;
        this.userSocket.socket.onmessage = (e) => {
        var data = JSON.parse(e.data);
        if(data.status)
        {
           let userIndex = this.chat.conversations.findIndex(x => x.id == data.id);
           this.chat.conversations[userIndex].user_status = data.status;
        }
        if(data.response_load_unconnected_user || data.response_search_user)
        {
            var html = '';
            if(data.data.length > 0)
            {

            }
            else
            {
                html = 'No User Found';
            }
        }
        if(data.response_connected_chat_user){
            if(data.data.length > 0){
                let users = data.data;
                for(var i = 0; i < users.length; i++)
                {
                    this.chat.conversations.push({
                        id: users[i].id,
                        name: users[i].name,
                        messages: [],
                        lastText: users[i].last_message,
                        chatTimestamp: users[i].chat_timestamp,
                        lastSeen: users[i].last_seen,
                        unread: null,
                        user_status: users[i].user_status,
                        direction: users[i].direction,
                        message_status: users[i].message_status,
                        activeWindow: false,
                        hideWindow: false
                    });
                    this.check_unread_message(from_user_id, users[i].id);
                }
            this.sortChat();
            this.setCurrentIndex();
            }
        }

        if(data.message){
        let i = this.chat.conversations.findIndex(x => x.id === data.from_user_id || x.id === data.to_user_id);
        this.chat.conversations[i].lastText = data.message;
        this.chat.conversations[i].chatTimestamp = data.created_at;
        var timestamp = new Date(data.created_at);

        var chatTimestamp = moment(timestamp).format("hh:mm A");
        if(data.from_user_id == from_user_id)
        {
            this.chat.conversations[this.chat.currentIndex].messages.push({
                id: data.chat_message_id,
                msg: data.message,
                direction: "out",
                status: data.message_status,
                chat_timestamp: chatTimestamp
            })
            this.chat.conversations[this.chat.currentIndex].message_status = data.message_status;
            this.chat.conversations[this.chat.currentIndex].direction = "out";
            this.msg = "";
            this.scroll_top();
        }
        else
        {
            let i = this.chat.conversations.findIndex(x => x.id === data.from_user_id)
            this.chat.conversations[i].direction = "in";
            console.log(data.from_user_id)
            console.log(this.$route.params.id)
            console.log(this.chat.conversations[i].activeWindow)
            if(data.from_user_id == this.$route.params.id || (this.chat.conversations[i].activeWindow && !this.chat.conversations[i].hideWindow))
            {
                let typeIndex = this.chat.conversations[i].messages.findIndex(x => x.status === "typing");
                if(typeIndex >=0){
                    this.chat.conversations[i].messages.splice(typeIndex, 1);
                }
                this.chat.conversations[i].messages.push({
                        msg: data.message,
                        direction: "in",
                        status: 'Read',
                        chat_timestamp: chatTimestamp
                })
                this.scroll_top();
                this.update_message_status(data.chat_message_id, data.from_user_id, data.to_user_id, 'Read');
            }
            else
            { 
                this.update_message_status(data.chat_message_id, data.from_user_id, data.to_user_id, 'Send');
                
                this.chat.conversations[i].unread += 1;
                this.userSocket.socketNotif += 1;
                if(!this.$route.fullPath.includes("chats")){
                    if(!this.chat.conversations[i].activeWindow){
                        this.chat.currentIndex = i;
                        this.userSocket.chatBubble = true;
                        this.chat.conversations[i].activeWindow = true;
                        this.load_chat_data(this.user.id, data.from_user_id);
                    }else{
                        this.chat.conversations[i].messages.push({
                                msg: data.message,
                                direction: "in",
                                status: 'Send',
                                chat_timestamp: chatTimestamp
                        })
                    }
                }
            }
        }
        this.sortChat(); 
        this.setCurrentIndex();
        }
        if(data.update_message_status){
            console.log(data);
            var chatIndex = this.chat.conversations.findIndex(x => x.id == data.to_user_id);
            if(chatIndex >= 0){
                this.chat.conversations[chatIndex].message_status = data.update_message_status;
                
                if(this.chat.conversations[chatIndex].activeWindow){
                    let msgIndex = this.chat.conversations[chatIndex].messages.findIndex(x => x.id == data.chat_message_id);
                    if(msgIndex >= 0){
                        this.chat.conversations[chatIndex].messages[msgIndex].status = data.update_message_status;
                    }
                }
            }

            if(data.unread_msg){
                let i = this.chat.conversations.findIndex(x => x.id === data.from_user_id)
                if(i >= 0){
                    this.chat.conversations[i].unread += data.count_unread_message;
                }
                this.sortChat();
                this.setCurrentIndex();
            }
        }

        if(data.chat_history)
        {
            this.chat.currentIndex = this.chat.conversations.findIndex(x => x.id === data.to_user_id);
            this.chat.conversations[this.chat.currentIndex].messages = [];
            this.userSocket.socketNotif -= this.chat.conversations[this.chat.currentIndex].unread
            this.chat.conversations[this.chat.currentIndex].unread = null;
            for(var count = 0; count < data.chat_history.length; count++)
            {
                var dateSpacer = false;
                var chatDate = new Date(data.chat_history[count].created_at);
                var chatDtStr = moment(chatDate).format("YYYY-MM-DD");
                var chatDay = moment(chatDate).format("D");
                var chatMonth = moment(chatDate).format("M");
                var chatYear = moment(chatDate).format("YYYYY");
                //PREVIOUS CHAT DATEs

                var newDate = new Date().toISOString();
                var newDay = moment(newDate).format("D");
                var newDateStr = moment(newDate).format("YYYY-MM-DD");
                let dateStr = "";
                if(chatDtStr < newDateStr){
                    if(Number(newDay) < Number(chatDay)){
                        dateStr = moment(chatDate).format("MMM DD, hh:mm A");
                        let addDate = new Date(chatDate);
                        addDate.setDate(addDate.getDate() + 5);
                        addDate = moment(addDate).format("YYYY-MM-DD");
                        if(addDate > newDateStr){
                            dateStr = moment(chatDate).format("ddd, hh:mm A");
                        }
                    }else{

                        dateStr = moment(chatDate).format("ddd, hh:mm A");

                        if(Number(newDay) - Number(chatDay) > 5){
                            dateStr = moment(chatDate).format("MMM DD, hh:mm A");
                        }
                    }
                }else{
                    dateStr = moment(chatDate).format("hh:mm A");
                }
                if(data.chat_history[count].from_user_id == from_user_id)
                {
                    var icon_style = '';
                    this.chat.conversations[this.chat.currentIndex].messages.push({
                        id: data.chat_history[count].id,
                        msg:data.chat_history[count].chat_message,
                        direction: "out",
                        status: data.chat_history[count].message_status,
                        chat_timestamp: dateStr
                    })
                    this.chat.conversations[this.chat.currentIndex].direction = "out"
                }
                else
                {
                    if(data.chat_history[count].message_status != 'Read')
                    {
                        this.update_message_status(data.chat_history[count].id, data.chat_history[count].from_user_id, data.chat_history[count].to_user_id, 'Read');
                    }
                    this.chat.conversations[this.chat.currentIndex].messages.push({
                        id: data.chat_history[count].id,
                        msg:data.chat_history[count].chat_message,
                        direction: "in",
                        status: data.chat_history[count].message_status,
                        chat_timestamp: dateStr
                    })
                    this.chat.conversations[this.chat.currentIndex].direction = "in"
                }
            }
            this.scroll_top();
        }
        if(data.typing){
            var fromIndex = this.chat.conversations.findIndex(x => x.id == data.from_user_id);
            if(this.$route.params.id == data.from_user_id || (this.chat.conversations[fromIndex].activeWindow && !this.chat.conversations[fromIndex].hideWindow)){
                var typeStat = {
                    id: null,
                    msg:" typing...",
                    direction:"in",
                    status:"typing"
                }
                let index = this.chat.conversations[fromIndex].messages.length - 1
                if(this.chat.conversations[fromIndex].messages[index].status != "typing"){
                    this.chat.conversations[fromIndex].messages.push(typeStat);
                    this.scroll_top();
                    var self = this;
                    setTimeout(function() {
                        let typeIndex = self.chat.conversations[fromIndex].messages.findIndex(x => x.status === "typing");
                        if(typeIndex >= 0){
                            self.chat.conversations[fromIndex].messages.splice(typeIndex, 1);
                            }
                        }, 3000);
                    }
                }
            }
            if(data.response_unread_msgs){
                this.userSocket.socketNotif = data.total_unread; 
            }
        }
    },
    mounted(){
        this.fromUserID = this.user.id;
        // this.toUserID = this.$route.params.id;
        window.mitt.emit("page_loaded");
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

</style>