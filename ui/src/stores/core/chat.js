import {defineStore} from 'pinia'
import {actions} from "../defaults";

export const ChatStore = defineStore({
  id: 'chat',
  state: () => ({
    module: 'chat',
    url: '/mailer/chats',
    loading: false,
    single: {
        conversations: [],
        currentIndex: null
    },
    many: [],
    package: {
    }
  }),
//   getters: {
//     token_accepted: (state) => state.single && state.single.id !== null,
//   },
//   actions: {
//     get(id = null) {
//       return actions.get(this, id)
//     },
//     fetch(postData = null) {
//       return actions.fetch(this, postData)
//     },
//     put() {
//       return actions.put(this)
//     },
//   }
})
