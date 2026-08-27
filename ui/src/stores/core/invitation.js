import { defineStore } from 'pinia'
import {actions, sessionDomain} from "../defaults";

export const InvitationStore = defineStore({
  id: 'register',
  state: () => ({
    module: 'register',
    loading: false,
    single: {
      id: null,
      uuid: null,
      email: null,
    },
    many: [],
    package: {
      uuid: '',
    }
  }),
  getters: {
    token_accepted: (state) => state.single && state.single.id !== null,
  },
  actions: {
    get(id = null){return actions.get(this, id)},
    fetch(postData = null){return actions.fetch(this,postData)},
    put(){return actions.put(this)},
  }
})
