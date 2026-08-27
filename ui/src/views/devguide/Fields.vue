<template>
    <div class="wrapper">

        <H1>Input fields</H1>
        <br />
        <Input placeholder="Placeholder" v-model:value="input_val" icon="search-normal-1" label="Input field" after="Value" :required="input_required ? input_required : null" :disabled="input_disabled" @changed="inputChange"/>
        <div class="attr">
            <H3>Attributes</H3>
            <P><strong><b>large</b></strong> Make the field large</P>
            <P><strong><b>small</b></strong> Make the field small</P>
            <P><input type="checkbox" :checked.sync="input_required" @click="input_required = !input_required"> <strong><b>required</b></strong> Make field required and autocheck for errors</P>
            <P><strong><b>placeholder</b>=<i>"text"</i></strong> A string for showing a placeholder</P>
            <P><strong><b>after</b>=<i>"text"</i></strong> A text in the end of the field, eg. Valuta, DKK, EUR</P>
            <P><strong><b>label</b>=<i>"text"</i></strong> Show a label above the field</P>
            <P><strong><b>icon</b>=<i>"text"</i></strong> Show icon before input</P>
            <P><strong><b>v-model:value</b>=<i>"variable"</i></strong> A data variable to store the value in</P>
            <P><input type="checkbox" :checked.sync="input_disabled" @click="input_disabled = !input_disabled"> <strong><b>:disabled</b>=<i>"true/false"</i></strong> Disable the field and all input</P>
            <P><span :class="{change:true, changed:input_changed}"></span><strong><b>@changed</b>=<i>"function"</i> </strong>Function that triggers on a change, try write and see the effect</P>
        </div>

        <Dropdown placeholder="Placeholder" v-model:value="dropdown_value" :options="dropdown_options" icon="search-normal-1" search :required="dropdown_required ? dropdown_required : null" @changed="dropdownChange" :disabled="dropdown_disabled" okey="name" label="Dropdown field" required after="Value" multi />
        <div class="attr">
            <H3>Attributes</H3>
            <P><strong><b>large</b></strong> Make the field large</P>
            <P><strong><b>small</b></strong> Make the field small</P>
            <P><strong><b>search</b></strong> Show search in dropdown</P>
            <P><strong><b>multi</b></strong> Allow selection of more than 1 value</P>
            <P><input type="checkbox" :checked.sync="dropdown_required" @click="dropdown_required = !dropdown_required"> <strong><b>required</b></strong> Make field required and autocheck for errors</P>
            <P><strong><b>placeholder</b>=<i>"text"</i></strong> A string for showing a placeholder</P>
            <P><strong><b>icon</b>=<i>"text"</i></strong> Show an icon in the field</P>
            <P><strong><b>label</b>=<i>"text"</i></strong> Show a label above the field</P>
            <P><strong><b>options</b>=<i>"array"</i></strong> An array of objects to be shown in the list (default key="value")</P>
            <P><strong><b>okey</b>=<i>"string"</i></strong> Overwrite the key shown as value (default key="value")</P>
            <P><strong><b>v-model:value</b>=<i>"variable/array"</i></strong> A data variable to store the value in, when multi is on value needs to be of array type</P>
            <P><input type="checkbox" :checked.sync="dropdown_disabled" @click="dropdown_disabled = !dropdown_disabled"> <strong><b>:disabled</b>=<i>"true/false"</i></strong> Disable the field and all input</P>
            <P><span :class="{change:true, changed:dropdown_changed}"></span><strong><b>@changed</b>=<i>"function"</i> </strong>Function that triggers on a change, try write and see the effect</P>
        </div>

        <Checkbox v-model:value="checkbox_value" label="Checkbox field" :disabled="checkbox_disabled" :required="checkbox_required ? checkbox_required : null" @changed="checkboxChange" :toggle="checkbox_toggle ? true : null"/>
        <div class="attr">
            <H3>Attributes</H3>
            <P><input type="checkbox" :checked.sync="checkbox_toggle" @click="checkbox_toggle = !checkbox_toggle"><strong><b>toggle</b></strong> Make this a toggle style checkbox</P>
            <P><input type="checkbox" :checked.sync="checkbox_required" @click="checkbox_required = !checkbox_required"> <strong><b>required</b></strong> Make field required and autocheck for errors</P>
            <P><strong><b>label</b>=<i>"text"</i></strong> Show a label beside the checkbox (optional)</P>
            <P><strong><b>v-model:value</b>=<i>"true/false"</i></strong> Value of the checkbox boolean</P>
            <P><input type="checkbox" :checked.sync="checkbox_disabled" @click="checkbox_disabled = !checkbox_disabled"> <strong><b>:disabled</b>=<i>"true/false"</i></strong> Disable the field and all input</P>
            <P><span :class="{change:true, changed:checkbox_change}"></span><strong><b>@changed</b>=<i>"function"</i> </strong>Function that triggers on a change, try write and see the effect</P>
        </div>

        <Editor label="Editor field" placeholder="placeholder" :disabled="editor_disabled" :required="editor_required ? true : null" @changed="editorChange" v-model:value="editor_value"/>
        <div class="attr">
            <H3>Attributes</H3>
            <P><input type="checkbox" :checked.sync="editor_required" @click="editor_required = !editor_required"> <strong><b>required</b></strong> Make field required and autocheck for errors</P>
            <P><strong><b>placeholder</b>=<i>"text"</i></strong> A string for showing a placeholder</P>
            <P><strong><b>label</b>=<i>"text"</i></strong> Show a label above the field</P>
            <P><strong><b>v-model:value</b>=<i>"variable"</i></strong> A data variable to store the value in</P>
            <P><input type="checkbox" :checked.sync="editor_disabled" @click="editor_disabled = !editor_disabled"> <strong><b>:disabled</b>=<i>"true/false"</i></strong> Disable the field and all input</P>
            <P><span :class="{change:true, changed:editor_changed}"></span><strong><b>@changed</b>=<i>"function"</i> </strong>Function that triggers on a change, try write and see the effect</P>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            input_val: '',
            input_disabled: false,
            input_required: true,
            input_changed: false,

            dropdown_value: [],
            dropdown_disabled: false,
            dropdown_required: true,
            dropdown_changed: false,
            dropdown_options: [
                {
                    name: 'test 1',
                    id: 41244
                },
                {
                    name: 'test 2',
                    id: 41243
                },
                {
                    name: 'test 3',
                    id: 43
                }
            ],

            checkbox_value: true,
            checkbox_required: true,
            checkbox_toggle: false,
            checkbox_disabled: false,
            checkbox_change: false,

            editor_required: true,
            editor_disabled: false,
            editor_changed: false,
            editor_value: null,
        }
    },
    methods:{
        inputChange(){
            this.input_changed = true;
            window.setTimeout(() => {
                this.input_changed = false;
            }, 400);
        },
        dropdownChange(){
            this.dropdown_changed = true;
            window.setTimeout(() => {
                this.dropdown_changed = false;
            }, 400);
        },
        checkboxChange(){
            this.checkbox_change = true;
            window.setTimeout(() => {
                this.checkbox_change = false;
            }, 400);
        },
        editorChange(){
            this.editor_changed = true;
            window.setTimeout(() => {
                this.editor_changed = false;
            }, 400);
        }
    },
    created() {},
    mounted() {}
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.wrapper {
    max-width: 1280px;
    margin: 64px auto auto;
    width: 100%;

    .attr{
        width: calc(100% - 80px);
        height: auto;
        display: flex;
        flex-direction: column;
        margin: 24px 0 100px;
        background-color: $gray-L2;
        padding: 40px;

        .change{
            width: 13px;
            height: 13px;
            margin-right: 3px;
            display: inline-block;
            border-radius: 100%;
            background-color: $brand-L2;
            opacity: 0;
            transition: 0.2s;

            &.changed{
                opacity: 1;
            }
        }

        strong{
            width: 200px;
            display: inline-block;
            margin-left: 22px;

            &:first-child{
                margin-left: 40px;
            }
        }

        i{
            font-weight: 900;
            color: $success;
            font-family: $font-family;
            margin: 0 20px 0 0;
        }
    }
}
</style>