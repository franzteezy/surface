<template>
    <div class="step">
        <Row>
            <H2 bold>Create password</H2>
        </Row>
        <Row class="thirty">
            <P large gray>Create a password to protect your account, <br/>a strong password contains atleast 8 characters.</P>
        </Row>
        <Row class="thirty">
            <Input label="Password" placeholder="Passwords must match" v-model:value="user.password" password strength name="password" required/>
        </Row>
        <Row class="thirty">
            <Input label="Repeat password" placeholder="Passwords must match" v-model:value="user.password_repeat" password strength name="password_repeat" required/>
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
            return window.store.auth.single;
        }
    },
    methods: {
        checkFields(){
            let errors = [];
            if(this.user.password === '' || !this.user.password){
                errors.push({
                    id: window.fields.password.field_id,
                    message: 'This field is required',
                });
            }
            if(this.user.password_repeat === '' || !this.user.password_repeat){
                errors.push({
                    id: window.fields.password_repeat.field_id,
                    message: 'This field is required',
                });
            }
            if(!errors.length && this.user.password_repeat !== this.user.password){
                errors.push({
                    id: window.fields.password.field_id,
                    message: 'Passwords must match',
                });
                errors.push({
                    id: window.fields.password_repeat.field_id,
                    message: 'Passwords must match',
                });
            }
            if(!errors.length && this.user.password_repeat === this.user.password && this.user.password.length < 4){
                errors.push({
                    id: window.fields.password.field_id,
                    message: 'Password is too short',
                });
            }

            if(errors.length){
                window.mitt.emit('request_failed', {errors:errors})
            } else {
                this.$emit('next');
            }
        }
    },
    created() {
    },
    beforeUnmount() {
        window.mitt.off('check_registration');
    },
    mounted() {
        window.mitt.on('check_registration', this.checkFields);
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.step{
    .thirty{
        margin-bottom: 30px;
    }
}
</style>