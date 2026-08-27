<template>
    <h4 :class="{center:center !== null, white:white !== null, gray:gray !== null, bold:bold !== null, click:click}"><slot></slot></h4>
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

h4{
    font-style: normal;
    font-weight: 400;
    font-size: 24px;
    line-height: 32px;
    letter-spacing: 0.25px;
    color: $gray-D3;
    max-width: fit-content;

    &.bold{
        font-weight: 800;
    }

    &.click{
        cursor: pointer;
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
