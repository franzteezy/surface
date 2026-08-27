<template>
    <Wrapper class="creation-wrapper" nm>
        <Row nm split>
            <Column w7>
                <H4 bold class="marg-b">Basic details</H4>

                <Input v-click-outside="clickOutside" v-model:value="customer.name"
                       :loading="companies_loading" class="marg-t marg-b"
                       label="Company name" placeholder="E.g. Maersk" required @changed="searchCompanies"
                       @focus="setFocus"/>

                <div class="results-wrapper marg-b">
                    <Column v-if="focus_name && (companies || companies_loading)" centerh class="results">
                        <Column v-for="(source, key) in companies" :data-key="key" :data-source="JSON.stringify(source)"
                                nm>
                            <a :href="source.source_url" target="_blank">
                                <Row class="database">
                                    <P bold gray>Data powered by</P>
                                    <img :src="source.source_image" alt="source" height="14"/>
                                </Row>
                            </a>
                            <Row v-for="company in source.data" centerv class="company" nm
                                 @click="selectLead(company, key)">
                                <Column nm w2>
                                    <img :src="company.image" alt="logo" height="40" width="24"/>
                                </Column>
                                <Column w10>
                                    <P large>{{ company.name }}</P>
                                    <P gray>{{ company.address }}</P>
                                </Column>
                            </Row>
                            <img v-if="companies_loading & !source.data" alt="loader" src="/src/assets/svg/loader.svg"
                                 width="60"/>
                        </Column>

                    </Column>
                </div>
                <Input v-model:value="customer.fields.email" class="marg-t" label="Email"
                       placeholder="E.g. hello@example.com" required/>

                <Tel v-model:cc="cc" v-model:value="phone" class="marg-t" label="Phone number" name="phone"
                     placeholder="555 000 999" @changed="updateCompanyPhone"/>

                <Loc v-model:selected="location" class="marg-t" label="Address" @changed="locationChange"
                     placeholder="E.g. K Street 1667 NW Washington DC 20006"/>

            </Column>
            <Column centerv w5>
                <Wrapper class="brand-bg">
                    <Row>
                        <Column>
                            <img alt="computer" class="computer-hero marg-b" src="/src/assets/svg/computer.svg"
                                 width="120"/>
                            <P bold class="fade marg-t" white>LEAD DATABSES</P>
                            <H6 bold white>How add get leads...</H6>
                            <P class="marg-t marg-b" white>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Lorem ipsum dolor sit amet.</P>
                            <P bold white @click="ReadMore">Read more</P>
                        </Column>
                    </Row>
                </Wrapper>
            </Column>
        </Row>
    </Wrapper>
</template>

<script>
import _ from 'lodash';

export default {
    computed: {
        customer() {
            return window.store.customer.single;
        },
        company() {
            return window.store.company.single;
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
            focus_name: false,
            cc: '',
            phone: '',
            location: null,
        }
    },
    methods: {
        locationChange() {
            this.customer.fields.location = this.location;
        },
        updateCompanyPhone() {
            let phone = this.cc + ' ' + this.phone;
            this.customer.fields.phone = phone;
        },
        searchCompanies: _.debounce((val) => {
            if (val !== '') {
                window.store.company.package.name = val.current;
                window.store.company.fetch().then(res => {
                    this.companies = res.many;
                });
            }
        }, 1000),
        clickOutside(e) {
            if (this.focus_name && e.target !== document.querySelectorAll('.results')[0]) {
                this.focus_name = false;
            }
        },
        openUrl(url) {
            window.open(url, '_blank');
        },
        setFocus(val) {
            if (val) {
                this.focus_name = val;
            }
        },
        ReadMore() {
            console.log('test');
        },
        selectLead(company, source) {
            this.customer.fields.name = company.name;
            this.company.identification = company.identification;
            window.store.company.get(source + '/' + company.identification);
        },
    },
    mounted() {

    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.fade {
    opacity: 50%;
}

.creation-wrapper {
    width: 750px;

    .brand-bg {
        background: $brand;
        padding: calc(#{$padding} * 2);
        border-radius: $radius;

        .computer-hero {
            margin-top: -70px;
        }
    }

    .results-wrapper {
        width: 100%;
        position: relative;

        .results {
            position: absolute;
            width: 100%;
            max-height: 220px;
            border-radius: $radius;
            background: $white;
            z-index: $level3;
            box-shadow: $shadow;
            overflow: auto;

            a {
                text-decoration: none;
            }

            .company {
                padding: calc(#{$padding} / 2) $padding;
                cursor: pointer;
                transition: 0.2s;

                &:hover {
                    background: $gray-L4;
                }
            }

            .database {
                padding: calc(#{$padding} / 2) $padding;
                background: $gray-L3;
                border-bottom: 1px solid $gray-L2;

                img {
                    margin-left: 4px;
                }
            }
        }
    }
}

.customer {
    border-bottom: 1px solid $gray-L2;
}

.actions {
    font-size: 20px;

    i {
        cursor: pointer;
        margin-right: 16px;
    }

    .icon-call {
        color: #EEA537;

        &:hover {
            color: #ba822b;
        }
    }

    .icon-mail-open {
        color: #5B76FF;

        &:hover {
            color: #445dd1;
        }
    }

    .icon-website {
        color: #0FDB85;

        &:hover {
            color: #0ea767;
        }
    }
}

.company-name {
    &:hover {
        text-decoration: underline;
    }
}

.tags, .date {

    p {
        padding: 6px 10px;
        background: $gray-L2;
        margin-right: 4px;
        border-radius: $radius;
        cursor: default;

        &.click {
            transition: $transition;
            cursor: pointer;

            &:hover {
                background: $gray-L1;
                color: $gray-D3;
            }
        }
    }
}

.red {
    color: $error;
    cursor: pointer;
}

.blue {
    color: #5B76FF;
    cursor: pointer;
}
</style>
