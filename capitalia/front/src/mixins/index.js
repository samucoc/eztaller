import { regiones } from "../api/region";

export const authMixin = {
    data() {
        return {
            regiones: [],
            tableFooterProps: {
                itemsPerPageText: "Resultados por página:",
                itemsPerPageOptions: [10, 20, 30, 40],
                pageText: '{0}-{1} de {2}',
            }
        };
    },
    computed: {
        user() {
            return this.$store.getters.getUser || {};
        }
    },
    methods: {
        getUser() {
            return this.$store.getters.getUser;
        },
        hasRole(...roles) {
            let userRoles = this.getRoles().map(role => role.name);
            if (Array.isArray(roles)) {
                for (let role of roles) {
                    if (userRoles.indexOf(role) !== -1) {
                        return true;
                    }
                }
            } else if (typeof roles == "string" && userRoles.indexOf(roles) !== -1) {
                return true;
            }
            return false;
        },
        getRoles() {
            let user = this.getUser();
            return user && user['roles'] ? user['roles'] : [];
        },
        hasPermission(...permissions) {
            let allPermissions = this.getPermissions();
            if (Array.isArray(permissions)) {
                for (let permission of permissions) {
                    if (allPermissions.indexOf(permission) !== -1) {
                        return true;
                    }
                }
            } else if (typeof permissions == "string" && allPermissions.indexOf(permissions) !== -1) {
                return true;
            }
            return false;
        },
        getPermissions() {
            let user = this.getUser();
            return user && user['all_permissions'] ? user['all_permissions'] : [];
        },
        getErrorResponse(reason) {
            let { data } = reason.response;
            if (data.hasOwnProperty("error")) {
                return data['error'];
            }
            if (data.hasOwnProperty("errors")) {
                let { errors } = data;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        let error = errors[key];
                        return Array.isArray(error) && error.length > 0 ? error[0] : error;
                    }
                }
            }
            return "Ha ocurrido un error, intente de nuevo.";
        },
        showMessage(text, type) {
            this.$root.$emit('showSnackbarMessage', text, type);
        },
        getRegiones() {
            regiones()
                .then(response => {
                    this.regiones = response.data;
                    this.regiones.unshift({ nom_reg: "Seleccione una región", cod_reg: null });
                })
                .catch(reason => console.error(reason))
        },
        getBitEstado(constante) {
            let user = this.getUser();
            return user.bit_estados[constante];
        },
        getBitEstados() {
            let user = this.getUser();
            return user.bit_estados;
        }
    }
};