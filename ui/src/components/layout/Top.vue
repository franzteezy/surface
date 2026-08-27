<template>
    <Wrapper full center>
        <Wrapper>
            <Row nm split centerv>
                <H5 bold>{{title}}</H5>
                <Row end nm>
                    <slot></slot>
                </Row>
            </Row>
        </Wrapper>
    </Wrapper>
</template>

<script>
export default {
    props: {
        title: {Type: String, default: ''},
    },
    data() {
        return {
        }
    },
    computed: {
    },
    methods: {
    },
    created() {
    },
    mounted() {
    },
};
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.button{
    display: flex;
    padding: 0 24px;
    height: 40px;
    border-radius: $radius;
    background-color: $brand;
    width: fit-content;
    white-space: nowrap;
    align-items: center;
    transition: $transition;
    box-shadow: 0 1px 3px rgba(85, 66, 246, 0.3), 0 4px 8px rgba(85, 66, 246, 0.2);
    cursor: pointer;
    user-select: none;

    &:hover{
        background-color: $brand-D1;
        box-shadow: 0 1px 3px rgba(85, 66, 246, 0.7), 0 4px 8px rgba(85, 66, 246, 0.5);
    }

    &.loading{
        pointer-events: none;
    }

    &.small{
        height: 32px;
    }

    &.large{
        height: 48px;
    }

    &.xl{
        height: 48px;
        width: 100%;
        justify-content: center;
    }

    .loading{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        .dot{
            width: 8px;
            height: 8px;
            border-radius: 100%;
            background: $white;
            margin-right: $padding;

            animation-name: jump;
            transform-origin: 50% 50%;
            animation-duration: 1.5s;
            animation-iteration-count: infinite;
            animation-fill-mode: forwards;
            animation-timing-function: ease-in-out;
            animation-delay: 0.3s;

            @keyframes jump {
                0%   {transform: translate3d(0,0%,0) }
                25% {transform: translate3d(0,-70%,0) }
                40%  {transform: translate3d(0,0%,0) }
                100%  {transform: translate3d(0,0%,0) }
            }

            &:nth-child(2){
                animation-delay: 0.6s;
            }

            &:nth-child(3){
                animation-delay: 0.9s;
                margin-right: 0;
            }

        }
    }

    p{
        i{
            position: relative;
            top: 1px;
            margin-right: 8px;
        }
    }

    &.light{
        background-color: $brand-L5;
        box-shadow: none;

        &:hover{
            background-color: $brand-L4;
            box-shadow: none;
        }
    }

    &.white{
        background-color: $white;
        box-shadow: none;
        border: 1px solid $gray-L2;

        i{
            color: $gray-D1;
            transition: $transition;
        }

        &:hover{
            box-shadow: none;
            border: 1px solid $gray;

            i{
                color: $gray-D3;
            }
        }
    }
}

</style>
