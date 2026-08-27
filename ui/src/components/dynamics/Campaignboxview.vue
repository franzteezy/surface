<template>
    <Wrapper class="campaignboxwrapper">
        <Row class="campaignboxrow" split wrap>
            <Column class="campaignboxcol" w4 v-for="item in 4">
                <Column class="campaignboxcolinner">
                    <Row class="campaignheaderimg"></Row>
                    <Row>
                        <Column w8>
                            <P large bold>Online Retail Industry</P>
                            <P gray>Total leads 23242</P>
                        </Column>
                        <Column w4>
                            <img src="/src/assets/images/agents.png"/>
                        </Column>
                    </Row>
                </Column>
                <row class="campaignboxbuttons">
                    <Column>
                        <Button white>Open in Dialer</Button>
                    </Column>
                    <Column end>
                        <Button>View campaign</Button>
                    </Column>
                </row>
            </Column>
        </Row>
    </Wrapper>
</template>

<script>
import _ from 'lodash';

export default {
    props: {},
    data(){
        return{
        }
    },
    computed: {

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


.campaignboxrow{
    .col{
        &.campaignboxcol{
            margin-right: 0;
            max-width: 32%;
            margin-bottom: calc(#{$padding} * 1.5);
            border-radius: $radius;
            border: solid $gray-L2 1px;

            .campaignboxcolinner{
                padding: calc(#{$padding} * 1.5);
            }
        }
    }

    .campaignheaderimg{
        background-image: url('https://images.unsplash.com/photo-1496247749665-49cf5b1022e9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 100px;
        border-radius: $radius;

    }

    img{ // Den her skal fjernes, agents skal byttes ud med component
        max-height: 32px;
        max-width: 92px;
    }

    .campaignboxbuttons{
        border-top: solid 1px $gray-L2;
        padding: calc(#{$padding} * 1.5);
    }

}

</style>