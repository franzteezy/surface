<template>
    <h3 :class="{center:center !== null, white:white !== null, bold:bold !== null, gray:gray !== null, click:click}">
        <slot></slot>
    </h3>
</template>

<script>
export default {
    props: {
        center: {Type: Boolean, default: null},
        white: {Type: Boolean, default: null},
        gray: {Type: Boolean, default: null},
        bold: {Type: Boolean, default: null},
    },
    data() {
        return {}
    },
    computed: {
        click: {
            get(){
                return this.$attrs && this.$attrs.onClick;
            }
        }
    },
    methods: {
    },
    created() {
    },
    mounted() {
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

h3{
    font-style: normal;
    font-weight: 400;
    font-size: 26px;
    line-height: 32px;
    letter-spacing: 0.2px;
    color: $gray-D3;
    max-width: fit-content;

    &.click{
        cursor: pointer;
    }

    &.center{
        text-align: center;
    }

    &.white {
        color: white;
    }

    &.gray {
        color: $gray;
    }

    &.bold {
        font-weight: 700;
    }
}

</style>
