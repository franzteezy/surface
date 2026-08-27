<template>
    <div class="submenu">
        <router-link :to="link.toLowerCase()" v-for="(link, item) in menu">
            <P :white="dark===null?true:null" semibold >{{item}}</P>
        </router-link>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    watch: {},
    props: {
        dark: {Type: Boolean, default: null},
    },
    data(){
        return{     }
    },
    computed: {
        menu: {
            get(){
                let arr = {};
                for(let i in this.$route.matched[0].children){
                    if(this.$route.matched[0].children[i].path !== '' && !(this.$route.matched[0].children[i].meta && this.$route.matched[0].children[i].meta.sub === false)){
                        arr[this.$route.matched[0].children[i].path] = (this.$route.matched[0].path+'/'+this.$route.matched[0].children[i].path);
                    }
                }
                return arr;
            }
        }
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

.submenu{
    display: flex;
    padding: calc(#{$padding}/1.5) 0;

    a{
        opacity: 0.4;
        margin-right: 40px;
        transition: $transition;
        text-decoration: none;
        text-transform: capitalize;

        &:hover{
            opacity: 0.6;
        }

        &.router-link-active{
            opacity: 1;
        }

        &:last-child{
            margin: 0;
        }
    }

}

</style>