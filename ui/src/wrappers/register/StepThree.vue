<template>
    <div class="step">
        <Row>
            <H2 bold>Upload your image</H2>
        </Row>
        <Row class="thirty">
            <P large gray>Use a clear profile image, <br/>give your profile a little style.</P>
        </Row>
        <Row class="thirty">
            <Image icon="user" v-model:value="user.image" name="profile_image"/>
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
            this.$emit('next');
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