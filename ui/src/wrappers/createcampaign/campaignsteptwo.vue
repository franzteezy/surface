<template>
    <Column w8 class="campaignsettings">
        <Column centerv class="basicdetails">
            <H2 bold>Add leads</H2>
            <P gray large>Write an introduction to the job posting</P>
        </Column>
        <Row class="choosetype">
            <Button>Integrations</Button>
            <Button white>Upload from file</Button>
        </Row>
        <Campaignintegrations/>
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


.campaignsettings {
    border: solid 1px $gray-L2;
    border-radius: $radius;
    background-color: $white;
    display: block;
    min-height: 1200px;
    height: fit-content;
    padding-bottom: calc(#{$padding} * 2);

    .col{
        padding: 0 calc(#{$padding} * 2);
    }

    .basicdetails {
        border-bottom: solid 1px $gray-L2;
        padding-bottom: calc(#{$padding} * 2);
        margin-bottom: calc(#{$padding} * 3);
        padding-top: calc(#{$padding} * 2);
        min-height: calc(160px - 32px);
    }

    .choosetype{
        padding: 0 calc(#{$padding} * 2);
        .button{
            margin-right: $padding;
        }
    }



}


</style>