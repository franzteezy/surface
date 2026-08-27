<template>
    <Wrapper full center class="content-rect" v-if="!!!$route.params.id">
        <Row class="content-row">
            <Column w10 class="search-col">
                <Input class="mail-search" large icon="search" placeholder="Search in your email"></Input>
            </Column>
            <Column w3 class="search-col" centerv> 
                <div class="mail-pager">
                    <i class="icon icon-arrow-left pager"></i>
                    <i class="icon icon-arrow-right pager"></i>
                    <P  class="page-count">4/126</P>
                    <div class="list-switch">
                    <Button icon="grid" class="switch"></Button>
                    <Button icon="menu-outline"   class="switch"></Button>
                    </div>
                </div>
            </Column>
        </Row>
        <Row class="content-row-tools">
            <Column w11>
            <div class="content-tools">
                <Checkbox class="content-cb cb-main">
                </Checkbox>
                <i class="icon icon-caret-down"></i>
                <i class="icon icon-flag"></i>
                <i class="icon icon-tag"></i>
                <i class="icon icon-comm"></i>
                <i class="icon icon-trash"></i>
            </div>
            </Column>
        </Row>

        <Wrapper full class="content-list-wrap">
            <Row class="content-list">
              <Column w12>
              <Box class="box-container">
                  <Row  v-for="(item) in getEmailList()" class="list-row">
                      <div :class="{sysFlex:true, unread:item.unread}" @click="view(item)">
                      <Column w3>
                          <div class="content-div div-1">
                              <div class="badge" v-if="item.unread"></div>
                              <Checkbox :value="item.checked" class="content-cb">
                              </Checkbox>
                              <i class="icon icon-star-outlined"></i>
                          

                              <div :class="{user:true, ['base-10']:true}">
                                  <Avatar />  
                              </div> 
                              <P large class="mailer-name">{{item.name}}</P>
                          </div>
                      </Column>
                      <Column w9 centerv>
                          <div class="content-div div-1">
                              <P class="mail-subject" large semibold>{{item.subject}}</P>
                              <P class="mail-content" ellipsis>{{item.innerText}}</P>
                          </div>
                      </Column>
                      </div>
                  </Row>
              </Box>
              </Column>
          </Row>
        </Wrapper>
        
    </Wrapper>
    <Wrapper full v-if="!!$route.params.id">	
		<router-view></router-view>
    </Wrapper>
</template>

<script>
export default {
    computed: {
        mailer(){
          return window.store.mailer
        }
    },
    data() {
        return {
            sentEmails:[],
            emails:[
            {
                id:1,
                name: "Bill Willams",
                subject: "What drives your behavior?",
                content: "",
                email: "bw@gmail.com",
				        innerText: "",
                unread: true,
            },
            {
                id:2,
                name: "John Doe",
                subject: "What drives your behavior?",
                content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod consectetur adipiscing elit consectetur adipiscing elit",
                email: "jd@gmail.com",
				innerText: "",
                unread: true,
            },
            {
                id:3,
                name: "David Pony",
                subject: "What drives your behavior?",
                content: "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                email: "dp@gmail.com",
				innerText: "",
                unread: true,
            },
            {
                id:4,
                name: "Dan Litt",
                subject: "What drives your behavior?",
                content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
                email:  "dl@gmail.com",
				innerText: "",
                unread: false,
            },
            {
                id:5,
                name: "Mike Ross",
                subject: "What drives your behavior?",
                content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod consectetur adipiscing elit consectetur adipiscing elit",
                email: "mr@gmail.com",
				innerText: "",
                unread: false,
            },
            {
                id:6,
                name: "Rachel Zane",
                subject: "What drives your behavior?",
                content: "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                email: "rz@gmail.com",
				innerText: "",
                unread: false,
            }
        ]
        }
    },
    methods: {
        view(data){
          let rt = this.$route.path;
          if(rt.includes("inbox")){
            this.$router.push('/mailer/inbox-list/' + data.id);
          }else if(rt.includes("sent")){
            this.$router.push('/mailer/sent/' + data.id);
          }else if(rt.includes("draft")){
            this.$router.push('/mailer/draft/' + data.id);
          }else if(rt.includes("deleted")){
            this.$router.push('/mailer/deleted/' + data.id);
          }
        },

		checkItem(data, event){
			data.checked = event;
		},
    
      getSentRecord(){
        window.store.mailer.fetch().then(() => {
        this.mailer.many.forEach(mail => {
          const div = document.createElement('div');
            div.innerHTML = mail.content;
          this.sentEmails.push({
            id: mail.uuid,
            name: mail.email_to,
            subject: mail.subject,
            content: mail.content,
            email: mail.email_from,
            innerText: div.innerText,
          })
        });
        });
      },
      getEmailList(){
       
        if(this.$route.path.includes("sent")){
          return this.sentEmails;
        }
          return this.emails;
      }
    },
    mounted() {
        window.mitt.emit("page_loaded");
        if(this.$route.path.includes("sent")){
          this.getSentRecord();
        }
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.user {
        width: 32px;
        height: 32px;
        margin-left: 12px;
        margin-right: 12px;
        background-image: url('/src/assets/images/user-base/base-1.png');
        background-size: cover;
        cursor: pointer;

        @for $i from 1 through 37 {
        .base-#{$i} {
                background-image: url('/src/assets/images/user-base/base-#{$i}.png');
        }
    }
}

.avatar-col{
    margin-right: 0px;
}
.user-name{
    color:#677F95;
}
.content{
    color:#98A8B7;
}

:deep(.mail-search){
    width: 100%;
    display: inline;
    .field{
        border-radius: 0%;
        i{
            line-height: 1;
        }
    }
}

.content-rect{
    box-sizing: border-box;
padding: 0px;
height: 90vh;
width: 100%;
border-right: 1px solid rgba(229, 233, 237, 0.6);
    .content-row{
        margin-bottom: 8px;
    }
}
.mail-pager{
    height: 48px;
    width: 100%;
    display: inline-flex;
    border:1px solid rgba(229, 233, 237, 0.6);
    align-items:center;
}
.search-col{
    margin-right: 0px;
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
    position:fixed;
    right: 20px;
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
.content-tools{
    padding-left:16px;
    display: inline-flex;
    i{
        margin-left: 16px;
      
    }
}
.content-row-tools{
    margin-bottom: 0px;
}
.icon{
    cursor:pointer;
        line-height: 2.2;
        color: #CBD4DB;
          &:hover{
            color: #9ea8af;
        }
}
.box-container{
    margin-left:12px;
    margin-right: 12px;
    padding:0px;
    width:1180px;
    display:block;
    .content-cb{
        padding:0px;
        padding-left:4px;
    }
    .content-div{
        padding:0px;
        height: 48px;
        display: inline-flex;
        align-items: center;
    }
    .list-row{
        margin-bottom:0px;
        cursor: pointer;
        height: 48px;
        border-bottom: 1px solid #E5E9ED99;
        &:last-child{
            border-bottom: 0px;
        }
        .sysFlex{
        width: 100%;
        align-items: center;
        display: inline-flex;
            &.unread{
                background-color: #6FCF970D !important;
            }
        }
        .badge{
            height: 24px;
            width:  2px;
            border-radius: 0px 2px 2px 0px;
            background-color: #6FCF97;
        }
    }
    
}

:deep(.content-cb){
    .box{

        .check{
            border: 1px solid #cbd4db;
            width:13.5px;
            height:13.5px;
			i{
				font-size: 8px;
			}
        }
    }
}
.icon-caret-down{
    margin-left: 0px !important;
}
:deep(.cb-main){
    .box{
    padding-right: 0px !important;
		.check{
			i{
				font-size: 8px;
			}
		}
    }
}
.mailer-name{
    color: #677F95;
}
.mail-content{
    font-size: 13px;
    font-weight: 400;
    line-height: 20px;
    letter-spacing: 0.10000000149011612px;
    text-align: left;
    color: #98A8B7;
    margin-left: 8px;
}
.icon-star-outlined{
    line-height: 0.9;
}
.mail-subject{
    white-space: nowrap;
}
.content-list-wrap{
  max-height: 100%;
  overflow-y: scroll;
}
</style>