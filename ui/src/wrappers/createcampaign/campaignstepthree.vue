<template>
    <Column w8 class="campaignsettings">
        <Row class="basicdetails">
            <Column w2 shrink>
                <img class="leadsourceimage" src="/src/assets/images/virklogo.svg"/>
            </Column>
            <Column w11 centerv >
                <H2 bold>Virk Database</H2>
                <P gray large>Write an introduction to the job posting</P>
            </Column>
        </Row>
        <Column class="introduction">
            <P bold xl>Lorum ibsum intro</P>
            <P gray>Fagrubrikken gør det muligt at søge efter virksomheder, der tilhører et specifikt fag.</P>
        </Column>
        <Column class="filterswrapper">

            <!-- Company Status Filter -->
            <Row class="singlefilter companystatus">
                <Column w6 centerv>
                    <P xl bold>Company status <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Button>Select company status</Button>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/companystatus.svg"/>
                </Column>
            </Row>
            <!-- Company Status Filter END-->

            <!-- Location Filter -->
            <Row class="singlefilter location">
                <Column w6 centerv>
                    <P xl bold>Location <i class="icon icon-warning"/></P>
                    <Row nm>
                        <P bold class="amountselected">20</P>
                        <P bold large>SELECTED</P>
                    </Row>
                    <Row class="selectedlocations">
                        <Column centerh class="singlelocation" v-for="item in 8">
                            <P semibold>Kolding</P>
                        </Column>
                        <P class="showmore">+ 12 more</P>
                    </Row>
                    <Row>
                    <Button>Change</Button>
                    <Button white>Reset</Button>
                    </Row>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/location-campaign.svg"/>
                </Column>
            </Row>
            <!-- Location Filter END-->

            <!-- Company Type Filter -->
            <Row class="singlefilter companytype">
                <Column w6 centerv>
                    <P xl bold>Company Type <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Button>Select industries</Button>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/companytype-campaign.svg"/>
                </Column>
            </Row>
            <!-- Company Type Filter END-->

            <!-- Number of employees Filter -->
            <Row class="singlefilter employees">
                <Column w6 centerv>
                    <P xl bold>Number of employees <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Row>
                        <Input class="min" placeholder="min"/>
                        <Input placeholder="max"/>
                    </Row>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/employees-campaign.svg"/>
                </Column>
            </Row>
            <!-- Number of employees Filter END-->


            <!-- Details Criteria Filter -->
            <Row class="singlefilter companytype">
                <Column w6 centerv>
                    <P xl bold>Detail criteria <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Button>Select industries</Button>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/companytype-campaign.svg"/>
                </Column>
            </Row>
            <!-- Details Criteria Filter END-->


            <!-- Manual Search Filter -->
            <Row class="singlefilter companytype">
                <Column w6 centerv>
                    <P xl bold>Manual search <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Button>Search companies</Button>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/manualsearch-campaigns.svg"/>
                </Column>
            </Row>
            <!-- Manual Search Filter END-->

            <!-- Auto Sync Filter -->
            <Row class="singlefilter companytype">
                <Column w6 centerv>
                    <P xl bold>Auto sync leads <i class="icon icon-warning"/></P>
                    <P semibold gray large>Write an introduction to the job posting. Summarizes the important elements of.</P>
                    <Checkbox toggle/>
                </Column>
                <Column w6 end centerv>
                    <img src="/src/assets/images/autosync-campaign.svg"/>
                </Column>
            </Row>
            <!-- Auto Sync Filter END-->



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
    }

    .introduction{
        padding: calc(#{$padding} * 2) calc(#{$padding} * 2) 0 calc(#{$padding} * 2);
    }

    .leadsourceimage{
        max-width: 90px;
    }

    .filterswrapper{
        padding: calc(#{$padding} * 2);


        .singlefilter{
            padding: calc(#{$padding} * 3);
            border: solid 1px $gray-L2;
            border-radius: $radius;
            margin-bottom: calc(#{$padding} * 2);
            min-height: 280px;

            img{
                max-width: 200px;
            }

            p{
                margin-bottom: $padding;
            }

            i{
                position: relative;
                top: 3px;
                left: 5px;
                color: $gray-L1;
                font-size: 18px;
            }

            &.location{

                .amountselected{
                    background-color: #E20088;
                    padding: calc(#{$padding} / 8) calc(#{$padding} / 2);
                    border-radius: calc(#{$radius} * 3);
                    margin-right: calc(#{$padding} / 2);
                    color: $white;
                }

                .button{
                    margin-right: $padding;
                }

                .selectedlocations{
                    flex-wrap: wrap;
                    display: flex;
                    max-width: 100%;
                    justify-content: space-between;
                    max-height: 110px;
                    overflow-y: hidden;


                    .singlelocation{
                        width: fit-content;
                        max-height: 25px;
                        background-color: $gray-L4;
                        padding: calc(#{$padding} / 4) calc(#{$padding} / 3);
                        border-radius: $radius;
                        margin-bottom: calc(#{$padding} / 1.5);
                    }

                    p{
                        color: $gray-D1;


                    }

                    .showmore{
                        background-color: $brand-L5;
                        padding: calc(#{$padding} / 4) calc(#{$padding} / 2);
                        border-radius: calc(#{$radius} * 3);
                        margin-right: calc(#{$padding} / 2);
                        color: $brand;
                    }


                }
            }

            &.employees{
                .min{
                    margin-right: $padding;
                }
            }
        }

    }

}


</style>