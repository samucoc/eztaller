import Vue from 'vue'
import Router from 'vue-router'
import Layout from "./components/Layout";
import View from "./components/View";
import Mantenedores from "./components/Mantenedores";
import Gestion from "./components/Gestion";
import Estadisticas from "./components/Estadisticas";
import Reportes from "./components/Reportes";
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
        redirect: 'view/tab/operativa',
        name: 'main',
        hidden: true,
        children: [
            {
                path: 'view/tab',
                name: 'tab',
                component: View,
                redirect: 'view/tab/operativa',
                hidden: true,
                children: [
                    {
                        path: 'operativa',
                        component: Mantenedores,
                        name: 'operativa'
                    },
                    {
                        path: 'gestion',
                        component: Gestion,
                        name: 'gestion'
                    },
                    {
                        path: 'estadisticas',
                        component: Estadisticas,
                        name: 'estadisticas'
                    },
                    {
                        path: 'reportes',
                        component: Reportes,
                        name: 'reportes'
                    },
                ]
            },
        ]
    },
    // {
    //     path: '/',
    //     component: Layout,
    //     redirect: '/habitabilidad',
    //     name: 'main',
    //     hidden: true,
    //     children: [
    //         {
    //             path: 'habitabilidad',
    //             component: Habitabilidad,
    //             redirect: 'habitabilidad/convocatoria',
    //             name: 'habitabilidad',
    //             hidden: true,
    //             children: [
    //                 {
    //                     path: 'convocatoria',
    //                     component: Convocatoria,
    //                     name: 'convocatoria'
    //                 },
    //                 {
    //                     path: 'dfamilia/:id',
    //                     component: DiagnosticoFamilia,
    //                     name: 'dfamilia'
    //                 },
    //                 {
    //                     path: 'lfamilia',
    //                     component: ListadoFamilia,
    //                     name: 'lfamilia'
    //                 },
    //                 {
    //                     path: 'rfamilia',
    //                     component: RegistroFamilia,
    //                     name: 'rfamilia'
    //                 },
    //                 {
    //                     path: 'pfamilia',
    //                     component: PropuestaFamilia,
    //                     name: 'pfamilia'
    //                 },
    //                 {
    //                     path: 'resumenc',
    //                     component: ResumenFamilia,
    //                     name: 'resumenc'
    //                 },
    //                 {
    //                     path: 'resumen_diag/:id',
    //                     component: ResumenDiagnostico,
    //                     name: 'resumen_diag'
    //                 },
    //                 {
    //                     path: 'propuesta-familias',
    //                     component: PropuestaFamilias,
    //                     name: 'propuesta_familias'
    //                 },
    //                 {
    //                     path: 'proceso-compra-adquisicion',
    //                     component: ProcesoAdquisicion,
    //                     name: 'proceso_compra_adquisicion'
    //                 },
    //                 {
    //                     path: 'propuesta-pic/:id',
    //                     component: PropuestaPic,
    //                     name: 'propuesta_pic'
    //                 },
    //                 {
    //                     path: 'propuesta-mod-pic/:id',
    //                     component: PropuestaModPic,
    //                     name: 'propuesta_mod_pic'
    //                 },
    //                 {
    //                     path: 'asesorias-grupales-pic/:id',
    //                     component: AsesoriasGrupalesPic,
    //                     name: 'asesorias_grupales_pic'
    //                 },
    //                 {
    //                     path: 'asesorias-grupales-mod-pic/:id',
    //                     component: AsesoriasGrupalesModPic,
    //                     name: 'asesorias_grupales_mod_pic'
    //                 },
    //                 {
    //                     path: 'ejecucion-propuestas',
    //                     component: EjecucionPropuestas,
    //                     name: 'ejecucion_propuestas'
    //                 },
    //                 {
    //                     path: 'ejecucion-propuesta/:id',
    //                     component: EjecucionPropuesta,
    //                     name: 'ejecucion_propuesta'
    //                 },
    //                 {
    //                     path: 'ejecucion-propuesta-grupales/:id',
    //                     component: EjecucionPropuestaGrupales,
    //                     name: 'ejecucion_propuesta_grupales'
    //                 },
    //                 {
    //                     path: 'resumen-propuesta-comunal',
    //                     component: ResumenPropuestaComunal,
    //                     name: 'resumen_propuesta_comunal'
    //                 },

    //             ]
    //         }
    //     ]
    // },
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
