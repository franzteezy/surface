<template>
    <Wrapper nm>
        <Column centerv class="start">
            <router-link to="/settings/fields/templates" class="back">
                <div class="icon-wrap">
                    <i class="icon icon-arrow-left" />
                </div>
                <P large semibold>Back to overview</P>
            </router-link>
        </Column>
        <Column class="marg-t">
            <Row>
                <Column w4>
                    <Input label="Template name" placeholder="E.g. No cure, No pay - Recruitemnt"/>
                </Column>
                <Column w4>
                    <Input label="Short description" placeholder="A short description to show your employees"/>
                </Column>
                <Column w4>

                </Column>
            </Row>
        </Column>

        <Column class="marg-t pad-t">
            <Row>
                <Column w8>
                    <Tip title="A good description">
                        <P>A good description will create a fast and easy flow for users. Improve speed by giving as much information as possible</P>
                    </Tip>
                </Column>
                <Column w4>

                </Column>
            </Row>
        </Column>


        <Column class="marg-t pad-t">

            <Row class="marg-t">
                <Column w8>
                    <H6 bold>Select fields</H6>
                    <P gray>Select the fields this template should show, you can re-use these fields in other templates.</P>
                </Column>
                <Column w4 />
            </Row>

            <Row class="fields">
                <Column w9 center class="selected">
                    <img class="marg-b" src="/src/assets/svg/page.svg">
                    <H6 bold>Result fields</H6>
                    <P class="marg-t" gray center>Please select the result fields,<br/>you would like to use with this template</P>
                </Column>
                <Column w3 fill>
                    <Row nm>
                        <Column class="selectable">


                            <Column class="group marg-t" nm>
                                <Checkbox label="Job details"/>
                            </Column>
                            <Column nm>
                                <Checkbox label="Recruitment type"/>
                                <Checkbox label="Desired start-up "/>
                                <Checkbox label="Candidate search"/>
                                <Checkbox label="Select contact person"/>
                                <Checkbox label="Workplace location"/>
                                <Checkbox label="Number of positions"/>
                            </Column>


                            <Column class="group marg-t" nm>
                                <Checkbox label="Job details"/>
                            </Column>
                            <Column nm>
                                <Checkbox label="Recruitment type"/>
                                <Checkbox label="Desired start-up "/>
                                <Checkbox label="Candidate search"/>
                                <Checkbox label="Select contact person"/>
                                <Checkbox label="Workplace location"/>
                                <Checkbox label="Number of positions"/>
                                <Checkbox label="Jobtype"/>
                                <Checkbox label="Jobtitle"/>
                            </Column>


                        </Column>
                    </Row>
                </Column>
            </Row>

        </Column>













        <Column class="marg-t pad-t">

            <Row class="marg-t">
                <Column w8>
                    <H6 bold>Select fields</H6>
                    <P gray>Select the fields this template should show, you can re-use these fields in other templates.</P>
                </Column>
                <Column w4 />
            </Row>

            <Row class="fields">
                <Column w9 class="marg-t marg-b marg-l marg-r">
                    <Column nm>
                        <Row class="top" nm>
                            <Column w5>
                                <P>Name</P>
                            </Column>
                            <Column w3>
                                <P>Type</P>
                            </Column>
                            <Column w3>
                                <P>Required</P>
                            </Column>
                            <Column w1>
                            </Column>
                        </Row>

                        <Row class="item" nm>
                            <Column w5>
                                <P large bold>Recruitment type</P>
                            </Column>
                            <Column w3>
                                <P>Dropdown</P>
                            </Column>
                            <Column w3>
                                <P>required</P>
                            </Column>
                            <Column w1 end>
                            </Column>
                        </Row>

                        <Row class="item" nm>
                            <Column w5>
                                <P large bold>Desired start-up</P>
                            </Column>
                            <Column w3>
                                <P>Date & time</P>
                            </Column>
                            <Column w3>
                                <P>required</P>
                            </Column>
                            <Column w1 end>
                            </Column>
                        </Row>

                        <Row class="item" nm>
                            <Column w5>
                                <P large bold>Jobtitle</P>
                            </Column>
                            <Column w3>
                                <P>String</P>
                            </Column>
                            <Column w3>
                                <P>Not required</P>
                            </Column>
                            <Column w1 end>
                            </Column>
                        </Row>
                    </Column>
                </Column>
                <Column w3 fill>
                    <Row nm>
                        <Column class="selectable">


                            <Column class="group marg-t" nm>
                                <Checkbox label="Job details"/>
                            </Column>
                            <Column nm>
                                <Checkbox label="Recruitment type"/>
                                <Checkbox label="Desired start-up "/>
                                <Checkbox label="Candidate search"/>
                                <Checkbox label="Select contact person"/>
                                <Checkbox label="Workplace location"/>
                                <Checkbox label="Number of positions"/>
                            </Column>


                            <Column class="group marg-t" nm>
                                <Checkbox label="Job details"/>
                            </Column>
                            <Column nm>
                                <Checkbox label="Jobtype"/>
                                <Checkbox label="Jobtitle"/>
                                <Checkbox label="Recruitment type"/>
                                <Checkbox label="Desired start-up "/>
                                <Checkbox label="Candidate search"/>
                                <Checkbox label="Select contact person"/>
                                <Checkbox label="Workplace location"/>
                                <Checkbox label="Number of positions"/>
                            </Column>


                        </Column>
                    </Row>
                </Column>
            </Row>

        </Column>




    </Wrapper>
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

.start{
    align-items: flex-start;
}
.back{
    display: flex;
    text-decoration: none;
    align-items: center;
    white-space: nowrap;

    &:hover{
        p{
            color: $gray-D3;
        }
        .icon-wrap {
            color: $gray-D3;
        }
    }

    p{
        color: $gray-D1;
        transition: $transition;
    }

    .icon-wrap{
        font-size: 14px;
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 22px;
        padding: 10px;
        color: $gray-D1;
        border: 1px solid $gray-L2;
        border-radius: 100%;
        margin-right: $padding;
        transition: $transition;
    }
}


.top{
    background: $gray-L4;
    padding: calc(#{$padding} / 2) $padding;
    border: 1px solid $brand-L4;
}
.item{
    padding: $padding;
    border: 1px solid $brand-L4;
    border-top: none;
    transition: $transition;

    &:last-child{
        border-radius: 0 0 $radius $radius;
    }

    i{
        color: $gray-D1;

        &:hover{
            color: $error;
        }
    }
}

.fields{
    border-radius: $radius;
    border: 1px solid $gray-L2;

    img{
        width: 150px;
    }

    .selected{
        margin: calc(#{$padding} * 4) 0;
        padding: 0 $padding;
        border-right: 1px solid $gray-L2;
    }
}

.group{
    margin-bottom: $padding;
    border-bottom: 1px solid $gray-L2;

    :deep(p){
        font-weight: 700;
        color: $gray-D3;
    }
}

.selectable{
    padding: 0 $padding $padding;
    height: 400px;
    overflow-y: auto;
}
</style>