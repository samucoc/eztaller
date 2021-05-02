<template>
  <section>
    <v-breadcrumbs :items="breadcrumbs">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <v-container fluid>
      <template>
        <v-card>
          <v-card-title class="pt-0">
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar..."></v-text-field>
            <v-btn
              v-if="sso_auth==true"
              class="ma-sm-3"
              color="success"
              small
              x-small
              dark
              title="Desactivar SSO"
              @click="sso_auth_dialog=true"
            >
              SSO Activo
              <v-icon dark right>mdi-checkbox-marked-circle</v-icon>
            </v-btn>
            <v-btn
              v-if="sso_auth==false"
              class="ma-sm-3"
              color="error"
              small
              x-small
              dark
              title="Activar SSO"
              @click="sso_auth_dialog=true"
            >
              SSO Inactivo
              <v-icon dark right>mdi-cancel</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
              v-if="hasPermission('adm.add.usuario')"
              fab
              dark
              x-small
              color="indigo"
              title="Nuevo usuario"
              @click="createUser()"
            >
              <v-icon dark>mdi-plus</v-icon>
            </v-btn>
          </v-card-title>
          <v-data-table :headers="headers" :items="users" :search="search" dense :loading="loading">
            <template v-slot:item.activo="{ item }">
              <v-icon v-if="item.activo" dark small color="green" title="Sí">mdi-check-circle</v-icon>
              <v-icon v-if="!item.activo" dark small color="error" title="No">mdi-minus-circle</v-icon>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                v-if="hasPermission('adm.edt.usuario')"
                @click="editUser(item)"
                small
                class="mr-2"
                title="Editar usuario"
              >mdi-pencil</v-icon>
              <v-icon
                v-if="hasPermission('adm.ver.usuario')"
                @click="showUser(item)"
                small
                class="mr-2"
                title="Ver usuario"
              >mdi-eye</v-icon>
            </template>
          </v-data-table>
        </v-card>
      </template>
    </v-container>
    <v-row justify="center">
      <v-dialog scrollable v-model="dialog">
        <v-form ref="form" v-model="form_validation" lazy-validation>
          <v-card>
            <v-toolbar flat>
              <v-toolbar-title>{{ dialogTitle }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon title="Cerrar" @click="dialog=false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar>
            <v-divider></v-divider>
            <v-tabs v-model="active_tab">
              <v-tab>Datos Básicos</v-tab>
              <v-tab
                :disabled="(edited_user.role_type=='' || edited_user.role_type=='nacional')"
              >Territorialidad</v-tab>
              <v-tab
                :disabled="(edited_user.role_type=='' || edited_user.role_type=='nacional' || edited_user.role_type=='regional')"
              >Convocatorias</v-tab>
            </v-tabs>
            <v-card-text class="mt-2 pa-0" style="height: 400px;">
              <v-tabs-items class="pa-0" v-model="active_tab">
                <v-tab-item class="py-0">
                  <v-card-text class="py-0">
                    <v-row class="py-0">
                      <v-col cols="12" md="4">
                        <v-text-field
                          v-model="edited_user.rut"
                          @keyup="getPersona"
                          :disabled="field_disabled"
                          label="RUT"
                          :error-messages="showUsuarioFormError('rut')"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="4">
                        <v-text-field
                          v-model="edited_user.nombre"
                          :disabled="field_disabled"
                          label="Nombre"
                          :error-messages="showUsuarioFormError('nombre')"
                          readonly
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="4">
                        <v-select
                          v-model="edited_user.role_id"
                          :items="roles"
                          :disabled="field_disabled"
                          @change="changeRole"
                          label="Perfil"
                          :error-messages="showUsuarioFormError('role_id')"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="4">
                        <v-text-field
                          v-model="edited_user.email"
                          :disabled="field_disabled"
                          label="Correo electrónico"
                          :error-messages="showUsuarioFormError('email')"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="4">
                        <v-text-field
                          v-model="edited_user.password"
                          :append-icon="show_password ? 'mdi-eye' : 'mdi-eye-off'"
                          :type="show_password ? 'text' : 'password'"
                          label="Contraseña"
                          counter
                          :disabled="field_disabled"
                          :error-messages="showUsuarioFormError('password')"
                          @click:append="show_password = !show_password"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row class="py-0">
                      <v-col cols="2">
                        <v-checkbox
                          :checked="edited_user.activo"
                          v-model="edited_user.activo"
                          :disabled="field_disabled"
                          label="Activo"
                          :error-messages="showUsuarioFormError('activo')"
                        ></v-checkbox>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-tab-item>
                <v-tab-item class="py-0">
                  <v-card-text class="py-0" style="min-height: 300px;">
                    <v-row>
                      <v-col cols="12">
                        <v-alert
                          v-if="!edited_user.role_id"
                          border="left"
                          colored-border
                          type="info"
                          elevation="2"
                          class="mt-4"
                        >Debe seleccionar el perfil para mostrar la opciones de territorialidad.</v-alert>
                      </v-col>
                    </v-row>
                    <div class="mt-2">
                      <!-- perfil nacional -->
                      <!-- show/edit user -->
                      <section v-if="(edited_user.role_type=='nacional')">
                        <h3 class="pb-4">Región</h3>
                        <template v-for="item in regiones" class="pa-0 ma-0">
                          <v-checkbox
                            class="pa-0 ma-0"
                            v-model="edited_user.territorialidad_id"
                            :label="item.name"
                            :value="item.id"
                            disabled
                          ></v-checkbox>
                        </template>
                      </section>
                      <!-- show/edit user -->
                      <!-- perfil nacional -->
                      <!-- perfil regional -->
                      <section v-if="edited_user.role_type=='regional'">
                        <h3 class="mb-4">Región</h3>
                        <!-- show user -->
                        <template v-if="field_disabled" v-for="item in regiones">
                          <p v-if="item.id==edited_user.territorialidad_id[0]">{{item.name}}</p>
                        </template>
                        <!-- show user -->
                        <!-- edit user -->
                        <v-radio-group
                          v-if="!field_disabled"
                          v-model="edited_user.territorialidad_id[0]"
                          @change="selectRegion"
                        >
                          <template v-for="item in regiones">
                            <v-radio :label="item.name" :value="item.id"></v-radio>
                          </template>
                        </v-radio-group>
                        <!-- edit user -->
                      </section>
                      <!-- perfil regional -->

                      <!-- perfil comunal -->
                      <section v-if="edited_user.role_type=='comunal'">
                        <h3 class="mb-4">Región / Comuna</h3>
                        <!-- show user -->
                        <!-- show user -->
                        <!-- edit user -->
                        <v-treeview
                          v-model="edited_user.territorialidad_id"
                          dense
                          hoverable
                          open-on-click
                          rounded
                          selectable
                          activatable
                          :items="comunas"
                          @input="selectComuna"
                        ></v-treeview>
                        <!-- edit user -->
                      </section>
                    </div>
                    <section>
                      <div class="red--text">{{ showUsuarioFormError('territorialidad_id') }}</div>
                    </section>
                    <!-- edit user -->
                    <!-- perfil comunal -->
                  </v-card-text>
                </v-tab-item>
                <v-tab-item class="py-0 mx-0">
                  <v-card-text class="py-0" style="min-height: 300px;">
                    <v-col
                      v-if="edited_user.territorialidad_id.length==0"
                      cols="12"
                      class="py-0 px-0"
                    >
                      <v-alert
                        border="left"
                        colored-border
                        type="info"
                        elevation="2"
                        class="mt-4"
                      >Debe seleccionar la territorialidad para mostrar la opciones de convocatorias.</v-alert>
                    </v-col>
                    <v-data-table
                      v-if="edited_user.territorialidad_id.length>0"
                      v-model="edited_user.convocatoria_id"
                      :headers="headers_convocatorias"
                      :items="convocatorias"
                      item-key="id"
                      class="elevation-1 mt-2"
                      dense
                      show-select
                      hide-default-footer
                      disable-pagination
                    ></v-data-table>
                    <section>
                      <div class="red--text">{{ showUsuarioFormError('convocatoria_id') }}</div>
                    </section>
                  </v-card-text>
                </v-tab-item>
              </v-tabs-items>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="hideDialog()">Cerrar</v-btn>
              <v-btn v-if="!field_disabled" color="blue darken-1" text @click="saveUser()">Guardar</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
    <v-dialog v-model="sso_auth_dialog" max-width="400">
      <v-card>
        <v-card-text class="text-center pt-5">
          <h3>
            ¿Está seguro que desea
            <strong>{{ (sso_auth) ? 'desactivar' : 'activar' }}</strong> el inicio de sesión a través del SSO?
          </h3>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn depressed class="btnPrimario" text @click="sso_auth_dialog=false">No</v-btn>
          <v-btn depressed class="btnPrimario" text @click="setSsoAuth(!sso_auth)">Sí</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import { getRoleOptionsFromApi } from "../../api/role";
import {
  getComunasFromApi,
  getRegionesFromApi,
  getUsersFromApi,
  storeUserFromApi,
  updateUserFromApi,
} from "../../api/usuario";
import { alpha, checkRut, email, required, rut } from "../../services/rules";
import { getPersonaByRut } from "../../api/webservices";
import { getConfigFromApi, setConfigFromApi } from "../../api/configuracion";
import { buscarFromApi } from "../../api/convocatoria";

export default {
  name: "Usuarios",
  created() {
    if (!this.hasPermission("adm.ver.usuario")) {
      this.$router.push("/");
    }
    this.resetEditedUser();
    this.getUsers();
    this.getRoleOptions();
    this.getRegionesOptions();
    this.getComunasOptions();
  },
  data() {
    return {
      profile: this.getUser(),
      breadcrumbs: [
        {
          text: "Home",
          disabled: false,
          href: "dashboard",
        },
        {
          text: "Usuarios",
          disabled: true,
          href: "usuarios",
        },
      ],
      dialog: false,
      field_disabled: false,
      edited_user_index: -1,
      edited_user: null,
      search: "",

      loading: true,
      headers: [
        { text: "", value: "actions", align: "right", sortable: false },
        { text: "Nombre", align: "start", value: "nombre" },
        { text: "RUT", value: "rut" },
        { text: "Correo electrónico", value: "email" },
        { text: "Perfil", value: "role" },
        { text: "Territorio", value: "territorios" },
        { text: "Activo", value: "activo", sortable: false },
      ],
      headers_convocatorias: [
        { text: "Año de convocatoria", align: "start", value: "anio" },
        { text: "Región", value: "region" },
        { text: "Comuna(s)", value: "comuna" },
        { text: "Estado convocatoria", value: "estado_convocatoria" },
        // { text: "", value: "actions", align: "right", sortable: false },
      ],
      convocatorias: [],
      form_validation: false,
      rut_rules: [required, rut],
      nombre_rules: [
        required,
        alpha,
        (v) => v.length > 5 || "El campo debe tener al menos 5 caracteres",
        (v) => v.length < 50 || "El campo debe tener menos de 50 caracteres",
      ],
      email_rules: [
        required,
        email,
        (v) => v.length > 5 || "El campo debe tener al menos 5 character",
        (v) => v.length < 50 || "El campo debe tener menos de 50 characters",
      ],
      role_rules: [required],
      users: [],
      roles: [],
      territorialidad: [],

      regiones: [],
      comunas: [],
      comunas_selected: [],
      // territorialidad_items_disabled: false,
      active_tab: 0,

      // Activar / Desactivar SSO
      sso_auth_dialog: false,
      sso_auth: null,

      usuario_form_errors: [],
      show_password: false,
    };
  },
  mounted() {},
  methods: {
    createUser() {
      this.field_disabled = false;
      this.resetEditedUser();
      this.showDialog();
    },
    editUser(item) {
      // this.getConvocatorias
      this.field_disabled = false;
      this.edited_user_index = this.users.indexOf(item);
      this.edited_user = Object.assign({}, item);
      switch (this.edited_user.role_type) {
        case "nacional":
        case "regional":
          this.buscarConvocatorias({
            region_id: this.edited_user.territorialidad_id,
          });
          break;
        case "comunal":
          this.buscarConvocatorias({
            comuna_id: this.edited_user.territorialidad_id,
          });
          break;
      }
      this.showDialog();
    },
    showUser(item) {
      this.field_disabled = true;
      this.edited_user_index = this.users.indexOf(item);
      this.edited_user = Object.assign({}, item);
      this.showDialog();
    },
    showDialog() {
      this.active_tab = 0;
      this.show_password = false;
      this.dialog = true;
    },
    hideDialog() {
      this.resetValidation();
      this.usuario_form_errors = [];
      this.dialog = false;
    },
    storeUser(user) {
      storeUserFromApi(user)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getUsers();
              this.hideDialog();
              this.showMessage(
                "Los datos del usuario han sido guardados con éxito.",
                "success"
              );
            } else {
              this.usuario_form_errors = response.data.errors;
            }
          } else {
            console.error(response);
            this.showMessage(response.data.message, "warning");
          }
        })
        .catch((err) => {
          console.error(err);
          this.showMessage(
            "Error al intentar guardar la información.",
            "error"
          );
        });
    },
    updateUser(user) {
      updateUserFromApi(user)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getUsers();
              this.hideDialog();
            } else {
              this.usuario_form_errors = response.data.errors;
            }
          } else {
            console.error(response);
            this.showMessage(response.data.message, "warning");
          }
        })
        .catch((err) => {
          console.error(err);
          this.showMessage(
            "Error al intentar guardar la información.",
            "error"
          );
        });
    },
    saveUser() {
      if (this.edited_user_index < 0) {
        this.storeUser(this.edited_user);
      } else {
        this.updateUser(this.edited_user);
      }
    },
    resetEditedUser() {
      this.edited_user_index = -1;
      this.edited_user = {
        id: "",
        nombre: "",
        rut: "",
        email: "",
        role: "",
        role_id: "",
        role_type: "",
        role_hierarchy: "",
        activo: true,
        territorios: "",
        territorialidad_id: [],
        convocatoria_id: [],
      };
      this.active_tab = 0;
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    getRoleOptions() {
      let data = {
        role_type: this.getUser().roles[0].type,
      };
      getRoleOptionsFromApi(data)
        .then((response) => {
          try {
            if (response.data.type == "success") {
              this.roles = response.data.data;
            } else {
              console.error(response.data);
            }
          } catch (error) {
            console.error(error);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    getRegionesOptions() {
      let data = {
        user_id: this.getUser().id,
        role_type: this.getUser().roles[0].type,
      };
      getRegionesFromApi(data)
        .then((response) => {
          try {
            if (response.data.type == "success") {
              this.regiones = response.data.data;
            } else {
              console.error(response.data);
            }
          } catch (error) {
            console.error(error);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    getComunasOptions() {
      let data = {
        user_id: this.getUser().id,
        role_type: this.getUser().roles[0].type,
      };
      getComunasFromApi(data)
        .then((response) => {
          try {
            if (response.data.type == "success") {
              this.comunas = response.data.data;
              this.comunas_selected = response.data.data;
            } else {
              console.error(response.data);
            }
          } catch (error) {
            console.error(error);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    getUsers() {
      let data = {
        user_id: this.getUser().id,
        role_type: this.getUser().roles[0].type,
      };
      getUsersFromApi(data)
        .then((response) => {
          try {
            if (response.data.type == "success") {
              this.users = response.data.data;
              this.getSsoAuth();
            } else {
              console.error(response.data);
            }
          } catch (error) {
            console.error(error);
          }
          this.loading = false;
        })
        .catch((err) => {
          console.error(err);
          this.loading = false;
        });
    },
    getSsoAuth() {
      getConfigFromApi("SSO_AUTH")
        .then((response) => {
          try {
            if (
              response.data.type == "success" &&
              response.data.data !== null
            ) {
              this.sso_auth = response.data.data.valor == "1" ? true : false;
              console.error(this.sso_auth);
            } else {
              this.showMessage(
                "Ha ocurrido un error inesperado al intentar realizar la acción.",
                "warning"
              );
              console.error(response.data);
            }
          } catch (error) {
            this.showMessage(
              "Ha ocurrido un error inesperado al intentar realizar la acción.",
              "warning"
            );
            console.error(error);
          }
          this.loading = false;
        })
        .catch((err) => {
          this.showMessage(
            "Ha ocurrido un error inesperado al intentar realizar la acción.",
            "warning"
          );
          console.error(err);
          this.loading = false;
        });
    },
    setSsoAuth(valor) {
      setConfigFromApi("SSO_AUTH", valor)
        .then((response) => {
          try {
            if (
              response.data.type == "success" &&
              response.data.data !== null
            ) {
              this.sso_auth = response.data.data.valor == "1" ? true : false;
              this.sso_auth_dialog = false;
            } else {
              this.showMessage(
                "Ha ocurrido un error inesperado al intentar realizar la acción.",
                "warning"
              );
              console.error(response.data);
            }
          } catch (error) {
            this.showMessage(
              "Ha ocurrido un error inesperado al intentar realizar la acción.",
              "warning"
            );
            console.error(error);
          }
          this.loading = false;
        })
        .catch((err) => {
          this.showMessage(
            "Ha ocurrido un error inesperado al intentar realizar la acción.",
            "warning"
          );
          console.error(err);
          this.loading = false;
        });
    },

    getPersona(event) {
      let rut = this.edited_user.rut;
      if (checkRut(rut)) {
        getPersonaByRut(rut).then((response) => {
          this.edited_user.nombre = response.data.nombre;
        });
      }
    },
    changeRole() {
      let selected = null;
      for (let i = 0; i < this.roles.length; i++) {
        if (this.roles[i].value == this.edited_user.role_id) {
          selected = this.roles[i];
          this.edited_user.role = selected.name;
          this.edited_user.role_type = selected.type;
          this.edited_user.role_hierarchy = selected.hierarchy;
          i = this.roles.length;
        }
      }

      if (this.edited_user.role_type == "nacional") {
        this.edited_user.territorialidad_id = [];
        for (let i = 0; i < this.regiones.length; i++) {
          this.edited_user.territorialidad_id.push(this.regiones[i].id);
        }
        this.buscarConvocatorias({
          region_id: this.edited_user.territorialidad_id,
        });
      } else {
        this.edited_user.territorialidad_id = [];
        this.buscarConvocatorias({});
      }
    },
    showUsuarioFormError(field) {
      try {
        if (
          typeof this.usuario_form_errors[field] !== "undefined" ||
          this.usuario_form_errors[field] !== "" ||
          this.usuario_form_errors[field] !== null
        ) {
          return this.usuario_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },
    buscarConvocatorias(params) {
      buscarFromApi(params)
        .then((response) => {
          this.convocatorias = [];
          if (Object.keys(params).length == 0) {
            this.edited_user.convocatoria_id = [];
          }
          try {
            if (response.data.type == "success") {
              this.convocatorias = response.data.data;
              if (
                this.edited_user_index === -1 &&
                this.edited_user.convocatoria_id.length === 0
              ) {
                this.edited_user.convocatoria_id = this.convocatorias;
              }
            } else {
              console.error(response.data);
            }
          } catch (error) {
            console.error(error);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    selectRegion(item) {
      this.buscarConvocatorias({ region_id: [item] });
    },
    selectComuna(item) {
      this.buscarConvocatorias({ comuna_id: item });
    },
  },
  computed: {
    dialogTitle() {
      if (this.field_disabled === true) {
        return "Información del usuario";
      } else {
        return this.edited_user_index === -1
          ? "Nuevo usuario"
          : "Editar usuario";
      }
    },
  },
};
</script>

<style scoped>
</style>