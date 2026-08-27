<template>
    <Column :class="{tip:true}">
        <Row class="marg-b">
            <i class="icon icon-bulb-charge" />
            <Column w12>
                <P semibold class="yellow-text">Pro-tip</P>
                <P bold large>{{title}}</P>
            </Column>
        </Row>
        <Row class="marg-b">
            <div class="push" />
            <Column w12>
                <slot></slot>
            </Column>
        </Row>
    </Column>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        title: {
            Type: String,
            default: 'Need som help?'
        }
    },
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

.tip{
    border-radius: $radius;
    background: #{$yellow}1D;
    padding: calc(#{$padding} * 1.5);
    border: 1px solid #{$yellow}4D;

    .push{
        width: 36px;
    }

    .icon-bulb-charge{
        color: $yellow;
        font-size: 34px;
        width: 36px;
    }

    .yellow-text{
        color: $yellow;
    }
}
</style>