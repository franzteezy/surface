<template>
    <Column class="uploadfile">
        <Column center class="dragndrop">
            <img src="/src/assets/images/filetypes.svg"/>
            <P large>Drag and drop CSV or JSON files here or <span>browse</span></P>
            <P gray>file format supported - CSV, JSON</P>
        </Column>
    </Column>
    <Column class="mapping">
        <Row nm centerv class="chosenfile">
            <Column w1>
                <img src="/src/assets/images/csv.svg"/>
            </Column>
            <Column w11>
                <P large>leadliste_cph_snedkervirksomheder.xlsm <i class="icon icon-checkmark"></i></P>
                <P large gray>12 MB</P>
            </Column>
            <Column w1 end>
                <i class="icon icon-trash"></i>
            </Column>
        </Row>
        <Column class="mappingfieldswrapper">
            <Row nm class="mappingfieldstitles">
                <Column w6>
                    <P large>Column name from file</P>
                </Column>
                <Column w6>
                    <P large>Fields in system</P>
                </Column>
            </Row>
            <Column class="mapfieldswrapper">
                <Row nm class="mappingfields" v-for="item in 8">
                    <Column centerv w6>
                        <P large>Company name</P>
                    </Column>
                    <Column w6>
                        <Dropdown placeholder="Company name"/>
                    </Column>
                </Row>
            </Column>
        </Column>
    </Column>
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

.uploadfile{
    padding: 0 calc(#{$padding} * 2);

    .dragndrop{
        width: 100%;
        border: dashed 1px $gray-L1;
        border-radius: $radius;
        padding: calc(#{$padding} * 3.5);
        margin-top: $padding;
        cursor: pointer;
        transition: $transition;

        &:hover{
            border: dashed 1px $brand;
        }

        img{
            max-width: 75px;
        }

        span{
            color: $brand;
        }

    }
}

.mapping{

    padding: 0 calc(#{$padding} * 2);

    .chosenfile{
        background-color: $success-L2;
        padding: $padding;
        border-radius: $radius $radius 0 0;
        margin-top: $padding;

        img{
            max-width: 35px;
        }
    }

    .icon-checkmark{
        color: $success;
        font-size: 10px;
        position: relative;
        left: 5px;
    }

    .icon-trash{
        color: $gray-D2;
        font-size: 20px;
        transition: $transition;

        &:hover{
            transform: scale(1.1);
            cursor: pointer;
            color: $error;
        }
    }
}

.mappingfieldswrapper{
    border: solid 1px $gray-L2;
    border-radius: 0 0 $radius $radius;

    .mappingfieldstitles{
        padding: $padding calc(#{$padding} * 1.5);
        border-bottom: solid 1px $gray-L2;
    }

    .mapfieldswrapper{
        overflow-y: auto;
        max-height: 800px;

        .mappingfields{
            padding: $padding calc(#{$padding} * 1.5);
        }
    }
}

</style>