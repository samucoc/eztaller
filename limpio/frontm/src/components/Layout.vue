<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" clipped app>
      <v-list dense>
        <v-list-item
          :title="item.text"
          v-for="item in items"
          v-show="item.show"
          :key="item.text"
          :to="{name: item.to}"
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar clipped-left app dense class="backWhite">

      <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="mt-3"></v-app-bar-nav-icon>
      <v-toolbar-title class="tituloPrincipal fontSizetitulo text-uppercase position-tittle">
        <span class="font-weight-ligh">Capitalia - prototipo</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <section class="mt-3">
        <v-menu offset-y min-width="200px">
          <template v-slot:activator="{ on }">
            <v-btn text v-on="on">
              <span class="mr-3">{{ user['nombre'] }}</span>
              <v-icon>mdi-account</v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-clipboard-account-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title v-for="item in usuario.roles">{{ item }}</v-list-item-title>
            </v-list-item>
            <v-list-item @click="showPerfilDialog">
              <v-list-item-icon>
                <v-icon>mdi-account-card-details-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Mi Perfil</v-list-item-title>
            </v-list-item>
            <v-list-item @click="logout()">
              <v-list-item-icon>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Salir</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </section>
      <br />
    </v-app-bar>
    <v-main class="ma-3">
      <v-snackbar
        class="no-shadow"
        v-model="snackbarShow"
        :color="snackbarType"
        :timeout="snackbarTimeout"
        value="true"
      >
        <v-icon class="mr-3">{{snackbarIcon}}</v-icon>
        <div>{{snackbarText}}</div>
        <v-btn text icon color="white" @click="snackbarShow = false">
          <v-icon color="white">mdi-close-circle</v-icon>
        </v-btn>
      </v-snackbar>
      <v-dialog v-model="perfil_dialog" width="60%">
        <v-card height="450px">
          <v-toolbar flat color="primary" dark>
            <v-toolbar-title>Mi Perfil</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon dark @click="closePerfilDialog">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar>
          <v-tabs v-model="perfil_active_tab">
            <v-tab class="text-left">
              <v-icon left>mdi-account</v-icon>Datos Básicos
            </v-tab>
            <v-tab class="text-left">
              <v-icon left>mdi-lock</v-icon>Cambiar contraseña
            </v-tab>
          </v-tabs>
          <v-card-text class="mt-2 pa-0">
            <v-tabs-items class="pa-0" v-model="perfil_active_tab">
              <v-tab-item>
                <v-card-text>
                  <v-text-field class="mb-1" v-model="usuario.nombre" label="Nombre" disabled></v-text-field>
                  <v-text-field class="mb-1" v-model="usuario.rut" label="RUT" disabled></v-text-field>
                  <v-text-field
                    class="mb-1"
                    v-model="usuario.email"
                    label="Correo electrónico"
                    disabled
                  ></v-text-field>
                  <v-text-field class="mb-1" v-model="usuario.rol" label="Perfil" disabled></v-text-field>
                </v-card-text>
              </v-tab-item>
              <v-tab-item>
                <v-card-text>
                  <v-text-field
                    class="mb-1"
                    v-model="password_actual"
                    :append-icon="password_actual_show ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="password_actual_show ? 'text' : 'password'"
                    label="Contraseña actual"
                    counter
                    @click:append="password_actual_show = !password_actual_show"
                    :error-messages="showPasswordFormError('password_actual')"
                  ></v-text-field>
                  <v-text-field
                    class="mb-5"
                    v-model="password_nuevo"
                    :append-icon="password_nuevo_show ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="password_nuevo_show ? 'text' : 'password'"
                    label="Contraseña nueva"
                    counter
                    @click:append="password_nuevo_show = !password_nuevo_show"
                    :error-messages="showPasswordFormError('password_nuevo')"
                  ></v-text-field>
                  <v-btn class="mb-4" color="primary" @click="changePassword()">Guardar</v-btn>
                </v-card-text>
              </v-tab-item>
            </v-tabs-items>
          </v-card-text>
        </v-card>
      </v-dialog>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { changePasswordFromApi } from "../api/usuario";

export default {
  name: "Layout",
  data() {
    return {
      drawer: false,
      items: [
        {
          icon: "mdi-home-city",
          text: "Capitalia",
          to: "tab",
          show: true,
        },
        {
          icon: "mdi-account-multiple",
          text: "Usuarios",
          to: "adminUsuarios",
          show: this.hasPermission("adm.ver.usuario"),
        },
      ],
      usuario: {
        nombre: null,
        email: null,
        profesion: null,
        rut: null,
        rol: null,
        roles: [],
        estados_conv: [],
      },
      snackbarShow: false,
      snackbarIcon: "",
      snackbarType: "",
      snackbarText: "",
      snackbarTimeout: 12000,

      // Perfil
      perfil_active_tab: 0,
      perfil_dialog: false,

      password_form_errors: [],
      password_actual: null,
      password_actual_show: false,
      password_nuevo: null,
      password_nuevo_show: false,
    };
  },
  mounted() {
    const user = this.getUser();
    this.usuario.id = user.id;
    this.usuario.nombre = user.nombre;
    this.usuario.email = user.email;
    this.usuario.profesion = user.profesion;
    this.usuario.rut = user.rut;
    this.usuario.estados_conv = user.estados_conv;
    for (const rol of user.roles) {
      this.usuario.roles.push(rol.description);
    }
    this.usuario.rol = this.usuario.roles.join(", ");
    this.$root.$on("showSnackbarMessage", (text, type) => {
      this.showSnackbarMessage(text, type);
    });
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$store
        .dispatch("logout", {})
        .then(() => this.$router.push("/login"))
        .catch((err) => console.error(err));
    },
    showSnackbarMessage(text, type) {
      this.snackbarType = type;
      this.snackbarText = text;
      this.snackbarShow = true;
      let icon = "mdi-information";
      switch (type) {
        case "info":
          icon = "mdi-information";
          break;
        case "error":
          icon = "mdi-alert";
          break;
        case "success":
          icon = "mdi-check-circle";
          break;
        case "warning":
          icon = "mdi-exclamation";
          break;
      }
      this.snackbarIcon = icon;
    },

    // Perfil
    showPerfilDialog() {
      this.perfil_active_tab = 0;
      this.perfil_dialog = true;
    },
    closePerfilDialog() {
      this.perfil_active_tab = 0;
      this.perfil_dialog = false;
    },
    changePassword() {
      changePasswordFromApi(
        this.usuario.id,
        this.password_actual,
        this.password_nuevo
      )
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.password_form_errors = [];
              this.password_actual = null;
              this.password_nuevo = null;
              this.showSnackbarMessage(
                response.data.message,
                response.data.type
              );
            } else {
              this.password_form_errors = response.data.errors;
              console.error(this.password_form_errors);
            }
          } else {
            console.error(response);
            this.showSnackbarMessage(response.data.message, "warning");
          }

          // this.password_actual = null;
          // this.password_nuevo = null;
          // this.showSnackbarMessage(response.data.message, response.data.type);
        })
        .catch((err) => {
          console.error(err);
          this.showSnackbarMessage(
            "Error al intentar guardar la información.",
            "error"
          );
        });
    },
    showPasswordFormError(field) {
      try {
        if (
          typeof this.password_form_errors[field] !== "undefined" ||
          this.password_form_errors[field] !== "" ||
          this.password_form_errors[field] !== null
        ) {
          return this.password_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },
  },
};
</script>

<style scoped>
.position-tittle {
  top: 8px;
  position: inherit;
}
</style>