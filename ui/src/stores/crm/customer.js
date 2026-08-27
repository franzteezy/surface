import {defineStore} from 'pinia'
import {actions} from "../defaults";

export const CustomerStore = defineStore({
  id: 'customer',
  state: () => ({
    module: 'crm',
    url: '/customer',
    loading: false,
    single: {
      id: null,
      hash: null,
      name: null,
      imported_by: null,
      fields: {
        address: null,
        email: null,
        employees: null,
        identification: null,
        industry: null,
        phone: null,
        website: null,
        zip: null,
        country: null,
        city: null,
        image: null,
        location: null
      }
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
