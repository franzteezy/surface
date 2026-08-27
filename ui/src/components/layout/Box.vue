<template>
    <div :class="{box:true, center:center !== null}">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
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

.box{
    width: 100%;
    height: auto;
    padding: 24px;
    background-color: $white;
    border-radius: $radius;
    display: flex;
    box-shadow: 0 1px 4px rgb(0 0 0 / 10%);

    &:last-child{
        margin-right: 0;
    }

    &.center{
        justify-content: center;
    }
}

</style>
