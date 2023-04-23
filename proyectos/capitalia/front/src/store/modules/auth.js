import {login, me} from '../../api/auth'

let userData = localStorage.getItem('user') || '{}';
const auth = {
    state: {
        token: localStorage.getItem('token') || '',
        user: JSON.parse(userData),
        loading: false,
        list_data: null
    },
    mutations: {
        set_token(state, token) {
            localStorage.setItem("token", token);
            state.token = token;
        },
        set_user(state, user) {
            state.user = user;
            localStorage.setItem("user", JSON.stringify(user));
        },
        logout(state) {
            state.token = '';
            state.user = {};
        },
        set_loading(state, loading) {
            state.loading = loading;
        },
        set_list_data(state, data) {
            state.list_data = data;
        }
    },
    actions: {
        login: ({commit}, user) => {
            return new Promise((resolve, reject) => {
                login(user)
                    .then(response => {
                        let {user, token} = response.data;
                        commit('set_token', token);
                        commit('set_user', user);
                        resolve(response);
                    })
                    .catch(err => {
                        localStorage.removeItem('token');
                        localStorage.removeItem('user');
                        reject(err);
                    });
            });
        },
        me: ({commit}) => {
            return new Promise((resolve, reject) => {
                me()
                    .then(response => {
                        let user = response.data;
                        commit('set_user', user);
                        resolve(response);
                    })
                    .catch(err => {
                        reject(err);
                    });
            })
        },
        logout: ({commit}) => {
            return new Promise((resolve) => {
                commit('logout');
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                resolve()
            });
        },
        loading: ({commit}, loading) => {
            return new Promise(resolve => {
                commit('set_loading', loading);
                resolve();
            });
        },
        list_data: ({commit}, data) => {
            return new Promise(resolve => {
                commit('set_list_data', data);
                resolve();
            })
        }

    }
};
export default auth;