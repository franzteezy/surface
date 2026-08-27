<template>
    <Wrapper class="creation-wrapper" nm>
        <Row v-if="companies_loading === 'get'" centerh class="marg-b marg-t">
            <img alt="loader" src="/src/assets/svg/loader.svg" width="60"/>
        </Row>
        <div v-if="companies_loading !== 'get'">
            <Row centerv>
                <Column w6>
                    <Button icon="arrow-left" light @click="reset">Back to selection</Button>
                </Column>
                <Column end w6>
                    <P>View company details on <span class="blue" @click="goTo"><img :src="company.source_image" alt=""
                                                                                     height="14"/> <i
                        class="icon icon-export"/></span></P>
                </Column>
            </Row>
            <Row class="marg-t" nm>
                <div class="map">
                    <iframe :class="{show:iframe_loaded}"
                            :src="'https://www.google.com/maps/embed/v1/search?zoom=8&key=AIzaSyCVW1zrdMUlx5-zhGVzU1Lw9pNo_psa6OU&q='+company.address"
                            loading="lazy"
                            @load="iframe_loaded = true"/>
                </div>
            </Row>
            <Row class="overlap-t pad-t marg-b">
                <div class="logo">
                    <i class="icon icon-company"/>
                </div>

                <Column>
                    <Row class="marg-t">
                        <Column>
                            <H3 bold>{{ company.name }}</H3>
                            <P gray large>{{ company.address }}</P>
                        </Column>
                    </Row>
                    <Row class="pad-t marg-t border-t marg-b pad-b">
                        <Column class="base-details">
                            <Row v-for="field in fields" class="marg-t" nm>
                                <Column w5>
                                    <Row centerv>
                                        <i class="icon icon-website"/>
                                        <P large semibold>{{ field.name }}</P>
                                    </Row>
                                </Column>
                                <Column w7>
                                    <P large>
                                        <a v-if="field.click !== null" :href="'http://'+company[field.text]"
                                           target="_blank">{{ company[field.text] ?? '-' }}</a>
                                        {{ field.click === null ? (company[field.text] ?? '-') : '' }}
                                    </P>
                                </Column>
                            </Row>
                        </Column>
                    </Row>
                    <Row :class="{'expandable marg-t':true, open:detail_expanded}" centerv
                         v-if="false" @click="detail_expanded = !detail_expanded">
                        <Column>
                            <Row centerv>
                                <Column w6>
                                    <H6 bold>Extra information</H6>
                                </Column>
                                <Column end w6>
                                    <i :class="{expander:true, icon:true, 'icon-pointer-up':!detail_expanded,'icon-pointer-down':detail_expanded}"/>
                                </Column>
                            </Row>
                        </Column>
                    </Row>
                    <Row v-if="detail_expanded" class="marg-t">
                        <Column>
                            <Row class="marg-b marg-t">
                                <Column w5>
                                    <Row centerv>
                                        <P overline semibold>Description</P>
                                    </Row>
                                </Column>
                                <Column w7>
                                    <P large>Selskabet tegnes af en direktør eller af den samlede bestyrelse.</P>
                                </Column>
                            </Row>
                            <Row class="marg-b marg-t">
                                <Column w5>
                                    <Row centerv>
                                        <P overline semibold>Description</P>
                                    </Row>
                                </Column>
                                <Column w7>
                                    <P large>Selskabet tegnes af en direktør eller af den samlede bestyrelse.</P>
                                </Column>
                            </Row>
                        </Column>
                    </Row>
                </Column>
            </Row>
        </div>
    </Wrapper>
</template>

<script>

export default {
    computed: {
        customer() {
            return window.store.customer.single;
        },
        company() {
            let item = {...window.store.company.single};
            item.zipcity = window.store.company.single.zip + ' ' + window.store.company.single.city;
            return item;
        },
        companies() {
            return window.store.company.many;
        },
        companies_loading() {
            return window.store.company.loading;
        },
    },
    data() {
        return {
            iframe_loaded: false,
            detail_expanded: false,
            fields: [
                {
                    name: 'Company identification',
                    text: 'identification',
                    icon: 'companies-find',
                    click: null
                },
                {
                    name: 'Zipcode & city',
                    text: 'zipcity',
                    icon: 'radar',
                    click: null
                },
                {
                    name: 'Country',
                    text: 'country',
                    icon: 'location',
                    click: null
                },
                {
                    name: 'Email',
                    text: 'email',
                    icon: 'email-open',
                    click: null
                },
                {
                    name: 'Phone',
                    text: 'phone',
                    icon: 'call',
                    click: null
                },
                {
                    name: 'Website',
                    text: 'website',
                    icon: 'website',
                    click: true,
                },
            ]
        }
    },
    methods: {
        reset() {
            window.store.company.single.identification = null;
        },
        goToWebsite() {
            window.open(this.company.reference, '_blank');
        },
        goTo() {
            window.open(this.company.reference, '_blank');
        }
    },
    mounted() {

    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.creation-wrapper {
    width: 750px;
}

.expandable {
    height: 88px;
    cursor: pointer;
    background: $brand-L5;
    border-radius: 0 0 $radius $radius;

    &.open {
        border-radius: 0;
    }

    .expander {
        width: 40px;
        height: 40px;
        border-radius: 100%;
        border: 1px solid $gray-L2;
        background: $white;
        color: $gray-D1;
        text-align: center;
        line-height: 40px;
        cursor: pointer;
    }
}

a {
    color: $blue;
    cursor: pointer;
    text-decoration: none;
}

.border-t {
    border-top: 1px solid $gray-L2;
}

.base-details {
    i {
        margin-right: $padding;
    }
}

.overlap-t {
    margin-top: -20px;
    background: $white;
    border-radius: $radius;
    z-index: $level3;
    border: 1px solid $gray-L2;
    position: relative;
    margin-bottom: $padding;

    & > .col > .row {
        padding-left: 40px;
        padding-right: 40px;
    }

    .logo {
        position: absolute;
        width: 70px;
        height: 70px;
        border-radius: $radius;
        background: $gray-L2;
        border: 4px solid $white;
        left: 40px;
        top: -48px;
        box-shadow: 0 2px 0 0 rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 0 2px 0 0 rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 2px 0 0 rgba(0, 0, 0, 0.1);

        i {
            font-size: 32px;
            color: $brand;
            width: 100%;
            height: 100%;
            text-align: center;
            line-height: 70px;
            display: inline-block;
        }
    }
}

.map {
    height: 120px;
    width: 164%;
    position: relative;
    overflow: hidden;
    border-radius: $radius $radius 0 0;
    background: $brand-L3;

    iframe {
        width: 140%;
        height: 150%;
        margin-left: -20%;
        margin-top: -26px;
        opacity: 0;
        transition: $transition;

        &.show {
            opacity: 1;
        }
    }
}
</style>
