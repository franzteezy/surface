<template>
    <div class="wrapper">

        <H1>Dynamics</H1>
        <br />
        <br />
        <H3>Steps</H3>
        <div class="objects">
            <Steps :steps="steps" v-model:active="step" clickable/>
        </div>
        <div class="attr">
            <H3>How to create:</H3>
            <P><strong><b>clickable</b></strong> Make the steps clickable</P>
            <P><strong><b>v-model:step</b>=<i>"variable"</i></strong> The current step as a number e.g. "0"</P>
            <P><strong><b>steps</b>=<i>"array"</i></strong> Array of steps as object -> {icon:'call', title:'Phonenumber'}</P>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            step: 0,
            steps: [
                {
                    icon: 'lightning',
                    title: 'Basic details'
                },
                {
                    icon: 'password',
                    title: 'Password'
                },
                {
                    icon: 'username',
                    title: 'Profile image'
                },
                {
                    icon: 'call',
                    title: 'Add Phone'
                }
            ]
        }
    },
    methods:{
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