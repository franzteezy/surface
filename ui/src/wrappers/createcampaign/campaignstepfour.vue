<template>
    <Column w8 class="campaignsettings">
        <Column centerv class="basicdetails">
            <H2 bold>Pipeline</H2>
            <P gray large>Write an introduction to the job posting</P>
        </Column>
            <Column class="pipelinewrapper">
                <Row centerv class="pipestep" v-for="item in 5">
                    <span class="pipestepcolor"></span>
                    <Column w11>
                        <H6 bold>1. Prospecting</H6>
                    </Column>
                    <Column w2 centerh>
                        <i class="icon icon-trash"/>
                    </Column>
                </Row>
                <Column centerh>
                    <i class="icon icon-add"/>
                </Column>
            </Column>
    </Column>
</template>

<script>
import _ from 'lodash';

export default {
    props: {},
    data() {
        return {}
    },
    computed: {},
    methods: {},
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";


.campaignsettings {
    border: solid 1px $gray-L2;
    border-radius: $radius;
    background-color: $white;
    display: block;
    height: fit-content;
    padding-bottom: calc(#{$padding} * 2);

    .basicdetails {
        border-bottom: solid 1px $gray-L2;
        padding: calc(#{$padding} * 2);
        min-height: calc(160px - 32px);
        margin-bottom: calc(#{$padding} * 2);
    }



    .icon-add{
        padding: $padding;
        border-radius: $radius;
        border: dashed 1px $gray-L2;
        color: $gray-L1;
        transition: $transition;
        width: 100%;
        text-align: center;

        &:hover{
            border: dashed 1px $brand-L2;
            color: $brand;
            background-color: $brand-L5;
            cursor: pointer;
        }
    }

    .pipelinewrapper{
        padding: $padding calc(#{$padding} * 2);

            .pipestep{
                border: solid 1px $gray-L2;
                border-radius: $radius;
                min-height: 75px;
                transition: $transition;
                margin-bottom: $padding;

                .icon-trash{
                    display: none;
                    transition: $transition;
                }

                &:hover{
                    box-shadow: $shadow;
                    cursor: pointer;

                    .icon-trash{
                        display: block;
                        font-size: 20px;
                        color: $gray-D1;

                        &:hover{
                            transform: scale(1.1);
                            color: $error;
                        }
                    }

                }

                .pipestepcolor{
                    height: 40px;
                    width: 4px;
                    background-color: $success;
                    margin: 0 calc(#{$padding} * 1.5) 0 12px;
                    border-radius: $radius;
                }
            }
        }


    }


</style>