import {defineStore} from 'pinia'
import {actions} from "../defaults";

export const LocationStore = defineStore({
  id: 'location',
  state: () => ({
    module: 'location',
    loading: false,
    single: {
      id: null,
    },
    many: [],
    package: {
      name: ''
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
