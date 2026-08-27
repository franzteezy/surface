<template>
    <div class="step">
        <Row>
            <H2 bold>Welcome to Stafflify</H2>
        </Row>
        <Row class="thirty">
            <P large gray>you are almost ready, <br/>please enter your profile information below.</P>
        </Row>
        <Row class="thirty">
            <Input label="email" v-model:value="user.email" required name="email" :disabled="true"/>
        </Row>
        <Row class="thirty">
            <Input label="Firstname" placeholder="E.g. John" v-model:value="user.first_name" required name="first_name"/>
        </Row>
        <Row class="thirty">
            <Input label="Lastname" placeholder="E.g. Doe" v-model:value="user.last_name" required name="last_name"/>
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
            if(this.user.first_name === '' || !this.user.first_name){
                errors.push({
                    id:window.fields.first_name.field_id,
                    message: 'This field is required',
                });
            }
            if(this.user.last_name === '' || !this.user.last_name){
                errors.push({
                    id:window.fields.last_name.field_id,
                    message: 'This field is required',
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