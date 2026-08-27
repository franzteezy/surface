<template>
    <Wrapper full>
    <Row>
    <Column w4 class="content-rect">
        <Row class="search-row">
            <Column w12 class="search-col">
            <Input class="mail-search" large icon="search" placeholder="Search in your email"></Input>
            </Column>
        </Row>
        <Wrapper full class="list-row">
            <Row class="row-content" v-for="(item, index) in emails" >
                <Column w12 centerh centerv>
                <RouterLink :to="route + item.id" :class="{active: isActive(item.id), unread: item.unread}" >
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
                        <Column split>
                            <P class="user-name">{{item.name}}</P>
                            <P large semibold class="subject">{{item.subject}}</P>
                            <P class="content">{{item.innerText}}</P>
                        </Column>
                    </Row>
                    </Box>
                    </RouterLink>
                </Column>
            </Row>
        </Wrapper>
    </Column>
    <Column w9 class="content-section">
        <Row class="search-row">
            <Column w12 class="search-col" centerv> 
                <div class="mail-pager">
                    <i class="icon icon-arrow-left pager"></i>
                    <i class="icon icon-arrow-right pager"></i>
                    <P  class="page-count">4/126</P>
                    <i class="icon icon-cog setting"></i>
                    <div class="list-switch">
                    <Button icon="grid" class="switch"></Button>
                    <Button icon="menu-outline"   class="switch"></Button>
                    </div>
                </div>
            </Column>
        </Row>
		<Wrapper full class="content-page">
 		<Row>
            <Column w12 v-if="data">
                <Row class="detail-header">
                    <Column w1>
                        <div :class="{user:true, ['base-10']:true}">
                            <Avatar />
                        </div>
                    </Column>
                    <Column w5>
                        <div class="user-header">
                            <P large semibold>{{data.name}}</P>
                            <P large gray class="user-email">{{data.email}}</P>
                        </div>
                        <P large gray>for Me</P>
                    </Column>
                    <Column w7 end>
                        <P gray large>30. jun. 2021 09.10 (8 days ago)</P>
                    </Column>
                </Row>
                <div class="divider"></div>
                <Row class="detail-header-tools">
                    <Column w2 centerv>
                        <div class="header-flex">
                        <i class="icon icon-folder"></i>
                        <i class="icon icon-warning"></i>
                        </div>
                    </Column>
					<Column end>
					 <div class="header-flex">
                        <i class="icon icon-reply"></i>
                        <i class="icon icon-reply-all"></i>
						            <i class="icon icon-star-outlined"></i>
                        <i class="icon icon-trash"></i>
                        <i class="icon icon-dots-vertical"></i>
                        </div>
					</Column>
                </Row>
                <div class="divider"></div>
				<Row class="content-detail">
					<Column>
					<div v-html="data.content"></div>
					</Column>
				</Row>
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
        user() {
            //    return window.store.auth.single;
        },
        mailer(){
          return window.store.mailer;
        }
    },
    data() {
        return{
			      firstLoad:true,
            routes: "",
            route: "",
            data: null,
            isInboxRoute: false,
            emails: []
        }
    },
    methods: {
        loadContent(id, index){
            this.data = this.emails.find(x => x.id === id);
          },
          view(id, index){
              this.data = null;
              this.loadContent(id, index);
          },
          isActive(id){
            if(!this.isInboxRoute){
              return this.$route.path.includes('/mailer/sent/' + id);
            }
              return this.$route.path.includes('/mailer/inbox-list/' + id);
          },
          assignRoute(){
            if(this.$route.path.includes("inbox")){
              this.isInboxRoute = true;
              this.route = "/mailer/inbox-list/";
            }else{
              this.isInboxRoute = false;
              this.route = "/mailer/sent/";
            }
          },
          loadEmails(){ 
                this.mailer.many.forEach(mail => {
                const div = document.createElement('div');
                div.innerHTML = mail.content;
                this.emails.push({
                id: mail.uuid,
                name: mail.email_to,
                subject: mail.subject,
                content: mail.content,
                email: mail.email_from,
                innerText: div.innerText,
                })
            });
          }
    },
    mounted() {
        this.loadEmails();
	    let index = this.emails.findIndex(x => x.id === this.$route.params.id);
        this.assignRoute();
        this.loadContent(this.$route.params.id, index)
        window.mitt.emit("page_loaded");
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";


:deep(.box-content){
    border: 1px solid  rgba(229, 233, 237, 0.6);
    height: 112px;
width: 335px;
padding:0px;
border-radius: 12px;
box-shadow: 0px 4px 4px 0px #0000000D;
cursor:pointer;

	.row{
		margin:14px;
	}
	.unread-badge{
            height: 112px;
            width:  3px;
            border-radius: 3px 0px 0px 3px;
            background-color: #6FCF97;
        }
	.hidden-badge{
		height: 112px;
		width:  3px;
		border-radius: 3px 0px 0px 3px;
	}
	.active-badge{
		height: 112px;
		width:  3px;
		border-radius: 3px 0px 0px 3px;
		background-color:rgba(84, 66, 246, 0.6)  !important;
	}
}

.user {
        width: 32px;
        height: 32px;
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
    overflow-x:hidden;
    overflow-y:hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    display: -webkit-box;
    -webkit-box-orient: vertical;

}

:deep(.mail-search){
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
height: 90vh;
border-right: 1px solid rgba(229, 233, 237, 0.6);
position:relative;
display: flex;
flex-direction: column;
margin:0px;
}
.list-row{
    max-height: 100%;
    overflow-y: scroll;
    
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
.row-content{
    margin-bottom: 0px;
    margin-top: 16px;
	&:last-child{
		margin-bottom: 16px;
	}
}
.search-row{
    margin-bottom: 0px;
}

.inbox-container{
    display:flex;
}
.content-dtl{
padding: 0px;
height: 90vh;
border-bottom: 1px solid rgba(229, 233, 237, 0.6);
position: relative;
}


.mail-pager{
    height: 48px;
    width: 100%;
    display: inline-flex;
    border:1px solid rgba(229, 233, 237, 0.6);
    align-items:center;
    .icon{
    cursor:pointer;
        line-height: 2.2;
        color: #CBD4DB;
}
}

.icon{
	&:hover{
            color: #9ea8af;
        }
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
.setting{
    position: fixed;
    right: 100px;
    line-height: 0.9 !important;
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
	height: 90vh;
	margin:0;
	position:relative;
}
.content-page{
	max-height: 100%;
	overflow-y: scroll;
}
</style>