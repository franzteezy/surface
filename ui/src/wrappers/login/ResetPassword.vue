<template>
    <div class="content">
        <Row>
            <H2 bold>Create new password</H2>
        </Row>
        <Row class="thirty">
            <Input label="Password" v-model:value="forgot.new_password" name="new_password" required password strength/>
        </Row>
        <Row class="thirty">
            <Input label="Password repeat" v-model:value="forgot.new_password_confirmation" name="new_password_confirmation" required password strength/>
        </Row>
        <Row>
            <Button xl @click="updatePassword">Update password</Button>
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
        updatePassword(){
            window.store.auth.reset_password().then(() => {
                window.notify('Your password has been updated.', null, false, true, 0);
                this.goToLogin();
            });
        },
        goToLogin(){
            this.$router.push('/login')
        }
    },
    created() {
    },
    mounted() {
        this.forgot.token = this.$route.params.token;
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