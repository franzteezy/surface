<template>
    <div :class="{'filter-wrapper':true, active:active, checked:checkActive}" v-click-outside="clickOutside">
        <P gray @click="activate">
            <slot></slot>
            <span v-if="multiselect!==null && checkActive">({{ activated() }} selected)</span></P>

        <div class="options" v-show="active && options!==null">
            <P bold class="marg-b">Filter
                <slot></slot>
            </P>
            <Input class="marg-b" small placeholder="Search" v-model:value="search"/>
            <div v-if="multiselect===null">
                <Radio v-for="field in filteredOptions" v-model:value="value" :label="field.label" :name="name"
                       :option="field.option"/>
            </div>
            <div v-if="multiselect!==null">
                <Checkbox v-for="(field, key) in filteredOptions" v-model:value="value[key]" :label="field.label"
                          :name="field.name"/>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        options: {
            Type: Array,
            default: null
        },
        value: {
            Type: null,
            default: null
        },
        multiselect: {
            Type: Boolean,
            default: null
        },
        name: {
            Type: String,
            default: null
        },
    },
    data(){
        return{
            active: false,
            search: ''
        }
    },
    computed: {
        filteredOptions(){
            if(Array.isArray(this.$props.options)){
                return this.$props.options.filter((item) => (item.label.toLowerCase().includes(this.search.toLowerCase()) || this.search === ''));
            }
            return this.$props.options;
        },
        checkActive(){
            if(this.$props.options === null){
                return this.$props.value===true;
            } else if(this.$props.multiselect !== null){
                return this.$props.value.includes(true);
            } else {
                return this.$props.value !== null;
            }
        }
    },
    methods: {
        activated() {
            if (this.$props.options !== null && this.$props.multiselect !== null) {
                let count = 0;
                for (let option in this.$props.value) {
                    count += this.$props.value[option] ? 1 : 0;
                }
                return count;
            }
        },
        activate() {
            if (this.$props.options === null) {
                this.$emit('update:value', !this.$props.value);
            } else {
                this.active = !this.active;
            }
        },
        clickOutside() {
            this.active = false;
        }
    },
    created() {
    },
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.filter-wrapper {
    border-radius: calc(#{$radius} / 2);
    width: fit-content;
    background: $white;
    border: 1px solid $gray-L2;
    cursor: pointer;
    transition: $transition;
    position: relative;
    margin-right: calc(#{$padding} / 2);
    z-index: $level3;

    p {
        padding: 5px 12px;
        white-space: nowrap;
    }

    &:hover {
        border: 1px solid $gray-D1;

        p {
            color: $gray-D1;
        }
    }

    &.active{
        border: 1px solid $brand-L2;

        p{
            color: $brand-D1;
        }
    }

    &.checked{
        border: 1px solid $brand-L3;
        background: $brand-L5;

        p{
            color: $brand-D1;
        }
    }

    .options {
        position: absolute;
        min-width: 280px;
        min-height: 40px;
        box-shadow: $shadow;
        border-radius: calc(#{$radius} / 2);
        top: calc(28px + (#{$padding} / 2));
        left: 0;
        padding: calc(#{$padding} * 1.5);
        background: $white;

        .field-wrapper {
            .box {
                width: 100%
            }
        }
    }
}
</style>