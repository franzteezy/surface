<template>
    <div :class="{edit:true, dark:dark!==null}">
        <i class="icon icon-dots-vertical" @click="edit_active=!edit_active" v-click-outside="clickOutside"/>
        <div class="selector" v-if="edit_active">
            <P v-for="item in menu" @click="runFunc(item.click)"><i :class="{icon:true, ['icon-'+item.icon]:true}" v-if="item.icon"/>{{item.label}}</P>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        menu: {Type: Object, default: {}},
        dark: {Type: Boolean, default: null},
        pass: {Type: String, default: null},
    },
    data(){
        return{
            edit_active: false,
        }
    },
    computed: {
    },
    methods: {
        runFunc(clickable){
            clickable(this.$props.pass);
        },
        clickOutside(){
            this.edit_active = false;
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

.edit{
    width: 32px;
    height: 32px;
    background: #{$white}1A;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: $transition;
    border-radius: $radius;
    position: relative;

    &.dark{
        i{
            color: $gray;
        }
    }

    &:hover{
        background: #{$white}33;
    }

    &.active{
        background: #{$white}55;
    }

    i{
        color: $white;
    }

    .selector{
        position: absolute;
        top: 38px;
        background: $white;
        display: flex;
        flex-direction: column;
        z-index: 999;
        border-radius: $radius;
        box-shadow: $shadow;
        min-width: 160px;
        padding: calc(#{$padding} / 2) $padding;

        &:after{
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            left: calc(50% - 3px);
            top: -3px;
            background: $white;
            transform: rotate(45deg);
        }

        p{
            margin-bottom: $padding;
            color: $gray-D1;
            transition: $transition;
            width: 100%;

            &:last-child{
                margin: 0;
            }

            i{
                color: $gray-D1;
                margin-right: calc(#{$padding} / 2);
                top: 2px;
                position: relative;
            }

            &:hover{
                color: $gray-D3;
                i {
                    color: $gray-D3;
                }
            }
        }
    }
}

</style>