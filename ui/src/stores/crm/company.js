import {defineStore} from 'pinia'
import {actions} from "../defaults";

export const CompanyStore = defineStore({
  id: 'company',
  state: () => ({
    module: 'crm',
    url: '/company',
    loading: false,
    single: {
      address: null,
      email: null,
      employees: null,
      identification: null,
      industry: null,
      name: null,
      phone: null,
      website: null,
      zip: null,
      country: null,
      city: null,
      image: null,
      reference: null,
      source_image: null,
      source_name: null,
    },
    many: [],
    package: {
      name: null,
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
