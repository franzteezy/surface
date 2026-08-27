<template>
    <div class="wrapper">

        <H1>Buttons</H1>
        <br />
        <div class="objects">
            <Button @click="clickButton" icon="search">Standard primary button</Button>
            <Button white @click="clickButton" icon="checkmark">Standard white button</Button>
            <Button light @click="clickButton" icon="trash">Standard light button</Button>
        </div>
        <br />
        <div class="objects">
            <Button small @click="clickButton" icon="search">Small primary button</Button>
            <Button small white @click="clickButton" icon="checkmark">Small white button</Button>
            <Button small light @click="clickButton" icon="trash">Small light button</Button>
        </div>
        <br />
        <div class="objects">
            <Button large @click="clickButton" icon="search">Large primary button</Button>
            <Button large white @click="clickButton" icon="checkmark">Large white button</Button>
            <Button large light @click="clickButton" icon="trash">Large light button</Button>
        </div>
        <br />
        <div class="objects">
            <Button xl @click="clickButton" icon="search">Extra large primary button</Button>
            <Button xl white @click="clickButton" icon="checkmark">Extra large white button</Button>
            <Button xl light @click="clickButton" icon="trash">Extra large light button</Button>
        </div>
        <div class="attr">
            <H3>Attributes</H3>
            <P><strong><b>light</b></strong> Create a light type button</P>
            <P><strong><b>white</b></strong> Create a white type button</P>
            <P><strong><b>small</b></strong> Make the button small</P>
            <P><strong><b>large</b></strong> Make the button large</P>
            <P><strong><b>xl</b></strong> Make the button extra large</P>
            <P><strong><b>icon</b>=<i>"text"</i></strong> Show an icon in the button</P>
            <P><span :class="{change:true, changed:clicked}"></span><strong><b>@click</b>=<i>"function"</i> </strong>Function that triggers on a click, try write and see the effect</P>
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
        clickButton(){
            this.clicked = true;
            window.setTimeout(() => {
                this.clicked = false;
            }, 400);
        },
    },
    created() {},
    mounted() {}
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