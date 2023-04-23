<template>
  <section>
    <v-container fluid ref="mantenedores">
      <v-row class="pro-fam">
        <v-col cols="12" md="12">
          <v-expansion-panels multiple accordion>
            <v-expansion-panel>
              <v-expansion-panel-header>
                <div>
                  <v-badge
                    inline
                    color="blue"
                    :value="10"
                    :content="10"
                    
                  >Inversionistas</v-badge>
                </div>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <div class="text-right">
                  <v-btn
                    medium
                    @click="openInversionistaDialog()"
                    >Agregar Inversionista</v-btn>
                </div>
                <br />
                <v-simple-table>
                  <thead>
                    <tr class="blue lighten-4">
                      <th>
                        
                      </th>
                      <th>Nombre Completo</th>
                      <th>Rut</th>
                      <th>Email</th>
                      <th>Telefono de contacto</th>

                    </tr>
                  </thead>
                  <tbody>
                    <template >
                      <tr>
                        <td>
                          <v-btn
                            text
                            small
                            icon
                            title="Editar Inversionista"
                            @click="openInversionistaDialog()"

                          >
                            <v-icon>mdi-file-document-edit-outline</v-icon>
                          </v-btn>
                          <v-btn
                            text
                            small
                            icon
                            title="Agregar inversión"
                            @click="openInversionDialog()"
                          >
                            <v-icon>mdi-comment-edit-outline</v-icon>
                          </v-btn>
                          <v-btn text small icon @click="toggleDetalleInversionista()">
                            <v-icon
                              title="Mostrar detalles"
                              v-show="!detalle_inversionista"
                            >mdi-plus-box-outline</v-icon>
                            <v-icon
                              title="Ocultar detalles"
                              v-show="detalle_inversionista"
                            >mdi-minus-box-outline</v-icon>
                          </v-btn>
                        </td>
                        <td>Franco Andres</td>
                        <td>12345678-9</td>
                        <td>fanres@gmail.com</td>
                        <td>+56 9 8765 1234</td>
                      </tr>
                      <tr v-show="detalle_inversionista" >
                        <td colspan="20">
                          <div class="row">
                            <div class="col-sm-2 text-right" title="Descripción">
                              <v-btn
                                text
                                small
                                icon
                                title="Editar Inversión"
                                @click="openInversionDialog()"
                              >
                                <v-icon>mdi-comment-edit-outline</v-icon>
                              </v-btn>
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$CLP
                              <br />
                              10.000
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$US
                              <br />
                              100.000
                            </div>
                            <div class="col-sm-2">
                              Fecha y hora
                              <br />
                              <br />
                              10-10-2021 10:00
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2 text-right" title="Descripción">
                              <v-btn
                                text
                                small
                                icon
                                title="Editar Inversión"
                                @click="openInversionDialog()"
                              >
                                <v-icon>mdi-comment-edit-outline</v-icon>
                              </v-btn>
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$CLP
                              <br />
                              20.000
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$US
                              <br />
                              200.000
                            </div>
                            <div class="col-sm-2">
                              Fecha y hora
                              <br />
                              <br />
                              12-10-2021 10:00
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2 text-right" title="Descripción">
                              <v-btn
                                text
                                small
                                icon
                                title="Editar Inversión"
                                @click="openInversionDialog()"
                              >
                                <v-icon>mdi-comment-edit-outline</v-icon>
                              </v-btn>
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$CLP
                              <br />
                              30.000
                            </div>
                            <div class="col-sm-2">
                              Inversión
                              <br />$US
                              <br />
                              300.000
                            </div>
                            <div class="col-sm-2">
                              Fecha y hora
                              <br />
                              <br />
                              13-10-2021 10:00
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <v-btn
                            text
                            small
                            icon
                            title="Editar Inversionista"
                            @click="openInversionistaDialog()"

                          >
                            <v-icon>mdi-file-document-edit-outline</v-icon>
                          </v-btn>
                          <v-btn
                            text
                            small
                            icon
                            title="Agregar inversión"
                            @click="openInversionDialog()"
                          >
                            <v-icon>mdi-comment-edit-outline</v-icon>
                          </v-btn>
                          <v-btn text small icon >
                            <v-icon
                              title="Mostrar detalles"
                              
                            >mdi-plus-box-outline</v-icon>
<!--                             <v-icon
                              title="Ocultar detalles"
                              v-show="soluciones[index].detalle_visible"
                            >mdi-minus-box-outline</v-icon> -->
                          </v-btn>        
                        </td>
                        <td>Natalie Paola</td>
                        <td>19876543-2</td>
                        <td>npaola@gmail.com</td>
                        <td>+56 9 8765 1234</td>
                      </tr>
                      <tr>
                        <td>
                          <v-btn
                            text
                            small
                            icon
                            title="Editar Inversionista"
                            @click="openInversionistaDialog()"

                          >
                            <v-icon>mdi-file-document-edit-outline</v-icon>
                          </v-btn>
                          <v-btn
                            text
                            small
                            icon
                            title="Agregar inversión"
                            @click="openInversionDialog()"
                          >
                            <v-icon>mdi-comment-edit-outline</v-icon>
                          </v-btn>
                          <v-btn text small icon >
                            <v-icon
                              title="Mostrar detalles"
                              
                            >mdi-plus-box-outline</v-icon>
<!--                             <v-icon
                              title="Ocultar detalles"
                              v-show="soluciones[index].detalle_visible"
                            >mdi-minus-box-outline</v-icon> -->
                          </v-btn>
                        </td>
                        <td>Vanessa Angelica</td>
                        <td>18293485-6</td>
                        <td>vangelica@gmail.com</td>
                        <td>+56 9 8765 1234</td>
                      </tr>
                      <tr>
                        <td>
                          <v-btn
                            text
                            small
                            icon
                            title="Editar Inversionista"
                            @click="openInversionistaDialog()"

                          >
                            <v-icon>mdi-file-document-edit-outline</v-icon>
                          </v-btn>
                          <v-btn
                            text
                            small
                            icon
                            title="Agregar inversión"
                            @click="openInversionDialog()"
                          >
                            <v-icon>mdi-comment-edit-outline</v-icon>
                          </v-btn>
                          <v-btn text small icon >
                            <v-icon
                              title="Mostrar detalles"
                              
                            >mdi-plus-box-outline</v-icon>
<!--                             <v-icon
                              title="Ocultar detalles"
                              v-show="soluciones[index].detalle_visible"
                            >mdi-minus-box-outline</v-icon> -->
                          </v-btn>                          
                        </td>
                        <td>Ines Veronica</td>
                        <td>98765432-1</td>
                        <td>iveronica@gmail.com</td>
                        <td>+56 9 8765 1234</td>
                      </tr>
                      <tr>
                        <td>
                          <v-btn
                            text
                            small
                            icon
                            title="Editar Inversionista"
                            @click="openInversionistaDialog()"

                          >
                            <v-icon>mdi-file-document-edit-outline</v-icon>
                          </v-btn>
                          <v-btn
                            text
                            small
                            icon
                            title="Agregar inversión"
                            @click="openInversionDialog()"
                          >
                            <v-icon>mdi-comment-edit-outline</v-icon>
                          </v-btn>
                          <v-btn text small icon >
                            <v-icon
                              title="Mostrar detalles"
                              
                            >mdi-plus-box-outline</v-icon>
<!--                             <v-icon
                              title="Ocultar detalles"
                              v-show="soluciones[index].detalle_visible"
                            >mdi-minus-box-outline</v-icon> -->
                          </v-btn>                          
                        </td>
                        <td>Paulima Claudia</td>
                        <td>12348765-1</td>
                        <td>pclaudia@gmail.com</td>
                        <td>+56 9 8765 1234</td>
                      </tr>
                    </template>
                  </tbody>
                </v-simple-table>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-col>
      </v-row>
    </v-container>

    <!-- dialogo form inversionistas -->
    <v-dialog v-model="inversionista_dialog" width="98%">
      <v-card>
        <v-card-title>
          <span
            class="sol-tex-sha"
          >Datos Personales</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Nombre"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Email"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Comuna"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Apellido Paterno"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Telefono"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Edad"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Apellido Materno"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Estado Civil"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Fecha Nacimiento"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Rut"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Region"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Contraseña"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Domicilio"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Ciudad"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
          <!-- {{inversionista_edited}} -->
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeInversionistaDialog()">Cancelar</v-btn>
          <v-btn
            @click="closeInversionistaDialog()"
          >Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- dialogo form inversion -->
    <v-dialog v-model="inversion_dialog" width="98%">
      <v-card>
        <v-card-title>
          <span
            class="sol-tex-sha"
          >Inversión</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Inversión CLP$"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Inversión US$"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Fecha y Hora"
                ></v-text-field>
              </v-col>
            </v-row>

          </v-form>
          <!-- {{inversionista_edited}} -->
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeInversionDialog()">Cancelar</v-btn>
          <v-btn
            @click="closeInversionDialog()"
          >Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
export default {
  components: {
  },
  directives: {

  },
  name: "Mantenedores",
  data() {
    return {
      
      inversionista_dialog: false,
      inversionista_edited_index: -1,
      inversionista_edited: [],
      detalle_inversionista: false,
      
      inversion_dialog: false,
      inversion_edited_index: -1,
      inversion_edited: [],

      
    };
  },
  props: {
    
  },
  mounted() {

  },
  computed: {

  },
  methods: {
    openInversionistaDialog(){
      this.inversionista_dialog=true
    },
    openInversionDialog(){
      this.inversion_dialog=true
    },
    closeInversionistaDialog(){
      this.inversionista_dialog=false
    },
    closeInversionDialog(){
      this.inversion_dialog=false
    },
    toggleDetalleInversionista(){
      this.detalle_inversionista = !this.detalle_inversionista
    }
  },
};
</script>

<style scoped>
</style>