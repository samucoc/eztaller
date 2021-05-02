<template>
  <section>
    <v-simple-table dense class="mb-2">
      <thead>
        <tr class="green lighten-4">
          <th>
            <v-btn
              text
              small
              icon
              :disabled="!showBtnAddAsesoriaGrupal()"
              title="Agregar Asesoría Grupal"
              @click="openAsesoriaGrupalDialog(null)"
            >
              <v-icon>mdi-tooltip-plus-outline</v-icon>
            </v-btn>
          </th>
          <th class="text-center">N</th>
          <th>Estado</th>
          <th>Tipo de Asesoría</th>
          <th>Modalidad</th>
          <th>Grupo Etario</th>
          <th>Subcomponente asociado</th>
          <th>Soluciones asociadas</th>
          <th>Temática</th>
          <th>Actividades principales</th>
          <th>Personas a convocar</th>
          <th>Familias a convocar</th>
          <th>Fecha planificada</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="asesorias_grupales.length == 0">
          <td colspan="20" class="text-center grey lighten-4">
            <strong>Sin información</strong>
          </td>
        </tr>
        <tr
          v-for="(item, index) in asesorias_grupales"
          :key="'ase_gru_'+item.propuesta_asesoria_id"
        >
          <td class="nowrap" style="width:80px !important;">
            <v-btn
              :disabled="!hasPermission('edt.ase.gru.pic')"
              text
              small
              icon
              title="Editar asesoría grupal"
              @click="openAsesoriaGrupalDialog(item)"
            >
              <v-icon>mdi-file-document-edit-outline</v-icon>
            </v-btn>
            <v-btn
              :disabled="!hasPermission('del.ase.gru.pic')"
              text
              small
              icon
              title="Eliminar asesoría grupal"
              @click="deleteAsesoriaGrupal(item)"
            >
              <v-icon>mdi-trash-can-outline</v-icon>
            </v-btn>
          </td>
          <td>{{(index+1)}}</td>
          <td>
            <!-- showBitacoraDialog -->
            <a
              @click="showBitacoraDialog({
                  id: item.propuesta_asesoria_id,
                  tipo_entidad_id: item.tipo_entidad_id
                  })"
            >{{item.bit_estado.estado}}</a>
          </td>
          <td>{{item.tipo_asesoria}}</td>
          <td>{{item.modalidad_asesoria}}</td>
          <td>{{item.grupo}}</td>
          <td>
            <template v-for="sub_componente in item.sub_componente">
              <div v-bind:key="'sub_com_'+sub_componente.id">{{sub_componente.sub_componente}}</div>
            </template>
          </td>
          <td>{{item.soluciones.length}}</td>
          <td>
            <template v-for="tematica in item.tematicas">
              <div v-bind:key="'tem_'+tematica.id">{{tematica.tematica}}</div>
            </template>
          </td>
          <td>{{item.actividades}}</td>
          <td>{{item.num_personas}}</td>
          <td>
            <ul>
              <template v-for="(propuesta_familia,j) in item.propuesta_familias">
                <li
                  v-bind:key="'pro_fam_'+j+'_'+propuesta_familia.id"
                >{{propuesta_familia.nom_benef}}</li>
              </template>
            </ul>
          </td>
          <td>{{date2fecha(item.fecha_planificada)}}</td>
        </tr>
      </tbody>
    </v-simple-table>
    <!-- <v-row class="pt-2 px-2">
      <v-col cols="6">
        <v-btn small color="primary">VISAR ASESORÍA</v-btn>
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small color="success">VISAR ASESORÍA</v-btn>
      </v-col>
    </v-row>-->

    <v-dialog v-model="asesoria_grupal_dialog">
      <v-card>
        <v-card-title>
          <span>{{asesoriaGrupalDialogTitle}}</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-select
                  v-show="asesoria_grupal_edited.propuesta_asesoria_id !== null && canEditStatusAsesoriaFamiliar()"
                  v-model="asesoria_grupal_edited.bit_estado_actual_id"
                  :items="asesorias_estados_options"
                  label="Estado Asesoría"
                  item-text="estado"
                  item-value="id"
                  @change="openConvDialog()"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="asesoria_grupal_edited.tipo_asesoria_id"
                  :items="tipo_asesoria_options"
                  :error-messages="this.showAsesoriaGrupalFormError('tipo_asesoria_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Tipo de asesoría"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="asesoria_grupal_edited.modalidad_asesoria_id"
                  :items="modalidad_asesoria_options"
                  :error-messages="this.showAsesoriaGrupalFormError('modalidad_asesoria_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Modalidad"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="asesoria_grupal_edited.grupo_id"
                  :items="grupo_options"
                  :error-messages="this.showAsesoriaGrupalFormError('grupo_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Grupo etario"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  multiple
                  v-model="asesoria_grupal_edited.solucion_id"
                  :items="solucion_options"
                  :error-messages="this.showAsesoriaGrupalFormError('solucion_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Solución"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  multiple
                  v-model="asesoria_grupal_edited.tematica_id"
                  :items="tematica_options"
                  :error-messages="this.showAsesoriaGrupalFormError('tematica_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Temática"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="asesoria_grupal_edited.num_personas"
                  :error-messages="this.showAsesoriaGrupalFormError('num_personas')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Nº personas a convocar"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12">
                <v-text-field
                  v-model="asesoria_grupal_edited.actividades"
                  :error-messages="this.showAsesoriaGrupalFormError('actividades')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Actividades principales"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12">
                <v-select
                  multiple
                  :items="familia_options"
                  v-model="asesoria_grupal_edited.propuesta_familia_id"
                  :error-messages="this.showAsesoriaGrupalFormError('propuesta_familia_id')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Familias a convocar"
                ></v-select>
              </v-col>
              <v-col cols="12" md="12">
                <v-menu
                  offset-y
                  v-model="asesoria_grupal_datepicker"
                  max-width="290px"
                  min-width="290px"
                  transition="scale-transition"
                  :close-on-content-click="false"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                      v-model="asesoriaGrupalDateFormatted"
                      label="Fecha planificada"
                      persistent-hint
                      append-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :error-messages="showAsesoriaGrupalFormError('fecha_planificada')"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    no-title
                    v-model="asesoria_grupal_edited.fecha_planificada"
                    locale="es-cl"
                    @input="asesoria_grupal_datepicker = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="secondary" @click="closeAsesoriaGrupalDialog()">Cancelar</v-btn>
          <v-spacer></v-spacer>
          <v-btn
            :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
            @click="saveAsesoriaGrupal()"
          >Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="asesoria_grupal_delete_dialog" max-width="60%" persistent>
      <v-card>
        <v-card-text>
          <h2 class="pt-10 pb-5 text-center">¿Está seguro que desea eliminar la asesoría grupal?</h2>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="secondary" @click="asesoria_grupal_delete_dialog=false">No</v-btn>
          <v-spacer></v-spacer>
          <v-btn @click="dropAsesoriaGrupal()">Sí</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <bitacora-dialog ref="bitacoraDialog"></bitacora-dialog>
    <v-dialog v-model="convDialog" max-width="400">
      <v-card>
        <v-card-text
          class="text-center pt-5"
        >Para cambiar estado de la asesoría, debe ingresar un comentario</v-card-text>
        <v-card-text class="justify-center">
          <v-text-field
            auto-grow
            counter
            rows="2"
            name="comentario"
            label="Comentario"
            v-model="asesoria_grupal_edited.comentario"
          ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn depressed class="btnPrimario" text @click="addComentarioAsesoria()">Aceptar</v-btn>
          <v-btn depressed class="btnPrimario" text @click="closeComentarioAsesoria()">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialogo Desestimar familia -->
    <v-dialog persistent v-model="dialog_desestimar" scrollable max-width="550">
      <v-card>
        <v-card-title>Desestimar Asesoría Grupal</v-card-title>
        <v-card-text>
          <p>Seleccione un motivo:</p>
          <p>
            <v-radio-group class="mx-3 my-3" v-model="motivo_seleccionado">
              <v-radio
                v-for="item in motivos_desestimar"
                :key="item.id"
                :label="`${item.nombre}`"
                :value="`${item.nombre}`"
                @change="selectMotivoParaDesestimar(item.nombre)"
              />
              <v-radio label="Otro" value="0" @change="selectMotivoParaDesestimar(0)" />
            </v-radio-group>
            <v-text-field v-model="motivo_otro" label="Escriba un motivo" v-if="motivo_otro_show"></v-text-field>
          </p>
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn @click="closeDialogDesestimar()">Cancelar</v-btn>
          <v-spacer />
          <v-btn @click="desestimar()">Aceptar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import {
  getAsesoriasGrupalesPicFromApi,
  saveAsesoriaGrupalFromApi,
  dropAsesoriaGrupalFromApi,
  saveCostoAsesoriaFromApi,
  changeStatusAsesoriasFromApi,
  getStatusEntidad,
} from "../../api/propuesta";
import {
  habilitarBeneficiarioFromApi,
  getMotivosParaDesestimarFromApi,
  desestimarBeneficiarioFromApi,
  setVisadoByConvocatoria,
  getBeneficiariosFromApi,
} from "../../api/propuestaFamilia";

import { getAsesoriasGrupalesOptionsFromApi } from "../../api/propuestaFamilia";
import { moneyFormat, date2fecha } from "../../services/util";
import BitacoraDialog from "../BitacoraDialog.vue";

export default {
  components: { BitacoraDialog },
  props: ["asesorias_grupales", "convocatoria", "beneficiarios"],
  name: "AsesoriasGrupales",
  data() {
    return {
      asesoria_grupal_edited: {},
      asesoria_grupal_edited_index: -1,
      asesoria_grupal_dialog: false,
      asesoria_grupal_delete_dialog: false,
      asesoria_grupal_form_errors: [],
      asesoria_grupal_datepicker: false,

      tipo_asesoria_options: [],
      modalidad_asesoria_options: [],
      grupo_options: [],
      solucion_options: [],
      tematica_options: [],
      familia_options: [],
      asesorias_estados_options: [],

      show_bitacora_dialog: false,

      convDialog: false,
      convDialog_edited: [],

      motivos_desestimar: [],
      motivo_seleccionado: "",
      motivo_otro: "",
      motivo_otro_show: false,

      dialog_desestimar: false,

      bit_estado_actual_diag_id: false,
    };
  },
  mounted() {
    this.resetAsesoriaGrupalEdited();
    // this.getAsesoriasGrupalesPic();
  },
  computed: {
    asesoriaGrupalDateFormatted() {
      return date2fecha(this.asesoria_grupal_edited.fecha_planificada);
    },
    asesoriaFamiliarDialogTitle() {
      if (this.asesoria_familiar_edited_index == -1) {
        return "Agregar asesoría familiar";
      } else {
        return "Editar asesoría familiar";
      }
    },
    asesoriaGrupalDialogTitle() {
      if (this.asesoria_grupal_edited_index == -1) {
        return "Agregar Asesoría Grupal";
      } else {
        return "Editar Asesoría Grupal";
      }
    },
  },
  methods: {
    date2fecha,
    moneyFormat,

    openDialogDesestimar() {
      // TODO: obtener motivos apra desestimar
      this.getMotivosParaDesestimar();
    },
    closeDialogDesestimar() {
      this.motivo_seleccionado = "";
      this.motivo_otro = "";
      this.motivo_otro_show = false;
      this.dialog_desestimar = false;
    },
    getMotivosParaDesestimar() {
      getMotivosParaDesestimarFromApi()
        .then((res) => {
          if (res.data.type == "success") {
            this.motivos_desestimar = res.data.data;
            this.dialog_desestimar = true;
          } else {
            this.motivos_desestimar = [];
          }
        })
        .catch((err) => {
          console.error(res);
        });
    },
    selectMotivoParaDesestimar(item) {
      this.motivo_otro = "";
      this.motivo_otro_show = item == "0";
    },
    desestimar() {
      let motivo =
        this.motivo_seleccionado == "0"
          ? this.motivo_otro
          : this.motivo_seleccionado;
      this.asesoria_grupal_edited.comentario = motivo;
      this.closeDialogDesestimar();
      this.changeStatusAsesorias();
    },
    openConvDialog() {
      let estado_id = this.asesoria_grupal_edited.bit_estado_actual_id;
      let est = this.getUser().bit_estados;
      if (estado_id == est.ASE_DES) this.openDialogDesestimar();
      else this.convDialog = true;
    },

    showBitacoraDialog(item) {
      this.$refs.bitacoraDialog.open(item);
    },
    closeBitacoraDialog() {
      this.show_bitacora_dialog = false;
    },
    getAsesoriasGrupalesPic() {
      getAsesoriasGrupalesPicFromApi(this.conv_id)
        .then((response) => {
          if (response.data.type == "success") {
            this.convocatoria = response.data.data.convocatoria;
            this.familias = response.data.data.familias;
            this.asesorias = response.data.data.asesorias;
            this.costos = response.data.data.costos;
            // options
            this.tipo_asesoria_options =
              response.data.data.options.tipo_asesorias;
            this.modalidad_asesoria_options =
              response.data.data.options.modalidad_asesorias;
            this.grupo_options = response.data.data.options.grupos;
            this.solucion_options = response.data.data.options.soluciones;
            this.tematica_options = response.data.data.options.tematicas;
            this.familia_options = response.data.data.options.familias;
            this.bit_estado_actual_diag_id =
              response.data.data.bit_estado_actual_diag_id;

            this.$emit("getData");
          } else {
            this.showMessage(response.data.message, "warning");
          }
        })
        .catch((err) => console.error(err));
    },

    openCostoAsesoriaDialog(item) {
      this.resetCostoAsesoriaEdited();
      this.costo_asesoria_form_errors = [];
      this.costo_asesoria_edited_index = this.costos.indexOf(item);
      this.costo_asesoria_edited = Object.assign({}, item);
      this.costo_asesoria_dialog = true;
    },
    closeCostoAsesoriaDialog() {
      this.costo_asesoria_dialog = false;
      this.resetCostoAsesoriaEdited();
    },
    goBack() {
      window.history.back();
    },

    closeComentarioAsesoria() {
      this.convDialog = false;
    },
    addComentarioAsesoria() {
      this.asesoria_familiar_edited.comentario = this.asesoria_familiar_edited.comentario;
      //this.convocatoria.bit_estado_actual_id = this.convDialog_edited.estado_id;
      this.closeComentarioAsesoria();
      this.changeStatusAsesorias();
    },

    changeStatusAsesorias() {
      var status = this.asesoria_grupal_edited.bit_estado_actual_id;
      var solucion_id = this.asesoria_grupal_edited.propuesta_asesoria_id;
      if (this.asesoria_grupal_edited.comentario == null) {
        this.showMessage("Comentario esta vacío", "warning");
      } else {
        changeStatusAsesoriasFromApi(
          status,
          solucion_id,
          this.asesoria_grupal_edited.comentario
        )
          .then((response) => {
            this.getPropuestaPic();
          })
          .catch((err) => console.error(err));
      }
    },

    openAsesoriaGrupalDialog(item) {
      var estado_diag = this.bit_estado_actual_diag_id;
      let est = this.getUser().bit_estados;
      let benef = this.beneficiarios;
      let flag = 1;
      for (let i = 0; i < benef.length; i++) {
        estado_diag = this.beneficiarios[i].bit_estado_actual_diag_id;
        if (
          this.beneficiarios[i].bit_estado_actual_diag_id == est.FAM_DIA_DES ||
          this.beneficiarios[i].bit_estado_actual_diag_id == est.FAM_DIA_FIN ||
          this.beneficiarios[i].bit_estado_actual_diag_id == est.FAM_DIA_VIS ||
          this.beneficiarios[i].bit_estado_actual_diag_id == est.FAM_DIA_APR
        ) {
          flag = 0;
        }
      }

      if (flag == 1) {
        this.showMessage(
          "No tiene privilegios para crear la asesoría",
          "warning"
        );
        return;
      }

      if (item == null) {
        getAsesoriasGrupalesOptionsFromApi(this.convocatoria.id)
          .then((res) => {
            if (res.data.type == "success") {
              this.tipo_asesoria_options = res.data.data.tipos;
              this.modalidad_asesoria_options = res.data.data.modalidades;
              this.grupo_options = res.data.data.grupos;
              this.solucion_options = res.data.data.soluciones;
              this.tematica_options = res.data.data.tematicas;
              this.familia_options = res.data.data.familias;
            }
            if (item === null) {
              this.resetAsesoriaGrupalEdited();
              this.asesoria_grupal_dialog = true;
            } else {
              this.asesoria_grupal_form_errors = [];
              this.asesoria_grupal_edited_index = this.asesorias_grupales.indexOf(
                item
              );
              this.asesoria_grupal_edited = Object.assign({}, item);
              this.asesoria_grupal_dialog = true;
            }
            var bit_estado_actual_id = this.asesoria_grupal_edited
              .bit_estado_actual_id;
            if (bit_estado_actual_id == null) {
            } else {
              getStatusEntidad(bit_estado_actual_id)
                .then((response) => {
                  if (response.data.type == "success") {
                    this.asesorias_estados_options = response.data.data;
                    this.asesoria_grupal_edited.bit_estado_actual_id = bit_estado_actual_id;
                    this.asesoria_grupal_edited.bit_estado_actual_id = parseInt(
                      this.asesoria_grupal_edited.bit_estado_actual_id
                    );
                  } else {
                    this.showMessage(response.data.message, "warning");
                  }
                })
                .catch((err) => console.error(err));
            }
          })
          .catch((err) => {
            console.error(err);
          });
      } else {
        if (
          estado_diag == est.FAM_DIA_DES ||
          estado_diag == est.FAM_DIA_FIN ||
          estado_diag == est.FAM_DIA_VIS ||
          estado_diag == est.FAM_DIA_APR
        ) {
          getAsesoriasGrupalesOptionsFromApi(this.convocatoria.id)
            .then((res) => {
              if (res.data.type == "success") {
                this.tipo_asesoria_options = res.data.data.tipos;
                this.modalidad_asesoria_options = res.data.data.modalidades;
                this.grupo_options = res.data.data.grupos;
                this.solucion_options = res.data.data.soluciones;
                this.tematica_options = res.data.data.tematicas;
                this.familia_options = res.data.data.familias;
              }
              if (item === null) {
                this.resetAsesoriaGrupalEdited();
                this.asesoria_grupal_dialog = true;
              } else {
                this.asesoria_grupal_form_errors = [];
                this.asesoria_grupal_edited_index = this.asesorias_grupales.indexOf(
                  item
                );
                this.asesoria_grupal_edited = Object.assign({}, item);
                this.asesoria_grupal_dialog = true;
              }
              var bit_estado_actual_id = this.asesoria_grupal_edited
                .bit_estado_actual_id;
              if (bit_estado_actual_id == null) {
              } else {
                getStatusEntidad(bit_estado_actual_id)
                  .then((response) => {
                    if (response.data.type == "success") {
                      this.asesorias_estados_options = response.data.data;
                      this.asesoria_grupal_edited.bit_estado_actual_id = bit_estado_actual_id;
                      this.asesoria_grupal_edited.bit_estado_actual_id = parseInt(
                        this.asesoria_grupal_edited.bit_estado_actual_id
                      );
                    } else {
                      this.showMessage(response.data.message, "warning");
                    }
                  })
                  .catch((err) => console.error(err));
              }
            })
            .catch((err) => {
              console.error(err);
            });
        } else {
          this.showMessage(
            "No tiene privilegios para crear o editar asesorías grupales.",
            "warning"
          );
        }
      }

      // TODO: Obtener FormOptions
    },
    closeAsesoriaGrupalDialog() {
      this.asesoria_grupal_dialog = false;
      this.resetAsesoriaGrupalEdited();
    },

    deleteAsesoriaGrupal(item) {
      this.asesoria_grupal_delete_dialog = true;
      this.asesoria_grupal_edited = item;
    },
    dropAsesoriaGrupal() {
      dropAsesoriaGrupalFromApi(this.asesoria_grupal_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.$emit("getData");
              this.asesoria_grupal_delete_dialog = false;
            } else {
              this.showMessage(response.data.message, "warning");
            }
          } else {
            this.showMessage(response.data.message, "warning");
          }
        })
        .catch((err) => console.error(err));
    },

    resetAsesoriaGrupalEdited() {
      this.asesoria_grupal_form_errors = [];
      this.asesoria_grupal_edited_index = -1;
      this.asesoria_grupal_edited = {
        propuesta_asesoria_id: null,
        fecha_planificada: null,
        num_personas: null,
        tipo_asesoria_id: null,
        modalidad_asesoria_id: null,
        grupo_id: null,
        propuesta_familia_id: [],
        solucion_id: [],
        tematica_id: [],
        actividades_principales: null,
        fecha_planificada: null,
      };
    },

    resetCostoAsesoriaEdited() {
      this.costo_asesoria_form_errors = [];
      this.costo_asesoria_edited_index = -1;
      this.costo_asesoria_edited = {
        id: null,
        monto_aporte_mds: null,
        monto_aporte_local: null,
        monto_aporte_otros: null,
        monto_aporte_total: null,
        convocatoria_id: null,
        plan_cuenta_item_id: null,
        plan_cuenta_item: null,
        tipo_propuesta_id: null,
      };
    },

    closeComentarioAsesoria() {
      this.convDialog = false;
    },
    addComentarioAsesoria() {
      this.asesoria_grupal_edited.comentario = this.asesoria_grupal_edited.comentario;
      //this.convocatoria.bit_estado_actual_id = this.convDialog_edited.estado_id;
      this.closeComentarioAsesoria();
      this.changeStatusAsesorias();
    },

    changeStatusAsesorias() {
      var status = this.asesoria_grupal_edited.bit_estado_actual_id;
      var solucion_id = this.asesoria_grupal_edited.propuesta_asesoria_id;
      if (this.asesoria_grupal_edited.comentario == null) {
        this.showMessage("Comentario esta vacío", "warning");
      } else {
        changeStatusAsesoriasFromApi(
          status,
          solucion_id,
          this.asesoria_grupal_edited.comentario
        )
          .then((response) => {
            this.$emit("getData");
          })
          .catch((err) => console.error(err));
      }
    },

    saveAsesoriaGrupal() {
      this.asesoria_grupal_edited.convocatoria_id = this.convocatoria.id;
      saveAsesoriaGrupalFromApi(this.asesoria_grupal_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.$emit("getData");
              this.asesoria_grupal_dialog = false;
            } else {
              this.asesoria_grupal_form_errors = response.data.errors;
            }
          } else {
            this.showMessage(response.data.message, "warning");
            this.form_errors = response.data.errors;
          }
        })
        .catch((err) => console.error(err));
    },
    showAsesoriaGrupalFormError(field) {
      try {
        if (
          typeof this.asesoria_grupal_form_errors[field] !== "undefined" ||
          this.asesoria_grupal_form_errors[field] !== "" ||
          this.asesoria_grupal_form_errors[field] !== null
        ) {
          return this.asesoria_grupal_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },
    saveCostoAsesoria() {
      this.costo_asesoria_edited.convocatoria_id = this.convocatoria.id;
      saveCostoAsesoriaFromApi(this.costo_asesoria_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getAsesoriasGrupalesPic();
              this.costo_asesoria_dialog = false;
            } else {
              this.costo_asesoria_form_errors = response.data.errors;
            }
          } else {
            this.showMessage(response.data.message, "warning");
            this.form_errors = response.data.errors;
          }
        })
        .catch((err) => console.error(err));
    },
    showCostoAsesoriaFormError(field) {
      try {
        if (
          typeof this.costo_asesoria_form_errors[field] !== "undefined" ||
          this.costo_asesoria_form_errors[field] !== "" ||
          this.costo_asesoria_form_errors[field] !== null
        ) {
          return this.costo_asesoria_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },

    showBtnAddAsesoriaGrupal() {
      if (this.hasPermission("add.ase.gru.pic")) {
        let est = this.getUser().bit_estados;
        if (
          this.convocatoria.bit_estado_actual_id == est.CON_DIAGNOSTICO ||
          this.convocatoria.bit_estado_actual_id == est.CON_PROPUESTAS_TECNICAS
        ) {
          return true;
        }
      }
      return false;
    },
    showBtnEditAsesoriaGrupal(bit_est_id) {
      if (this.hasPermission("add.ase.gru.pic")) {
        let est = this.getUser().bit_estados;
        if (
          this.convocatoria.bit_estado_actual_id == est.CON_DIAGNOSTICO ||
          this.convocatoria.bit_estado_actual_id == est.CON_PROPUESTAS_TECNICAS
        ) {
          if (bit_est_id == est.ASE_NO_INI) {
            return true;
          }
        }
      }
      return false;
    },

    canEditStatusAsesoriaFamiliar() {
      return this.hasPermission("ase.status.change");
    },

    showBtnDiagnosticar(bit_est_id) {
      // Permiso diag.fam
      // TODO: Cuando se la convocatoria se encuentre en:

      // TODO: Cuando el estado actual sea:
      // Diagnostico no iniciado
      // Diagnostico en desarrollo
      // Diagnostico finalizado
      // Diagnostico visado
      // Diagnostico aprobado

      let est = this.getUser().bit_estados;
      if (this.hasPermission("diag.fam")) {
        if (
          this.convocatoria.bit_estado_actual_id ==
            est.CON_SELECCION_FAMILIAS ||
          this.convocatoria.bit_estado_actual_id == est.CON_DIAGNOSTICO
        ) {
          if (
            bit_est_id == est.FAM_DIA_NO_INI ||
            bit_est_id == est.FAM_DIA_DES ||
            bit_est_id == est.FAM_DIA_FIN ||
            bit_est_id == est.FAM_DIA_VIS ||
            bit_est_id == est.FAM_DIA_APR
          ) {
            return true;
          }
        }
      }
      return false;
    },
  },
};
</script>

<style scoped>
.tituloPrincipal {
  font-size: 13px;
  padding: 0;
}

.title-section {
  color: #0f69b4;
}

.v-data-table__wrapper {
  overflow-x: hidden !important;
}
</style>