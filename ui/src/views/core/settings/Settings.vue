<template>
    <Base>
        <Wrapper>
            <Column>
                <H5>System settings</H5>
                <Row class="bg" centerv>
                    <Column>
                        <H4 white>Manage Your Recruitment agancy</H4>
                        <P white>Specify your settings to match your agency's preferences.<br/>This is not required, but is recommended for the best experience</P>
                    </Column>
                    <img src="/src/assets/images/settings-astro.svg"/>
                </Row>
                <Row wrap>
                    <Column w6 @click="goto('settings-fields')" v-for="x in 5">
                        <Row centerv class="item">
                            <i class="icon icon-list-ordered marg-r" />
                            <Column centerv>
                                <P large semibold>Fields and field groups</P>
                                <P gray>Create and update fields within the system, these can be used to generate KPI's, result-data and much more!</P>
                            </Column>
                        </Row>
                    </Column>
                </Row>
            </Column>
        </Wrapper>
    </Base>
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

.bg{
    height: 210px;
    background-image: url('/src/assets/images/settings.png');
    background-size: cover;
    margin-top: calc(#{$padding} * 2);
    padding: calc(#{$padding} * 4) calc(#{$padding} * 2);
    border-radius: calc(#{$radius} * 5);
}
.col{
    .item{
        margin-top: $padding;
        box-shadow: $shadow;
        border-radius: $radius;
        padding: calc(#{$padding} * 2) $padding;
        cursor: pointer;
        transition: $transition;

        &:hover{
            box-shadow: $shadow-hover;

            i{
                color: $brand-L1;
                border: 1px solid $brand-L3;
                background: $gray-L4;
            }
        }

        i{
            font-size: 20px;
            padding: calc(#{$padding} / 2);
            background: $gray-L3;
            border: 1px solid $gray-L2;
            border-radius: $radius;
            transition: $transition;
        }
    }
}
</style>