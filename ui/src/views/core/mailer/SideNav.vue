<!-- <template>
    <div class="side-nav-menu">
    <Column w2 centerv class="mailer-nav">
                    <Wrapper full center class="rect">
                        <Row class="side-nav-row">
                            <Column class="new-msg" w12 centerv centerh >

                            <P center xl semibold class="icon icon-send">&nbsp; &nbsp; New message</P>
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
                                    <Button class="nav-btn" small :icon="item.icon">&nbsp; &nbsp;{{item.str}}</Button>
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
                </div>
</template>
<script>
export default {
    computed: {
        user() {
            //    return window.store.auth.single;
        }
    },
    data() {
        return {
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
                    route: '/chats'
                },
                1: {
                    str: 'Favorites',
                    icon: 'favorite',
                    route: '/mailer/favorites'
                },
            }
            };
    },
    methods: {
        isActive(route){
            return this.$route.path.includes(route);
        }
    },
    mounted() {
        window.mitt.emit("page_loaded");
    },
}
</script>



<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.mailer-nav{
    height: 100%;
    margin: 0px;
    position: sticky;
}
.rect{
box-sizing: border-box;
padding: 0px;
width: 222px;
height: 100vh;
left: 0px;
top: 1px;    
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
height: 40px;
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
            p{
                color: $gray-D3;
            }
        }
}

:deep(.mail-search){
    .field{
        border-radius: 0%;
        i{
            line-height: 1;
        }
    }
}
.mailer-list{
    height: 100vh;
}
.content-rect{
    box-sizing: border-box;
padding: 0px;
width: 425px;
height: 100vh;
left: 0px;
top: 1px;
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
    P{
        i{
            color: #0ECFC4;
        }
    }
}
:deep(.nav-btn-work){
    P{
        i{
            color: #F79F24;
        }
    }
}
:deep(.nav-btn-imp){
    P{
        i{
            color: #E8178A;
        }
    }
}
:deep(.nav-btn-rec){
    P{
        i{
            color: #9D72D3;
        }
    }
}
.side-nav-menu{
    position: sticky;
    height: 100%;
    width: 100%;
}
</style> -->