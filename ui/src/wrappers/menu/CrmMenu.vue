<template>
    <ModuleArea module="crm" icon="crm"/>
    <Nav :menu="menu_data"/>
    <UserArea :chatNotif="user.socketNotif"/>
</template>

<script>

export default {
    props: {},
    data(){
        return{
            menu_data: {
                Dashboard: '/crm/dashboard',
                Campaigns: '/crm/campaigns',
                Customers: '/crm/customers',
                Organize: '/crm/organize',
                Documents: '/crm/documents',
            }
        }
    },
    computed: {
        user(){
            return window.store.auth;
        }
    },
    methods: {
    },
    created : function(){
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

</style>