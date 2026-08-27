<template>
    <div :class="{row:true, 'no-margin':nm !== null, 'center-h':centerh !== null, 'split':split !== null, 'center-v':centerv !== null, center:center !== null,end:end !== null, wrap:wrap!==null}">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        center: {Type: Boolean,default: null},
        centerv: {Type: Boolean,default: null},
        centerh: {Type: Boolean,default: null},
        end: {Type: Boolean,default: null},
        split: {Type: Boolean,default: null},
        nm: {Type: Boolean,default: null},
        wrap: {Type: Boolean,default: null},
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

.row{
    width: 100%;
    display: flex;
    flex-direction: row;
    margin-bottom: 16px;

    &.wrap{
        flex-wrap: wrap;
    }

    &.end{
        justify-content: flex-end;
    }

    &.center{
        align-items: center;
        justify-content: center;
    }

    &.center-v{
        align-items: center;
    }

    &.center-h{
        justify-content: center;
    }

    &.split{
        justify-content: space-between;
    }

    &:last-child, .no-margin{
        margin-bottom: 0;
    }
}

</style>
