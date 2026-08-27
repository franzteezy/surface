<template>
    <Wrapper full>
        <Row>
            <Column w5 class="left" nm>
                <Row centerv class="logo">
                    <img src="/src/assets/svg/logo.svg" />
                </Row>
                <Row center class="full">
                    <Column w8>
                        <ForgotPassword/>
                    </Column>
                </Row>
            </Column>
            <Column w7 class="right" nm fill>
                <div class="floater">
                    <P gray overline large>Faster hires, Better hiring.</P>
                    <H2 bold>Applicant Tracking System<br/>for Recruitment Agencies</H2>
                </div>
            </Column>
        </Row>
    </Wrapper>
</template>

<script>
export default {
    computed: {
        user(){
            return window.store.auth.single;
        }
    },
    data(){
        return{
        }
    },
    methods: {
    },
    mounted(){
        window.store.auth.get().then(() => {
            this.$router.push('/crm');
        }).catch(() => {
            window.mitt.emit('page_loaded');
        });
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

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

</style>
