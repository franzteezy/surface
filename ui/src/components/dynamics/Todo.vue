<template>
    <Column class="todo">
        <Row end>
            <P gray>2m</P>
        </Row>
        <Row>
            <P xl bold>Candidate Assignment</P>
        </Row>
        <Row>
            <Column center class="dateset">
                <P white><i class="icon icon-location"/> Tomorrow 9:00</P>
            </Column>
            <Column center class="deadline">
                <P white><i class="icon icon-location"/> 22/APR/2022</P>
            </Column>
            <Column w3 center class="tasks">
                <P white><i class="icon icon-location"/> 1/3</P>
            </Column>
            <Column w2 center>
                <img src="/src/assets/images/avatar-template.png"/>
            </Column>
        </Row>
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

.col {
    &.todo {
        padding: $padding $padding $padding calc(#{$padding} * 2);
        border-radius: $radius;
        background-color: #F2FCFF;
        border: solid 1px #E0F8FF;
        margin-bottom: $padding;
        flex-grow: unset;

        img {
            max-width: 24px;
        }

        .dateset {
            background-color: #ED2F96;
        }

        .deadline {
            background-color: #F89C14;
        }

        .tasks {
            background-color: #01CE84;
        }

        .col {
            padding: 2px 10px;
            border-radius: calc(#{$radius} * 3);
            width: fit-content;
            flex-grow: unset;
            margin-right: calc(#{$padding} / 2);


            p {
                white-space: nowrap;

                i {
                    position: relative;
                    top: 2px;
                }
            }

        }
    }
}

</style>