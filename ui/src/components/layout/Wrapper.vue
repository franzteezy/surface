<template>
    <div :class="{wrapper:true, full:full!==null, nm:nm!==null, center:center!==null}">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        full: {Type: Boolean, default: null},
        nm: {Type: Boolean, default: null},
        center: {Type: Boolean, default: null},
    },
    data() {
        return {

        }
    },
    computed: {
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

.wrapper{
    display: flex;
    flex-direction: column;
    max-width: 1280px;
    width: 100%;
    margin: 24px 0;

    &.nm{
        margin: 0;
    }

    &.full{
        max-width: initial;
        margin: 0;
        padding: 0;

        &> .wrapper{
            &:not(.full){
                max-width: calc(1280px + (#{$padding * 2}));
                padding: 0 $padding;
            }
        }
    }

    &.center{
        align-items: center;
    }
}

</style>
