<template>
    <Row class="acitivitywrapper">
        <Column w1>
            <img src="/src/assets/images/avatar-template.png"/>
        </Column>

        <Column w10 centerv>
            <P large ellipsis>Darlene Robertson</P>
            <P class="sub-activity">added <a>James Hansen</a> to shedule</P>
            <P gray>5 Min ago</P>
            <Row class="accept-activity">
                <Button small>Accept</Button>
                <Button white small>Reject</Button>
            </Row>
            <Row class="note-activity">
                <Column>
                    <Row class="note"><P>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ipsum in leo vulputate blandit sit. Velit aliquam quam tellus libero iaculis faucibus adipiscing dictum.</P></Row>
                    <Row><P gray>12 jan. 12:00 PM</P></Row>
                </Column>
            </Row>
        </Column>

        <Column w1 centerv>
            <span class="watch"><i class="icon icon-unhide"/></span>
        </Column>


    </Row>
</template>

<script>
import _ from 'lodash';

export default {
    props: {

    },
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


    .acitivitywrapper {
        border-bottom: solid 1px $gray-L3;
        border-radius: $radius;
        padding: $padding;
        transition: $transition;

        .sub-activity{
            color: $gray-D1;
        }

        a {
            color: $brand;
        }

        .accept-activity{
            margin-top: $padding;

            .button{
                margin-right: calc(#{$padding} / 2);
            }


        }

        .note-activity{

            .note{
                padding: $padding;
                border-left: solid 2px $gray-L1;
                border-radius: 2px;

                p{
                    color: $gray-D2;
                }

            }

        }

        .watch {
            background-color: $white;
            border: solid 1px $gray-L2;
            border-radius: 25px;
            width: 32px;
            height: 32px;
            text-align: center;
            transition: $transition;

            i {
                transition: $transition;
                font-size: 17px;
                color: $gray-L2;
                position: relative;
                top: 5px;
            }

            &:hover{
                background-color: $brand-L5;
                border: solid 1px $brand-L4;
                cursor: pointer;

                i{
                    color: $brand;
                }

            }
        }


    }

    img {
        max-width: 32px;
    }




</style>