<template>


    <Wrapper class="kpiwrapper">
        <Row split>
            <Column class="kpibox" w3 v-for="item in 4">
                <Row>
                    <Column>
                        <P gray>Lead Search</P>
                    </Column>
                    <Column end>
                        <i class="icon icon-dots-horizontal"/>
                    </Column>
                </Row>
                <Row nm>
                    <Column w6><H4 bold>294</H4></Column>
                    <Column w6 end><H4 bold gray>2321</H4></Column>
                </Row>
                <Row class="percent">
                    <span class="percentline"></span>
                    <span class="percentlinebg"></span>
                </Row>
                <Row>
                    <P gray large><i class="icon icon-arrow-up"/> +15% more then last month </P>
                </Row>
            </Column>
        </Row>
    </Wrapper>

    <!-- Leadlist Start -->
    <Wrapper class="leadlist">
        <Column>
            <Row class="sorting">
                <Column w4>
                    <P large gray>Company <i class="icon icon-double-carret"/></P>
                </Column>
                <Column w3>
                    <P large gray>Vat number <i class="icon icon-double-carret"/></P>
                </Column>
                <Column w3>
                    <P large gray>Status <i class="icon icon-double-carret"/></P>
                </Column>
                <Column w3>
                    <P large gray>Phone number <i class="icon icon-double-carret"/></P>
                </Column>
                <Column w2>

                </Column>
                <Column w1 shrink>
                    <i class="icon icon-cog"/>
                </Column>
            </Row>
            <Row class="singlelead" v-for="item in 10">
                <Column w4 centerv>
                    <Row>
                        <img alt="logo" class="companylogo" src="/src/assets/images/madslogo-test.svg"/>
                        <Column>
                            <P xl semibold>Binford Ltd.</P>
                            <P gray><img alt class="flag" flag src="/src/assets/images/us-flag.svg"/>8080 Railroad St.
                            </P>
                        </Column>
                    </Row>
                </Column>
                <Column w3 centerv>
                    <P large class="vat">31274753</P>
                </Column>
                <Column w3 centerv>
                    <P large white class="leadstatus hot"><i class="icon icon-double-carret"/> Hot lead</P>
                </Column>
                <Column w3 centerv>
                    <P large class="phone">+ 45 31111441</P>
                </Column>
                <Column w2 centerv>
                    <Row end class="leadcta">
                        <i class="icon icon-login"/>
                        <i class="icon icon-calling"/>
                        <i class="icon icon-mail-open"/>
                        <i class="icon icon-website"/>
                    </Row>
                </Column>
                <Column w1 shrink centerv>
                    <i class="icon icon-dots-vertical" @click=""/>
                </Column>
            </Row>
        </Column>
    </Wrapper>
    <!-- Leadlist End -->
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

.kpiwrapper {

    .kpibox {
        padding: calc(#{$padding} * 1.5);
        border-radius: $radius;
        border: solid 1px $gray-L2;

        .icon-arrow-up {
            color: $success;
            font-size: 20px;
            position: relative;
            top: 4px;
        }

        .percent {
            width: 100%;
            margin-top: 5px;

            .percentlinebg {
                width: 100%;
                height: 2px;
                background-color: $brand;
                opacity: 0.2;
                border-radius: 50px;


            }

            .percentline {
                width: 50%;
                height: 2px;
                background-color: $blue;
                border-radius: 50px;
            }
        }
    }

}


.leadlist {
    padding: $padding;

    i {
        position: relative;
        top: 2px;
        transition: $transition;

        &:hover {
            cursor: pointer;
            transform: scale(1.1);
        }

    }

    .sorting {
        margin-bottom: calc(#{$padding} * 2);

        i {
            color: $gray;
        }
    }

    .singlelead {

        padding: $padding 0;
        border-bottom: solid 1px $gray-L3;

        p {
            &.phone {
                color: $gray-D1;
            }

            &.vat {
                color: $gray-D1;
            }
        }

        .companylogo {
            max-width: 40px;
            margin-right: $padding;
        }

        .flag {
            max-width: 18px;
            margin-right: calc(#{$padding} / 4);
        }

        .leadstatus {
            i {
                color: $white;
            }

            &.hot {
                padding: calc(#{$padding} / 2) $padding;
                background-color: #{$error}E6;
                color: $white;
                border-radius: calc(#{$padding} * 2);
                border: solid 2px $error;
            }

            &.warm {
                padding: calc(#{$padding} / 2) $padding;
                background-color: #{$warning}db;
                color: $white;
                border-radius: calc(#{$padding} * 2);
                border: solid 2px $warning;
            }

            &.cold {
                padding: calc(#{$padding} / 2) $padding;
                background-color: #{$blue}f0;
                color: $white;
                border-radius: calc(#{$padding} * 2);
                border: solid 2px $blue;
            }

        }

        .leadcta {

            i {
                margin-right: $padding;
            }

            .icon-login {
                color: #E20088;
                font-size: 20px;
            }

            .icon-calling {
                color: #EEA537;
                font-size: 20px;
            }

            .icon-mail-open {
                color: $brand;
                font-size: 20px;
            }

            .icon-website {
                color: $success;
                font-size: 20px;
            }

        }
    }
}


</style>