<template>
    <div class="wrapper">

        <H1>Notifications</H1>
        <br />
        <div class="objects">
            <Button @click="invokeStandard">Standard notification</Button>
            <Button @click="invokeWarning">Warning notification</Button>
            <Button @click="invokeSuccess">Success notification</Button>
        </div>
        <br />
        <div class="objects">
            <Button @click="invokeSmallStandard">Small standard notification</Button>
            <Button @click="invokeSmallWarning">Small warning notification</Button>
            <Button @click="invokeSmallSuccess">Small success notification</Button>
        </div>
        <br />
        <div class="objects">
            <Button @click="invokeSmallStandardStaying">Small standard notification that doesnt timeout</Button>
            <Button @click="invokeSmallWarningStaying">Small warning notification that doesnt timeout</Button>
            <Button @click="invokeSmallSuccessStaying">Small success notification that doesnt timeout</Button>
        </div>
        <div class="attr">
            <H3>How to create:</H3>
            <P>You can invoke an notification easily by calling


                <b><pre>
            window.mitt.emit('notification', {
                title: 'This is a title', //this is optional (iut will be small if there is no title)
                message: 'this is the message on the notification', //(required)
                warning: true, //if this is true it will be a warning style (optional)
                success: true //if this is true it will be a success style (optional)
            })</pre></b>
                </P>

            <br/>
            <br/>
            <br/>
            <H6>Wrapper function</H6>
            <pre>
                window.notify(message, title = null, warning = false, success = false, timeout = 5000);
                //set timeout to 0 and it will stay until user clicks destroy
            </pre>

            <H6>Below you can se all examples of notifications above</H6>

            <pre>
                invokeStandard(){
                    window.notify('this is the message on the notification', 'Standard notification');
                },
                invokeWarning(){
                    window.notify('this is the message on the notification', 'Warning notification', true);
                },
                invokeSuccess(){
                    window.notify('this is the message on the notification', 'Success notification', false, true);
                },
                invokeSmallStandard(){
                    window.notify('this is the message on the notification');
                },
                invokeSmallWarning(){
                    window.notify('this is the message on the notification', null, true);
                },
                invokeSmallSuccess(){
                    window.notify('this is the message on the notification', null, false, true);
                },
                invokeSmallStandardStaying(){
                    window.notify('this is the message on the notification', null, false, false, 0);
                },
                invokeSmallWarningStaying(){
                    window.notify('this is the message on the notification', null, true, false, 0);
                },
                invokeSmallSuccessStaying(){
                    window.notify('this is the message on the notification', null, false, true, 0);
                },
            </pre>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            clicked: false,
        }
    },
    methods:{
        invokeStandard(){
            window.notify('this is the message on the notification', 'Standard notification');
        },
        invokeWarning(){
            window.notify('this is the message on the notification', 'Warning notification', true);
        },
        invokeSuccess(){
            window.notify('this is the message on the notification', 'Success notification', false, true);
        },
        invokeSmallStandard(){
            window.notify('this is the message on the notification');
        },
        invokeSmallWarning(){
            window.notify('this is the message on the notification', null, true);
        },
        invokeSmallSuccess(){
            window.notify('this is the message on the notification', null, false, true);
        },
        invokeSmallStandardStaying(){
            window.notify('this is the message on the notification', null, false, false, 0);
        },
        invokeSmallWarningStaying(){
            window.notify('this is the message on the notification', null, true, false, 0);
        },
        invokeSmallSuccessStaying(){
            window.notify('this is the message on the notification', null, false, true, 0);
        },
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.wrapper {
    max-width: 1280px;
    margin: 64px auto auto;
    width: 100%;

    .objects{
        display: flex;

        .button{
            margin-right: 8px;
        }
    }

    .attr{
        width: calc(100% - 80px);
        height: auto;
        display: flex;
        flex-direction: column;
        margin: 24px 0 100px;
        background-color: $gray-L2;
        padding: 40px;

        .change{
            width: 13px;
            height: 13px;
            margin-right: 3px;
            display: inline-block;
            border-radius: 100%;
            background-color: $brand-L2;
            opacity: 0;
            transition: 0.2s;

            &.changed{
                opacity: 1;
            }
        }

        strong{
            width: 200px;
            display: inline-block;
            margin-left: 22px;

            &:first-child{
                margin-left: 40px;
            }
        }

        i{
            font-weight: 900;
            color: $success;
            font-family: $font-family;
            margin: 0 20px 0 0;
        }
    }
}
</style>