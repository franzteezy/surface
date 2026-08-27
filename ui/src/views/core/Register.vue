<template>
    <Wrapper full v-if="token_accepted">
        <Row>
            <Column w5 class="left" nm>
                <Row centerv class="logo">
                    <img src="/src/assets/svg/logo.svg" />
                </Row>
                <Row center class="full">
                    <Column w8>
                        <Row>
                            <Steps :steps="steps" v-model:active="step"/>
                        </Row>
                        <div class="content">
                            <RegisterStepOne    @next="step++" v-if="step === 0"/>
                            <RegisterStepTwo    @next="step++" v-if="step === 1"/>
                            <RegisterStepThree  @next="step++" v-if="step === 2"/>
                            <RegisterStepFour   @next="verifying=true" v-if="step === 3 && !verifying"/>
                            <RegisterStepVerify @next="performRegister" v-if="step === 3 && verifying"/>
                            <RegisterStepFive   @next="goToLogin" v-if="step === 4"/>
                        </div>
                        <Column nm>
                            <Row>
                                <Button xl @click="performRegister" light v-if="step===3" class="divider">Add later</Button>
                                <Button xl @click="nextStep">Continue</Button>
                            </Row>
                            <Row>
                                <Button xl @click="stepBack" white v-if="step!==0 && step!==4">Back</Button>
                            </Row>
                        </Column>
                    </Column>
                </Row>
            </Column>
            <Column w7 fill class="right" nm full>
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
        },
        registration:{
            get(){
                return window.store.register.single;
            }
        },
        token_accepted:{
            get(){
                return window.store.register.token_accepted;
            }
        }
    },
    watch: {
        registration(newval){
            this.user.registration_token = this.$route.params.token;
            this.user.email = newval.email;
        },
        token_accepted(newval){
            if(newval){
                window.mitt.emit('page_loaded');
            }
        }
    },
    data(){
        return{
            step: 0,
            verifying: false,
            steps: [
                {
                    icon: 'lightning',
                    title: 'Basic details'
                },
                {
                    icon: 'password',
                    title: 'Password'
                },
                {
                    icon: 'username',
                    title: 'Profile image'
                },
                {
                    icon: 'call',
                    title: 'Add Phone'
                }
            ]
        }
    },
    methods: {
        performRegister(){
            window.store.cdn
    
            .store(this.user.image, this.registration.encryption_key)

            .then((res) => {
                if(res.data.file){
                    this.user.image_uuid = res.data.file;
                }
            })

            .finally(() => {
                window.store.auth.put().then(() => {
                    this.step++;
                });
            });
        },
        stepBack(){
            if(this.verifying){
                this.verifying = false;
            } else {
                this.step--;
            }
        },
        goToLogin(){
            this.$router.push('/login')
        },
        nextStep(){
            window.mitt.emit('check_registration');
            if(this.step===4){
                this.goToLogin();
            }
        }
    },
    mounted() {
        window.store.register.get(this.$route.params.token).catch(res => {
            this.$router.push('/login');
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
