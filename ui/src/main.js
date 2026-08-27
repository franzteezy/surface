import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue'
import router from './router'
import axios from "axios";
import * as _ from "lodash";
import { sessionDomain } from "./stores/defaults";
import RegisterStores from "./stores";
import RegisterComponents from "./components";
import mitt from "mitt";
import vClickOutside from "click-outside-vue3"
import VueCookies from 'vue-cookies';
import moment from 'moment';

window.mitt = window.mitt || new mitt(); //setup mitt project-wide
window._ = _;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.baseURL = "https://" + sessionDomain;

window.running_processes = {};

window.makeid = function (length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}
const app = createApp(App)
app.use(createPinia())
app.use(vClickOutside)
app.use(router)
app.use(VueCookies)
app.use(moment);
RegisterComponents(app);
RegisterStores();
app.mount('#app');