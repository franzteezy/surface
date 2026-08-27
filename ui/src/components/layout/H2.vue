<template>
    <h2 :class="{center:center !== null, white:white !== null, gray:gray !== null, bold:bold !== null, click:click}"><slot></slot></h2>
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

h2{
    max-width: fit-content;
    font-style: normal;
    font-weight: 400;
    font-size: 30px;
    line-height: 40px;
    letter-spacing: 0.1px;
    color: $gray-D3;

    &.click{
        cursor: pointer;
    }

    &.bold{
        font-weight: 700;
    }

    &.center{
        text-align: center;
    }

    &.white{
        color: white;
    }

    &.gray{
        color: $gray;
    }
}

</style>
