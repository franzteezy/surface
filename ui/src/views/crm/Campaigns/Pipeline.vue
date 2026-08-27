<template>
    <Wrapper class="pipewrapper">
        <Row class="pipelineinner">
            <Column class="pipestep" v-for="item in 4">
                <Row class="pipestepdetails">
                    <Column centerv shrink w10>
                        <P large bold ellipsis>Terms sent</P>
                    </Column>
                    <Column centerv>
                        <P class="amountinpipe" bold>23</P>
                    </Column>
                </Row>
                <Wrapper class="leadwrapper" nm v-for="item in 2">
                <Column class="lead" >
                    <Row>
                        <Column centerv w2 shrink>
                            <img src="/src/assets/images/madslogo-test.svg"/>
                        </Column>
                        <Column centerv w9>
                            <P gray large>Royal Dutch Shell</P>
                        </Column>
                        <Column centerv w1 shrink>
                            <P gray>3d</P>
                        </Column>
                    </Row>
                </Column>
                <Row class="leadcta">
                    <Column w2 shrink><i class="icon icon-mail-open"/></Column>
                    <Column w8><i class="icon icon-call"/></Column>
                    <Column w2 shrink><i class="icon icon-blacklist"/></Column>
                </Row>
                </Wrapper>
            </Column>
        </Row>
    </Wrapper>
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

.pipewrapper {
    padding: $padding;
    border-radius: $radius;
    border: solid 1px $gray-L2;
    background-color: $gray-L4;

    .pipelineinner {
        flex-grow: 1;
        overflow-x: auto;
    }

    .col {

        &.pipestep {
            min-width: 320px;
            margin-right: $padding;
            margin-right: 16px;
            min-height: 700px;
            max-height: 900px;
            padding: 8px;
            overflow-x: hidden;
            overflow-y: auto;
        }

    }

    .pipestepdetails {
        border-bottom: solid 2px $success;
        padding-bottom: calc(#{$padding} / 2);
        margin-bottom: 0;

    }

    p {
        &.amountinpipe {
            background-color: $success-L1;
            border-radius: $radius;
            padding: 2px 4px;
            color: $success;
        }
    }
}

.leadwrapper{
    position: relative;
    transition: $transition;

    .lead {
        padding: $padding;
        border-radius: $radius;
        transition: $transition;
        margin-top: $padding;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.04), 0px 0px 2px rgba(0, 0, 0, 0.06), 0px 0px 1px rgba(0, 0, 0, 0.04);
        background-color: $white;
        flex-grow: unset;
        position: relative;
        z-index: 2;

        &:hover {
            cursor: pointer;
        }

        img {
            max-width: 32px;
        }
    }

    .leadcta{
        padding: $padding;
        border-radius: $radius;
        transition: $transition;
        position: absolute;
        top: 16px;
        background: $white;

        i{
            background-color: $success-L2;
            border-radius: $radius;
            padding: calc(#{$padding} / 2 );
            border: solid 1px $success-L1;
            color: $success;
            font-size: 13px;
            max-width: 32px;
        }

        .icon-call{
            background-color: $success-L2;
            border-radius: $radius;
            padding: calc(#{$padding} / 2 );
            border: solid 1px $success-L1;
            color: $success;
            font-size: 13px;
            max-width: 32px;
            transition: $transition;

            &:hover{
                transform: scale(1.1);
                cursor: pointer;
            }
        }

        .icon-mail-open{
            background-color: #{$blue}1A;
            border-radius: $radius;
            padding: calc(#{$padding} / 2 );
            border: solid 1px #{$blue}1A;
            color: #2F80ED;
            font-size: 13px;
            max-width: 32px;
            transition: $transition;

            &:hover{
                transform: scale(1.1);
                cursor: pointer;
            }
        }

        .icon-blacklist{
            background-color: $error-L2;
            border-radius: $radius;
            padding: calc(#{$padding} / 2 );
            border: solid 1px $error-L1;
            color: $error;
            font-size: 13px;
            max-width: 32px;
            transition: $transition;

            &:hover{
                transform: scale(1.1);
                cursor: pointer;
            }
        }

    }

    &.active{
        margin-bottom: 65px;

        .leadcta{
            position: absolute;
            top: 80px;
            padding: $padding;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.04), 0px 0px 2px rgba(0, 0, 0, 0.06), 0px 0px 1px rgba(0, 0, 0, 0.04);
            border-radius: 0 0 $radius $radius;
        }
    }
}
</style>