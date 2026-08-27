<template>
    <Wrapper class="campaignlistview">
        <Column v-for="item in 8">
            <row centerv class="campaignrow">
                <Column w1>
                    <img src="/src/assets/images/campagin-placeholder-image.png"/>
                </Column>
                <Column w3>
                    <P large bold ellipsis @click="" class="campaigntitle">Airline personnel</P>
                    <P gray ellipsis>Created by Morten Sandvei</P>
                </Column>
                <Column w3 class="activecons">
                    <img src="/src/assets/images/madslogo-test.svg"/>
                </Column>
                <Column w1>
                    <P large bold>554</P>
                    <P gray>Leads</P>
                </Column>
                <Column w2>
                    <P large bold>123 / 554</P>
                    <P gray>Treated</P>
                </Column>
                <Column w1>
                    <P large bold><i class="icon icon-arrow-up-a"/>3.5%</P>
                    <P gray>Conv. rate</P>
                </Column>
                <Column w2>
                    <P large bold><i class="icon icon-arrow-up-a"/>32</P>
                    <P gray>Contracts sent</P>
                </Column>
                <Column w2>
                    <Button white>Open campaign</Button>
                </Column>
            </row>
        </Column>
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



.campaignrow {

    transition: $transition;
    border-bottom: solid $gray-L2 1px;
    padding: $padding;

    img {
        max-width: 61px;
        max-height: 48px;
    }

    .activecons {
        img {
            max-width: 32px;
        }
    }

    i {
        color: $success;
        position: relative;
        margin-right: 4px;
    }

    .campaigntitle:hover{
        color: $brand;
    }



}


</style>