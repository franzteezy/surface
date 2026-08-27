<template>
    <div @mousedown="enableMove" 
    :class="{notification:true, holding:holding!==false, warning:warning!==null, success:success!==null, big:title!==null, destroying:destroying, creating:creating}" 
    :style="{
        right: add !== 0 ? 16-add+'px':null,
        bottom:bottom!==null?bottom:null
        }">
        <div class="border">
        </div>
        <i class="icon icon-bell" v-if="warning===null&&success===null"></i>
        <i class="icon icon-success" v-if="success!==null"></i>
        <i class="icon icon-warning" v-if="warning!==null"></i>
        <div class="text">
            <P bold xl v-if="title!==null">{{title}}</P>
            <P brand><slot></slot></P>
        </div>
        <i class="icon icon-clear" @click="destroyNotification"/>
    </div>
</template>

<script>
export default {
    props: {
        warning: {Type: Boolean, default: null},
        success: {Type: Boolean, default: null},
        title: {Type: String, default: null},
        bottom: {Type: String, default: null},
        destroy: {Type: Function, default: null},
        timeout: {Type: Number, default: 5000},
    },
    data() {
        return {
            destroying: false,
            creating: true,
            holding: false,
            add: 0,
        }
    },
    computed: {
    },
    methods: {
        moveMouse(e){
            if(this.holding !== false){
                let moved = e.clientX - this.holding;
                if(moved > -16){
                    this.add = moved;
                }
            }
        },
        enableMove(e){
            this.holding = e.clientX;
        },
        disableMove(){
            if(this.add > 32 && this.holding !== false){
                this.holding = false;
                this.destroyNotification();
            } else {
                this.holding = false;
                this.add = 0;
            }
        },
        destroyNotification(){
            this.destroying = true;
            window.removeEventListener('mouseup', () => this.disableMove());
            window.removeEventListener('mousemove', (e) => this.moveMouse(e));
            window.setTimeout(() => {
                this.destroying = false;
                this.$emit('destroy');
            }, 700)
        }
    },
    created() {
    },
    mounted() {
        window.addEventListener('mouseup', () => this.disableMove());
        window.addEventListener('mousemove', (e) => this.moveMouse(e));

        window.setTimeout(() => {
            this.creating = false;
        }, 700);

        if(this.$props.timeout){
            window.setTimeout(() => {
                this.destroyNotification();
            }, this.$props.timeout)
        }
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.notification{
    display: flex;
    width: 464px;
    min-height: calc(48px - #{$padding} - #{$padding});
    padding: $padding 0;
    position: fixed;
    right: $padding;
    bottom: $padding;
    box-shadow: $shadow;
    align-items: center;
    background-color: $brand-L4;
    transition: 0.3s;
    cursor: default;
    user-select: none;

    &.holding{
    transition: 0s;
    }

    &.creating{
        animation-name: create;
        animation-duration: 0.7s;
        animation-iteration-count: 1;
        animation-fill-mode: forwards;

        @keyframes create {
            from {right: -467px}
            to {right: $padding;}
        }
    }

    &.recover{
        animation-duration: 0s;
    }

    &.destroying{
        animation-name: destroy;
        animation-duration: 0.4s;
        animation-iteration-count: 1;
        animation-fill-mode: forwards;

        @keyframes destroy {
            from {}
            to {right: -467px}
        }
    }

    &.success{
        background-color: $success-L2;
        .border{
            background-color: $success;
        }
        p{
            color: $success;

            &.bold{
                color: $gray-D3;
            }
        }
        .icon-clear{
            color: $success;
        }
    }

    &.warning{
        background-color: $error-L2;
        .border{
            background-color: $error;
        }
        p{
            color: $error;

            &.bold{
                color: $gray-D3;
            }
        }
        .icon-clear{
            color: $error;
        }
    }

    &.big{
        height: 88px;
        background-color: $white;

        .border{
            height: 58px;
        }

        p{
            color: $gray;

            &.bold{
                color: $gray-D3;
            }
        }

        .icon-clear{
            color: $gray;
            &:hover{
                background-color: $gray-L2;
                color: $gray-D3;
            }
        }
    }

    &.success{
        .icon-clear{
            &:hover{
                background-color: $success-L1;
                color: $success;
            }
        }
    }

    &.warning{
        .icon-clear{
            &:hover{
                background-color: $error-L1;
                color: $error;
            }
        }
    }

    .border{
        height: 21px;
        width: 2px;
        background-color: $brand;
        border-radius: 0 $radius $radius 0;
        margin-right: $padding;
    }

    p{
        max-width: 360px;
        transition: 0s;
    }

    i{
        position: relative;
        margin-right: $padding;
        top: 1px;
        color: $brand;

        &.icon-warning{
            color: $error;
        }

        &.icon-success{
            color: $success;
        }

        &.icon-clear{
            margin-left: auto;
            cursor: pointer;
            color: $brand;
            padding: 6px;
            line-height: 2px;
            transition: $transition;
            border-radius: 100%;

            &:hover{
                background-color: $brand-L3;
            }
        }
    }
}

</style>
