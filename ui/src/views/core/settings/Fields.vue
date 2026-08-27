<template>
    <Base>
        <Wrapper full center class="bg">
            <Wrapper>
                <Column>
                    <H4 bold white>Fields</H4>
                </Column>
            </Wrapper>
            <Wrapper full class="darker" center nm>
                <Wrapper nm>
                    <Submenu />
                </Wrapper>
            </Wrapper>
        </Wrapper>
        <Wrapper>
            <router-view></router-view>
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
    background-image: url("/src/assets/images/campaign-bg.png");
    background-size: cover;
    background-color: darken($blue, 20);
}

.darker{
    background: #{$black}10;
    backdrop-filter: blur(4px);
    padding: calc(#{$padding} / 2) 0;
}

</style>