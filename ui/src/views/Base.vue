<template>
  <main :class="{dev:dev!==null}">
      <Menu/>
      <Wrapper full center>
          <slot></slot>
      <ChatSocket v-if="!userSocket.socket"></ChatSocket>
      <ChatBubble></ChatBubble>
      </Wrapper>
  </main>
</template>

<script>
export default {
    props: {
        dev: {Type: Boolean, default: null},
    },
    computed:{
        userSocket(){
            return window.store.auth;
        }
    },
    data(){
        return{
        }
    },
    created() {
    },
    mounted() {
        window.store.auth.get().then(() => {
            window.mitt.emit('page_loaded');
        }).catch(() => {
            window.notify('Session expired - please login');
            this.$router.push('/login');
        })
    }
}
</script>

<style lang="scss">
main{
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100vh;

    &.dev{
        .wrapper{
            background-color: darkblue;
            min-height: 20px;
        }

        .row{
            background-color: lightblue;
            min-height: 20px;
        }

        .col{
            background-color: lightsalmon;
            min-height: 20px;
        }
    }
}
</style>