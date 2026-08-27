<template>
    <Modal v-model:show="show_create_modal" :cancel="false" confirm="Add customer" title="Add customer"
           @confirm="addCustomer">
        <AddCustomerModal v-if="!company.identification"/>
        <AddCustomerCompany v-if="company.identification"/>
    </Modal>
    <Base>
        <Wrapper nm>
            <Row class="marg-t marg-b" split>
                <Column w6>
                    <H5>Customers</H5>
                </Column>
                <Column w6>
                    <Row end nm>
                        <Button class="marg-r" small white>Export customers</Button>
                        <Button small @click="show_create_modal=true">Add customer</Button>
                    </Row>
                </Column>
            </Row>
        </Wrapper>

        <Wrapper center class="bg" full>
            <Wrapper>
                <Row split>

                    <Column v-for="x in 4" :key="x" class="darken" split w3>
                        <Row centerv>
                            <P class="opac" semibold>Total conversions</P>
                        </Row>
                        <Row centerv>
                            <H5 bold white>5941</H5>
                            <Row end>
                                <div class="tracker">

                                </div>
                            </Row>
                        </Row>
                        <Row centerv>
                            <P class="opac" semibold><span class="red">5%</span> lower than last month</P>
                        </Row>
                    </Column>

                </Row>
            </Wrapper>
        </Wrapper>

        <Wrapper>
            <Row split>
                <Column w6>
                    <Row nm>
                        <Filter v-model:value="following">Following</Filter>
                        <Filter v-model:value="show_active_only">Only active</Filter>
                        <Filter v-model:value="created_by" :options="created_by_options" multiselect>Created by</Filter>
                    </Row>
                </Column>
                <Column w3>
                    <Row end nm>
                        <Input v-model:value="search" icon="search" placeholder="Search by name" small/>
                    </Row>
                </Column>
            </Row>
        </Wrapper>


        <Wrapper>
            <Row split>
                <Column w4>
                    <P bold gray>Company <i class="icon icon-double-carret"></i></P>
                </Column>
                <Column w2>
                    <P bold gray>Tags <i class="icon icon-double-carret"></i></P>
                </Column>
                <Column w2>
                    <P bold gray>Date created <i class="icon icon-double-carret"></i></P>
                </Column>
                <Column w2>
                    <P bold gray>Last order <i class="icon icon-double-carret"></i></P>
                </Column>
                <Column w2>
                    <P bold gray>Actions</P>
                </Column>
            </Row>

            <Row v-for="x in 7" :key="x" centerv class="customer" nm split>
                <Column w4>
                    <Row nm>
                        <Column nm w2>
                            <img alt="logo" height="40" src="/src/assets/images/mads-logo-test-v2.svg" width="40"
                                 @click="goToCompany"/>
                        </Column>
                        <Column w10>
                            <P class="company-name" large @click="goToCompany">Kandidaterne ApS</P>
                            <P gray>Kokholm 1A, 6000 Kolding, Danmark</P>
                        </Column>
                    </Row>
                </Column>
                <Column w2>
                    <Row class="tags" nm>
                        <P @click="goToTags()">Automotive</P>
                        <P @click="goToTags()">+2</P>
                    </Row>
                </Column>
                <Column class="date" w2>
                    <P><i class="icon icon-calendar"/> 12 DEC 2023</P>
                </Column>
                <Column class="date" w2>
                    <P @click="goToTags()"><i class="icon icon-calendar"/> 12 DEC 2023</P>
                </Column>
                <Column class="actions" w2>
                    <Row split>
                        <div>
                            <i class="icon icon-call"/>
                            <i class="icon icon-mail-open"/>
                            <i class="icon icon-website"/>
                        </div>
                        <ContextMenu :menu="context" dark pass="12314"/>

                    </Row>
                </Column>
            </Row>
        </Wrapper>

    </Base>
</template>

<script>

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
    watch: {},
    data() {
        return {
            show_create_modal: false,
            context: [
                {
                    label: 'Edit',
                    icon: 'edit',
                    click: (key) => console.log('test ' + key)
                },
                {
                    label: 'Delete',
                    icon: 'trash',
                    click: (key) => console.log('test ' + key)
                }
            ],
            search: '',
            following: false,
            show_active_only: false,
            created_by: [false, false],
            created_by_options: [
                {
                    label: 'Joachim Bertelsen',
                    value: 1
                },
                {
                    label: 'Mads Friis',
                    value: 1
                }
            ],
        }
    },
    methods: {
        addCustomer() {
            let key = this.company.identification ? 'company' : 'customer';

            window.store[key].put().then(res => {
                this.$router.push('/crm/customers/' + res.data.hash);
            });
        },
        goToCompany() {
            console.log('test');
        },
        goToTags() {
            console.log('test');
        },
        seeAll() {
        }
    },
    mounted() {

    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables";

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

.customer {
    height: 90px;
}

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
