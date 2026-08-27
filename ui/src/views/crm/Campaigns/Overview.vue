<template>
    <Base>
        <Top title="Campaigns">
            <Button white class="marg-r">Export customers</Button>
            <Button>Create campaign</Button>
        </Top>

        <!-- KPI's -->
        <Wrapper full center class="bg">
            <Wrapper>
                <Row split>
                    <Column w3 class="darken" split>
                        <Row centerv>
                            <P semibold class="opac">Total conversions</P>
                        </Row>
                        <Row centerv>
                            <H5 bold white>5941</H5>
                            <Row end>
                                <div class="tracker">

                                </div>
                            </Row>
                        </Row>
                        <Row centerv>
                            <P semibold class="opac"><span class="red">5%</span> lower than last month</P>
                        </Row>
                    </Column>


                    <Column w3 class="darken" split>
                        <Row centerv>
                            <P semibold class="opac">Total conversions</P>
                        </Row>
                        <Row centerv>
                            <H5 bold white>5941</H5>
                            <Row end>
                                <div class="tracker">

                                </div>
                            </Row>
                        </Row>
                        <Row centerv>
                            <P semibold class="opac"><span class="red">5%</span> lower than last month</P>
                        </Row>
                    </Column>


                    <Column w3 class="darken" split>
                        <Row centerv>
                            <P semibold class="opac">Total conversions</P>
                        </Row>
                        <Row centerv>
                            <H5 bold white>5941</H5>
                            <Row end>
                                <div class="tracker">

                                </div>
                            </Row>
                        </Row>
                        <Row centerv>
                            <P semibold class="opac"><span class="red">5%</span> lower than last month</P>
                        </Row>
                    </Column>


                    <Column w3 class="darken" split>
                        <Row centerv>
                            <P semibold class="opac">Total conversions</P>
                        </Row>
                        <Row centerv>
                            <H5 bold white>5941</H5>
                            <Row end>
                                <div class="tracker">

                                </div>
                            </Row>
                        </Row>
                        <Row centerv>
                            <P semibold class="opac"><span class="red">5%</span> lower than last month</P>
                        </Row>
                    </Column>
                </Row>
            </Wrapper>
        </Wrapper>

        <!-- Filters -->
        <Wrapper>
            <Campaignlistview/>
        </Wrapper>
        <!-- Filters END -->



        <!-- Campaign List -->

        <!-- Campaign List END -->
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

.bg {
    background-image: url('/src/assets/images/crm-dashboard-bg.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.darken {
    background: #{$black}66;
    border-radius: $radius;
    padding: $padding;

    .tracker {
        width: 110px;
        height: 40px;
    }
}

.opac {
    color: #{$white}99;
}

.red {
    color: #{$error}99;
}




</style>