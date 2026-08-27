<template>
    <div :class="{'field-wrapper':true,error:error, disabled:disabled}" :fieldId="field_id">
        <P class="label" v-if="label" overline bold>{{label}}{{required!==null?'*':''}}</P>
        <div :class="{'box-wrapper':true, focus:focus}">
            <div class="toolbox" v-if="editor">
                <i :class="{'icon icon-undo':true, active:editor.isActive('undo')}" @click="editor.chain().focus().undo().run() && editorChange()"/>
                <i :class="{'icon icon-redo':true, active:editor.isActive('redo')}" @click="editor.chain().focus().redo().run() && editorChange()"/>
                <div class="divider"></div>
                <i :class="{'icon icon-text-bold':true, active:editor.isActive('bold')}" @click="editor.chain().focus().toggleBold().run() && editorChange()"/>
                <i :class="{'icon icon-text-italic':true, active:editor.isActive('italic')}" @click="editor.chain().focus().toggleItalic().run() && editorChange()"/>
                <i :class="{'icon icon-text-underline':true, active:editor.isActive('underline')}" @click="editor.chain().focus().toggleUnderline().run() && editorChange()" />
                <i :class="{'icon icon-text-size-1':true, active:editor.isActive('heading', { level: 1 })}"  @click="editor.chain().focus().toggleHeading({ level: 1 }).run() && editorChange()"/>
                <i :class="{'icon icon-text-size-2':true, active:editor.isActive('heading', { level: 2 })}"  @click="editor.chain().focus().toggleHeading({ level: 2 }).run() && editorChange()"/>
                <div class="divider"></div>
                <i :class="{'icon icon-align-left':true, active:editor.isActive({ textAlign: 'left' })}" @click="editor.chain().focus().setTextAlign('left').run() && editorChange()" />
                <i :class="{'icon icon-align-center':true, active:editor.isActive({ textAlign: 'center' })}" @click="editor.chain().focus().setTextAlign('center').run() && editorChange()" />
                <i :class="{'icon icon-align-right':true, active:editor.isActive({ textAlign: 'right' })}" @click="editor.chain().focus().setTextAlign('right').run() && editorChange()" />
                <div class="divider"></div>
                <i :class="{'icon icon-list-ordered':true, active:editor.isActive('orderedList')}" @click="editor.chain().focus().toggleOrderedList().run() && editorChange()"/>
                <i :class="{'icon icon-list-unordered':true, active:editor.isActive('bulletList')}" @click="editor.chain().focus().toggleBulletList().run() && editorChange()"/>
            </div>
            <div :class="{field:true, error:error, disabled:disabled}">
                <editor-content :editor="editor" :disabled="disabled" @keydown="kd" @keyup="ku"/>
            </div>
        </div>
        <P class="error-message" v-if="error_message && error">{{error_message}}</P>
    </div>
</template>

<script>
import _ from 'lodash';
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import Underline from '@tiptap/extension-underline'
import Text from '@tiptap/extension-text'
import TextAlign from '@tiptap/extension-text-align'


export default {
    components: {
        EditorContent,
    },
    props: {
        placeholder: {
            Type: String,
            default: ''
        },
        value: {
            Type: String,
            default: ''
        },
        name: {
            Type: String,
            default: ''
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
        required:{
            Type: Boolean,
            default: null
        }
    },
    data(){
        return{
            previous_input: '',
            error: false,
            error_message: '',
            focus: false,
            field_id: null,
            editor: null,
        }
    },
    methods: {
        editorChange(){
            this.kd();
            this.ku();
        },
        kd(){
            this.previous_input = this.$props.value;
        },
        ku(){
            this.error = false;
            this.$emit('update:value', this.editor.getHTML());
            this.debounceChange();
        },
        debounceChange: _.debounce(function() {
            if(this.previous_input !== this.editor.getHTML()){
                this.$emit('changed', {
                    prev: this.previous_input,
                    current: this.editor.getHTML()
                })
            }
        }, 200),
    },
    mounted(){
        this.editor = new Editor({
            content: null,
            extensions: [
                Text,
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                Underline,
                Placeholder.configure({
                    emptyEditorClass: 'is-editor-empty',
                    placeholder: this.placeholder,
                }),
                StarterKit,
            ],
        });

        this.editor.on('blur', () => {
            this.focus = false;
        })

        this.editor.on('focus', () => {
            this.focus = true;
        })
    },
    beforeUnmount() {
        if(window.fields[this.$props.name].field_id === this.field_id){
            delete window.fields[this.$props.name];
        }
        this.editor.destroy()
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

    &.disabled{
        pointer-events: none;
    }

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

    .box-wrapper{
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        border-radius: calc(#{$radius} / 2);


        &:hover{
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            .toolbox{
                border: 1px solid $gray-L1;
                border-bottom: none;
            }
            .field {
                border: 1px solid $gray-L1;
            }
        }

        &.focus{
            box-shadow: 0 1px 3px #{$brand}4C, 0px 4px 8px #{$brand}33;
            .toolbox{
                border: 1px solid $brand;
                border-bottom: none;
            }
            .field {
                border: 1px solid $brand;
            }
        }

    }

    .toolbox{
        display: flex;
        width: calc(100% - (#{$padding} * 2));
        height: 38px;
        border: 1px solid $gray-L2;
        border-radius: calc(#{$radius} / 2) calc(#{$radius} / 2) 0 0;
        border-bottom: none;
        transition: $transition;
        align-items: center;
        padding: 0 $padding;

        .divider{
            width: 1px;
            height: 20px;
            margin: 0 16px;
            background-color: $gray-L2;
        }

        i{
            width: 20px;
            height: 20px;
            line-height: 24px;
            text-align: center;
            font-size: 13px;
            margin-right: 8px;
            border-radius: calc(#{$radius} / 2);
            background-color: $white;
            transition: $transition;
            color: $gray-D1;
            display: block;
            cursor: pointer;
            top: 0;

            &:hover{
                background-color: $gray-L3;
            }

            &.active{
                background-color: $brand;
                color: $white;
            }
        }
    }

    .field{
        display: flex;
        width: 100%;
        height: auto;
        border-radius:  0 0 calc(#{$radius} / 2) calc(#{$radius} / 2);
        background: #FFFFFF;
        border: 1px solid $gray-L2;
        transition: $transition;
        align-items: center;
        cursor: text;

        &.disabled{
            background: $gray-L3;
        }

        i{
            margin-left: 8px;
            margin-right: -8px;
            color: $gray;
            position: relative;
            top: 1px;
        }

        & > div{
            width: 100%;
            outline: none;
            :deep(.ProseMirror){
                padding: $padding;
                outline: none;

                ul, ol{
                    li{
                        margin-left: 16px;
                    }
                }

                .is-editor-empty:first-child::before {
                    color: $gray;
                    content: attr(data-placeholder);
                    float: left;
                    height: 0;
                    pointer-events: none;
                }
            }
        }

        &.error{
            border: 1px solid $error;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        &.disabled{
            background: $gray-L3;

            &:hover{
                border: 1px solid $gray-L2;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            }
        }
    }
}
</style>