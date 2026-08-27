<template>
    <PageLoader v-if="!remove_loader" :loaded="page_loaded"/>
    <Core />
    <RouterView v-show="page_loaded" v-if="ready_to_load"/>
</template>

<script>
import PageLoader from "./components/layout/PageLoader.vue";

export default {
    components: {PageLoader},
    data(){
        return{
            page_loaded: false,
            ready_to_load: false,
            remove_loader: false,
            buttons: [],
        }
    },
    methods:{
        pageLoaded(){
            this.page_loaded = true;
            window.setTimeout(() => {
                this.remove_loader = true;
            }, 500);
        }
    },
    created() {
    },
    mounted() {
        window.mitt.on('loading', (val) => {
            if(val){
                this.short_load_timeout = window.setTimeout(() => {
                    //this.loading = val;
                }, 500);
            } else {
                window.clearTimeout(this.short_load_timeout);
                this.loading = val;
            }
        });
        window.mitt.on('page_loaded', this.pageLoaded);
        window.setTimeout(() => {
            this.ready_to_load = true;
        }, 500);
    }
}
</script>

<style lang="scss">
@import "/src/assets/variables.scss";

* {
    // font-family: $font-family;
    margin: 0;
    padding: 0;
    box-sizing: border-box;

    &:not(font){
        font-family: $font-family;
    }

    &.marg-b {
        margin-bottom: $padding !important;
    }

    &.marg-t {
        margin-top: $padding !important;
    }

    &.marg-r {
        margin-right: $padding !important;
    }

    &.marg-l {
        margin-left: $padding !important;
    }

    &.pad-b {
        padding-bottom: $padding !important;
    }

    &.pad-t {
        padding-top: $padding !important;
    }

    &.pad-r {
        padding-right: $padding !important;
    }

    &.pad-l {
        padding-left: $padding !important;
    }

    i {
        line-height: 0;
    }
}
</style>
