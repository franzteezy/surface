<template>
    <div class="nav">
        <RouterLink :to="route" v-for="(route, item) in menu" :class="{partial:isActive(route)}">
            <P semibold gray>{{item}}</P>
        </RouterLink>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        menu: {Type: Object, default: {}},
    },
    data(){
        return{
        }
    },
    computed: {
    },
    methods: {
        isActive(route){
            return this.$route.path.includes(route);
        }
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.nav{
    display: flex;
    height: 100%;
    align-items: center;
    cursor: pointer;

    a{
        margin-right: 48px;
        text-decoration: none;

        &.router-link-active, &.partial{
            p{
                color: $gray-D3;
            }
        }

        &:last-child{
            margin: 0;
        }
    }
}

</style>