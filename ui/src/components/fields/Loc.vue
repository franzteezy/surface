<template>
    <div v-click-outside="() => setFocus(false)" :class="{'field-wrapper':true,error:error}" :fieldId="field_id">
        <P v-if="label" class="label" overline>{{ label }}{{ required !== null ? '*' : '' }}</P>
        <div v-click-outside="clickOutside"
             :class="{field:true, large:large!==null, small:small!==null, error:error, focus:focus, disabled:disabled}"
             @click="focusField">
            <i v-if="icon!==null" :class="{icon:true, ['icon-'+icon]:true}"/>
            <input ref="inputfield" :disabled="disabled" :name="name" :placeholder="placeholder" :value="value"
                   type="text" @blur="setFocus(false)" @click="setFocus(true)" @focus="setFocus(true)" @keyup="ku"/>

            <img v-if="location.loading" alt="loader" src="/src/assets/svg/loader.svg" width="40"/>
            <i v-if="selected!==null && disabled" :class="{icon:true, 'icon-trash':true, red:true}"
               @click="resetSelect"/>
            <div v-if="after!==null" class="after">
                <P large>{{ after }}</P>
            </div>

        </div>
        <div v-if="focus && !disabled && location.many !== [] && value !== ''"
             class="results-wrapper">
            <Column centerh class="results marg-t">
                <Column nm>
                    <Row v-for="loc in location.many" centerv class="location" nm
                         @click="selectLocation(loc)">
                        <Column class="marg-r" nm w1>
                            <i class="icon icon-location"/>
                        </Column>
                        <Column w11>
                            <P large>{{ loc.name }}</P>
                            <P gray>{{ loc.full_address }}</P>
                        </Column>
                    </Row>
                </Column>
            </Column>
        </div>
        <P v-if="error_message && error" class="error-message">{{ error_message }}</P>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    computed: {
        location: {
            get() {
                return window.store.location;
            }
        }
    },
    props: {
        placeholder: {
            Type: String,
            default: ''
        },
        selected: {
            Type: String,
            default: ''
        },
        focus: {
            Type: Function,
            default: null
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
        required: {
            Type: Boolean,
            default: null
        },
        after: {
            Type: String,
            default: null
        },
    },
    data() {
        return {
            value: '',
            previous_input: '',
            error: false,
            error_message: '',
            focus: false,
            field_id: null,
        }
    },
    methods: {
        resetSelect() {
            this.$emit('update:selected', null);
            this.value = '';
            this.$props.disabled = false;
        },
        selectLocation(location) {
            this.$emit('update:selected', location);
            this.value = location.full_address;
            this.$props.disabled = true;
            this.$emit('changed', location);
        },
        setFocus(val = false) {
            window.setTimeout(() => {
                this.focus = val;
                this.$emit('focus', val);
            }, 200);
        },
        clickOutside() {
            this.focus = false;
        },
        focusField() {
            this.$refs.inputfield.focus();
        },
        ku() {
            this.error = false;
            this.value = this.$refs.inputfield.value;
            this.debounceChange();
        },
        debounceChange: _.debounce(function () {
            if (this.previous_input !== this.value) {
                this.previous_input = this.value;
                this.location.package.name = this.value;
                this.location.many = [];
                if (this.location.package.name !== '') {
                    this.location.fetch();
                }
            }
        }, 400)
    },
    beforeUnmount() {
        if (window.fields[this.$props.name].field_id === this.field_id) {
            delete window.fields[this.$props.name];
        }
    },
    created() {

        if (this.$props.name !== '') {
            if (!window.fields) {
                window.fields = {};
            }

            window.fields[this.$props.name] = this;
        }

        this.field_id = window.makeid(20);
        if (this.$props.required !== null) {
            window.mitt.on('request_failed', (data) => {
                for (let error in data.errors) {
                    error = data.errors[error];
                    if (error.id === this.field_id) {
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

.field-wrapper {
    width: 100%;

    &.error {
        p {
            color: $error;
        }

        .error-message {
            margin-top: 2px;
        }
    }

    .results-wrapper {
        width: 100%;
        position: relative;

        .results {
            position: absolute;
            width: 100%;
            max-height: 220px;
            border-radius: $radius;
            background: $white;
            z-index: $level3;
            box-shadow: $shadow;
            overflow: auto;

            a {
                text-decoration: none;
            }

            .location {
                padding: calc(#{$padding} / 2) $padding;
                cursor: pointer;
                transition: 0.2s;

                &:hover {
                    background: $gray-L4;
                }
            }
        }
    }

    .label {
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }

    .field {
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

        i {
            margin-left: 8px;
            margin-right: -8px;
            color: $gray;
            position: relative;

            &.icon-trash {
                color: $error;
                cursor: pointer;
            }

            &.icon-unhide, &.icon-hide {
                margin-right: 8px;
                cursor: pointer;
            }
        }

        .strength {
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: $gray-L2;
            bottom: 0;

            .percentage {
                width: 20%;
                height: 2px;
                position: absolute;
                background-color: $error;
                transition: 0.4s;

                &.mid {
                    background-color: $warning;
                }

                &.high {
                    background-color: $success;
                }
            }
        }

        &:hover {
            border: 1px solid $gray-L1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        &.error {
            border: 1px solid $error;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        &.focus {
            border: 1px solid $brand;
            box-shadow: 0 1px 3px #{$brand}4C, 0px 4px 8px #{$brand}33;

            .icon-unhide, .icon-hide {
                color: $brand;
            }
        }

        &.disabled {
            background: $gray-L3;

            &:hover {
                border: 1px solid $gray-L2;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            }
        }

        &.large {
            height: 48px;
        }

        &.small {
            height: 32px;

            input {
                font-weight: 300;
                font-size: 14px;

                &::placeholder {
                    color: $gray;
                }
            }
        }

        .after {
            padding: 0 $padding;
            background-color: $gray-L3;
            border-left: 1px solid $gray-L2;
            border-radius: 0 calc(#{$radius} / 2) calc(#{$radius} / 2) 0;
            display: flex;
            height: 100%;
            align-items: center;
            user-select: none;

            p {
                color: $gray-D1;
                margin: 0;
            }
        }

        input {
            outline: none;
            border: none;
            width: calc(100% - 32px);
            height: 100%;
            background: none;
            padding: 0 16px;
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            color: $gray-D3;

            &::placeholder {
                color: $gray;
            }
        }
    }
}
</style>