<template>
    <Column w8 class="campaignsettings">
        <Column centerv class="basicdetails">
            <H2 bold>Basic Details</H2>
            <P gray large>Write an introduction to the job posting. Summarizes the important elements of
                this job posting.</P>
        </Column>
             <Column>
                <Row>
                    <Input class="inputcustom" label="CAMPAIGN NAME" placeholder="Enter Campaign Name..."/>
                    <Input class="inputcustom" label="SHORT DESCRIPTION" placeholder="Write a short description..."/>
                </Row>
                <Row class="revenue">
                        <Input class="inputcustom" label="EXPECTED REVENUE" placeholder="$ 100.000"/>
                </Row>
                <Row class="date">
                    <Input class="inputcustom" label="Start date"/>
                    <Input class="inputcustom" label="End date"/>
                </Row>
            </Column>
                <Column w12 class="servicestitle">
                    <H6>Recruitment services</H6>
                    <P gray large>Har du leads i et dokument kan de manage recruitment services</P>
                </Column>
                <Column w12 class="services">
                    <Row class="singleservicewrap">
                        <Row centerv class="singleservice" v-for="item in 7">
                            <P large>Recruitment</P>
                            <Checkbox toggle></Checkbox>
                        </Row>
                    </Row>
                </Column>
    </Column>
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


.campaignsettings {
    border: solid 1px $gray-L2;
    border-radius: $radius;
    background-color: $white;
    display: block;
    min-height: 1200px;
    height: fit-content;
    padding-bottom: calc(#{$padding} * 2);

    .col{
        padding: 0 calc(#{$padding} * 2);
    }

    .basicdetails {
        border-bottom: solid 1px $gray-L2;
        padding-bottom: calc(#{$padding} * 2);
        margin-bottom: calc(#{$padding} * 3);
        padding-top: calc(#{$padding} * 2);
        min-height: calc(160px - 32px);
    }

    .inputcustom {
        margin-right: calc(#{$padding} * 2);
    }

    .revenue {
        width: 50%;
    }

    .date {
        padding-bottom: calc(#{$padding} * 4);
    }

    .servicestitle {
        border-bottom: solid 1px $gray-L2;
        padding-bottom: $padding;
    }

    .services {
        padding-top: calc(#{$padding} * 2);

        .singleservicewrap {
            flex-wrap: wrap;
            display: flex;
            max-width: 100%;
            justify-content: flex-start;

            .singleservice {
                width: fit-content;
                background-color: $white;
                border: solid 1px $gray-L2;
                border-radius: $radius;
                display: flex;
                padding: calc(#{$padding} / 2) $padding;
                margin-right: $padding;
                max-height: 54px;


                &.active {
                    background-color: $success-L1;

                    border: solid 1px $success-L2;

                    p{
                        color: $success;
                    }
                }

                p {
                    margin-right: calc(#{$padding} / 2);
                }
            }
        }
    }
}



</style>