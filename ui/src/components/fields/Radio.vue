<template>
    <div :class="{'field-wrapper':true,error:error}" :fieldId="field_id">
        <div :class="{box:true, checked:value===option, 'no-label':label===null, disabled:disabled}" @click="mark">
            <div class="check">
                <div class="selected"></div>
            </div>
            <P large v-if="label">{{label}}{{required!==null?'*':''}}</P>
        </div>
        <P class="error-message" v-if="error_message && error">{{error_message}}</P>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        option: {
            Type: null, // value of this field
            default: false
        },
        value: {
            Type: null, // value to pass onto value field
            default: false
        },
        change: {
            Type: Function,
            default: null
        },
        disabled: {
            Type: Boolean,
            default: false
        },
        label: {
            Type: String,
            default: null
        },
        name:{
            Type: String,
            default: ''
        },
        required:{
            Type: Boolean,
            default: null
        },
        toggle: {
            Type: Boolean,
            default: null
        },
    },
    data(){
        return{
            error: false,
            error_message: '',
            focus: false,
            field_id: null,
        }
    },
    methods: {
        mark(){
            if(!this.$props.disabled){
                this.$emit('update:value', this.$props.option);
                this.$emit('changed');
                this.error = false;
                this.error_message = '';
            }
        }
    },
    beforeUnmount() {
    },
    created() {
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.field-wrapper{

    &.error{
        p{
            color: $error;
        }

        .error-message{
            margin-top: 2px;
        }

        .box{
            background-color: $error-L1;
            &.checked{
                background-color: $error-L1;

                p{
                    color: $error;
                }
                .check{
                    background-color: $error;
                }
            }
            &.no-label {
                &.checked {
                    background-color: $error-L1;
                }
            }
        }
    }

    .label{
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }

    .box{
        display: flex;
        padding: 8px;
        border-radius: calc(#{$radius} / 2);
        background: $white;
        transition: $transition;
        align-items: center;
        width: fit-content;
        white-space: nowrap;
        cursor: pointer;


        &:hover{
            .check{
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);

                .selected{
                    opacity: 0.1;
                }
            }
        }

        &.disabled{
            opacity: 0.7;
        }

        &.no-label{

            &.checked{
                background: $white;
            }
        }


        &.checked{
            background: $brand-L5;
            .check{
                border: 2px solid $brand;
                box-shadow: 0 1px 3px rgba(85, 66, 246, 0.3), 0 2px 6px rgba(85, 66, 246, 0.2);

                .selected{
                    opacity: 1;
                }
            }

            p{
                color: $brand;
            }
        }

        .check{
            width: 18px;
            height: 18px;
            border-radius: 100%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-align: center;
            border: 2px solid $gray-L2;
            transition: $transition;
            display: flex;
            justify-content: center;
            align-items: center;

            .selected{
                width: 6px;
                height: 6px;
                border-radius: 100%;
                opacity: 0;
                background: $brand;
                transition: $transition;
            }

        }

        p{
            margin-left: 11px;
        }
    }
}
</style>