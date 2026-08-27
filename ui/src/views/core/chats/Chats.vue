<template>
    <Wrapper full class="chat-wrap">
    <Row class="chat-row">
    <Column w4 class="content-rect" v-if="!onBubble">
        <Row class="search-row">
            <Column w12 class="search-col">
            <Input class="convo-search" large icon="search" placeholder="Search conversations"></Input>
            </Column>
        </Row>
        <Wrapper full class="list-row">
            <Row class="row-content" v-for="(item, index) in chat.conversations">
                <Column w12 centerh centerv>
                <RouterLink :to="'/mailer/chats/' + item.id" :class="{routeUser:true, active: isActive(item.id), unread: item.unread}" >
                    <Box class="box-content" @click="view(item.id, index)">
					<div class="hidden-badge" v-if="!isActive(item.id) && !item.unread"></div>
					<div class="unread-badge" v-if="item.unread"></div>
					<div class="active-badge" v-if="isActive(item.id)"></div>
                    <Row>
                        <Column w2 class="avatar-col">
								<div :class="{user:true, 'base-14':true}">
									<Avatar />
								</div>
                        </Column>
                        <Column w8>
                            <P large semibold>{{item.name}}</P>
                            <P large class="content">{{item.lastText}}</P>
                        </Column>
                        <Column w3 end>
                            <P large class="date">{{item.lastSeen}}</P>
                            <div v-if="item.unread" class="read-state-badge">
                                <P large>{{item.unread}}</P>
                            </div>
                            <div v-if="item.message_status && !item.unread && item.direction == 'out'" class="status-badge">
                                <i v-if="item.message_status == 'Not Send'" class="icon icon-chat-send icon-chat-status not-send"></i>
                                <i v-if="item.message_status == 'Send'" class="icon icon-chat-send icon-chat-status"></i>
                                <i v-if="item.message_status == 'Read'" class="icon icon-chat-delivered icon-chat-status"></i>
                            </div>
                        </Column>
                    </Row>
                    </Box>
                    </RouterLink>
                </Column>
            </Row>
        </Wrapper>
    </Column>
    <Column w9 class="content-section" v-if="openChat">
        <ChatMsgs ref="chatMsgs" :fromUserID="fromUserID" :toUserID="toUserID"></ChatMsgs>
    </Column>
    </Row>
    </Wrapper>
</template>
<script>
export default {
    computed: {
        user() {
            return window.store.auth.single;
        },
        userSocket(){
            return window.store.auth;
        },
        mailer(){
          return window.store.mailer;
        },
        chat(){
            return window.store.chat.single;
        }
    },
    data() {
        return{
            eventUUID: null,
            conn: null,
            onBubble: false,
            fromUserID: null,
            toUserID: null,
            newMessage: null,
            messages: [],
            // typing: false,
            username: null,
            ready: false,
            connected: false,
            info: [],
            connections: 0,
			firstLoad:true,
            msg: "",
            routes: "",
            route: "",
            data: null,
            isInboxRoute: false,
            currentIndex: null,
            openChat: false,
            conversations: [] 
        }
    },
    methods: {
        sortChat(){
                this.chat.conversations.sort(function compare(a, b) {
                    var dateA = new Date(a.chatTimestamp);
                    var dateB = new Date(b.chatTimestamp);
                    return dateB - dateA;
                });
        },
        loadContent(id, index){
                this.toUserID = id;
                this.chat.currentIndex = index;
                this.openChat = true;
                this.load_chat_data(this.fromUserID, id);
          },
        view(id, index){
            this.data = null;
            this.chat.conversations[index].activeWindow = true;
            if(this.chat.currentIndex){
                if(index != this.chat.currentIndex){
                    this.chat.conversations[this.chat.currentIndex].activeWindow = false;
                }else{
                    return;
                }
            }
            this.loadContent(id, index);
        },
        isActive(id){
            return this.$route.path.includes('/mailer/chats/' + id);
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
    },
    mounted() {
        this.fromUserID = this.user.id;
        this.userSocket.chatBubble = false;
        this.sortChat();
        window.mitt.emit("page_loaded");
    },
    beforeUnmount(){
        for(let i = 0; i < this.chat.conversations.length; i++){
            this.chat.conversations[i].activeWindow = false;
        }
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.chat-wrap{
    height: 100%;
    position: relative;
    overflow: hidden;
}
.chat-row{
    height: 100%;
    position: relative;
}

:deep(.box-content){
    border: 1px solid  rgba(229, 233, 237, 0.6);
    height: 100px;
    width: 100%;
    padding:0px;
    border-radius: 12px;
    box-shadow: 0px 4px 4px 0px #0000000D;
    cursor:pointer;
	.row{
		margin:14px;
	}
	.unread-badge{
            height: 100px;
            width:  3px;
            border-radius: 3px 0px 0px 3px;
            background-color: #6FCF97;
        }
	.hidden-badge{
		height: 100px;
		width:  3px;
		border-radius: 3px 0px 0px 3px;
	}
	.active-badge{
		height: 100px;
		width:  3px;
		border-radius: 3px 0px 0px 3px;
		background-color:rgba(84, 66, 246, 0.6)  !important;
	}

    .read-state-badge{
        height: 24px;
        width: 24px;
        margin-top: 12px;
        background: linear-gradient(0deg, rgba(47, 128, 237, 0.2), rgba(47, 128, 237, 0.2)), #FFFFFF;
        border-radius: 5px;
        .large{
            margin:auto;
            color:#2F80ED;
        }
    }
    .status-badge{
        height: 24px;
        width: 24px;
    }
}
.icon-chat-status{
            text-decoration: none;
            color: #6FCF97;
            &:hover{
                cursor: default;
            }
            &.not-send{
                color: #98A8B7;
            }
        }
.user {
        width: 32px;
        height: 32px;
        margin-right: 10px;
        background-image: url('/src/assets/images/user-base/base-1.png');
        background-size: cover;
        cursor: pointer;

        @for $i from 1 through 37 {
            .base-#{$i} {
                background-image: url('/src/assets/images/user-base/base-#{$i}.png');
            }
        }
    }
.content-detail{
  padding: 12px 32px;
}
.avatar-col{
    margin-right: 10px;
}
.user-name{
    color:#677F95;
}
.content{
    color:#98A8B7;
    display: -webkit-box;
    overflow-x:hidden;
    overflow-y: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    margin-top:12px;
}

:deep(.convo-search){
    width: 100%;
    .field{
        border-radius: 0%;
        i{
            line-height: 1;
        }
    }
}

.content-rect{
    padding: 0px;
    height: 100%;
    border-right: 1px solid rgba(229, 233, 237, 0.6);
    position:relative;
    display: flex;
    flex-direction: column;
    margin:0px;
}
.list-row{
    height: 100%;
    max-height: 100%;
    overflow-y: scroll;
    overflow-x: hidden;

    &::-webkit-scrollbar{
        display: none;
    }
    a{
        text-decoration: none;
         &.router-link-active, &.active{
                :deep(.box-content){
                background-color:rgba(84, 66, 246, 0.06)  !important;
                box-shadow: 0 1px 3px rgba(85, 66, 246, 0.2), 0 4px 8px rgba(85, 66, 246, 0.1);
                }
            
        }
		&.unread{
			:deep(.box-content){
				
                background-color: #6FCF970D !important;
                }
		}
    }
}
.routeUser{
    width: 90%;
}
.row-content{
    margin-bottom: 0px;
    margin-top: 16px;
	// &:last-child{
	// 	margin-bottom: 16px;
	// }
}
.search-row{
    margin-bottom: 0px;
}

.inbox-container{
    display:flex;
}
.content-dtl{
    padding: 0px;
    height: 100%;
    border-bottom: 1px solid rgba(229, 233, 237, 0.6);
    position: relative;
}



.pager{
cursor: pointer;
color: #CBD4DB;
margin-left: 16px;
line-height: 0.5;
}
.page-count{
    margin-left: 20px;
    color: #CBD4DB;
}
.list-switch{
    height: 32px;
    width: 64px;
    border-radius: 8px;
    display: inline-flex;
    border:1px solid #CBD4DB;
    align-items:center;
    position: fixed;
    right:20px;
    }


    :deep(.switch){
    line-height: 0.5;
    margin-left: 6px;
    width:22.4px;
    height: 22.4px;
    padding:0px;
    border-radius: 6px;
    box-shadow: none;
    background-color: transparent;
    p{

        i{
            margin-right: 0px;
            margin-left: 4px;
            color: #98A8B7;
        }
    }
     &:hover{
            box-shadow: none;
            border: none;
            background-color: transparent;
            i{
                color: $gray-D3;
            }
            p{
                color: $gray-D3;
        }
    }
}
.search-col{
    margin:0px;
}
:deep(.detail-header){
    padding: 24px 32px 24px 32px;
    margin-bottom: 0px;
    .col{
        margin-right: 0px;
    }
}
.user-email{
    background: #F5F6F8;
    border-radius: 45px;
    margin-left: 10px;
}
.user-header{
    display: inline-flex;
}
.divider{
    width: 93%;
    margin:auto;
    border: 1px solid rgba(229, 233, 237, 0.6);

}
.detail-header-tools{
    padding: 12px 32px 12px 32px;
    margin-bottom: 0px;
    .header-flex{
        display: inline-flex;
        widows: 100%;
    }
	i{
		cursor: pointer;
		margin-right: 10px;
		color: #CBD4DB;
		&:last-child{
			margin-right: 0px;
		}
	}
}
.content-section{
	height: 100%;
	margin:0;
	position:relative;

    .icon{
        &:hover{
                color: #9ea8af;
            }
    }
}

</style>