<template>
    <div class="module">
        <i class="icon icon-menu-outline" />
        <i :class="{'module-icon icon':true, ['icon-'+icon]:true}" />
        <H5 bold>{{module}}</H5>
        <P gray>by stafflify</P>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        module: {Type: String, default: 'ats'},
        icon: {Type: String, default: 'ats'},
    },
    data(){
        return{
        }
    },
    computed: {

    },
    methods: {
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.module{
    display: flex;
    height: 100%;
    align-items: center;
    cursor: pointer;
    width: 200px;

    &:hover{
        .icon-menu-outline{
            color: $gray-D3;
        }
    }

    h5{
        text-transform: uppercase;
        font-weight: 900;
    }

    p{
        margin-top: 6px;
        margin-left: 8px;
    }

    .icon-menu-outline{
        font-size: 20px;
        color: $gray-D1;
        margin-right: 8px;
        transition: $transition;
    }

    .module-icon{
        color: $brand;
        border-radius: 8.2px;
        padding: 7px;
        font-size: 18px;
        background: $brand-L3;
        margin-right: 8px;
    }
}

</style>