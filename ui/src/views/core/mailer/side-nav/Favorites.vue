<template>
        <H1>FAVORITES</H1>
</template>

<script>
export default {
    computed: {
        user() {
            //    return window.store.auth.single;
        }
    },
    data() {
            
    },
    methods: {},
    mounted() {
        window.mitt.emit("page_loaded");
    },
}
</script>