<template>
    <Wrapper>
        <Row>
            <Column w9>
                <div class="fixed">
                    <H6 bold>Manage field templates</H6>
                    <P large gray>These templates will be used throughout the system to create order, campaigns and more</P>
                </div>

                <Row class="marg-t pad-t">
                    <Filter v-model:value="showEnabled">Active</Filter>
                    <Filter v-model:value="showDisabled">Disabled</Filter>
                </Row>

                <Row wrap split class="marg-t">
                    <Column w6 class="item marg-b" v-for="x in 5">
                        <div class="image" :style="{'background-image': 'url(https://images.unsplash.com/photo-1651688730796-151972ba8f87?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600)'}"/>
                        <H6 bold class="marg-t">Try&Hire</H6>
                        <P large gray>The jobtitle should clearly communicate the scope the of the position so job</P>
                        <div class="split-line marg-t marg-b"></div>
                        <Row nm split v-if="!showDisabled">
                            <Button white>Disable everywhere</Button>
                            <Button>Edit template</Button>
                        </Row>
                        <Row nm split v-if="showDisabled">
                            <Button light>Delete template</Button>
                            <Button>Restore template</Button>
                        </Row>
                    </Column>
                </Row>
            </Column>


            <Column w3 end fill>
                <div class="fixed">
                    <Row nm>
                        <Button small @click="goto('settings-fields-templates-create')">New template</Button>
                    </Row>
                </div>

                <Row nm>
                    <Tip class="double-marg" title="How to use field templates">
                        <P bold class="marg-b">Be Clear and Concise</P>
                        <P>The jobtitle should clearly communicate the scope the of the position so job seekers can easily identify whether or not it’s the role they’re seeking.</P>
                        <br/>
                        <P>The jobtitle should clearly communicate the scope the of the position so job seekers can easily identify whether or not it’s the role they’re seeking.</P>
                    </Tip>
                </Row>
            </Column>
        </Row>
    </Wrapper>
</template>

<script>
import _ from 'lodash';

export default {
    props: {},
    data(){
        return{
            showDisabled: false
        }
    },
    computed: {
        showEnabled:{
            get(){
                return !this.showDisabled;
            },
            set(val){
                this.showDisabled = !val;
            }
        }
    },
    methods: {
        goto(to){
            this.$router.push({ name: to});
        }
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";


.double-marg{
    margin-top: calc(#{$padding} * 2);
}

.fixed{
    height: 48px;
}

.item{
    padding: calc(#{$padding} * 1.5);
    border-radius: $radius;
    background: $white;
    border: 1px solid $gray-L2;

    .image{
        width: 100%;
        height: 96px;
        background-size: cover;
        background-position: center;
        border-radius: $radius;
    }

    .split-line{
        width: 100%;
        height: 1px;
        background: $gray-L2;
    }
}
</style>