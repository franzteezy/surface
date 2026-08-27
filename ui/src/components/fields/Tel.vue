<template>
    <div :class="{'field-wrapper':true,error:error}" :fieldId="field_id">
        <P class="label" v-if="label" overline bold>{{label}}{{required!==null?'*':''}}</P>

        <div class="fields" v-click-outside="clickOutside">
            <div :class="{field:true, large:large!==null, small:small!==null, error:error, focus:focus, disabled:disabled}" @click="focusFieldSmall">
                <input :placeholder="placeholder" :value="cc_input" :disabled="disabled" ref="inputfieldSmall"
                       type="text"
                       @keyup="ku" @keydown="kd" @focus="focus=true"/>

            </div>
            <div :class="{field:true, large:large!==null, small:small!==null, error:error, focus:focus, disabled:disabled}" @click="focusField">
                <i :class="{icon:true, ['icon-'+icon]:true}" v-if="icon!==null"/>
                <input :placeholder="placeholder" :value="value" :disabled="disabled" ref="inputfield" :name="name"
                       type="text"
                       @keyup="ku" @keydown="kd" @focus="focus=true"/>
                <div class="after" v-if="after!==null">
                    <P large>{{after}}</P>
                </div>

            </div>
        </div>
        <P class="error-message" v-if="error_message && error">{{error_message}}</P>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        placeholder: {
            Type: String,
            default: ''
        },
        value: {
            Type: String,
            default: ''
        },
        cc: {
            Type: String,
            default: ''
        },
        change: {
            Type: Function,
            default: null
        },
        large: {
            Type: Boolean,
            default: null
        },
        small: {
            Type: Boolean,
            default: null
        },
        disabled: {
            Type: Boolean,
            default: false
        },
        icon: {
            Type: String,
            default: null
        },
        name: {
            Type: String,
            default: ''
        },
        label: {
            Type: String,
            default: null
        },
        required:{
            Type: Boolean,
            default: null
        },
        after:{
            Type: String,
            default: null
        },
    },
    data(){
        return{
            previous_input: '',
            error: false,
            error_message: '',
            focus: false,
            field_id: null,
            password_hidden: true,
        }
    },
    computed: {
        cc_input(){
            if(!this.$props.cc){
                return '+';
            }
            if(this.$props.cc && this.$props.cc.includes('+')){
                return this.$props.cc;
            }
            return '+'+this.$props.cc;
        }
    },
    methods: {
        calculateStrength(){
            let percentage = 0;
            let specialChars = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            let nubmers = /[1234567890]/;
            let upperCase = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
            if(this.$props.value && this.$props.value.length >= 8){
                percentage += 20;
            }
            if(this.$props.value && this.$props.value.length >= 4 && this.$props.value.match(upperCase)){
                percentage += 15;
            }
            if(this.$props.value && this.$props.value.length >= 4 && this.$props.value.match(specialChars)){
                percentage += 35;
            }
            if(this.$props.value && this.$props.value.length >= 4 && this.$props.value.match(nubmers)){
                percentage += 20;
            }
            if(this.$props.value && this.$props.value.length >= 12){
                percentage += 10;
            }
            return percentage;
        },
        clickOutside(e){
            this.focus = false;
        },
        focusFieldSmall(){
            this.$refs.inputfieldSmall.focus();
        },
        focusField(){
            this.$refs.inputfield.focus();
        },
        kd(){
            this.previous_input = this.$props.value;
        },
        ku(){
            this.error = false;
            this.$emit('update:value', this.$refs.inputfield.value);
            this.$emit('update:cc', this.$refs.inputfieldSmall.value);
            this.debounceChange();
        },
        debounceChange: _.debounce(function() {
            if(this.previous_input !== this.$refs.inputfield.value){
                this.$emit('changed', {
                    prev: this.previous_input,
                    current: this.$refs.inputfield.value
                })
            }
        }, 200)
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
        if(this.$props.required !== null){
            window.mitt.on('request_failed', (data) => {
                for(let error in data.errors){
                    error = data.errors[error];
                    console.log(error.id, this.field_id);
                    if(error.id === this.field_id){
                        this.error_message = error.message ? error.message : '';
                        this.error = true;
                    }
                }
            });
        }
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.field-wrapper{
    width: 100%;

    &.error{
        p{
            color: $error;
        }

        .error-message{
            margin-top: 2px;
        }
    }

    .label{
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }

    .fields{
        display: flex;

        .field{
            position: relative;
            display: flex;
            width: 100%;
            height: 40px;
            border-radius: calc(#{$radius} / 2);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            background: #FFFFFF;
            border: 1px solid $gray-L2;
            transition: $transition;
            align-items: center;
            cursor: text;
            overflow: hidden;

            &:first-child{
                width: 85px;
                margin-right: $padding;
            }

            i{
                margin-left: 8px;
                margin-right: -8px;
                color: $gray;
                position: relative;

                &.icon-unhide, &.icon-hide{
                    margin-right: 8px;
                    cursor: pointer;
                }
            }

            .strength{
                position: absolute;
                width: 100%;
                height: 2px;
                background-color: $gray-L2;
                bottom: 0;

                .percentage{
                    width: 20%;
                    height: 2px;
                    position: absolute;
                    background-color: $error;
                    transition: 0.4s;

                    &.mid{
                        background-color: $warning;
                    }

                    &.high{
                        background-color: $success;
                    }
                }
            }

            &:hover{
                border: 1px solid $gray-L1;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            &.error{
                border: 1px solid $error;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            }

            &.focus{
                border: 1px solid $brand;
                box-shadow: 0 1px 3px #{$brand}4C, 0px 4px 8px #{$brand}33;

                .icon-unhide, .icon-hide{
                    color: $brand;
                }
            }

            &.disabled{
                background: $gray-L3;

                &:hover{
                    border: 1px solid $gray-L2;
                    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
                }
            }

            &.large{
                height: 48px;
            }

            &.small{
                height: 32px;
            }

            .after{
                padding: 0 $padding;
                background-color: $gray-L3;
                border-left: 1px solid $gray-L2;
                border-radius: 0 calc(#{$radius} / 2) calc(#{$radius} / 2) 0;
                display: flex;
                height: 100%;
                align-items: center;
                user-select: none;

                p{
                    color: $gray-D1;
                    margin: 0;
                }
            }

            input{
                outline: none;
                border: none;
                width: 100%;
                height: 100%;
                background: none;
                padding: 0 16px;
                font-style: normal;
                font-weight: 400;
                font-size: 14px;
                color: $gray-D3;

                &::placeholder{
                    color: $gray;
                }
            }
        }
    }
}
</style>