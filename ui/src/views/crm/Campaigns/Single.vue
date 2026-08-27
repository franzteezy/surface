<template>
    <Base>
        <Wrapper class="bg pad-t">
            <Row class="pad-l pad-r">
                <Column shrink>
                    <Row nm centerv>
                        <div class="back marg-r">
                            <i class="icon icon-arrow-left" />
                        </div>
                        <div class="image-container" style="background-image: url('https://images.unsplash.com/photo-1651494613472-32bca90a5a8c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80')"/>
                    </Row>
                </Column>
                <Column centerv>
                    <H6 white bold>Software Development Companies, <span>New York City</span></H6>
                    <P white>Description goes here</P>
                </Column>
                <Column shrink centerv>
                    <Row nm end>
                        <Button small class="marg-r">Import leads</Button>
                        <Button white small class="marg-r">Start calling</Button>
                        <ContextMenu  :menu="context"/>
                    </Row>
                </Column>
            </Row>
            <Row>
                <Column>
                    <Row class="blur pad-l pad-r">
                        <Submenu />
                    </Row>
                </Column>
            </Row>
        </Wrapper>
        <router-view></router-view>

    </Base>
</template>

<script>
import _ from 'lodash';

export default {
    props: {},
    data() {
        return {
            edit_active: false,
            context: [
                {
                    label: 'Edit',
                    icon: 'edit',
                    click: () => this.clickEdit()
                },
                {
                    label: 'Delete',
                    icon: 'trash',
                    click: () => this.clickDelete()
                }
            ],
        }
    },
    computed: {},
    methods: {
        clickEdit(){
            console.log('Edit');
        },
        clickDelete(){
            console.log('Delete');
        }
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables";
#app{
    .wrapper {
        &.bg {
            padding: $padding 0 0 0;
            background-image: url('/src/assets/images/campaign-bg.png');
            background-size: cover;
            background-position: center;
            background-color: darken($blue, 20);
            border-radius: $radius;
            max-width: 1280px;

        .blur {
                border-top: 1px solid #{$white}1C;
                background-color: #{$white}1A;
                backdrop-filter: blur(40px);
                border-radius: 0 0 $radius $radius;
            }

            .back {
                display: flex;
                justify-content: center;
                align-items: center;
                min-width: 40px;
                min-height: 40px;
                border-radius: 100%;
                background-color: #{$white}1A;
                backdrop-filter: blur(20px);
                cursor: pointer;
                transition: $transition;

                &:hover {
                    background-color: #{$white}33;
                }

                i {
                    font-size: 20px;
                    color: $white;
                }
            }

            .image-container {
                width: 61px;
                height: 48px;
                background-size: cover;
                background-position: center;
                border-radius: $radius;
            }

            h6 {
                span {
                    font-weight: 400;
                }
            }

            p {
                opacity: 0.6;
            }

        }
    }
}
</style>