<template>
  <section>
    <div class="table-hover-none">
      <v-simple-table dense>
        <thead>
          <tr class="yellow lighten-4">
            <!-- <th>
              <v-checkbox color="success"></v-checkbox>
            </th>-->
            <th>
              <div>
                <v-btn
                :disabled="!canAddSolucion()"
                text
                small
                icon
                title="Agregar Solución"
                @click="addSolucion()"
              >
                  <v-icon>mdi-tooltip-plus-outline</v-icon>
                </v-btn>
                <v-btn
                  :disabled="soluciones.length==0"
                  text
                  small
                  icon
                  @click="toggleDetalleSolucion()"
                >
                  <v-icon
                    title="Mostrar detalles"
                    v-show="(soluciones.length==0) ? true:!soluciones[0].detalle_visible"
                  >mdi-plus-box-outline</v-icon>
                  <v-icon
                    title="Ocultar detalles"
                    v-show="(soluciones.length==0) ? false:soluciones[0].detalle_visible"
                  >mdi-minus-box-outline</v-icon>
                </v-btn>
              </div>
            </th>
            <th class="text-left no-wrap">Solución</th>
            <th class="text-left no-wrap">Estado</th>
            <th class="text-left no-wrap" title="Problematica Social en Diagnosticos">
              Problemática
              <br />Social
            </th>
            <th class="text-left no-wrap" title="Problematica Constructiva en Diagnosticos">
              Problemática
              <br />Constructiva
            </th>
            <th class="text-left no-wrap">
              Solución a
              <br />Intervenir
            </th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-show="soluciones.length == 0">
            <td colspan="20" class="text-center grey lighten-4">
              <strong>Sin información</strong>
            </td>
          </tr>
          <template v-for="(item,index) in soluciones">
            <tr v-bind:key="item.solucion_id">
              <!-- <td>
                <v-checkbox color="success"></v-checkbox>
              </td>-->
              <td class="nowrap" style="width:100px !important;">
                <v-btn
                  text
                  small
                  icon
                  title="Editar solución"
                  :disabled="!canEditSolucion()"
                  @click="editSolucion(item)"
                >
                  <v-icon>mdi-file-document-edit-outline</v-icon>
                </v-btn>
                <v-btn text small icon @click="toggleDetalleSolucion(index)">
                  <v-icon
                    title="Mostrar detalles"
                    v-show="!soluciones[index].detalle_visible"
                  >mdi-plus-box-outline</v-icon>
                  <v-icon
                    title="Ocultar detalles"
                    v-show="soluciones[index].detalle_visible"
                  >mdi-minus-box-outline</v-icon>
                </v-btn>
              </td>
              <td class="no-wrap">
                <span :style="item.solucion_configuracion" class="sol-tex-sha">{{ item.solucion }}</span>
              </td>
              <td class="no-wrap">
                <!-- showBitacoraDialog -->
                <a
                  @click="showBitacoraDialog({
                  id:item.propuesta_solucion_id,
                  tipo_entidad_id:item.tipo_entidad_id
                })"
                >{{ item.bit_estado }}</a>
              </td>

              <td>{{bool2str(item.problematica_social)}}</td>
              <td>{{bool2str(item.problematica_constructiva)}}</td>
              <td>{{bool2str(item.intervenir)}}</td>

            </tr>
            <tr v-show="item.detalle_visible" v-bind:key="item.solucion">
              <td colspan="20">
                <div class="row">
                  <div v-show="item.descripcion==''">
                    <i>Sin descripción</i>
                  </div>
                  <div class="col-sm-2">
                  </div>
                  <div v-show="item.descripcion!==''" class="col-sm-2" title="Descripción">
                    <strong>Descripción de la solución:</strong>
                    <br />
                    {{item.descripcion}}
                  </div>
                  <div class="col-sm-2" >
                    Total por
                    <br />solución
                    <br>{{ getMoneyFormat(item.monto_aporte_total) }}
                  </div>
                  <div class="col-sm-2" >
                    Aporte
                    <br />MDS
                    <br>{{ getMoneyFormat(item.monto_aporte_mds) }}
                  </div>
                  <div class="col-sm-2" >
                    Aporte
                    <br />Local
                    <br>{{ getMoneyFormat(item.monto_aporte_local) }}
                  </div>
                  <div class="col-sm-2" >
                    Aporte
                    <br />Otros
                    <br>{{ getMoneyFormat(item.monto_aporte_otros) }}
                  </div>
                </div>
                <div class="ml-4 my-2">
                  <v-simple-table dense class="tab-sol-det">
                    <thead>
                      <tr class="yellow lighten-4">
                        <th style="width:30%;">Detalle Solución</th>
                        <th style="width:10%;" class="nowrap">Problematica Constructiva</th>
                        <th style="width:10%;" class="nowrap">A Intervenir</th>
                        <th class="nowrap">Infactibilidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="row in item.detalle_soluciones" :key="row.id">
                        <td>
                          <span
                            :style="item.solucion_configuracion"
                            class="sol-tex-sha"
                          >{{row.detalle_solucion}}</span>
                        </td>
                        <td>{{bool2str(row.problematica_constructiva)}}</td>
                        <td>{{bool2str(row.intervenir)}}</td>
                        <td>
                          <v-row class="ma-0 pa-0">
                            <v-col
                              cols="12"
                              md="3"
                              class="mx-0 my-1 pa-0"
                            >Económica: {{bool2str(row.inf_eco)}}</v-col>
                            <v-col
                              cols="12"
                              md="3"
                              class="mx-0 my-1 pa-0"
                            >Técnica: {{bool2str(row.inf_tec)}}</v-col>
                            <v-col
                              cols="12"
                              md="3"
                              class="mx-0 my-1 pa-0"
                            >Legal: {{bool2str(row.inf_leg)}}</v-col>
                            <v-col
                              cols="12"
                              md="3"
                              class="mx-0 my-1 pa-0"
                            >Otra: {{bool2str(row.inf_otr)}}</v-col>
                          </v-row>
                        </td>
                      </tr>
                    </tbody>
                  </v-simple-table>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </v-simple-table>
    </div>
    <!-- {{soluciones}} -->
    <!-- dialogo formulario soluciones -->
    <v-dialog v-model="solucion_dialog" width="98%">
      <v-card>
        <v-card-title>
          <span
            :style="solucion_edited.solucion_configuracion"
            class="sol-tex-sha"
          >{{ solucionDialogTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-select
              v-show="this.solucion_edited.propuesta_solucion_id !== null && canEditStatusSolucion()"
              v-model="solucion_edited.bit_estado_id"
              :error-messages="this.showFormError('solucion_id')"
              :items="solucion_estados_options"
              label="Estado Solución"
              item-text="estado"
              item-value="id"
              @change="openConvDialog()"
            ></v-select>
            <br />
            <v-select
              v-if="this.solucion_edited_index == -1"
              v-model="solucion_option_selected"
              :error-messages="this.showFormError('solucion_id')"
              :items="solucion_options"
              label="Solución"
              @change="changeSolucion"
            ></v-select>
            <v-text-field
              label="Descripción"
              v-model="solucion_edited.descripcion"
              :error-messages="this.showFormError('descripcion')"
            ></v-text-field>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Aporte MDS"
                  v-model="solucion_edited.monto_aporte_mds"
                  v-money="mask_money"
                  :error-messages="this.showFormError('monto_aporte_mds')"
                  auto-grow
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Aporte local"
                  v-model="solucion_edited.monto_aporte_local"
                  v-money="mask_money"
                  :error-messages="this.showFormError('monto_aporte_local')"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  label="Aporte otros"
                  v-model="solucion_edited.monto_aporte_otros"
                  v-money="mask_money"
                  :error-messages="this.showFormError('monto_aporte_otros')"
                ></v-text-field>
              </v-col>
            </v-row>
            <div v-show="this.solucion_edited.solucion_id !== null">
              <div class="text-right mb-2">
                <a class="text-12" @click="showDetalleSolucionDialog()">Agregar detalle solución</a>
              </div>
              <v-simple-table dense class="tab-sol-det">
                <thead>
                  <tr>
                    <th style="width:25%;">Detalle Solución</th>
                    <th style="width:10%;" class="nowrap">Problematica Constructiva</th>
                    <th style="width:10%;" class="nowrap">A Intervenir</th>
                    <th class="nowrap">Infactibilidad</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in solucion_edited.detalle_soluciones" :key="item.id">
                    <td>
                      <span
                        :style="solucion_edited.solucion_configuracion"
                        class="sol-tex-sha"
                      >{{ item.detalle_solucion}}</span>
                    </td>
                    <td>{{bool2str(item.problematica_constructiva)}}</td>
                    <td>
                      <v-checkbox v-model="item.intervenir" @change="changeIntervenir(item)"></v-checkbox>
                    </td>
                    <td>
                      <v-row class="ma-0 pa-0">
                        <v-col cols="12" md="3" class="mx-0 my-0 pa-0 pr-5">
                          <v-checkbox
                            label="Económica"
                            v-model="item.inf_eco"
                            @change="changeInfactibilidad(item, $event)"
                          ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="3" class="mx-0 my-0 pa-0 pr-5">
                          <v-checkbox
                            label="Técnica"
                            v-model="item.inf_tec"
                            @change="changeInfactibilidad(item, $event)"
                          ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="3" class="mx-0 my-0 pa-0 pr-5">
                          <v-checkbox
                            label="Legal"
                            v-model="item.inf_leg"
                            @change="changeInfactibilidad(item, $event)"
                          ></v-checkbox>
                        </v-col>
                        <v-col
                          cols="12"
                          md="3"
                          class="mx-0 my-0 pa-0 pr-5"
                          @change="changeInfactibilidad(item, $event)"
                        >
                          <v-checkbox label="Otra" v-model="item.inf_otr"></v-checkbox>
                        </v-col>
                      </v-row>
                    </td>
                  </tr>
                </tbody>
              </v-simple-table>
              <div class="caption red--text">{{this.showFormError('detalle_soluciones')}}</div>
            </div>
          </v-form>
          <!-- {{solucion_edited}} -->
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeSolucionDialog">Cancelar</v-btn>
          <v-btn @click="savePropuestaSolucion()">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- dialogo formulario soluciones -->
    <v-dialog v-model="detalle_solucion_dialog" width="40%">
      <v-card>
        <v-card-title>
          <span>Agregar detalle solución</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-select
              :items="detalle_solucion_options"
              v-model="detalle_solucion_option_selected"
              :error-messages="this.detalle_solucion_options_error"
              label="Detalle Solución"
            ></v-select>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeDetalleSolucionDialog">Cancelar</v-btn>
          <v-btn @click="addDetalleSolucion()">Agregar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="convDialog" max-width="400">
      <v-card>
        <v-card-text
          class="text-center pt-5"
        >Para cambiar estado de la solución, debe ingresar un comentario</v-card-text>
        <v-card-text class="justify-center">
          <v-text-field
            auto-grow
            counter
            rows="2"
            name="comentario"
            label="Comentario"
            v-model="solucion_edited.comentario"
          ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            depressed
            class="btnPrimario"
            text
            @click="addComentarioSolucion()"
          >Aceptar</v-btn>
          <v-btn
            depressed
            class="btnPrimario"
            text
            @click="closeComentarioSolucion()"
          >Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <!-- Dialogo Desestimar familia -->
    <v-dialog persistent v-model="dialog_desestimar" scrollable max-width="550">
      <v-card>
        <v-card-title>Desestimar Solución</v-card-title>
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
    <!-- <v-row class="pt-2 px-2">
      <v-col cols="6">
        <v-btn small v-show="soluciones.length > 0" color="primary">VISAR SOLUCIÓN</v-btn>
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small v-show="soluciones.length > 0" color="success">APROBAR SOLUCIÓN</v-btn>
      </v-col>
    </v-row>-->
    <bitacora-dialog ref="bitacoraDialog"></bitacora-dialog>
  </section>
</template>
<script>
import {
  getDetalleSolucionesFromApi,
  getSolucionOptionsFromApi,
  getDetalleSolucionOptionsFromApi,
  getPropuestaPicFromApi,
  savePropuestaSolucionFromApi,
  saveAsesoriaFamiliarFromApi,
  dropAsesoriaFamiliarFromApi,
  changeStatusPropuestaSolucionFromApi ,
  getStatusEntidad,
} from "../../../api/propuesta";
import {
  habilitarBeneficiarioFromApi,
  getMotivosParaDesestimarFromApi,
  desestimarBeneficiarioFromApi,
  setVisadoByConvocatoria,
  getBeneficiariosFromApi,
} from "../../../api/propuestaFamilia";

import { moneyFormat } from "../../../services/util";
import { VMoney } from "v-money";
import BitacoraDialog from "../../BitacoraDialog.vue";

export default {
  components: {
    BitacoraDialog,
  },
  directives: {
    money: VMoney,
  },
  name: "Soluciones",
  data() {
    return {
      asesoria_familiar_edited: [],
      asesoria_familiar_edited_index: -1,
      asesoria_familiar_datepicker: false,
      asesoria_familiar_timepicker: false,
      asesoria_familiar_deleted: [],
      asesoria_familiar_delete_dialog: false,
      asesoria_familiar_dialog: false,
      asesoria_familiar_form_errors: [],
      asesoria_familiar_row: [],
      asesorias_familiares: [],
      beneficiario: {},
      convocatoria: {},
      detalle_solucion_row: [],
      detalle_solucion_dialog: false,
      detalle_solucion_options: [],
      detalle_solucion_options_error: null,
      detalle_solucion_option_selected: null,
      form_errors: [],
      mask_money: {
        decimal: ",",
        thousands: ".",
        precision: 0,
      },
      propuesta: [],
      panels: 0,
      solucion_dialog: false,
      solucion_edited_index: -1,
      solucion_edited: [],
      solucion_options: [],
      solucion_option_selected: null,
      soluciones: [],
      tematica_options: [],
      tipo_asesoria_options: [],
      modalidad_asesoria_options: [],
      estados:[],

      solucion_estados_options: [],
      
      convDialog : false,
      convDialog_edited : [],

      dialog_habilitar: false,
      dialog_desestimar: false,
      dialog_diagnostico_visita: false,

      familia: null,

      motivos_desestimar: [],
      motivo_seleccionado: "",
      motivo_otro: "",
      motivo_otro_show: false,

      bit_estado_actual_diag_id: false,
    };
  },
  props: {
    beneficiario_id: {
      type: Number,
    },
  },
  mounted() {
    this.getPropuestaPic();
    this.getSolucionOptions();
  },
  computed: {
    
    asesoriaFamiliarDateFormatted() {
      return this.date2fecha(this.asesoria_familiar_edited.fecha_planificada);
    },
    asesoriaFamiliarDialogTitle() {
      if (this.asesoria_familiar_edited_index == -1) {
        return "Agregar asesoría familiar";
      } else {
        return "Editar asesoría familiar";
      }
    },

    solucionDialogTitle() {
      if (this.solucion_edited_index == -1) {
        return "Agregar solución";
      } else {
        return this.solucion_edited.solucion;
      }
    },
  },
  methods: {
    
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
      this.solucion_edited.comentario = motivo;
      this.closeDialogDesestimar();
      this.changeStatusPropuestaSolucion()
    },
    openConvDialog(){
      let estado_id = this.solucion_edited.bit_estado_id ;
      if (estado_id != this.estados.SOL_DES) this.convDialog = true
      else this.openDialogDesestimar()
    },

    closeComentarioSolucion() {
      this.convDialog = false;
    },
    addComentarioSolucion() {
      this.solucion_edited.comentario = this.solucion_edited.comentario;
      //this.convocatoria.bit_estado_actual_id = this.convDialog_edited.estado_id;
      this.closeComentarioSolucion();
      this.changeStatusPropuestaSolucion()
    },
    
    showBitacoraDialog(item) {
      this.$refs.bitacoraDialog.open(item);
    },
    addAsesoriaFamiliar() {
      this.resetAsesoriaFamiliarEdited();
      this.asesoria_familiar_dialog = true;
    },

    addSolucion() {
      var estado_diag = this.beneficiario.bit_estado_actual_diag_id
      if (estado_diag == this.getBitEstado("FAM_DIA_DES") || estado_diag == this.getBitEstado("FAM_DIA_FIN") || estado_diag == this.getBitEstado("FAM_DIA_VIS") ){
        this.resetSolucionEdited();
        this.solucion_dialog = true;  
      }
      else{
        this.showMessage(
          "No tiene privilegios para crear solución",
          "warning"
        ); 
      }
    },
    addDetalleSolucion() {
      if (this.detalle_solucion_option_selected == null) {
        this.detalle_solucion_options_error = "Este campo es requerido.";
        return false;
      }
      for (let i = 0; i < this.solucion_edited.detalle_soluciones.length; i++) {
        if (
          this.solucion_edited.detalle_soluciones[0].detalle_solucion_id ==
          this.detalle_solucion_option_selected
        ) {
          this.detalle_solucion_options_error =
            "La opción seleccionada ya se encuentra en la lista.";
          return false;
        }
      }

      for (let i = 0; i < this.detalle_solucion_options.length; i++) {
        if (
          this.detalle_solucion_options[i].value ==
          this.detalle_solucion_option_selected
        ) {
          this.solucion_edited.detalle_soluciones.push({
            detalle_solucion: this.detalle_solucion_options[i].text,
            detalle_solucion_id: this.detalle_solucion_options[i].value,
            problematica_constructiva: false,
            intervenir: true,
            inf_eco: false,
            inf_tec: false,
            inf_leg: false,
            inf_otr: false,
          });
          this.closeDetalleSolucionDialog();
          break;
        }
      }
    },
    bool2str(bool) {
      return bool == true ? "Sí" : "No";
    },
    changeInfactibilidad(detalle_solucion, checked) {
      if (checked) {
        detalle_solucion.intervenir = false;
      }
    },
    changeIntervenir(detalle_solucion) {
      if (detalle_solucion.intervenir) {
        detalle_solucion.inf_eco = false;
        detalle_solucion.inf_leg = false;
        detalle_solucion.inf_otr = false;
        detalle_solucion.inf_tec = false;
      }
    },
    changeSolucion(selected) {
      this.solucion_edited.detalle_soluciones = [];
      for (let i = 0; i < this.solucion_options.length; i++) {
        if (this.solucion_options[i].value == selected) {
          this.solucion_edited.solucion_id = this.solucion_options[i].value;
          this.solucion_edited.solucion = this.solucion_options[i].text;
          this.solucion_edited.solucion_configuracion = this.solucion_options[
            i
          ].configuracion;
          break;
        }
      }
    },
    closeAsesoriaFamiliarDialog() {
      this.resetAsesoriaFamiliarEdited();
      this.asesoria_familiar_dialog = false;
    },
    closeAsesoriaFamiliarDeleteDialog() {
      this.resetAsesoriaFamiliarEdited();
      this.asesoria_familiar_delete_dialog = false;
    },
    closeDetalleSolucionDialog() {
      this.detalle_solucion_dialog = false;
    },
    closeSolucionDialog() {
      this.resetSolucionEdited();
      this.solucion_dialog = false;
    },
    deleteAsesoriaFamiliar(item) {
      this.asesoria_familiar_delete_dialog = true;
      this.asesoria_familiar_edited = item;
    },
    dropAsesoriaFamiliar() {
      dropAsesoriaFamiliarFromApi(this.asesoria_familiar_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getPropuestaPic();
              this.asesoria_familiar_delete_dialog = false;
            } else {
              this.showMessage(response.data.message, "warning");
            }
          } else {
            this.showMessage(response.data.message, "warning");
          }
        })
        .catch((err) => console.error(err));
    },
    editAsesoriaFamiliar(item) {
      this.asesoria_familiar_edited_index = this.asesorias_familiares.indexOf(
        item
      );
      this.asesoria_familiar_edited = Object.assign({}, item);
      this.asesoria_familiar_dialog = true;
    },
    editSolucion(item) {
      this.solucion_edited_index = this.soluciones.indexOf(item);
      this.solucion_edited = Object.assign({}, item);
      this.solucion_dialog = true;
      var bit_estado_id = this.solucion_edited.bit_estado_id
      if (bit_estado_id==null){

      }
      else{
        getStatusEntidad(bit_estado_id)
          .then((response) => {
            if (response.data.type == "success") {
              this.solucion_estados_options = response.data.data
              this.solucion_edited.bit_estado_id = bit_estado_id
              this.solucion_edited.bit_estado_id = parseInt(this.solucion_edited.bit_estado_id)
            } else {
              this.showMessage(response.data.message, "warning");
            }
          })
          .catch((err) => console.error(err));  
      }
    },
    date2fecha(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    getMoneyFormat(number) {
      return moneyFormat(number);
    },
    getPropuestaPic() {
      getPropuestaPicFromApi(this.beneficiario_id).then((response) => {
        this.estados = response.data.data.estados;
        this.beneficiario = response.data.data.beneficiario;
        this.convocatoria = response.data.data.convocatoria;
        this.propuesta = response.data.data.propuesta;
        this.soluciones = response.data.data.soluciones;
        this.asesorias_familiares = response.data.data.asesorias_familiares;
        this.tipo_asesoria_options = response.data.data.tipo_asesoria_options;
        this.modalidad_asesoria_options = response.data.data.modalidad_asesoria_options;
        this.tematica_options = response.data.data.tematica_options;
        this.bit_estado_actual_diag_id = response.data.data.bit_estado_actual_diag_id;

        this.$emit("getData");
      });
    },
    getSolucionOptions() {
      getSolucionOptionsFromApi().then((response) => {
        this.solucion_options = response.data.data;
      });
    },
    goBack() {
      window.history.back();
    },
    resetAsesoriaFamiliarEdited() {
      this.asesoria_familiar_form_errors = [];
      this.asesoria_familiar_edited_index = -1;
      this.asesoria_familiar_edited = {
        propuesta_id: this.propuesta.id,
        asesoria_familiar_id: null,
        tipo_asesoria_id: null,
        solucion_id: null,
        tematica_id: null,
        fecha_planificada: null,
      };
    },
    resetSolucionEdited() {
      this.form_errors = [];
      this.detalle_solucion_option_selected = null;
      this.detalle_solucion_options_error = null;
      this.solucion_option_selected = null;
      this.solucion_edited_index = -1;
      this.solucion_edited = {
        descripcion: null,
        detalle_soluciones: [],
        monto_aporte_local: null,
        monto_aporte_mds: null,
        monto_aporte_otros: null,
        monto_aporte_total: null,
        problematica_social: false,
        propuesta_id: this.propuesta.id,
        propuesta_solucion_id: null,
        solucion: null,
        solucion_configuracion: null,
        solucion_id: null,
      };
      this.form_errors = [];
    },
    saveAsesoriaFamiliar() {
      this.asesoria_familiar_edited.convocatoria_id = this.convocatoria.id;

      saveAsesoriaFamiliarFromApi(this.asesoria_familiar_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getPropuestaPic();
              this.asesoria_familiar_dialog = false;
            } else {
              this.asesoria_familiar_form_errors = response.data.errors;
            }
          } else {
            this.showMessage(response.data.message, "warning");
            this.form_errors = response.data.errors;
          }
        })
        .catch((err) => console.error(err));
    },
    showAsesoriaFamiliarFormError(field) {
      try {
        if (
          typeof this.asesoria_familiar_form_errors[field] !== "undefined" ||
          this.asesoria_familiar_form_errors[field] !== ""
        ) {
          return this.asesoria_familiar_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },
    changeStatusPropuestaSolucion() {
      var status = this.solucion_edited.bit_estado_id
      var solucion_id = this.solucion_edited.propuesta_solucion_id
      if (this.solucion_edited.comentario == null){
        this.showMessage('Comentario esta vacío', "warning");
      }
      else{
        changeStatusPropuestaSolucionFromApi(status, solucion_id, this.solucion_edited.comentario)
        .then((response) => {
          this.getPropuestaPic();
        })
        .catch((err) => console.error(err));
      }

    },
    savePropuestaSolucion() {
      this.form_errors = {};
      // Validar solucion unica al agregar
      if (this.solucion_edited.propuesta_solucion_id == null) {
        for (let i = 0; i < this.soluciones.length; i++) {
          if (
            this.soluciones[i].solucion_id == this.solucion_edited.solucion_id
          ) {
            this.form_errors = {
              solucion_id: [
                "La solución seleccionada ya se encuentra agregada.",
              ],
            };
            return false;
          }
        }
      }
      this.solucion_edited.convocatoria_id = this.convocatoria.id;
      savePropuestaSolucionFromApi(this.solucion_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.getPropuestaPic();
              this.solucion_dialog = false;
            } else {
              this.form_errors = response.data.errors;
            }
          } else {
            this.showMessage(response.data.message, "warning");
            // this.form_errors = response.data.errors;
          }
        })
        .catch((err) => console.error(err));
    },
    showDetalleSolucionDialog() {
      if (this.solucion_edited.solucion_id > 0) {
        getDetalleSolucionOptionsFromApi(this.solucion_edited.solucion_id)
          .then((response) => {
            this.detalle_solucion_option_selected = null;
            this.detalle_solucion_options_error = null;
            this.detalle_solucion_options = response.data.data;
            this.detalle_solucion_dialog = true;
          })
          .catch((err) => console.error(err));
      } else {
        this.showMessage(
          "Debe seleccionar una solución para continuar",
          "warning"
        );
      }
      // if (this.solucion_edited.solucion_id == -1) {
      //   alert("Debe seleccionar una solución.");
      //   return false;
      // }
    },

    showFormError(field) {
      try {
        if (
          typeof this.form_errors[field] !== "undefined" ||
          this.form_errors[field] !== ""
        ) {
          return this.form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },

    toggleDetalleSolucion(index = null) {
      console.log(index);
      let vm = this;
      if (index == null) {
        if (vm.soluciones.length > 0) {
          let det_vis = vm.soluciones[0].detalle_visible;
          for (let index = 0; index < vm.soluciones.length; index++) {
            vm.soluciones[index].detalle_visible = !det_vis;
          }
        }
      } else {
        vm.soluciones[index].detalle_visible = !vm.soluciones[index]
          .detalle_visible;
      }
    },
    toogleDetalleAsesoriaFamiliar(id) {
      const index = this.asesoria_familiar_row.indexOf(id);
      if (index > -1) {
        this.asesoria_familiar_row.splice(index, 1);
      } else {
        this.asesoria_familiar_row.push(id);
      }
    },

    canAddSolucion() {
      if (this.hasPermission("add.sol.pic")) {
        var estado_id = this.convocatoria.bit_estado_actual_id;
        if (
            (estado_id == this.estados.CON_DIAGNOSTICO ||
            estado_id == this.estados.CON_PROPUESTAS_TECNICAS)
          ) {
            return true;
          }  
        }
      return false;
    },

    canEditStatusSolucion() {
      return this.hasPermission("sol.status.change")
    },
    
    canEditSolucion() {
      if (this.hasPermission("add.sol.pic")) {
        var estado_id = this.convocatoria.bit_estado_actual_id;
        if (
          estado_id == this.estados.CON_DIAGNOSTICO ||
          estado_id == this.estados.CON_PROPUESTAS_TECNICAS
        ) {
          return true;
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