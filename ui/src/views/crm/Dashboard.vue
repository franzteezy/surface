<template>
    <Base>
        <Wrapper full center class="bg">
            <!--Top area-->

            <Wrapper>
                <Row>

                    <!--Greeting area-->
                    <Column centerv>
                        <Row>
                            <Column>
                                <H2 white>Good morning,</H2>
                                <H2 white bold>Christopher Klint 😊</H2>
                            </Column>
                        </Row>
                        <Row>
                            <P xl class="opac">You have <span>5</span> scheduled tasks</P>
                        </Row>
                        <Row>
                            <Column w4>
                                <H2 white bold @click="seeAll">64</H2>
                                <P white large class="opac">In pipeline</P>
                            </Column>
                            <Column w8>
                                <H2 white bold @click="seeAll">32</H2>
                                <P white large class="opac">Active jobs</P>
                            </Column>

                        </Row>
                    </Column>
                    <!--Greeting area END-->

                    <!--Events area-->
                    <Column>
                        <Row>
                            <Column w10>
                                <H6 white>My upcoming events</H6>
                            </Column>
                            <Column w2 end>
                                <P white @click="seeAll">See all</P>
                            </Column>
                        </Row>
                        <Column class="darken">

                            <Row class="item" v-for="item in 4">
                                <Column w4>
                                    <P large white semibold>Today</P>
                                    <P class="opac">11:30 - 12:00</P>
                                </Column>
                                <Column w8 centerv>
                                    <P large white semibold ellipsis>Interview Christian</P>
                                </Column>
                            </Row>

                        </Column>
                    </Column>
                    <!--Events area END-->

                    <!--Campaigns area -->
                    <Column>
                        <Row>
                            <Column w10>
                                <H6 white>My Campaigns</H6>
                            </Column>
                            <Column w2 end>
                                <P white @click="seeAll">See all</P>
                            </Column>
                        </Row>
                        <Column class="darken">

                            <Row class="noborder" v-for="item in 4">
                                <Column w2 centerv>
                                    <img src="/src/assets/images/madslogo-test.svg"/>
                                </Column>

                                <Column w8 centerv>
                                    <P large white semibold ellipsis>Darlene Robertson</P>
                                    <P class="opac"><i class="icon icon-location"/> Tarrytown, NY</P>
                                </Column>

                                <Column w2 centerv>
                                    <P class="opac">20m</P>
                                </Column>
                            </Row>

                        </Column>
                    </Column>
                    <!--Campaigns area END-->
                </Row>
            </Wrapper>
            <!--Top area END-->


        </Wrapper>
        <!--Bottom area -->
        <Wrapper>
            <Row>
                <Column>
                    <Row>
                        <H6>To do</H6>
                    </Row>
                    <Todo/>
                    <Todo/>
                    <Todo/>
                </Column>
                    <Column class="activitycol">
                        <Row>
                            <H6>Recent Activity</H6>
                        </Row>
                        <Activity/>
                        <Activity/>
                        <Activity/>
                    </Column>
                <Column>
                    <Row>
                        <H6>Guides & updates</H6>
                    </Row>
                    <Column>
                        <Row class="singleguide">
                            <Column>
                                <Row>
                                    <P white large>Candidate sourcing</P>
                                </Row>
                                <Row>
                                    <H5 bold white>Find prospects and source them on LinkediN</H5>
                                </Row>
                                <Row>
                                    <Column w1 centerv><img src="/src/assets/images/avatar-template.png"/></Column>
                                    <Column w11 centerv><P large white>By Lars Nielsen</P></Column>
                                </Row>
                            </Column>
                        </Row>
                        <Row class="singleupdate">
                            <Column>
                                <Row>
                                    <P xl white>Find prospects and source them on LinkediN</P>
                                </Row>
                            </Column>
                        </Row>
                        <Row class="singleupdate">
                            <Column>
                                <Row>
                                    <P xl white>Find prospects and source them on LinkediN</P>
                                </Row>
                            </Column>
                        </Row>
                    </Column>
                </Column>
            </Row>
        </Wrapper>
        <!--Bottom area end -->
    </Base>
</template>

<script>
export default {
    computed: {},
    watch: {},
    data() {
        return {}
    },
    methods: {
        seeAll() {
        }
    },
    mounted() {

    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.darken {
    border-radius: $radius;
    background: rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    padding: 32px;

    .row {
        &:nth-child(1) {
            border-left: 3px solid $warning;
        }

        &:nth-child(2) {
            border-left: 3px solid $success;
        }

        &:nth-child(3) {
            border-left: 3px solid $error;
        }

        &:nth-child(4) {
            border-left: 3px solid $brand;
        }

        &.noborder {
            cursor: pointer;
            border-radius: $radius;
            background: #{$white}00;
            transition: $transition;
            margin-bottom: calc(#{$padding} * 1.5);
            border: none;


            img {
                max-width: 35px;
            }


            &:last-child {
                margin-bottom: 0;
            }

            &:hover {
                background: linear-gradient(90deg, rgba(255, 255, 255, 0) 8%, rgba(255, 255, 255, 0.05) 24%, rgba(255, 255, 255, 0.05) 100%);
            }
        }


        &.item {
            cursor: pointer;
            border-radius: 2px $radius $radius 2px;
            padding: 0 $padding;
            background: #{$white}00;
            transition: $transition;
            margin-bottom: calc(#{$padding} * 1.5);

            &:last-child {
                margin-bottom: 0;
            }

            &:hover {
                background: #{$white}0D;
            }
        }
    }
}

#app{
    .wrapper{
        &.bg {
            background-image: url('/src/assets/images/crm-dashboard-bg.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 60px 0;
        }
    }
}

p {
    &.opac {
        color: #{$white}99;

        span {
            color: $white;
            text-decoration: dotted;
            cursor: pointer;

            &:hover {
                text-decoration: underline;
            }
        }
    }
}



.singleguide{
    transition: $transition;
    background-image: url('/src/assets/images/single-guide-bg.jpg');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: calc(#{$padding} * 2) calc(#{$padding} * 6) calc(#{$padding} * 2) calc(#{$padding} * 2) ;
    border-radius: $radius;

    img{
        max-width: 32px;
    }

    &:hover{
        box-shadow: $shadow2;
        cursor: pointer;
    }
}


.singleupdate{
    transition: $transition;
    background-image: url('/src/assets/images/single-guide-bg.jpg');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: calc(#{$padding} * 2) calc(#{$padding} * 4) calc(#{$padding} * 2) calc(#{$padding} * 2) ;
    border-radius: $radius;

    img{
        max-width: 32px;
    }

    &:hover{
        box-shadow: $shadow2;
        cursor: pointer;
    }
}

</style>
