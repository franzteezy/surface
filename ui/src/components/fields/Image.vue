<template>
    <div :class="{'field-wrapper':true,error:error}" :fieldId="field_id">
        <div class="image">
            <div :class="{'img-holder':true, show:loaded}" >
                <div class="loader" :style="{backgroundImage: 'url('+(preview)+')'}"></div>
            </div>
            <input type="file" @change="fileChange" :value="value ? value.value : null" ref="input" accept="image/png, image/jpeg, image/gif"/>
            <i :class="{icon:true, ['icon-'+icon]:true}" v-if="icon" />
        </div>
        <div class="info">
            <div class="buttons">
                <Button small v-if="value===null" @click="focusInput">Upload</Button>
                <Button white small v-if="value!==null" @click="remove">Remove</Button>
            </div>
            <P large gray>JPG, GIF or PNG. Max size of 2MB</P>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        value: {
            Type: Object,
            default: null
        },
        icon: {
            Type: String,
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
        name:{
            Type: Boolean,
            default: ''
        },
        required:{
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
            loaded: false,
            preview: null,
        }
    },
    methods: {
        focusInput(){
            this.$refs.input.click();
        },
        remove(){
            this.loaded = false;
            this.$emit('update:value', null);
        },
        fileChange(event){
            let reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);
            reader.onload = () => {
                const file = {
                    value: event.target.value,
                    name: event.target.files[0].name,
                    size: event.target.files[0].size,
                    lastModifiedDate: event.target.files[0].lastModifiedDate,
                    base64: reader.result
                };
                this.loaded = false;

                if(reader.result){
                    this.preview = reader.result;
                    let image = new Image();
                    image.addEventListener('load', () => {
                        this.loaded = true;
                    });
                    image.src = this.preview;
                }

                this.$emit('update:value', file);
            };
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
    display: flex;
    width: 100%;

    .image{
        width: 80px;
        height: 80px;
        margin-right: $padding;
        background-color: $brand-L5;
        border: 1px solid $brand-L2;
        border-radius: 100%;
        display: flex;
        position: relative;
        align-items: center;
        justify-content: center;
        overflow: hidden;

        .img-holder{
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: 0s;

            &.show{
                opacity: 1;
                transition: 1.2s;
            }

            .loader{
                width: 100%;
                background-size: cover;
                height: 100%;
            }
        }

        input{
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;

        }

        .icon{
            font-size: 35px;
            color: $brand;
        }
    }

    .info{
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: center;
        height: 100%;

        .buttons{
            display: flex;
            margin: 0 0 8px 0;
            .button{
                margin-right: $padding;
            }
        }
    }
}
</style>