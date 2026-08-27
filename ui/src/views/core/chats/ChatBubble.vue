<template>
    <Wrapper v-if="userSocket.chatBubble" nm class="bubble-container">
        <Row>
            <Column v-for="(item, index) in chat.conversations">
                <Wrapper v-if="item.activeWindow" nm class="bubble-col-container">
                    <Wrapper nm v-if="!item.hideWindow" class="bubble-col">
                        <ChatMsgs :fromUserID="user.id" :toUserID="item.id" @hide-bubble="hideWindow(index)" @close-bubble="closeWindow(index)" :isBubble="true"></ChatMsgs>
                    </Wrapper>
                    <Row v-if="item.hideWindow" class="search-row" @click="showWindow(index, item.id)">
                        <Column w12 class="search-col" centerv> 
                            <div :class="{'chat-header':true, unread: chat.conversations[index].unread > 0}">
                                <Row centerv class="user-msg-row">
                                    <Column centerv w8>
                                        <div class="user-activity">
                                            <i class="icon icon-activity-status" :class="{online: chat.conversations[index].user_status == 'Online'}"></i>
                                            <P large semibold >{{chat.conversations[index].name}}</P>
                                            <!-- UNREAD BADGE COUNTER -->
                                            <!-- <div v-if="chat.conversations[index].unread > 0" class="unread-badge">
                                            <P bold class="unread-count">{{chat.conversations[index].unread}}</P></div> -->
                                        </div>
                                    </Column>
                                    <Column centerv w5 end class="user-options">
                                        <div class="user-options">
                                            <i class="icon icon-clear" @click="closeWindow(index)"></i>
                                        </div>
                                    </Column>
                                </Row>
                            </div>
                        </Column>
                    </Row>
                </Wrapper>
            </Column>
        </Row>
    </Wrapper>
</template>
<script>
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
            isBubble: true,
            isHidden: false
        }
    },
    methods: {

        read_msgs(from_user_id, to_user_id){
            var data = {
                from_user_id :  from_user_id,
                to_user_id :    to_user_id,
                type : 'read_msgs'
            };
            this.userSocket.socket.send(JSON.stringify(data));
        },
        hideWindow(index){
           this.chat.conversations[index].hideWindow = true
        }, 
        closeWindow(index){
           this.chat.conversations[index].hideWindow = false
           this.chat.conversations[index].activeWindow = false
        },
        showWindow(index, to_user_id){
           this.chat.conversations[index].hideWindow = false
           this.userSocket.socketNotif -= this.chat.conversations[index].unread 
           this.chat.conversations[index].unread = null
           this.read_msgs(this.user.id, to_user_id);
        }
    },
    mounted(){
            window.mitt.emit('page_loaded');
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.hideMe{
    display: none !important;
}
.bubble-container{
    height: 60vh;
    width: 355px !important;
    min-width: 355px !important;
    display: table;
    padding: 0 !important;
    position: fixed;
    right: 40px;
    bottom: 0;
    .row{
        height: 100%;
    }
    .bubble-col-container{
        width: 355px;
        height: 100%;
        position: relative;
        margin-left: 10px;
        margin-right: 0px;
    }
    .bubble-col{
        width: 100%;
        height: 100%;
        // border: 1px solid #E5E9ED99;
        border-radius: 16px 16px 0px 0px;
        box-shadow: 0px 6px 12px 8px rgba(0, 0, 0, 0.104);
        background-color: #FFFFFF;
    }
}
.search-row{
    margin-right: 0px;
    &:hover{
        cursor: pointer;
    }
}
.search-col{
    margin:0px;
}
.chat-header{
    height: 40px;
    width: 355px;
    position: fixed;
    display: inline-flex;
    bottom: 0;
    border: none;
    background-color: $gray-L2;
    border-radius: 16px 16px 0px 0px;
    padding: 0px 12px;
    align-items:center;
    &.unread{
        background-color: $brand;
        .user-msg-row .col {
            .user-activity p{
                color: $gray-L4;
            }
        .user-options i{
                color: $gray-L4;
                &:hover{
                    color: $gray-L2;
                }
            }
        }
    }
}
.user-msg-row{
    height: 100%;
}

.user-activity{
    display: inline-flex;
    .icon-activity-status{
        line-height: 1.6;
        margin-right: 10px; 
        color: $gray;
        &.online{
            color: #00875A;
        }
    }
    .unread-badge{
        background: #FFFFFF;
        p{
            color: black !important;
        }
    }
}
.user-options{
    display:inline-flex;
    height: auto;
    .icon{
        cursor:pointer;
        color:#222a32;
        line-height: 1;
        font-size: 20px;
        margin-right:12px;
        &:last-child{
            margin-right: 0px;
        }
        &:hover{
            color:#020203;
        }
    }
}
.unread-badge{ 
    height: 19px;
    width: 24px;
    margin-left: 32px;
    display: inline-flex;
    background: $brand;
    border-radius: 9.5px;
    p{
            margin:auto;
            color: #FFFFFF;
    }
}
</style>