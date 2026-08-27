<template>
    <div :class="{'field-wrapper':true,error:error, 'has-value':value}" :fieldId="field_id">
        <P class="label" v-if="label" overline bold @click="focusField" :fieldLabel="field_id">{{label}}{{required!==null?'*':''}}</P>
        <div class="click-wrapper" v-click-outside="clickOutside">
            <div :class="{field:true, large:large!==null, small:small!==null, error:error, focus:focus, disabled:disabled}" @click="focusField">
                <i :class="{icon:true, ['icon-'+icon]:true}" v-if="icon!==null"/>
                <P v-if="multi===null" :gray="value===null ? true : null">{{value ? value[okey] : placeholder}}</P>
                <P v-if="multi!==null" :gray="value.length < 1 ? true : null">{{value.length >= 1 ? (value.length === 1 ? value[0][okey] : value.length+' selected') : placeholder}}</P>
                <i class="icon-arrow-down-1" />
            </div>

            <div class="dropdown-options" v-if="focus && !disabled">
                <Input v-model:value="search_field" placeholder="Search..." small v-if="search!==null"/>
                <div class="options">
                    <div :class="{option:true, selected:value===option||multi!==null && value.includes(option)}" v-for="option in filtered_options" @click="selectOption(option)">
                        <P>{{option[okey]}}</P>
                    </div>
                </div>
            </div>
        </div>
        <P class="error-message" v-if="error_message && error">{{error_message}}</P>
    </div>
</template>

<script>
export default {
    props: {
        placeholder: {
            Type: String,
            default: ''
        },
        icon: {
            Type: String,
            default: null
        },
        okey: {
            Type: String,
            default: 'value'
        },
        value: {
            Type: Object|Array,
            default: null
        },
        options: {
            Type: Array,
            default: []
        },
        change: {
            Type: Function,
            default: null
        },
        multi: {
            Type: Boolean,
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
        search: {
            Type: Boolean,
            default: null
        },
    },
    computed: {
        filtered_options: {
            get(){
                let filtered = [];
                for (let key in this.$props.options){
                    let option = this.$props.options[key];
                    if(option.s && option.s.toLowerCase().indexOf(this.search_field.toLowerCase()) !== -1){
                        filtered.push(option);
                    } else if(option[this.$props.okey] && option[this.$props.okey].toLowerCase().indexOf(this.search_field.toLowerCase()) !== -1){
                        filtered.push(option);
                    } else if(this.search_field === ''){
                        filtered.push(option);
                    }
                }
                return filtered;
            }
        }
    },
    data(){
        return{
            search_field: '',
            previous_input: '',
            error: false,
            error_message: '',
            focus: false,
            field_id: null,
        }
    },
    methods: {
        focusField(){
            if(!this.$props.disabled){
                this.search_field = '';
                this.focus = !this.focus;
                this.error = false;
                this.error_message = '';
            }
        },
        selectOption(option){
            if(this.$props.multi!==null){
                let current = this.$props.value;
                if(typeof current !== 'object'){
                    current = [];
                }
                if(current.includes(option)){
                    current.splice(current.indexOf(option), 1);
                } else {
                    current.push(option);
                }
                this.$emit('update:value', current);
            } else {
                this.$emit('update:value', option);
                this.focus = false;
            }
            this.$emit('changed', option);
        },
        clickOutside(e){
            if(this.focus && e.target !== document.querySelectorAll('[fieldLabel="'+this.field_id+'"]')[0]){
                this.search_field = '';
                this.focus = false;
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
    width: 100%;
    z-index: 10;

    &.error{
        p{
            color: $error;
        }

        .error-message{
            margin-top: 2px;
        }
    }

    i{
        margin-right: 8px;
        color: $gray;
        top: 2px;

        &.icon-arrow-down-1{
            margin-left: auto;
            margin-right: 0;
        }
    }

    .label{
        margin-bottom: 8px;
        cursor: pointer;
        letter-spacing: 0.01em;
    }

    .click-wrapper{
        position: relative;

        .dropdown-options{
            position: absolute;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: auto;
            min-height: 32px;
            background-color: $white;
            top: calc(40px + #{$padding});
            border-radius: calc(#{$radius} / 2);
            border: 1px solid $gray-L2;
        }

        .field-wrapper{
            margin: $padding $padding 10px;
        }

        .options{
            max-height: 280px;
            display: flex;
            flex-direction: column;
            overflow: auto;
            z-index: 999;

            .option{
                width: 100%;
                height: 32px;
                min-height: 32px;
                display: flex;
                align-items: center;
                cursor: pointer;
                padding: 0 calc(#{$padding} - 2px);
                border-left: 2px inset #{$brand-L3}00;
                transition: $transition;

                &:hover{
                    background-color: $gray-L4;
                    border-left: 2px inset $brand-L3;
                }

                &.selected{
                    border-left: 2px inset $brand;
                    p{
                        color: $brand;
                    }
                }

                p{
                    color: $gray-D2;
                }
            }
        }
    }

    .field{
        display: flex;
        width: 100%;
        height: 40px;
        border-radius: calc(#{$radius} / 2);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        background: #FFFFFF;
        border: 1px solid $gray-L2;
        transition: $transition;
        padding: 0 $padding;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;

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
            align-items: center;

            p{
                color: $gray-D1;
                margin: 0;
            }
        }

        input{
            outline: none;
            border: none;
            width: 100%;
            height: 40px;
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
</style>