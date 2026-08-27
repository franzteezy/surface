<template>
    <div class="content">
        <Row>
            <H2 bold>Forgot password</H2>
        </Row>
        <Row class="thirty">
            <Input label="E-mail" v-model:value="forgot.email" name="email" required/>
        </Row>
        <Row>
            <Button xl @click="requestPassword">Reset password</Button>
        </Row>
        <Row>
            <P gray @click="goToLogin">Back to login</P>
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
        forgot(){
            return window.store.auth.single;
        }
    },
    methods: {
        requestPassword(){
            window.store.auth.forgot_password().then(() => {
                window.notify('A reset link has been sent to your email address.', null, false, true, 0);
            });
        },
        goToLogin(){
            this.$router.push('/login');
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