<template>
    <div class="step">
        <Row>
            <H2 bold>Add your phone number</H2>
        </Row>
        <Row class="thirty">
            <P large gray>If you want to use the built in phone, <br/>we need a caller-id for you - or you can add this later.</P>
        </Row>
        <Row class="thirty">
            <Tel label="Country code & and phone number" v-model:cc="user.cc" v-model:value="user.phone" name="phone" required/>
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
            if(this.user.phone === '' || !this.user.phone || this.user.cc === '' || !this.user.cc){
                window.mitt.emit('request_failed', {errors:[{
                        id: window.fields.phone.field_id,
                        message: 'Please enter a phone number',
                    }]})
            } else {
                this.$emit('next')
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