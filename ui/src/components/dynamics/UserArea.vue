<template>
    <div class="user-area">
        <div class="icon-area">
            <i class="icon icon-calendar"/>
        <RouterLink :to="'/mailer'" :class="{partial:isActive('/mailer')}" ><i class="icon icon-mail-open " :class="{newNotif: chatNotif > 0}"/></RouterLink>
            <i class="icon icon-bell new"/>
        </div>
        <div :class="{user:true, ['base-'+user_image_base]:true}">
            <Avatar />
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {
        chatNotif: 0
    },
    data() {
        return {
        }
    },
    computed: {
        user: {
            get() {
                return window.store.auth.single;
            }
        },
        user_image_base: {
            get() {
                if (!this.user.id) {
                    return 1;
                } else {
                    return this.user.first_name[0].toLowerCase().charCodeAt(0) - 96;
                }
            }
        },
    },
    methods: {
        isActive(route){
            return this.$route.path.includes(route);
        }
    },
    created() {
    },
    mounted() {
        
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.user-area {
    display: flex;
    height: 100%;
    align-items: center;
    width: 200px;
    justify-content: flex-end;

    .user {
        width: 40px;
        height: 40px;
        background-image: url('/src/assets/images/user-base/base-1.png');
        background-size: cover;
        cursor: pointer;

        @for $i from 1 through 37 {
            .base-#{$i} {
                background-image: url('/src/assets/images/user-base/base-#{$i}.png');
            }
        }
    }

    .icon-area {
        display: flex;
        margin-right: $padding;

        a{
            text-decoration: none;
            &.router-link-active, &.partial{
                i{
                    color: $gray-D3 !important;
                }
            }
        }
        
        
        i {
            font-size: 18px;
            margin-right: $padding;
            color: $gray-L1;
            cursor: pointer;
            position: relative;
            
            &.new {
                &:after {
                    content: '';
                    width: 6px;
                    height: 6px;
                    background: $brand-L2;
                    border: 1px solid $white;
                    box-sizing: border-box;
                    position: absolute;
                    top: 2px;
                    right: 2px;
                    border-radius: 100%;
                }
            }
            &.newNotif {
                color: $brand-L2;
                &:after {
                    content: '';
                    width: 6px;
                    height: 6px;
                    background: $brand-L2;
                    border: 1px solid $white;
                    box-sizing: border-box;
                    position: absolute;
                    top: 2px;
                    right: 2px;
                    border-radius: 100%;
                }
            }
        }
    }
}

</style>