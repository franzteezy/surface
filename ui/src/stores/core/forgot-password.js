import { defineStore } from 'pinia'
import {actions, sessionDomain} from "../defaults";

export const ForgotPasswordStore = defineStore({
  id: 'forgot-password',
  state: () => ({
    module: 'forgot-password',
    loading: false,
    single: {
      email: null,
      token: null,
      new_password: null,
      new_password_repeat: null,
    },
    many: [],
    package: {
      email: null,
      token: null,
      new_password: null,
      new_password_repeat: null,
    }
  }),
  getters: {
  },
  actions: {
    get(id = null){return actions.get(this, id)},
    fetch(postData = null){return actions.fetch(this,postData)},
    put(){return actions.put(this)},
  }
})
