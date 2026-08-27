<template>
    <div id="menu">
        <Wrapper nm>
            <Column centerv fill>
                <Row nm split>
                    <CrmMenu v-if="menu === 'crm'"/>
                </Row>
            </Column>
        </Wrapper>
    </div>
</template>

<script>
export default {
    props: {
        full: {Type: Boolean, default: null},
    },
    data() {
        return {
            menu: null,
        }
    },
    computed: {
    },
    methods: {
    },
    created() {
    },
    mounted() {
        
        let route_menu = this.$route.meta.menu;
        if(route_menu === null || route_menu === undefined){
            let cookie_route = this.$cookies.get("router_menu");
            this.menu = cookie_route ?? 'crm';
        } else {
            
            this.$cookies.set("router_menu", route_menu);
            this.menu = route_menu;
        }
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

#menu{
    position: sticky;
    top: 0;
    width: 100%;
    height: 56px;
    background: $white;
    border-bottom: 1px solid $gray-L2;
    display: flex;
    justify-content: center;
    z-index: $level4;
}

</style>
