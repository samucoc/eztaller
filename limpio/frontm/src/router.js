import Vue from 'vue'
import Router from 'vue-router'
import Layout from "./components/Layout";
import Habitabilidad from "./components/Habitabilidad";
import Mantenedores from "./components/Mantenedores";
import Login from "./components/Login";
import store from "./store";

//Admin
import AdminLayout from "./components/admin/Layout";
import AdminDashboard from "./components/admin/Dashboard";
import AdminUsuarios from "./components/admin/Usuarios";

Vue.use(Router);

const routes = [
    {
        path: '*',
        redirect: '/',
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/',
        component: Layout,
        redirect: '/mantenedores',
        name: 'main',
        hidden: true,
        children: [
            {
                path: 'mantenedores',
                component: Mantenedores,
                name: 'mantenedores'
            },
        ]
    },
    {
        path: '/admin',
        component: AdminLayout,
        redirect: '/admin/dashboard',
        name: 'admin',
        hidden: true,
        children: [
            {
                path: 'dashboard',
                component: AdminDashboard,
                name: 'adminDashboard'
            },
            {
                path: 'usuarios',
                component: AdminUsuarios,
                name: 'adminUsuarios'
            },
        ]
    },

];
let router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach(((to, from, next) => {
    if (!store.getters.isLoggedIn) {
        if (to.name === 'login') {
            next();
        } else {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        }
    } else {
        if (store.getters.isLoggedIn && to.name === 'login') {
            next({ name: 'main' })
        } else {
            if (from.name === 'dfamilia' && to.name === 'lfamilia') {
                to.params.from_diag_fam = 'true'
            }
            next();
        }
    }
}));

export default router;
