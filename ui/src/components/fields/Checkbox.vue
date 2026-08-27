<template>
    <div :class="{'field-wrapper':true,error:error, toggle:toggle!==null}" :fieldId="field_id">
        <div :class="{box:true, checked:value, 'no-label':label===null, disabled:disabled}" @click="mark">
            <div class="check">
                <i class="icon icon-checkmark" v-if="!disabled"/>
                <i class="icon-lock4" v-if="disabled"/>
            </div>
            <P large :gray="value ? null : true" v-if="label">{{label}}{{required!==null?'*':''}}</P>
        </div>
        <P class="error-message" v-if="error_message && error">{{error_message}}</P>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        value: {
            Type: Boolean,
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
            Type: Boolean,
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
                this.$emit('update:value', !this.$props.value);
                this.$emit('changed');
                this.error = false;
                this.error_message = '';
            }
        }
    },
    beforeUnmount() {
        if(window.fields[this.$props.name].field_id === this.field_id){
            delete window.fields[this.$props.name];
        }
    },
    created() {

        if(this.$props.name !== ''){
            if(!window.fields){
                window.fields = {};
            }

            window.fields[this.$props.name] = this;
        }

        this.field_id = window.makeid(20);
        this.previous_input = this.$props.value;
        window.mitt.on('request_failed', (data) => {
            for(let error in data.errors){
                if(error.type === 'field' && error.id === this.field_id){
                    this.error_message = error.message ? error.message : '';
                    this.error = true;
                }
            }
        });
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
                background-color: $brand;
                box-shadow: 0 1px 3px rgba(85, 66, 246, 0.3), 0 2px 6px rgba(85, 66, 246, 0.2);

                i{
                    opacity: 1;

                    &.icon-lock4{
                        color: $brand-L5;
                        opacity: 1;
                    }
                }
            }

            p{
                color: $brand;
            }
        }

        .check{
            width: 18px;
            height: 18px;
            border-radius: calc(#{$radius} / 2);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-align: center;
            transition: $transition;
            display: flex;
            justify-content: center;
            align-items: center;

            i{
                color: $white;
                font-size: 12px;
                opacity: 0;
                transition: $transition;
            }

        }

        p{
            margin-left: 11px;
        }
    }

    &.toggle{
        .box{
            background: none;
            .check{
                background-color: $gray-L2;
                width: 37px;
                height: 20px;
                border-radius: 20px;
                position: relative;

                .icon-lock4{
                    color: $gray-L2;
                    z-index: 1;
                    position: absolute;
                    left: 5px;
                    top: 7px;
                }

                &:after{
                    content: '';
                    position: absolute;
                    width: 16px;
                    height: 16px;
                    border-radius: 100%;
                    background-color: $gray-D1;
                    left: 2px;
                    top: 2px;
                    transition: $transition;
                }
            }

            &.checked{
                .check {
                    background-color: $brand;

                    .icon-checkmark{
                        display: none;
                    }

                    .icon-lock4{
                        color: $brand;
                        left: 23px;
                    }

                    &:after {
                        background-color: $white;
                        left: 19px;
                    }
                }
            }
        }
    }
}
</style>