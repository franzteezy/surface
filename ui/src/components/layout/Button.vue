<template>
    <div :class="{button:true, light:light!==null, white:white!==null, small:small!==null, large:large!==null, xl:xl!==null, loading:loading}" @click="triggerEmitter">
        <P :bold="xl!==null?true:null" large :white="white===null&&light===null?true:null" :brand="light!==null?true:null" v-if="!loading">
            <i :class="{icon:true, ['icon-'+icon]:true}" v-if="icon"/> <slot />
        </P>
        <div class="loading" v-if="loading">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        light: {Type: Boolean, default: null},
        white: {Type: Boolean, default: null},
        small: {Type: Boolean, default: null},
        large: {Type: Boolean, default: null},
        xl: {Type: Boolean, default: null},
        icon: {Type: String, default: null},
    },
    data() {
        return {
            loading: false,
            button_id: null,
        }
    },
    computed: {
    },
    methods: {
        actionable(){
            this.loading = false;
        },
        setLoading(){
            this.loading = true;
        },
        triggerEmitter(){
            window.mitt.on('button_loading_trigger', this.setLoading);
            window.setTimeout(() => {
                window.mitt.off('button_loading_trigger');
            },100);
        }
    },
    created() {
    },
    mounted() {
        this.button_id = window.makeid(20);
        window.mitt.on('remove_button_loading', this.actionable);
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.button{
    display: flex;
    padding: 0 24px;
    height: 40px;
    border-radius: calc(#{$radius} / 2);
    background-color: $brand;
    width: fit-content;
    white-space: nowrap;
    align-items: center;
    transition: $transition;
    box-shadow: 0 1px 3px rgba(85, 66, 246, 0.3), 0 4px 8px rgba(85, 66, 246, 0.2);
    cursor: pointer;
    user-select: none;

    &:hover{
        background-color: $brand-D1;
        box-shadow: 0 1px 3px rgba(85, 66, 246, 0.7), 0 4px 8px rgba(85, 66, 246, 0.5);
    }

    &.loading{
        pointer-events: none;
    }

    &.small{
        height: 32px;
    }

    &.large{
        height: 48px;
    }

    &.xl{
        height: 48px;
        width: 100%;
        justify-content: center;
    }

    .loading{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        .dot{
            width: 8px;
            height: 8px;
            border-radius: 100%;
            background: $white;
            margin-right: $padding;

            animation-name: jump;
            transform-origin: 50% 50%;
            animation-duration: 1.5s;
            animation-iteration-count: infinite;
            animation-fill-mode: forwards;
            animation-timing-function: ease-in-out;
            animation-delay: 0.3s;

            @keyframes jump {
                0%   {transform: translate3d(0,0%,0) }
                25% {transform: translate3d(0,-70%,0) }
                40%  {transform: translate3d(0,0%,0) }
                100%  {transform: translate3d(0,0%,0) }
            }

            &:nth-child(2){
                animation-delay: 0.6s;
            }

            &:nth-child(3){
                animation-delay: 0.9s;
                margin-right: 0;
            }

        }
    }

    p{
        i{
            position: relative;
            top: 2px;
            margin-right: 8px;
        }
    }

    &.light{
        background-color: $brand-L5;
        box-shadow: none;

        &:hover{
            background-color: $brand-L4;
            box-shadow: none;
        }
    }

    &.white{
        background-color: $white;
        box-shadow: none;
        border: 1px solid $gray-L2;

        i{
            color: $gray-D1;
            transition: $transition;
        }

        &:hover{
            box-shadow: none;
            border: 1px solid $gray;

            i{
                color: $gray-D3;
            }
        }
    }
}

</style>
