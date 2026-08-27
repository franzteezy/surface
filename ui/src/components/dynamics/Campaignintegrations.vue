<template>
    <Row class="integrationsources">
        <Column class="singlesourcewrapper" v-for="item in 6">
            <Row>
                <Column w1>
                    <img class="sourceicon" src="/src/assets/images/mads-logo-test-v2.svg"/>
                </Column>
                <Column w11 end>
                    <Checkbox toggle></Checkbox>
                </Column>
            </Row>
            <Column class="sourcedetails">
                <P large bold>Datarade</P>
                <P>Fundz is a database of recently funded startups from around the...</P>
                <Button white small>connect</Button>
                <P class="sourceconnected">• connected</P>
            </Column>
        </Column>
    </Row>
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


.integrationsources {
    flex-wrap: wrap;
    display: flex;
    max-width: 100%;
    justify-content: space-between;
    overflow-y: auto;
    max-height: 1000px;
    padding: 0 calc(#{$padding} * 2);


    .singlesourcewrapper {
        border: solid 1px $gray-L2;
        border-radius: $radius;
        padding: calc(#{$padding} * 1.5);
        background-color: $white;
        max-width: 49%;
        margin: 0 0 $padding 0;

        .sourceconnected {
            display: none;
        }

        &.connected {

            .button {
                display: none;
            }

            .sourceconnected {
                display: block;
                padding: calc(#{$padding} / 2.5) $padding;
                color: $success;
                background-color: $success-L1;
                border-radius: calc(#{$radius} * 2);
                width: fit-content;
                margin-top: calc(#{$padding} / 2);
            }
        }

        .sourceicon {
            width: 35px;
        }

        .sourcedetails {
            p {
                max-width: 70%;
                word-break: break-word;
                margin-bottom: calc(#{$padding} / 2);
            }

            .button {
                margin-top: calc(#{$padding} / 2);
            }
        }

    }
}

</style>