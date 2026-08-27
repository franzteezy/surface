import { defineStore } from 'pinia'
import { actions, sessionDomain } from "../defaults";

export const AuthorizeStore = defineStore({
  id: 'authorize',
  state: () => ({
    module: 'authorize',
    loading: false,
    single: {
      id: null,
      email: null,
      first_name: null,
      last_name: null,
      created_at: null,
      updated_at: null,
      email_verified_at: null,
      password: null,
      password_repeat: null,
      registration_token: null,
      image: null,
      image_uuid: null,
      cc: null,
      phone: null,
      phone_verification: null,
      token: null,
    },
    socket: null,
    socketNotif: false,
    chatBubble: true,
    many: [],
    package: {
      email: '',
      password: ''
    }
  }),
  getters: {
    authorized: (state) => state.single.id !== null,
  },
  actions: {
    get(id = null) { return actions.get(this, id) },
    fetch(postData = null) { return actions.fetch(this, postData) },
    put() { return actions.put(this) },
    forgot_password() { return actions.put(this, '/forgot-password') },
    reset_password() { return actions.put(this, '/reset-password') },
  }
})
