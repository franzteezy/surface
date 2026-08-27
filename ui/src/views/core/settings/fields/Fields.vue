<template>
    <Modal v-model:show="showModal" confirm="Save" @confirm="del" :cancel="false" title="Create new field">
        <Column>
            <Row>
                <Input label="title" placeholder="E.g. salary" />
            </Row>
            <Row class="marg-t">
                <Textarea label="Short description" placeholder="Your description here..."/>
            </Row>
            <Row class="marg-t">
                <Dropdown label="Field type" :options="field_types" okey="name"/>
            </Row>
            <Row class="pad-b marg-t pad-t section">
                <Column>
                    <Row>
                        <P bold large>Options:</P>
                    </Row>

                    <Row class="option" centerv>
                        <Input placeholder="Option 1" />
                        <i class="icon icon-trash"/>
                    </Row>
                    <Row class="option" centerv>
                        <Input placeholder="Option 2" />
                        <i class="icon icon-trash"/>
                    </Row>

                    <P brand semibold class="marg-b">Add option</P>
                    <Checkbox label="Select multiple" toggle/>
                </Column>
            </Row>
            <Row class="marg-t">
                <Checkbox label="Required" toggle/>
            </Row>
        </Column>
    </Modal>

    <Modal v-model:show="showGroupModal" confirm="Save" @confirm="del" cancel="Cancel" @cancel="showGroupModal=false" title="Create new group">
        <Column>
            <Input label="Name" />
        </Column>
    </Modal>

    <Modal v-model:show="showDeleteModal" confirm="Delete" @confirm="del" cancel="Cancel" @cancel="showDeleteModal=false" title="Are you sure you want to delete this group?">
        <Column>
            <Dropdown label="move fields to" :options="field_types" okey="name"/>
        </Column>
    </Modal>

    <Wrapper>
        <Row>
            <Column w9>
                <div class="fixed">
                    <H6 bold>Create result fields</H6>
                    <P large gray>Create result fields to use throughout the system, these will also make the base for your KPI tracking</P>
                </div>

                <Row nm v-for="x in 3">
                    <Column class="marg-t pad-t">
                        <Column class="group">
                            <Row>
                                <Row nm centerv>
                                    <i class="icon icon-pointer-up" />
                                    <H6 bold>Recruiting</H6>
                                </Row>
                                <Row end nm>
                                    <ContextMenu dark :menu="context" pass="12314"/>
                                </Row>
                            </Row>
                        </Column>
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

                            <Row class="item" nm @click="edit">
                                <Column w5>
                                    <P large bold>Recruitment type</P>
                                </Column>
                                <Column w3>
                                    <P>Dropdown</P>
                                </Column>
                                <Column w3>
                                    <P>Not required</P>
                                </Column>
                                <Column w1 end>
                                    <i class="icon icon-trash" @click="del"/>
                                </Column>
                            </Row>
                        </Column>
                    </Column>
                </Row>

                <Row nm>
                    <Column class="marg-t pad-t">
                        <Column class="group closed">
                            <Row>
                                <Row nm centerv>
                                    <i class="icon icon-pointer-down" />
                                    <H6 bold>Recruiting</H6>
                                </Row>
                                <Row end nm>
                                    <ContextMenu dark :menu="context" pass="12314"/>
                                </Row>
                            </Row>
                        </Column>
                        <Column nm v-if="false">
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

                            <Row class="item" nm @click="edit">
                                <Column w5>
                                    <P large bold>Recruitment type</P>
                                </Column>
                                <Column w3>
                                    <P>Dropdown</P>
                                </Column>
                                <Column w3>
                                    <P>Not required</P>
                                </Column>
                                <Column w1 end>
                                    <i class="icon icon-trash" @click="del"/>
                                </Column>
                            </Row>
                        </Column>
                    </Column>
                </Row>



            </Column>
            <Column w3 end fill>
                <div class="fixed">
                    <Row nm>
                        <Button small light @click="showGroupModal = true" class="marg-r">New group</Button>
                        <Button small @click="showModal = true">New field</Button>
                    </Row>
                </div>

                <Row nm>
                    <Tip class="double-marg" title="How to use fields?">
                        <P bold class="marg-b">Be Clear and Concise</P>
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
            showModal: false,
            showGroupModal: false,
            showDeleteModal: false,
            context: [
                {
                    label: 'Edit',
                    icon: 'edit',
                    click: (key) => this.clickEdit(key)
                },
                {
                    label: 'Delete',
                    icon: 'trash',
                    click: (key) => this.clickDelete(key)
                }
            ],
            field_types: [
                {
                    name: 'Dropdown',
                },
                {
                    name: 'Checkbox',
                },
                {
                    name: 'Text',
                },
                {
                    name: 'Number',
                },
                {
                    name: 'Date',
                },
                {
                    name: 'Location',
                }
            ],
        }
    },
    computed: {

    },
    methods: {
        clickDelete(key){
            this.showDeleteModal = true;
        },
        clickEdit(key){
            console.log(key);
        },
        edit(e){
            if(!e.target.classList.contains('icon-trash')){
                console.log('edit');
            }
        },
        del(){
            console.log('delete');
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

.top{
    background: $gray-L4;
    padding: calc(#{$padding} / 2) $padding;
    border: 1px solid $brand-L4;
}
.item{
    padding: $padding;
    border: 1px solid $brand-L4;
    border-top: none;
    cursor: pointer;
    transition: $transition;

    &:hover{
        box-shadow: $shadow;
    }

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

.section{
    border-top: 1px solid $gray-L1;
    border-bottom: 1px solid $gray-L1;
}

.option{
    .icon-trash{
        font-size: 16px;
        margin-left: $padding;
        top: 2px;
        color: $gray-L1;
        transition: $transition;
        cursor: pointer;

        &:hover{
            color: $error;
        }
    }
}

.double-marg{
    margin-top: calc(#{$padding} * 2);
}

.fixed{
    height: 48px;
}

.group{
    padding: $padding;
    background: #{$brand-L3}1A;
    border: 1px solid #{$brand-L2}33;
    border-radius: $radius $radius 0 0;
    border-bottom: none;

    &.closed{
        border: 1px solid #{$brand-L2}33;
        border-radius: $radius;
    }

    i{
        padding: 5px;
        font-size: 14px;
        border-radius: 100%;
        cursor: pointer;
        color: $gray-D3;
        background: $white;
        margin-right: $padding;
        border: 1px solid $gray-L1;
        transition: $transition;

        &:hover{
            border: 1px solid $gray;
        }
    }
}

</style>