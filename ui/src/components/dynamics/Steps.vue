<template>
    <div class="steps">
        <div :class="{step:true, active:active === key, passed:active > key}" v-for="(step, key) in steps" @click="setActive(key)" ref="step" :style="{width: active === key ? this.activeWidth+'px' : '20px'}">
            <div class="content">
                <i :class="{icon:true, ['icon-'+step.icon]:true}"></i>
                <P bold>{{step.title}}</P>
            </div>
        </div>
        <div class="line"></div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    watch: {
      active(newValue, prevValue){
          if(this.$refs['step'][newValue]){
              this.activeWidth = this.$refs['step'][newValue].children[0].offsetWidth + 8;
          }
      }
    },
    props: {
        steps: {
            type: Array,
            default: []
        },
        active: {
            type: Number,
            default: 0,
        },
        clickable: {
            type: Boolean,
            default: null,
        }
    },
    data(){
        return{
            activeWidth: 0,
        }
    },
    computed: {},
    methods: {
        setActive(key){
            if(this.$props.clickable !== null){
                this.$emit('update:active', key);
            }
        }
    },
    created() {
    },
    mounted() {
        this.activeWidth = this.$refs['step'][this.active].children[0].offsetWidth + 12;
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.steps{
    display: flex;
    justify-content: space-between;
    position: relative;
    width: 100%;
    z-index: 0;
    margin: 12px 0;

    .line{
        position: absolute;
        height: 1px;
        content: '';
        width: 100%;
        border-bottom: 1px dashed $gray-L1;
        top: calc(50% - 1px);
        z-index: 0;
    }

    .step{
        position: relative;
        align-items: center;
        display: flex;
        border-radius: 20px;
        padding: 10px 11px;
        overflow: hidden;
        width: 20px;
        transition: $transition;
        z-index: 2;
        background: $white;
        box-sizing: initial;

        .content{
            position: relative;
            display: flex;
            align-items: center;
            margin: 0 4px;

            i{
                margin-right: 8px;
                font-size: 20px;
                color: $gray-L1;
            }


            p{
                white-space: nowrap;
                text-transform: uppercase;
            }
        }

        &.passed{
            .content{
                i{
                    color: $brand;
                }
            }
        }

        &.active{
            box-shadow: #{$shadow}, 0px 2px 0px 12px rgb(255 255 255);

            i{
                color: #E20088;
            }

            &:nth-child(2) {
                .content {

                    i {
                        color: #FF7658;
                    }
                }
            }

            &:nth-child(3){
                .content {

                    i {
                        color: #27AE60;
                    }
                }
            }

            &:nth-child(4){
                .content {

                    i {
                        color: #0451DB;
                    }
                }
            }
        }
    }

}

</style>