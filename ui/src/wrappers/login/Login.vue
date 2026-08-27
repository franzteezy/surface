<template>
    <div class="content">
        <Row>
            <H2 bold>Welcome to Stafflify</H2>
        </Row>
        <Row class="thirty">
            <Input label="E-mail" v-model:value="user.package.email" name="email" required/>
        </Row>
        <Row class="thirty">
            <Input label="Password" v-model:value="user.package.password" name="password" required password/>
        </Row>
        <Row>
            <Button xl @click="login">Login</Button>
        </Row>
        <Row>
            <P gray @click="forgotPassword">Forgot password?</P>
        </Row>
    </div>
</template>

<script>
import _ from 'lodash';
export default {
    props: {},
    data(){
        return{
        }
    },
    computed: {
        user(){
            return window.store.auth;
        }
    },
    methods: {
        login(){            
            window.store.auth.fetch().then(() => {
                window.store.auth.get().then(() => {
                    this.$router.push('/crm');
                });
            });
        },
        forgotPassword(){
            this.$router.push('/forgot');
        }
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.content{
    .thirty{
        margin-bottom: 30px;
    }
    
    p{
        cursor: pointer;
    }
}
</style>