<template>
    <Base class="base-view">
            <Row class="main-row">
                <Column w2 centerv class="mailer-nav">
                    <Wrapper center class="rect">
                        <Row class="side-nav-row">
                            <Column class="new-msg" w12 centerv centerh >

                            <P @click="show=true, nmHide=false, nmMaximize=false" center xl semibold class="icon icon-send">&nbsp; &nbsp; New message</P>
                           
                            </Column>
                        </Row>
                        <Row class="side-nav-row" v-for="(item) in side_nav">
                            <Column w12 centerv centerh>
                                <RouterLink :to="item.route" :class="{partial:isActive(item.route)}" >
                                    <Button class="nav-btn" small :icon="item.icon">&nbsp; &nbsp;{{item.str}}</Button>
                                </RouterLink>
                            </Column>
                        </Row>
                        <Row class="nav-spacer">  

                        </Row>
                        <Row class="side-nav-row" v-for="(item) in side_nav_sub">
                            <Column w12 centerv centerh>
                                <RouterLink :to="item.route" :class="{partial:isActive(item.route)}" >
                                    <Button class="nav-btn" small :icon="item.icon">&nbsp; &nbsp;{{item.str}} 
                                    <div v-if="item.str == 'Chats' && usr.socketNotif > 0" class="unread-badge">
                                        <P bold class="unread-count">{{usr.socketNotif}}</P></div></Button>
                                </RouterLink>
                            </Column>
                        </Row>
                        <Row>
                            <div class="divider"></div>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv>
                                <P overline class="side-nav-label">LABELS</P>
                            </Column>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv centerh>
                                    <Button class="nav-btn nav-btn-priv" small icon="pipe">&nbsp; &nbsp;Private</Button>
                            </Column>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv centerh>
                                    <Button class="nav-btn nav-btn-work" small icon="pipe">&nbsp; &nbsp;Work</Button>
                            </Column>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv centerh>
                                    <Button class="nav-btn nav-btn-imp" small icon="pipe">&nbsp; &nbsp;Important</Button>
                            </Column>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv centerh>
                                    <Button class="nav-btn nav-btn-rec" small icon="pipe">&nbsp; &nbsp;Recruiting</Button>
                            </Column>
                        </Row>
                        <Row>
                            <div class="divider"></div>
                        </Row>
                        <Row class="side-nav-row">
                            <Column w12 centerv>
                                <P overline class="side-nav-label">CONTACTS</P>
                            </Column>
                        </Row>
                    </Wrapper>
                </Column>
                <Column class="mailer-list">
                        <Row class="mailer-row">
                            <router-view></router-view>
                            <Wrapper nm v-if="show" class="new-message">
                                <NewMessage v-model:content="content" @hide="hideWindow" @maximize="maximizeWindow" @close="closeWindow" :title="mailer.subject ? mailer.subject : 'New Message'"></NewMessage>
                            </Wrapper>
							<Wrapper nm v-if="nmHide" class="nm-minimize">
								<Row class="nm-row">
									<Column w10 centerv>
										<P xl semibold>{{mailer.subject ? mailer.subject : 'New Message'}}</P>
									</Column>
									<Column w3 end centerv>
										<div class="nm-flex">
											<i class="icon icon-hide-window" @click="minimizeWindow"></i>
											<i class="icon icon-maximize" @click="maximizeWindow"></i>
											<i class="icon icon-clear" @click="nmHide=false"></i>
										</div>
									</Column>
                                </Row>
							</Wrapper>
							<NewMessageModal v-if="nmMaximize" v-model:content="content" :show="nmMaximize" @close="closeWindow" @hide="hideWindow" @minimize="minimizeWindow" :title="mailer.subject ? mailer.subject : 'New Message' "></NewMessageModal>
                        </Row>
                </Column>
            </Row>
    </Base>
</template>
<script>
export default {
    props:{
        content: {Type: Array, default: ['Try me! Here is some <strong>contenteditable</strong> &lt;div&gt; for the demo.']},
    },
    watch:{
        $route:{
            Immediate: true,
            Deep:true,
            Hander(){
                this.$forceUpdate;
            }
        }
    },
    computed: {
        usr() {
                return window.store.auth;
        },
        mailer(){
            return window.store.mailer.single
        }
    },
    data() {
        return {
            // content: ['Try me! Here is some <strong>contenteditable</strong> &lt;div&gt; for the demo.'],
			nmContent:'',
			nmRecipient: '',
			nmSubject: '',
			nmMaximize:false,
			nmHide:	false,
			fontList: [{
				label:"test",
				value:"test"
			}],
            formatText:false,
            side_nav: {
                0: 
                {
                    str: 'Inbox',
                    icon: 'inbox',
                    route: '/mailer/inbox-list'
                },
                1: {
                    str: 'Draft',
                    icon: 'edit',
                    route: '/mailer/draft'
                },
                2: {
                    str: 'Sent',
                    icon: 'mail',
                    route: '/mailer/sent'
                },
                3: {
                    str: 'Deleted',
                    icon: 'trash',
                    route: '/mailer/deleted'
                },
            },
            side_nav_sub: {
                0: 
                {
                    str: 'Chats',
                    icon: 'chat',
                    route: '/mailer/chats'
                },
                1: {
                    str: 'Favorites',
                    icon: 'favorite',
                    route: '/mailer/favorites'
                },
            },
            show:  false
            };
    },
    methods: {
        hideWindow(e){
            this.show = false;
            this.nmMaximize = false;
            this.nmHide = e;
        },
        maximizeWindow(e){
            this.show = false;
            this.nmHide = false;
            this.nmMaximize = e;
            console.log(this.mailer);
        },
        closeWindow(){
            this.show = false;
            this.nmHide = false;
            this.nmMaximize = false;
        },
        minimizeWindow(e){
            this.show = e;
            this.nmHide = false;
            this.nmMaximize = false;
        },
        isActive(route){
            return this.$route.path.includes(route);
        },
        hasUnreadNotif(str){
          if(str == "Chats" && this.usr.socketNotif > 0){
            return true;
          }

          return false;
        },
        showModal(){
            this.show = true;
        },
        format(){
            if(this.formatText){
                this.formatText = false;
            }else{
                this.formatText = true;
            }
        },
		browseFile(){
			this.$refs.fileBrowse.click();
		},
		browsePhoto(){
			this.$refs.photoBrowse.click();
		}
    },
    mounted() {
        console.log(this.usr);
        window.mitt.emit("page_loaded");
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
:deep(.base-view){
    position:relative !important;
    height: 100vh !important;
    min-width:1280px;
    overflow: hidden !important;
    .wrapper{
        // position: relative !important;
        height: 100% !important;
        overflow: hidden;
    }
}
.mailer-row{
    height: 100%;
    position: relative;
}
    .main-row{
    position:relative;
    height: 100%;
    overflow: hidden;
}
.left{
    min-width: 550px;
    
    .logo{
        height: 88px;
        border-bottom: 1px solid $gray-L2;

        img{
            margin: 0 $padding;
        }
    }

    .full{
        height: calc(100% - 120px);
        margin-bottom: 120px;

    .divider{
            margin-right: $padding;
        }

        .thirty{
            margin-bottom: 30px;
        }
    }
}

.right{
    background-image: url('/src/assets/images/register.jpg');
    background-size: cover;
    background-position: right;
    background-color: $brand-L2;
    height: 100vh;

    .floater{
        margin-left: 8%;
        margin-top: 18%;

        p{
            margin-bottom: 12px;
            font-style: normal;
            font-weight: 300;
        }

        h2{
            line-height: 40px;
        }
    }
}
.mailer-nav{
    height: 100%;
    margin: 0px;
}
.rect{
box-sizing: border-box;
padding: 0px;
// width: 222px;
height: 100%;
margin:0px;
left: 0px;
border-right: 1px solid rgba(229, 233, 237, 0.6);   
background: linear-gradient(0deg, #FAFBFF, #FAFBFF), linear-gradient(0deg, rgba(250, 251, 252, 0.7), rgba(250, 251, 252, 0.7)), #FFFFFF;
    
    .new-msg{
            P{
        cursor: pointer;
        }
        }
        a{
            text-decoration: none;
        &.router-link-active, &.partial{
            :deep(.nav-btn){
                background-color: $brand;
                box-shadow: 0 1px 3px rgba(85, 66, 246, 0.3), 0 4px 8px rgba(85, 66, 246, 0.2);
                p{
                    color: #FFFFFF !important;
                }
                i{
                    color: #FFFFFF !important;
                }
                .unread-badge{
                    background: #FFFFFF;
                    p{
                        color: black !important;
                    }
                }
            }
        }
    }
}
.new-msg{
    border: 1px solid;

border-color: #E5E9ED99;

border-image-source: GrayLight/Gray L2 - #E5E9ED (form stroke, lines, borders);
box-sizing: border-box;
width: 222px;
height: 48px;
left: 0px;
top: 1px;
/* White */
background: #FFFFFF;
}

:deep(.nav-btn){
width: 180px;
height: 40px !important;
left: 16px;
top: 72px;
border-radius: 44px;
box-shadow: none;
background-color: transparent;
border: 0px !important;
        i{
            color: $gray-D2;
            transition: $transition;
        }
        p{
            color: $gray-D2;
            font-weight: 500;
        }

        &:hover{
            box-shadow: none;
            border: none;
            background-color: transparent;
            i{
                color: $gray-D3;
            }
            p:not(.unread-count){
                color: $gray-D3;
            }
        }
}

.mailer-list{
    height: 100%;
    position: relative;

}
.nav-spacer{
    height: 30px;
}
.side-nav-row{
    margin-bottom:  0px;
}
.divider{
width: 222px;
height: 1px;
left: 0px;
top: 472px;
border: 1px solid rgba(229, 233, 237, 0.6);
margin-top: 20px;
margin-bottom: 10px;
transform: matrix(1, 0, 0, -1, 0, 0);
}
.side-nav-label{
    margin-left: 45px;
    margin-bottom: 5px;
    cursor:default;
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 500;
        font-size: 11px;
        line-height: 16px;
        /* identical to box height, or 145% */
        letter-spacing: 1.5px;
        text-transform: uppercase;

        /* GrayDark/Gray - #98A8B7 (placeholder text, icons ) */
        color: #98A8B7;
}
:deep(.nav-btn-priv){
    height: 32px !important;
    P{
        i{
            color: #0ECFC4;
        }
    }
}
:deep(.nav-btn-work){
    height: 32px !important;
    P{
        i{
            color: #F79F24;
        }
    }
}
:deep(.nav-btn-imp){
    height: 32px !important;
    P{
        i{
            color: #E8178A;
        }
    }
}
:deep(.nav-btn-rec){
    height: 32px !important;
    P{
        i{
            color: #9D72D3;
        }
    }
}
#side-nav-menu{
    position: sticky;
    height: 100%;
    width: 100%;
}
.new-message{
    height: 75vh;
    width: 40vw;
    min-width: 550px;
    position: fixed;
    bottom: 0;
    right: 24px;
    border-radius: 16px 16px 0px 0px;
    border: 1px solid #E5E9ED99;
    box-shadow: 0px 6px 12px 8px rgba(0, 0, 0, 0.104);
    background-color: #FFFFFF;
}
:deep(.nm-row){
        margin-bottom:0px;
        height: 48px;
        border-radius: 16px 16px 0px 0px;

        &:first-child{
        border-bottom: 1px solid #E5E9ED99;
        background: linear-gradient(0deg, #FAFBFF, #FAFBFF), 
        linear-gradient(0deg, rgba(250, 251, 252, 0.7),
         rgba(250, 251, 252, 0.7)), #FFFFFF;
        }
        &:last-child{
            border-bottom: 0px;
        }
        .w10{
            padding-left: 16px;
        }
        .w3{
            padding-right: 16px;
        }
        .nm-flex{
            display: inline-flex;

            i{
                cursor: pointer;
                margin-right: 10px;
                color: $gray-D1;
                &:last-child{
                    margin-right: 0px;
                }
                   &:hover{
                color: $gray-D3;
                }
              
            }
        }
    
    }

:deep(.nm-rec){
        width: 95%;
        display: inline;
        border-radius: 0px;
        border:0px;
        .field{
            border:0px;
        	border-radius: 0px;
        	border-bottom: 1px solid #cfcfcf;
			box-shadow: none;
            input{
	            padding: 0px;
            }
            i{
                line-height: 1;
            }
			&:hover{
				border:0px;
        		border-bottom: 1px solid #cfcfcf;
				box-shadow:none;
			}
			&.focus{
				border:0px;
        		border-bottom: 1px solid #cfcfcf;
				box-shadow: none;
			}
        }
    }
.nm-textarea{
	height: 327px !important;
}
:deep(.nm-content){
		height: 100%;
		 .field{

			height: 100%;
			max-height: 327px;
            border-radius: 0%;
            border:0px; 
			box-shadow: none;
            i{
                line-height: 1;
            }
			&:hover{
				border:0px;
				box-shadow:none;
			}
			&.focus{
				border:0px;
				box-shadow: none;
			}
        }
	}
:deep(.nm-tool){
	height: 54px;
	margin-bottom: 0px;
	margin-top:10px;
	.w3{
		margin-left: 16px;
		margin-right: 0px;
	}
	.w1{
		margin-right: 16px;
	}
	.nm-send{
	height: 36px;
	border-radius: 44px;
	}
	
}
	.nm-tool-flex{
		display: inline-flex;
		align-items: center;
		.ico{
		cursor: pointer;
		margin-right: 10px;
		color: $gray-D1;
		line-height: 0.5;
		font-size: 20px;
		&:last-child{
			margin-right: 0px;
		}
			&:hover, &.active{
		color: $gray-D3;
		}
    }
		.icon-nm{
				margin-right: 0px !important;	
			}
		.icon-double-carret-down{
			line-height: 2.0 !important;
			margin-right: 0px !important;
		}
}
.nm-formatter{
    position:fixed;
    margin-left: 16px !important;
    margin-right: 16px !important;
    width: 510px;
    height: 36px;
    border: none;
    bottom: 72px;
    border-radius: 16px;
    box-shadow: 0px 4px 5px 0px rgba(0,0,0,.14),0px 1px 10px 0px rgba(0,0,0,.12),0px 2px 4px -1px rgba(0,0,0,.2);
	.nm-toolbar{
		height: 100%;
		padding: 12px 12px;
	}
		.toolbar-div{
		width: 1px;
		height: 20px;
		border-left: 1px solid #cfcfcf ;
		margin-right: 10px;
		
	}
}
.nm-minimize{
	height: 40px;
    width: 260px;
    position: fixed;
    bottom: 0;
    right: 24px;
    border-radius: 16px 16px 0px 0px;
    border: 1px solid #E5E9ED99;
    box-shadow: 0px 6px 12px 8px rgba(0, 0, 0, 0.104);
    background-color: #FFFFFF;
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

