<template>
    <Row class="search-row">
            <Column w12 class="search-col" centerv> 
                <div :class="{'chat-header':true, isBubble:isBubble}">
                    <Row centerv class="user-msg-row">
                        <Column centerv w8>
                            <div class="user-activity">
                                <i class="icon icon-activity-status" :class="{online: chat.conversations[chat.currentIndex].user_status == 'Online'}"></i>
                                <P large semibold :class="{isBubble:isBubble}">{{chat.conversations[chat.currentIndex].name}}</P>
                            </div>
                        </Column>
                        <Column centerv w5 end class="user-options">
                            <div :class="{'user-options':true, isBubble:isBubble}">
                                <i v-if="!isBubble" class="icon icon-user-create"></i>
                                <i v-if="!isBubble" class="icon icon-calling"></i>
                                <i v-if="!isBubble" class="icon icon-dots-vertical"></i>
                                <!-- IF CHAT IS OPENED THRU BUBBLE -->
                                <i v-if="isBubble" class="icon icon-hide-window" @click="hideWindow()"></i>
                                <i v-if="isBubble" class="icon icon-clear" @click="closeWindow()"></i>
                            </div>
                        </Column>
                    </Row>
                </div>
            </Column>
        </Row>
        <Wrapper full class="msg-wrap">
            <Row :class="{'msg-row':true, isBubble:isBubble}">
                <Column ref="chatArea" id="contentMsg" class="content-msg">
                        <Row class="msg-row-dtl" v-for="(body, index) in chat.conversations[chat.currentIndex].messages">
                            <Column class="msg-body" :class="{end: body.direction==='out'}">
                                    <Row>
                                        <Column class="msg-in-avatar" w1 v-if="body.direction==='in'">
                                            <div :class="{user:true, 'base-14':tsue}">
                                                <Avatar />
                                            </div>
                                        </Column>
                                        <Column :class="{end: body.direction==='out', isBubble: isBubble}">
                                            <P id="wave" class="msg-in" v-if="body.status == 'typing'">
                                                <span class="dot one"></span>
                                                <span class="dot two"></span>
                                                <span class="dot three"></span>
                                            </P>
                                            <P v-if="body.status != 'typing'" large class="msg" :class="{'msg-in': body.direction === 'in', 'msg-out': body.direction !== 'in'}">{{body.msg}}</P>
                                            <P small class="chat-date">{{body.chat_timestamp}}</P>
                                        </Column>
                                        <Column w1 end v-if="body.direction==='out'">   
                                            <div :class="{user:true, 'base-14':true}">
                                                <Avatar />
                                            </div>
                                            <div class="chat-status" v-if="index == Number(chat.conversations[chat.currentIndex].messages.length - 1) || body.status != 'Read'">
                                                <i v-if="body.status == 'Not Send'" class="icon icon-chat-send icon-chat-status not-send"></i>
                                                <i v-if="body.status == 'Send'" class="icon icon-chat-send icon-chat-status"></i>
                                                <i v-if="body.status == 'Read'" class="icon icon-chat-delivered icon-chat-status"></i>
                                            </div>
                                        </Column>
                                    </Row>
                            </Column>
                        </Row>
                </Column>
            </Row>
            <Row :class="{'input-row':true, isBubble:isBubble}">
                <Column :class="{'input-col':true, inputFocus: focus}" centerv>
                    <div class="input-div">
                        <Input @keyup.enter="send_chat_message()" @keyup="typing" v-model:value="msg" @focus="setFocus" ref="inputRef" :class="{input:true, isBubble:isBubble}" large placeholder="Type a message..."></Input>
                        <i class="icon icon-emoji hide-if-bubble"></i>
                        <i class="icon icon-input-plus hide-if-bubble"></i>
                        <Button class="input-send" small icon="send-2" @click="send_chat_message()"></Button>
                    </div>
		        </Column>
	    	</Row>
        </Wrapper>
</template>
<script>
export default {
    props: {
        // currentIndex: null,
        fromUserID: null,
        toUserID: null,
        isBubble: false
    },
    data(){
        return{
            msg: null,
            focus: false,
            minimizeBubble: false
        }
    },
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
    methods: {
        typing(e){
            if(e.key != "Enter" && e.code.includes("Key")){
                var data = {
                    from_user_id : this.user.id,
                    to_user_id: this.toUserID,
                    type : 'typing'
                };
                this.userSocket.socket.send(JSON.stringify(data));
            }
        },
        scroll_top()
        {
            this.$nextTick(()=> {
                var contentMsg = document.querySelector("#contentMsg");
                document.querySelector("#contentMsg").scrollTop = contentMsg.scrollHeight
            })
        },

        setFocus(e){
			this.focus = e;
		},
        send_chat_message()
        {
            var data = {
                message : this.msg,
                from_user_id : this.fromUserID,
                to_user_id : this.toUserID,
                type : 'request_send_message'
            };
            if(this.msg !== ""){
            this.userSocket.socket.send(JSON.stringify(data));
            this.msg = "";
            }
        },
        hideWindow(){
            if(!this.minimizeBubble){
                this.minimizeBubble = true;
            }else{
                this.minimizeBubble = false;
            }
            this.$emit('hideBubble', this.minimizeBubble);
        },
        closeWindow(){
            this.$emit('closeBubble', true);
        }
    },
    mounted() {
        this.scroll_top();
        window.mitt.emit("page_loaded");
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.search-row{
    margin-bottom: 0px;
}
.search-col{
    margin:0px;
}
.chat-header{
    height: 48px;
    width: 100%;
    position: relative;
    display: inline-flex;
    padding: 0px 24px;
    border:1px solid rgba(229, 233, 237, 0.6);
    align-items:center;
    &.isBubble{
        
        border: none;
        background-color: $brand;
        border-radius: 16px 16px 0px 0px;
        padding: 0px 12px;
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
    .isBubble{
        color: #FFFFFF;
    }
}
.user-options{
    display:inline-flex;
    height: auto;
    .icon{
        cursor:pointer;
        color: $gray-L1;
        line-height: 1;
        font-size: 20px;
        margin-right:24px;
        &:last-child{
            margin-right: 0px;
        }
        &:hover{
            color: $gray;
        }
    }

    &.isBubble{
        .icon{
             color: $gray-L4;
            line-height: 1;
            font-size: 20px;
            margin-right:12px;
            &:hover{
                color: $gray-L1;
            }
            &:last-child{
                margin-right: 0px;
            }
        }
    }
}

.div-msg{
    height: 100%;
}
.content-msg{
    height: 100%;
    position:relative;
	overflow-y: auto;
    overflow-x: hidden;
    &::-webkit-scrollbar{
        display: none;
    }
}

.chat-status{
    padding-top: .25em;
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
.msg-row{
    background: rgba(85, 66, 246, 0.05);
    height: 74vh;
    max-height: 74vh;
    position:relative;
    margin: 0px;
    &.isBubble{
        height: 50vh;
        max-height: 50vh;
    }
}

.msg-row-dtl{
    &:last-child{
        margin-bottom: 8px;
    }
}

.msg-body{
        width:100%;
        padding: 24px 24px 0px 24px;
        display: inline-flex;
		.end{
			margin-right: 0px;
			.user{
				margin-right: 0px;
			}
		}
        .isBubble{
            margin-left: 32px;
            &.end{
                margin-left: 0px;
                margin-right: 32px;
            }
        }
        &.isBubble{
            padding: 12px 12px 0px 12px;
        }
}

.msg{
    width: auto;
	white-space: normal;
    padding: .5em .75em;
/*   margin-bottom: .5em; */
}
.chat-date{
    padding-top: .5em;
    color: #98A8B7;
}
.msg-out {
  background: $brand;
  color: white;
  border-radius: 18px 0px 18px 18px;
  box-shadow: 0px 1px 3px rgba(85, 66, 246, 0.3), 0px 4px 8px rgba(85, 66, 246, 0.2);
}
.msg-in {
  background: #FFFFFF;
  color: black;
  border-radius: 0px 18px 18px 18px;
  box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.12);
        &.user-typing{
            color: #98A8B7;
            font-style: italic;
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
    
.msg-in-avatar{
	margin-right: 0px !important;
}
.input-row{

    background: rgba(85, 66, 246, 0.05);
	position: relative;
    height: 15%;
	// height: 56px;
	padding:15px 24px;
    &.isBubble{
        height: 40px !important;
        padding: 0;
        .input-col{
            height: 100%;
            border-radius: 0;
            border:none;
            .input-div{
                height: 40px;
                .hide-if-bubble{
                    display: none;
                }
                .input-send{
                    height: 40px;
                    width: 40px;
                    border-radius: 0;
                }
            }
        }
    }
}
.input-col{
	background: #FFFFFF;
	border-radius: 16px;
	height:56px;
	border: 1px solid $gray-L2;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
}
.inputFocus{
		border: 1px solid $brand;
		box-shadow: 0 1px 3px #{$brand}4C, 0px 4px 8px #{$brand}33;
	}
:deep(.input){
	width:85%;
	.field{
	border-radius: 16px;
		border: none;
		box-shadow: none;
		&:hover{
			border: none;
			box-shadow: none;
		}
		&.focus{
			border: none;
			box-shadow: none;
		}
	}
    &.isBubble{
        width: 100%;
        height: 100%;
        .field{
            border-radius: 0;
            height: 40px;
        }
    }
}
.input-div{
    display: inline-flex;
    width: 100%;
    vertical-align:middle;
    .icon{
        margin:auto;
        color: $gray-L1;
        font-size: 18px;
        &:hover{
            color: $gray;
            cursor:pointer;
        }
    }
}
:deep(.input-send){
    border-radius: 12px;
    margin: auto;
    width:32px;
    height: 40px !important;
    padding: 0 8px;
    .large{
        font-size: 18px;
        margin:auto;
    }
    p{
        i{
            margin-right: 0;
        }
    }
}

.msg-wrap{
    height: 100%;
    max-height: 100%;
}
#wave{
    width: auto;
    padding: .5em .75em;
}
#wave .dot {
  display: inline-block;
  width: 5px;
  height: 5px;
  border-radius: 50%;
  margin-right: 0.8px;
  background: $brand;
  animation: wave 1s linear infinite;
  animation-delay: -0.9s;
}
#wave .dot.two {
  animation-delay: -0.7s;
}
#wave .dot:nth-child(3) {
  animation-delay: -0.6s;
}

@keyframes wave {
  0%,
	60%,
	100% {
    transform: initial;
  }
  30% {
    transform: translateY(-5px);
  }
}
</style>