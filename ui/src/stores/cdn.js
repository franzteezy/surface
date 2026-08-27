import { defineStore } from 'pinia'
import { actions, sessionDomain } from "./defaults";

const secure = () => {
  let url = window.location.href.split('://');
  return url[0] + '://';
};

export const tenant = () => {
  let url = window.location.href.split('://');
  let domain = url[1].split('/')[0];
  let parts = domain.split('.');
  return parts.shift();
};

export const CdnStore = defineStore({
  id: 'cdn',
  state: () => ({
    module: 'cdn',
    loading: false,
  }),
  getters: {},
  actions: {
    store: (file, key) => {
      window.mitt.emit('button_loading_trigger');
      let source = axios.CancelToken.source();
      let url = secure() + 'cdn.' + sessionDomain() + '/store.php';
      return new Promise(function (resolve, reject) {
        window.axios.post(url, {
          tenant: tenant(),
          tenant_key: key,
          file: file,
        }, { cancelToken: source.token }).then(res => {
          const data = res.data !== undefined ? res.data : {};
          if (data.success) {
            window.mitt.emit('remove_button_loading');
            resolve(data);
          } else {
            window.mitt.emit('remove_button_loading');
            reject();
          }
        }).catch(err => {
          if (err.response.status === 422) {
            window.notify(err.response.data.message, null, true, false, 0);
          }
          window.mitt.emit('remove_button_loading');
          reject(err);
        })
      })
    },
  }
})
