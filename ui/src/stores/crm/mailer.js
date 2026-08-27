import {defineStore} from 'pinia'
import {actions} from "../defaults";

export const MailerStore = defineStore({
  id: 'mailer',
  state: () => ({
    module: 'mailer',
    url: '/mailer',
    loading: false,
    single: {
      id: null,
      hash: null,
      email_to: null,
      email_from: null,
      subject: null,
      content: null,
      uploadedFiles: [],
      uploadedImages: [],
      send_at: null,
      opened_at: null,
      delivered_at: null,
      created_at: null,
      updated_at: null
    },
    many: [],
    package: {
      fields: {
        name: null,
      }
    }
  }),
  getters: {
    token_accepted: (state) => state.single && state.single.id !== null,
  },
  actions: {
    get(id = null) {
      return actions.get(this, id)
    },
    fetch(postData = null) {
      return actions.fetch(this, postData)
    },
    put() {
      return actions.put(this)
    },
  }
})
