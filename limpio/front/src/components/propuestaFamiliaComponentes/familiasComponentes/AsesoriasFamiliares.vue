<template>
  <section>
    <div class="table-hover-none">
      <v-simple-table dense>
        <thead>
          <tr class="green lighten-4">
            <!-- <th>
              <v-checkbox color="success"></v-checkbox>
            </th>-->
            <th class="nowrap">
              <v-btn
                :disabled="!canAddAsesoriaFamiliar()"
                text
                small
                icon
                title="Agregar asesoría familiar"
                @click="addAsesoriaFamiliar()"
              >
                <v-icon>mdi-tooltip-plus-outline</v-icon>
              </v-btn>
              <!--               <v-btn
                :disabled="asesorias_familiares.length==0"
                text
                small
                icon
                @click="toggleDetalleAsesoriaFamiliar()"
              >
                <v-icon
                  title="Mostrar detalles"
                  v-show="(asesorias_familiares.length==0) ? true:!asesorias_familiares[0].detalle_visible"
                >mdi-plus-box-outline</v-icon>
                <v-icon
                  title="Ocultar detalles"
                  v-show="(asesorias_familiares.length==0) ? false:asesorias_familiares[0].detalle_visible"
                >mdi-minus-box-outline</v-icon>
              </v-btn>-->
            </th>
            <th>N°</th>
            <th class="nowrap">Estado</th>
            <th class="nowrap">Modalidad</th>
            <th class="nowrap">Tipo de asesoría</th>
            <th class="nowrap">Soluciones</th>
            <th class="text-left no-wrap">Comentarios</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(item,index) in asesorias_familiares">
            <tr v-bind:key="item.propuesta_asesoria_id">
              <!-- <td>
              <v-checkbox color="success"></v-checkbox>
              </td>-->
              <td class="nowrap" style="width:130px !important;">
                <v-btn
                  :disabled="!canEditAsesoriaFamiliar()"
                  text
                  small
                  icon
                  title="Editar asesoría"
                  @click="editAsesoriaFamiliar(item)"
                >
                  <v-icon>mdi-file-document-edit-outline</v-icon>
                </v-btn>
                <v-btn
                  text
                  small
                  icon
                  title="Agregar un comentario"
                  @click="openAseFamGrupAddComDialog(item)"
                >
                  <v-icon>mdi-comment-edit-outline</v-icon>
                </v-btn>
                <v-btn
                  text
                  small
                  icon
                  title="Agregar medio de verificación"
                  @click="openAseFamGrupAddComDialogPhotos(item.photos, item)"
                  :disabled="!hasPermission('upload.ima.ase')"
                >
                  <v-icon>mdi-tooltip-image-outline</v-icon>
                </v-btn>
                <v-btn
                  text
                  small
                  icon
                  v-show="!asesorias_familiares[index].detalle_visible"
                  @click="asesorias_familiares[index].detalle_visible = true; asesoria_familiar_dialog = true; asesoria_familiar_dialog = false"
                >
                  <v-icon title="Mostrar detalles">mdi-plus-box-outline</v-icon>
                </v-btn>
                <v-btn
                  text
                  small
                  icon
                  @click="asesorias_familiares[index].detalle_visible=false; asesoria_familiar_dialog = true; asesoria_familiar_dialog = false"
                  v-show="asesorias_familiares[index].detalle_visible"
                >
                  <v-icon title="Ocultar detalles">mdi-minus-box-outline</v-icon>
                </v-btn>
              </td>
              <td>{{( index + 1)}}</td>
              <td>
                <a
                  @click="showBitacoraDialog({
                id: item.propuesta_asesoria_id,
                tipo_entidad_id: item.tipo_entidad_id
                })"
                >{{item.bit_estado}}</a>
              </td>
              <td>{{ item.modalidad_asesoria }}</td>
              <td>{{ item.tipo_asesoria}}</td>
              <td>
                <div v-for="item_solucion in item.soluciones" :key="item_solucion.solucion">
                  <div :style="item_solucion.configuracion">{{item_solucion.solucion}}</div>
                </div>
              </td>
              <td>
                <i v-if="item.comentario===null">Aún sin comentarios</i>
                <div v-if="item.comentario!==null">
                  <div class="my-1">{{ item.comentario.comentario }}</div>
                  <div class="text--secondary mb-1" title="Usuario, Fecha y hora de creación">
                    {{ item.comentario.user_nombre }}
                    <br />
                    {{ date2fecha(item.comentario.fecha_creacion) }} - {{ item.comentario.hora_creacion }}
                  </div>
                  <a @click="openAseFamGrupComentariosDialog(item)">Ver más</a>
                </div>
              </td>
            </tr>
            <tr
              v-model="asesorias_familiares[index].detalle_visible"
              v-if="asesorias_familiares[index].detalle_visible"
            >
              <td colspan="7">
                <div class="row">
                  <div class="col-sm-1" title="Descripción"></div>
                  <div class="nowrap col-sm-3" title="Descripción">
                    <strong>Actividades principales:</strong>
                    <br />
                    {{item.actividades}}
                  </div>
                  <div class="nowrap col-sm-4">
                    <strong>Temática a tratar</strong>
                    <br />
                    <div v-for="item_tematica in item.tematicas" :key="item_tematica.tematica">
                      <div>{{item_tematica.tematica}}</div>
                    </div>
                  </div>
                  <div class="nowrap col-sm-2">
                    <strong>Objetivos</strong>
                    <br />
                    <div>{{item.objetivos}}</div>
                  </div>
                  <div class="nowrap text-right col-sm-2">
                    <strong>Fecha planificada</strong>
                    <br />
                    {{ date2fecha(item.fecha_planificada) }}
                    <div>{{item.hora_planificada}}</div>
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </v-simple-table>
    </div>
    <v-dialog v-model="asesoria_familiar_dialog" width="98%">
      <v-card>
        <v-card-title>
          <span>{{ asesoriaFamiliarDialogTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-row class="pa-0 ma-0">
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-select
                  v-show="asesoria_familiar_edited.asesoria_familiar_id !== null && canEditStatusAsesoriaFamiliar()"
                  v-model="asesoria_familiar_edited.bit_estado_id"
                  :error-messages="this.showFormError('tipo_asesoria_id')"
                  :items="asesorias_estados_options"
                  label="Estado Asesoría"
                  item-text="estado"
                  item-value="id"
                  @change="openConvDialog()"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" class="py-0 my-0">
                <v-select
                  v-model="asesoria_familiar_edited.tipo_asesoria_id"
                  :error-messages="this.showAsesoriaFamiliarFormError('tipo_asesoria_id')"
                  :items="tipo_asesoria_options"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Tipo de asesoría"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" class="py-0 my-0">
                <v-select
                  v-model="asesoria_familiar_edited.modalidad_asesoria_id"
                  :error-messages="this.showAsesoriaFamiliarFormError('modalidad_asesoria_id')"
                  :items="modalidad_asesoria_options"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Modalidad"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" class="py-0 my-0">
                <v-select
                  v-model="asesoria_familiar_edited.solucion_id"
                  :error-messages="this.showAsesoriaFamiliarFormError('solucion_id')"
                  :items="solucion_options"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Soluciones"
                  multiple
                ></v-select>
              </v-col>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-text-field
                  v-model="asesoria_familiar_edited.objetivos"
                  :error-messages="this.showAsesoriaFamiliarFormError('objetivos')"
                  label="Objetivos"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-text-field
                  v-model="asesoria_familiar_edited.actividades"
                  :error-messages="this.showAsesoriaFamiliarFormError('actividades')"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  label="Actividades principales"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-select
                  v-model="asesoria_familiar_edited.tematica_id"
                  :error-messages="this.showAsesoriaFamiliarFormError('tematica_id')"
                  :items="tematica_options"
                  :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                  class="mb-1"
                  label="Temáticas a tratar"
                  multiple
                ></v-select>
              </v-col>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-menu
                  offset-y
                  v-model="asesoria_familiar_datepicker"
                  max-width="290px"
                  min-width="290px"
                  transition="scale-transition"
                  :close-on-content-click="false"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                      v-model="asesoriaFamiliarDateFormatted"
                      label="Fecha planificada"
                      persistent-hint
                      append-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :error-messages="showAsesoriaFamiliarFormError('fecha_planificada')"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    no-title
                    v-model="asesoria_familiar_edited.fecha_planificada"
                    locale="es-cl"
                    @input="asesoria_familiar_datepicker = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" md="12" class="py-0 my-0">
                <v-menu
                  ref="menu_hora_planificada"
                  v-model="asesoria_familiar_timepicker"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="asesoria_familiar_edited.hora_planificada"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
                      v-model="asesoria_familiar_edited.hora_planificada"
                      label="Hora planificada"
                      append-icon="mdi-clock"
                      readonly
                      v-on="on"
                      :error-messages="showAsesoriaFamiliarFormError('hora_planificada')"
                    />
                  </template>
                  <v-time-picker
                    v-if="asesoria_familiar_timepicker"
                    v-model="asesoria_familiar_edited.hora_planificada"
                    full-width
                    @click:minute="$refs.menu_hora_planificada.save(asesoria_familiar_edited.hora_planificada)"
                  />
                </v-menu>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeAsesoriaFamiliarDialog">Cancelar</v-btn>
          <v-btn
            :disabled="(convocatoria.bit_estado_actual_id==getBitEstado('CON_PIC_APROBADO'))"
            @click="saveAsesoriaFamiliar()"
          >Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-if="canDeleteAsesoriaFamiliar()"
      v-model="asesoria_familiar_delete_dialog"
      max-width="60%"
      persistent
    >
      <v-card>
        <v-card-title class="headline">¿Está seguro que desea eliminar la asesoría?</v-card-title>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeAsesoriaFamiliarDeleteDialog">No</v-btn>
          <v-btn @click="dropAsesoriaFamiliar()">Sí</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- <v-row class="pt-2 px-2">
      <v-col cols="6">
        <v-btn small v-show="asesorias_familiares.length > 0" color="primary">VISAR ASESORÍA</v-btn>
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small v-show="asesorias_familiares.length > 0" color="success">APROBAR ASESORÍA</v-btn>
      </v-col>
    </v-row>-->
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
            v-model="asesoria_familiar_edited.comentario"
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

    <v-dialog v-model="ase_fam_grup_comentarios_dialog">
      <v-card>
        <v-card-title>
          <span>Comentarios en Asesoría</span>
        </v-card-title>
        <v-card-text>
          <v-simple-table dense>
            <thead>
              <tr>
                <th>Tipo de Asesoría</th>
                <th>Modalidad</th>
                <th>Estado</th>
                <th class="text-right">Fecha planificada</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ ase_fam_grup_comentarios_item.tipo_asesoria }}</td>
                <td>{{ ase_fam_grup_comentarios_item.modalidad_asesoria }}</td>
                <td>{{ (ase_fam_grup_comentarios_item.bit_estado) ? ase_fam_grup_comentarios_item.bit_estado.estado : '' }}</td>
                <td class="text-right">
                  {{ date2fecha(ase_fam_grup_comentarios_item.fecha_planificada) }}
                  <br />
                </td>
              </tr>
            </tbody>
          </v-simple-table>
          <v-simple-table dense class="mt-4">
            <thead>
              <tr>
                <th>N</th>
                <th>Comentario</th>
                <th>Usuario</th>
                <th class="text-right">Fecha</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(item,index) in ase_fam_grup_comentarios">
                <tr v-bind:key="item.id">
                  <td>{{ (index+1) }}</td>
                  <td style="width:60% !important;">{{ item.comentario }}</td>
                  <td>{{ item.user_nombre }}</td>
                  <td class="text-right">
                    {{ item.fecha_creacion }}
                    <br />
                    {{ item.hora_creacion }}
                  </td>
                </tr>
              </template>
            </tbody>
          </v-simple-table>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="closeAseFamGrupComentariosDialog">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="ase_fam_grup_estado_dialog_photos">
      <v-card>
        <v-card-title>
          <span>Medio de verificación en asesoría</span>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="3">
              <v-text-field v-model="ase_fam_grup_edited.tipo_asesoria" label="Asesoría" disabled></v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="ase_fam_grup_edited.modalidad_asesoria"
                label="Modalidad"
                disabled
              ></v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field v-model="ase_fam_grup_edited.grupo" label="Grupo etario" disabled></v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field v-model="ase_fam_grup_edited.bit_estado.estado" label="Estado" disabled></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-file-input
                label="Ingresar medio de verificación"
                outlined
                dense
                hide-details
                @change="Photo_Change"
                accept=".png, .jpg, .jpeg"
              />
            </v-col>
            <v-col cols="6">
              <v-btn v-show="!!(Photo)" @click="uploadPhoto()">Subir</v-btn>
            </v-col>
            <v-col cols="12">
              <medios-slide :images="photos" category="photos"></medios-slide>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="ase_fam_grup_estado_dialog_photos = false">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="ase_fam_grup_add_com_dialog" max-width="700">
      <v-card>
        <v-card-title>
          <span>Agregar comentario</span>
        </v-card-title>
        <v-card-text>
          <v-simple-table v-if="ase_fam_grup_edited" class="mb-6">
            <thead>
              <tr>
                <th>Tipo de Aesoría</th>
                <th>Estado</th>
                <th class="text-right">Fecha planificada</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ ase_fam_grup_edited.tipo_asesoria }}</td>
                <td>...</td>
                <td class="text-right">
                  <div>{{ date2fecha(ase_fam_grup_edited.fecha_planificada) }}</div>
                  <div>{{ ase_fam_grup_edited.hora_planificada }}</div>
                </td>
              </tr>
            </tbody>
          </v-simple-table>
          <v-text-field
            auto-grow
            counter
            rows="2"
            name="comentario"
            label="Comentario"
            v-model="ase_fam_grup_com_edited.comentario"
            :error-messages="this.showAseFamGrupComentarioFormError('comentario')"
          ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" @click="closeAseFamGrupAddComDialog()">Cancelar</v-btn>
          <v-btn @click="saveAseFamGrupComentario(ase_fam_grup_com_edited)">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialogo Desestimar familia -->
    <v-dialog persistent v-model="dialog_desestimar" scrollable max-width="550">
      <v-card>
        <v-card-title>Desestimar Asesoría Familiar</v-card-title>
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
  changeStatusAsesoriasFromApi,
  getStatusEntidad,
} from "../../../api/propuesta";

import {
  habilitarBeneficiarioFromApi,
  getMotivosParaDesestimarFromApi,
  desestimarBeneficiarioFromApi,
  setVisadoByConvocatoria,
  getBeneficiariosFromApi,
} from "../../../api/propuestaFamilia";

import {
  getFamiliasFromApi,
  getAsesoriasGrupalesFromApi,
  getByBeneficiarioFromApi,
  saveAseFamComentarioFromApi,
  getAseFamComentariosFromApi,
  saveAseFamGrupComentarioFromApi,
  getAseFamGrupComentariosFromApi,
  saveSolFamComentarioFromApi,
  getSolFamComentariosFromApi,
  saveEstadoSol,
  saveEstadoAse,
  getEstadoOptionsFromApi,
  Photo,
  download,
  _mostrar_photos,
} from "../../../api/ejecucionPropuestas";

import MediosSlide from "../../../components/MediosSlide";
import { getFilename, moneyFormat } from "../../../services/util";
import { VMoney } from "v-money";
import BitacoraDialog from "../../BitacoraDialog.vue";

export default {
  components: {
    BitacoraDialog,
    MediosSlide,
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
      propuesta: null,
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
      estados: [],
      asesorias_estados_options: [],

      convDialog: false,
      convDialog_edited: [],

      motivos_desestimar: [],
      motivo_seleccionado: "",
      motivo_otro: "",
      motivo_otro_show: false,

      dialog_desestimar: false,

      bit_estado_actual_diag_id: false,

      // Comentarios en Asesoría Grupal
      ase_fam_grup_add_com_dialog: false,
      ase_fam_grup_lis_com_dialog: false,
      ase_fam_grup_com_edited: this.emptyAseFamGrupComentario(),
      ase_fam_grup_edited: this.emptyAseFamGrupEdited(),
      ase_fam_grup_comentario_form_errors: [],
      ase_fam_grup_comentarios: [],
      ase_fam_grup_comentarios_item: [],
      ase_fam_grup_comentarios_dialog: false,
      ase_fam_grup_estado_dialog: false,
      ase_fam_grup_estado_text: null,
      ase_fam_grup_estado_pro_sol_id: null,
      ase_fam_grup_estado_option: null,

      // Comentarios en Asesoría Grupal
      ase_fam_grup_estado_dialog_photos: false,
      ase_fam_grup_photos_edited: false,
      ase_fam_grup_photos_comentario_form_errors: [],
      ase_fam_grup_photos_com_edited: false,

      Photo: null,
      photos: [],
      fileURL_planos: null,
      fileURL_photo: null,
      fileURL_plano_viv: null,
      photo_data: {
        filename: null,
        disk: null,
        original_name: null,
        size: null,
        mime_type: null,
      },
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
    closeAseFamGrupComentariosDialog() {
      this.ase_fam_grup_comentarios_dialog = false;
    },

    Photo_Change(file) {
      this.Photo = file;
      this.fileURL_photo = window.URL.createObjectURL(file);
      this.photo_data.filename = file.name;
      this.photo_data.disk = "local";
      this.photo_data.original_name = file.name;
      this.photo_data.size = file.size;
      this.photo_data.mime_type = this.photo_data.type == "" ? "." : file.type;
    },

    uploadPhoto() {
      var compId = this.ase_fam_grup_photos_edited.pro_ase_id;
      Photo(compId, this.Photo, this.photo_data)
        .then((response) => {
          this.Photo = null;
          this.fileURL_photo = null;
          this.photos = response.data.data;
          let { message, type } = response.data;
          this.showMessage(message, type);
          this.getPropuestaPic();
        })
        .catch(() => {
          this.showMessage(
            "Ha ocurrido un error subiendo el archivo, intente de nuevo.",
            "error"
          );
        });
    },

    getFoto(id) {
      _mostrar_photos(id)
        .then((response) => {
          this.fileURL = window.URL.createObjectURL(new Blob([response.data]));
        })
        .catch((err) => console.error(err));
      return this.fileURL;
    },

    download(Id) {
      _download(Id)
        .then((response) => {
          let fileURL = window.URL.createObjectURL(new Blob([response.data]));
          let fileLink = document.createElement("a");
          fileLink.href = fileURL;

          fileLink.setAttribute("download", getFilename(response));
          document.body.appendChild(fileLink);
          fileLink.click();
        })
        .catch((err) => console.error(err));
    },

    openAseFamGrupComentariosDialog(item) {
      getAseFamGrupComentariosFromApi(item.propuesta_asesoria_id).then(
        (response) => {
          if (response.data.code == 200) {
            this.ase_fam_grup_comentarios = response.data.data;
            this.ase_fam_grup_comentarios_item = item;
            this.ase_fam_grup_comentarios_dialog = true;
          } else {
            this.showMessage(response.data.message, "warning");
          }
        }
      );
    },
    closeAseFamGrupAddComDialog() {
      this.ase_fam_grup_add_com_dialog = false;
      this.ase_fam_grup_edited = this.emptyAseFamGrupEdited();
      this.ase_fam_grup_com_edited = this.emptyAseFamGrupComentario();
    },
    saveAseFamGrupComentario() {
      saveAseFamGrupComentarioFromApi(this.ase_fam_grup_com_edited)
        .then((response) => {
          if (response.data.type == "success") {
            if (response.data.code == 200) {
              this.closeAseFamGrupAddComDialog();
              this.getPropuestaPic();
            } else {
              this.ase_fam_grup_comentario_form_errors = response.data.errors;
            }
          } else {
            this.showMessage(response.data.message, "warning");
            this.ase_fam_grup_comentario_form_errors = [];
          }
        })
        .catch((err) => console.error(err));
    },

    showAseFamGrupComentarioFormError(field) {
      try {
        if (
          typeof this.ase_fam_grup_comentario_form_errors[field] !==
            "undefined" ||
          this.ase_fam_grup_comentario_form_errors[field] !== "" ||
          this.ase_fam_grup_comentario_form_errors[field] !== null
        ) {
          return this.ase_fam_grup_comentario_form_errors[field][0];
        }
      } catch (e) {
        return "";
      }
    },

    emptyAseFamGrupComentario() {
      return {
        pro_ase_id: null,
        comentario: null,
        user_id: this.getUser().id,
      };
    },
    emptyAseFamGrupEdited() {
      return {
        actividades: null,
        bit_estado: {
          estado: "",
        },
        bit_estado_actual_id: null,
        comentario: null,
        entidad: null,
        fecha_planificada: null,
        grupo: null,
        grupo_id: null,
        modalidad_asesoria: null,
        modalidad_asesoria_id: null,
        num_personas: null,
        photos: [],
        pro_ase_id: null,
        propuesta_asesoria_id: null,
        propuesta_familia_id: null,
        propuesta_familias: null,
        solucion_id: [],
        soluciones: [],
        tematica_id: [],
        tematicas: [],
        tipo_asesoria: null,
        tipo_asesoria_id: null,
      };
    },

    openAseFamGrupAddComDialog(item) {
      this.ase_fam_grup_add_com_dialog = true;
      this.ase_fam_grup_edited = item;
      this.ase_fam_grup_comentario_form_errors = [];
      this.ase_fam_grup_com_edited = this.emptyAseFamGrupComentario();
      this.ase_fam_grup_com_edited.pro_ase_id = item.propuesta_asesoria_id;
    },

    openAseFamGrupAddComDialogPhotos(photos, item) {
      this.ase_fam_grup_edited = item;
      this.ase_fam_grup_estado_dialog_photos = true;
      this.ase_fam_grup_photos_edited = item;
      this.photos = photos;

      this.ase_fam_grup_photos_comentario_form_errors = [];
      this.ase_fam_grup_photos_com_edited = this.emptyAseFamGrupComentario();
      this.ase_fam_grup_photos_edited.pro_ase_id = item.propuesta_asesoria_id;
    },

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
      this.asesoria_familiar_edited.comentario = motivo;
      this.closeDialogDesestimar();
      this.changeStatusAsesorias();
    },
    openConvDialog() {
      let estado_id = this.asesoria_familiar_edited.bit_estado_id;
      if (estado_id != this.estados.ASE_DES) this.convDialog = true;
      else this.openDialogDesestimar();
    },

    showBitacoraDialog(item) {
      this.$refs.bitacoraDialog.open(item);
    },

    addAsesoriaFamiliar() {
      var estado_diag = this.beneficiario.bit_estado_actual_diag_id;
      if (
        estado_diag == this.getBitEstado("FAM_DIA_DES") ||
        estado_diag == this.getBitEstado("FAM_DIA_FIN") ||
        estado_diag == this.getBitEstado("FAM_DIA_VIS")
      ) {
        this.resetAsesoriaFamiliarEdited();
        this.asesoria_familiar_dialog = true;
      } else {
        this.showMessage("No tiene privilegios para crear asesoria", "warning");
      }
    },

    addSolucion() {
      this.resetSolucionEdited();
      this.solucion_dialog = true;
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
      this.asesoria_familiar_edited.comentario = "";
      var bit_estado_id = this.asesoria_familiar_edited.bit_estado_id;
      if (bit_estado_id == null) {
      } else {
        getStatusEntidad(bit_estado_id)
          .then((response) => {
            if (response.data.type == "success") {
              this.asesorias_estados_options = response.data.data;
              this.asesoria_familiar_edited.bit_estado_id = bit_estado_id;
              this.asesoria_familiar_edited.bit_estado_id = parseInt(
                this.asesoria_familiar_edited.bit_estado_id
              );
            } else {
              this.showMessage(response.data.message, "warning");
            }
          })
          .catch((err) => console.error(err));
      }
    },
    editSolucion(item) {
      this.solucion_edited_index = this.soluciones.indexOf(item);
      this.solucion_edited = Object.assign({}, item);
      this.solucion_dialog = true;
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
        this.modalidad_asesoria_options =
          response.data.data.modalidad_asesoria_options;
        this.tematica_options = response.data.data.tematica_options;
        this.bit_estado_actual_diag_id =
          response.data.data.bit_estado_actual_diag_id;

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
      var status = this.asesoria_familiar_edited.bit_estado_id;
      var solucion_id = this.asesoria_familiar_edited.propuesta_asesoria_id;
      if (this.asesoria_familiar_edited.comentario == null) {
        this.showMessage("Comentario esta vacío", "warning");
      } else {
        changeStatusAsesoriasFromApi(
          status,
          solucion_id,
          this.asesoria_familiar_edited.comentario
        )
          .then((response) => {
            this.getPropuestaPic();
            this.closeAsesoriaFamiliarDialog();
          })
          .catch((err) => console.error(err));
      }
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
    toogleDetalleAsesoriaFamiliar(id) {
      const index = this.asesoria_familiar_row.indexOf(id);
      if (index > -1) {
        this.asesoria_familiar_row.splice(index, 1);
      } else {
        this.asesoria_familiar_row.push(id);
      }
    },
    toggleDetalleAsesoriaFamiliar(index = null) {
      let vm = this;
      if (index == null) {
        if (vm.asesorias_familiares.length > 0) {
          let det_vis = vm.asesorias_familiares[0].detalle_visible;
          //alert(det_vis);
          for (let index = 0; index < vm.asesorias_familiares.length; index++) {
            vm.asesorias_familiares[index].detalle_visible = !det_vis;
          }
        }
      } else {
        if (vm.asesorias_familiares[index].detalle_visible)
          vm.asesorias_familiares[index].detalle_visible = false;
        else vm.asesorias_familiares[index].detalle_visible = true;
        console.log(vm.asesorias_familiares[index].detalle_visible);
      }
      //alert(vm.asesorias_familiares[index].detalle_visible)
    },
    canAddAsesoriaFamiliar() {
      if (this.hasPermission("add.ase.fam.pic")) {
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
    canEditAsesoriaFamiliar() {
      if (this.hasPermission("edt.ase.fam.pic")) {
        var estado_id = this.convocatoria.bit_estado_actual_id;
        if (
          estado_id == this.estados.CON_DIAGNOSTICO ||
          estado_id == this.estados.CON_PROPUESTAS_TECNICAS ||
          estado_id == this.estados.CON_PIC_APROBADO
        ) {
          return true;
        }
      }
      return false;
    },

    canEditStatusAsesoriaFamiliar() {
      return this.hasPermission("ase.status.change");
    },

    canDeleteAsesoriaFamiliar() {
      if (this.hasPermission("del.ase.fam.pic")) {
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