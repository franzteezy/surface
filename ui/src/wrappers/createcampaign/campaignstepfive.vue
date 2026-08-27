<template>
    <Column w8 class="campaignsettings">
        <Column centerv class="basicdetails">
            <H2 bold>User access</H2>
            <P gray large>These users will be able to see and act in this segmentation</P>
        </Column>

        <!-- Added Employees section -->
        <Column class="employeewrapper">
            <Column>
                <P bold xl>Added</P>
            </Column>
            <Row class="addedemployeewrapper">
                <Row centerv class="addedemployee" v-for="item in 6">
                    <Column w2>
                        <img src="/src/assets/images/employee-avatar.png"/>
                    </Column>
                    <Column w8>
                        <P class="name" large ellipsis>Jerome Bellandozan</P>
                    </Column>
                    <Column w2>
                        <i class="icon icon-clear"/>
                    </Column>
                </Row>
            </Row>
            <!-- Added Employees section END-->

            <!-- Search Employees section -->
            <Column>
                <Input placeholder="Search user..."/>
            </Column>
            <!-- Search Employees section END-->

            <!-- ADD Employees section -->
            <Column>
                <Row class="addemployeewrapper">
                    <Row centerv class="addemployee" v-for="item in 6">
                        <Column w2 center>
                            <i class="icon icon-add"/>
                            <img class="avatar" src="/src/assets/images/employee-avatar.png"/>
                        </Column>
                        <Column w10>
                            <P bold class="name" large ellipsis>Jerome Bellandozan</P>
                        </Column>
                    </Row>
                </Row>
            </Column>
            <!-- ADD Employees section END-->

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
    min-height: 600px;
    height: fit-content;
    padding-bottom: calc(#{$padding} * 2);

    .basicdetails {
        border-bottom: solid 1px $gray-L2;
        padding: calc(#{$padding} * 2);
        min-height: calc(160px - 32px);
        margin-bottom: calc(#{$padding} * 2);
    }

    .employeewrapper {
        padding: 0 calc(#{$padding} * 2);

        .addedemployeewrapper {
            flex-wrap: wrap;
            width: 100%;
            margin-top: $padding;
            margin-bottom: $padding;


            .addedemployee {
                padding: calc(#{$padding} / 2);
                border-radius: $radius;
                background-color: $success-L2;
                border: solid 1px $success-L1;
                max-width: fit-content;
                min-height: 40px;
                margin-right: $padding;
                margin-bottom: $padding;
                transition: $transition;

                .name {
                    max-width: 85px;
                    color: $gray-D2;
                }

                .icon-clear {
                    transition: $transition;
                }


                .avatar{
                    max-width: 24px;
                    border-radius: 50px;
                }

                &:hover {

                    background-color: $error-L2;
                    border: solid 1px $error-L1;
                    cursor: pointer;

                    .icon-clear {
                        color: $error;
                    }

                    .name {
                        color: $error;
                    }
                }
            }
        }


        .addemployeewrapper {
            flex-wrap: wrap;
            width: 100%;
            margin-top: calc(#{$padding} * 2);

            .addemployee {
                padding: calc(#{$padding} / 2);
                min-height: 40px;
                margin-right: $padding;
                margin-bottom: $padding;
                transition: $transition;
                min-width: 200px;
                max-width: fit-content;
                border-radius: calc(#{$radius} * 4);
                border: solid 1px $white;

                .name {
                    max-width: 200px;
                    color: $gray-D2;
                }

                .avatar{
                    width: 34px;
                    border-radius: 50px;
                }

                .icon-add {
                    display: none;
                    text-align: center;
                    padding: calc(#{$padding} / 2);
                    max-width: 34px;
                    max-height: 34px;
                    font-size: 19px;
                }

                &:hover {
                    cursor: pointer;
                    border: solid 1px $gray-L2;

                    .icon-add {
                        display: block;
                        background-color: $brand;
                        color: $white;
                        border-radius: 50px;
                        box-shadow: $shadow;
                    }

                    img {
                        display: none;
                    }
                }
            }
        }

    }

}


</style>