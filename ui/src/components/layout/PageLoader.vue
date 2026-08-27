<template>
    <div id="page-loader" :class="{loaded:loaded, faded:faded}">
        <img src="/src/assets/images/stafflify_logo_gray.svg"/>
        <div class="load">
            <img src="/src/assets/images/stafflify_logo.svg"/>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        faded: {
            type: Boolean,
            default: false
        },
        loaded: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
        }
    },
    computed: {
    },
    methods: {},
    created() {
    },
    mounted() {
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

#page-loader{
    width: 100vw;
    height: 100vh;
    position: fixed;
    background: $gray-L3;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;

    &.faded{
        background: #{$gray-L3}c2;
    }

    &.loaded{
        animation-name: loaded;
        animation-duration: 0.5s;
        animation-iteration-count: 1;
        animation-fill-mode: forwards;
        animation-timing-function: ease-in-out;

        @keyframes loaded {
            0% {
                opacity: 1;
            }
            99% {
                opacity: 0;
            }
            100% {
                display: none;
                opacity: 0;
            }
        }

        .load{
            height: 90px;
            width: 334px;
            margin-right: 0;
            animation-name: none;
        }
    }

    .load{
        height: 90px;
        width: 0;
        margin-right: 334px;
        position: absolute;
        overflow: hidden;
        transition: 1s;
        animation-name: load;
        animation-duration: 10s;
        animation-iteration-count: 1;
        animation-fill-mode: forwards;
        animation-timing-function: ease-in-out;

        @keyframes load {
            0% {
                width: 0;
                margin-right: 334px;
            }
            20% {
                width: 134px;
                margin-right: 200px;
            }
            80% {
                width: 290px;
                margin-right: 44px;
            }
            100% {
                width: 314px;
                margin-right: 20px;
            }
        }
    }

    img{
        height: 90px;
        width: 334px;
        position: absolute;
    }
}
</style>
