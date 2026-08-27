<template>
    <Base>
        <Wrapper>
            <Row>
                <!-- Campaign settings Left Box Start -->
                <Campaignstepfour/>
                <!--Campaign settings Left Box End -->

                <!--Campaign Overview Right Box End -->
                <Column w4 class="campaignoverview">
                    <H5>Campaign overview</H5>
                    <Column>
                        <div class="image">
                            <Column class="buttons" center>
                                <Button>Change Image</Button>
                                <Button white>Remove Image</Button>
                            </Column>
                        </div>
                    </Column>
                    <Column class="campaignname">
                        <P large bold class="subtitles">CAMPAIGN NAME</P>
                        <P gray large>Campaign name</P>
                    </Column>
                    <Column class="campaigndescription">
                        <P large bold class="subtitles">DESCRIPTION</P>
                        <P gray large>Write an introduction to the job posting. Summarizes the important elements of
                            this job posting.</P>
                    </Column>
                    <Row>
                        <Column w6>
                            <P large bold class="subtitles">Lead Source</P>
                        </Column>
                        <Column w6 end>
                            <i class="icon icon-editing"></i>
                        </Column>
                    </Row>
                    <Column class="leadsource">
                        <img alt="logo" class="leadsourceimage" src="/src/assets/images/mads-logo-test-v2.svg"/>
                        <P large bold>Datarade</P>
                        <P gray>Fundz is a database of recently funded startups from around the</P>
                    </Column>
                    <Column>
                        <P large bold class="subtitles pipeline">pipeline</P>
                        <Row class="pipestepmini" centerv v-for="item in 5">
                            <div class="pipecolor" style="height: 15px; width: 2px; background-color: #27AE60;"></div>
                            <Column w10>
                                <P large>1. Terms Sent</P>
                            </Column>
                        </Row>
                    </Column>
                    <Column class="launch">
                        <Button white xl>Save for later</Button>
                        <Button xl>Launch campaign</Button>
                    </Column>
                </Column>
                <!--Campaign Overview Right Box End -->
            </Row>
        </Wrapper>
    </Base>
</template>

<script>

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
@import "/src/assets/variables";

main {
    background: linear-gradient(0deg, #FAFBFF, #FAFBFF), linear-gradient(0deg, rgba(250, 251, 252, 0.7), rgba(250, 251, 252, 0.7)), #FFFFFF;
}


.campaignoverview {
    border: solid 1px $gray-L2;
    border-radius: $radius;
    padding: calc(#{$padding} * 2);
    background-color: $white;
    height: fit-content;
    position: sticky;
    top: 60px;


    .buttons {
        margin-top: 30px;

        .button {
            margin-bottom: $padding;
        }
    }

    .image {
        background-image: url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=700");
        background-position: center center;
        background-size: contain;
        border-radius: $radius;
        max-width: 330px;
        min-height: 155px;
        max-height: 155px;
        margin-top: calc(#{$padding} * 2);
        margin-bottom: calc(#{$padding} * 2);
        width: 100%;

    }

    .campaignname {
        margin-bottom: calc(#{$padding} * 2);
    }

    .campaigndescription {
        margin-bottom: calc(#{$padding} * 2);
    }


    .subtitles {
        text-transform: uppercase;
        color: $gray-D2;

        &.pipeline {
            margin-bottom: $padding;
        }
    }

    .leadsource {
        border: solid 1px $gray-L2;
        border-radius: $radius;
        padding: calc(#{$padding} * 1.5);
        margin-bottom: calc(#{$padding} * 2);
        transition: $transition;

        img {
            max-width: 36px;
            border-radius: $radius;
            margin-bottom: calc(#{$padding} / 2);
        }

        p {
            margin-bottom: calc(#{$padding} / 2);
        }

        &:hover {
            cursor: pointer;
            box-shadow: $shadow;
            border: solid 1px $brand;
        }
    }

    .pipestepmini {
        padding: calc(#{$padding} / 2);
        border-radius: $radius;
        border: solid 1px $gray-L2;

        .pipecolor {
            margin-right: $padding;
        }

        .row {
            margin-bottom: calc(#{$padding} / 2);
        }
    }

    .launch {
        margin-top: calc(#{$padding} * 2);
        padding: calc(#{$padding} * 2) 0 $padding 0;

        .button {
            margin-bottom: $padding;
        }
    }


}


</style>