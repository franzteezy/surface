<template>
    <p :class="{semibold:semibold!==null, center:center !== null, brand:brand !== null, white:white !== null, gray:gray !== null, large:large !== null, xl:xl !== null, overline:overline !== null, bold:bold !== null, ellipsis:ellipsis!==null, click:click}"><slot></slot></p>
</template>

<script>
export default {
    props: {
        center: {Type: Boolean, default: null},
        brand: {Type: Boolean, default: null},
        white: {Type: Boolean, default: null},
        gray: {Type: Boolean, default: null},
        large: {Type: Boolean, default: null},
        xl: {Type: Boolean, default: null},
        overline: {Type: Boolean, default: null},
        bold: {Type: Boolean, default: null},
        semibold: {Type: Boolean, default: null},
        ellipsis: {Type: Boolean, default: null},
    },
    data() {
        return {

        }
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

p{
    font-style: normal;
    font-weight: 300;
    font-size: 12px;
    line-height: 16px;
    color: $gray-D3;
    max-width: fit-content;
    transition: $transition;

    &.click{
        cursor: pointer;
    }
    
    &.ellipsis{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    &.center{
        text-align: center;
    }

    &.large{
        font-size: 14px;
        line-height: 20px;
    }

    &.xl{
        font-size: 16px;
        line-height: 24px;
    }

    &.overline{
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: 1.5px;
    }

    &.semibold{
        font-weight: 500;
    }

    &.bold{
        font-weight: 600;
    }

    &.brand{
        color: $brand;
    }

    &.white{
        color: white;
    }

    &.gray{
        color: $gray;
    }
}

</style>
