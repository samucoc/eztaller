import {authMixin} from "../mixins";

const AuthPlugin = {
    install(Vue, options) {
        Vue.mixin(authMixin);
    }
};

export default AuthPlugin