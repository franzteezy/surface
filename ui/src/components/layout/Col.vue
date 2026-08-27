<template>
    <div :class="{col:true, w1:w1 !== null, w2:w2 !== null, w3:w3 !== null, w4:w4 !== null, w5:w5 !== null, w6:w6 !== null, w7:w7 !== null, w8:w8 !== null, w9:w9 !== null, w10:w10 !== null, w11:w11 !== null, 'center-h':centerh !== null, 'center-v':centerv !== null, center:center !== null, 'no-margin': nm !== null, end:end!==null, split:split!==null, shrink:shrink!==null, wrap:wrap!==null,fill:fill!==null}">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        w1: {Type: Boolean,default: null},
        w2: {Type: Boolean,default: null},
        w3: {Type: Boolean,default: null},
        w4: {Type: Boolean,default: null},
        w5: {Type: Boolean,default: null},
        w6: {Type: Boolean,default: null},
        w7: {Type: Boolean,default: null},
        w8: {Type: Boolean,default: null},
        w9: {Type: Boolean,default: null},
        w10: {Type: Boolean,default: null},
        w11: {Type: Boolean,default: null},
        end: {Type: Boolean,default: null},
        wrap: {Type: Boolean,default: null},
        center: {Type: Boolean,default: null},
        centerv: {Type: Boolean,default: null},
        centerh: {Type: Boolean,default: null},
        split: {Type: Boolean,default: null},
        shrink: {Type: Boolean,default: null},
        fill: {Type: Boolean,default: null},
        nm: {Type: Boolean,default: null},
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

.col{
    width: 100%;
    margin-right: 16px;
    display: flex;
    flex-direction: column;

    &.shrink {
        flex-grow: 0;
        flex-shrink: 100;
    }

    &.end{
        align-items: flex-end;
    }

    &.split{
        justify-content: space-between;
    }

    &.wrap{
        flex-wrap: wrap;
    }

    &.center{
        align-items: center;
        justify-content: center;
    }

    &.center-v{
        justify-content: center;
    }

    &.center-h{
        align-items: center;
    }

    &.w1{
        width: calc((8.28% * 1) - 16px);
        max-width: calc((8.28% * 1) - 16px);
    }

    &.w2{
        width: calc((8.28% * 2) - 16px);
        max-width: calc((8.28% * 2) - 16px);
    }

    &.w3{
        width: calc((8.28% * 3) - 16px);
        max-width: calc((8.28% * 3) - 16px);
    }

    &.w4{
        width: calc((8.28% * 4) - 16px);
        max-width: calc((8.28% * 4) - 16px);
    }

    &.w5{
        width: calc((8.28% * 5) - 16px);
        max-width: calc((8.28% * 5) - 16px);
    }

    &.w6{
        width: calc((8.28% * 6) - 16px);
        max-width: calc((8.28% * 6) - 16px);
    }

    &.w7{
        width: calc((8.28% * 7) - 16px);
        max-width: calc((8.28% * 7) - 16px);
    }

    &.w8{
        width: calc((8.28% * 8) - 16px);
        max-width: calc((8.28% * 8) - 16px);
    }

    &.w9{
        width: calc((8.28% * 9) - 16px);
        max-width: calc((8.28% * 9) - 16px);
    }

    &.w10{
        width: calc((8.28% * 10) - 16px);
        max-width: calc((8.28% * 10) - 16px);
    }

    &.w11{
        width: calc((8.28% * 11) - 16px);
        max-width: calc((8.28% * 11) - 16px);
    }

    &:last-child, &.no-margin{
        margin-right: 0;
    }

    &.fill{
        flex-grow: 1;
        max-width: none;
    }

    &.no-margin{
        margin-right: 0;
        max-width: initial;
    }
}

</style>
