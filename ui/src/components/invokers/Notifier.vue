<template>
    <div class="notifications">
        <Notification :key="notification.id" v-for="(notification, key) in notifications" :success="notification.success?true:null" :timeout="notification.timeout" :warning="notification.warning?true:null" @destroy="destroy(notification)" :bottom="getHeightForKey(key)+'px'" :title="notification.title">{{notification.message}}</Notification>
    </div>
</template>

<script>
export default {
    props: {},
    data() {
        return {
            notifications: [],
        }
    },
    computed: {
    },
    methods: {
        destroy(notification){
            let deleting = null;
            for (let i in this.notifications){
                if(notification.id === this.notifications[i].id){
                    deleting = i;
                }
            }
            this.notifications.splice(deleting, 1);
        },
        invokeNotification(data){
            data.id = window.makeid(10);
            this.notifications.push(data)
        },
        getHeightForKey(key){
            let space = 16;
            for (let itemKey in this.notifications){
                let item = this.notifications[itemKey];

                if(parseInt(itemKey) === key){
                    return space;
                }

                if(item.title){
                    space += 88;
                } else {
                    space += 48;
                }

                space += 16;
            }
        }
    },
    created() {
        window.notify = (message, title = null, warning = false, success = false, timeout = 5000) => {
            this.invokeNotification({
                title: title,
                message: message,
                success: success,
                warning: warning && !success,
                timeout: timeout
            })
        }
    },
    mounted() {
        window.mitt.on('notification', this.invokeNotification);
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables";

</style>
