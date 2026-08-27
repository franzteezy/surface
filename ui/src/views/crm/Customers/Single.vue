<template>
    <Base>
        <img v-if="loading" alt="loader" src="/src/assets/svg/loader.svg" width="60"/>
        <Wrapper v-if="!loading" full>
            <div class="map">
                <iframe
                    :src="'https://www.google.com/maps/embed/v1/search?zoom=8&key=AIzaSyCVW1zrdMUlx5-zhGVzU1Lw9pNo_psa6OU&q='+customer.location.name"
                    loading="lazy"/>
            </div>
        </Wrapper>
        <Wrapper>
            <Row class="overlap">
                <div class="logo">

                </div>
            </Row>
        </Wrapper>
    </Base>
</template>

<script>

export default {
    computed: {
        customer() {
            return window.store.customer.single;
        },
        loading() {
            return window.store.customer.loading;
        },
    },
    watch: {},
    data() {
    },
    methods: {},
    mounted() {
        window.store.customer.get(this.$route.params.hash);
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables";


.map {
    height: 330px;
    width: 100%;
    position: relative;
    overflow: hidden;
    background: $brand-L3;

    iframe {
        width: 170%;
        height: 150%;
        margin-left: -35%;
        margin-top: -128px;
    }
}

.overlap {
    min-height: 220px;
    margin-top: -140px;
    border-radius: $radius;
    background: $white;
    z-index: $level3;
    position: relative;

    .logo {
        position: absolute;
        width: 170px;
        height: 170px;
        background: #F2F7FB;
        border: 10px solid $white;
        border-radius: 41.75px;
        left: 50px;
        top: -45px;
    }
}
</style>
