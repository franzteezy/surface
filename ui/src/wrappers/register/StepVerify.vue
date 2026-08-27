<template>
    <div class="step">
        <Row>
            <H2 bold>Add your phone number</H2>
        </Row>
        <Row class="thirty">
            <P large gray>you will recieve a call in a moment, <br/>please enter the verification code below.</P>
        </Row>
        <Row class="thirty">
            <Input label="verification code" placeholder="Please write the code here" v-model:value="user.phone_verification" name="verification" required/>
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
            if(this.user.phone_verification === '' || !this.user.phone_verification){
                window.mitt.emit('request_failed', {errors:[{
                        id: window.fields.verification.field_id,
                        message: 'Please enter verification code',
                    }]})
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