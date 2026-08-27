<template>
    <vue-final-modal v-model="show" classes="modal-container" content-class="modal-content">
        <Row class="title" split>
            <P large bold>{{title}}</P>
            <i class="icon icon-clear" @click="show=false"/>
        </Row>
        <Row class="content" nm>
            <slot></slot>
        </Row>
        <Row class="actions" end>
            <Button white @click="clickCancel" v-if="cancel!==false">{{cancel}}</Button>
            <Button @click="clickConfirm" v-if="confirm!==false">{{confirm}}</Button>
        </Row>
    </vue-final-modal>
</template>

<script>
import {ModalsContainer, VueFinalModal} from 'vue-final-modal'

export default {
    components: {
        VueFinalModal,
        ModalsContainer
    },
    watch:{
        show(newval){
            this.$emit('update:show', newval);
        }
    },
    props: {
        show: {Type: Boolean, default: false},
        title: {Type: String, default: ''},
        confirm: {Type: String, default: 'Confirm'},
        cancel: {Type: String, default: 'Cancel'},
    },
    data(){
        return{
        }
    },
    computed: {

    },
    methods: {
        clickCancel(){
            this.$emit('cancel')
        },
        clickConfirm(){
            this.$emit('confirm')
        },
    },
    created() {
    },
    mounted() {
        this.$el.parentNode.removeChild(this.$el);
        document.getElementById('modal-wrapper').appendChild(this.$el);
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

:deep(.vfm--overlay){
    z-index: $level5;
}

:deep(.modal-container) {
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: $level5;
    overflow: auto;
}
:deep(.modal-content) {
    display: flex;
    flex-direction: column;
    background: #fff;
    box-shadow: $shadow;
    min-width: 500px;
    border-radius: $radius;

    .content{
        padding: calc(#{$padding} * 2);
        background: $gray-L4;
        border-top: 1px solid $gray-L2;
        border-bottom: 1px solid $gray-L2;
        margin: 0;
        max-height: 80vh;
        overflow: auto;
    }

    .actions{
        padding: $padding calc(#{$padding} * 2);
        margin: 0;

        .button{
            margin-left: $padding;
        }
    }

    .title{
        padding: $padding calc(#{$padding} * 2);
        margin: 0;

        i{
            font-size: 20px;
            color: $gray-L1;
            cursor: pointer;
            transition: $transition;

            &:hover{
                color: $gray-D2;
            }
        }
    }
}

</style>