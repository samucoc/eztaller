import axios from 'axios'
import store from "../store";

const _this = axios.create({
    baseURL: process.env.VUE_APP_ROOT_API,
    timeout: 60000
});

_this.interceptors.request.use(
    config => {
        if (store.getters.isLoggedIn) {
            config.headers['Authorization'] = "Bearer " + store.getters.getToken;
        }
        store.dispatch('loading', true).finally();
        return config;
    }, error => {
        store.dispatch('loading', false).finally();
        return Promise.reject(error)
    }
);

_this.interceptors.response.use(
    response => {
        store.dispatch('loading', false).finally();
        return response;
    }, error => {
        store.dispatch('loading', false).finally();
        let { response } = error;
        if (response.status === 401) store.dispatch('logout').finally();
        return Promise.reject(error);
    });

export default _this