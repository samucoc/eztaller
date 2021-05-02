import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from './router'
import store from './store'
import AuthPlugin from "./plugins/auth";
import {splitComunas} from "./services/util";

require('./assets/css/styles.css');
Vue.use(AuthPlugin);
Vue.filter('split_comunas', splitComunas);

Vue.config.productionTip = false;

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app');
