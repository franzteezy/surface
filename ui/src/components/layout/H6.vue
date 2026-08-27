<template>
    <h6 :class="{center:center !== null, white:white !== null, gray:gray !== null, click:click}"><slot></slot></h6>
</template>

<script>
export default {
    props: {
        center: {Type: Boolean, default: null},
        white: {Type: Boolean, default: null},
        gray: {Type: Boolean, default: null},
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

h6{
    font-style: normal;
    font-weight: 600;
    font-size: 18.1px; // 0.1 FIXING BIG T CUT
    line-height: 24px;
    color: $gray-D3;
    max-width: fit-content;

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
