<template>
  <section>
    <v-simple-table>
      <thead>
        <tr class="blue lighten-4">
          <th>
            <div style="margin-left: 28px !important;">
              <v-btn
                :disabled="beneficiarios.length==0"
                text
                small
                icon
                @click="toggleDetalleFamilia()"
              >
                <v-icon
                  title="Mostrar detalles"
                  v-show="(beneficiarios.length==0) ? true:!beneficiarios[0].detalle_visible"
                >mdi-plus-box-outline</v-icon>
                <v-icon
                  title="Ocultar detalles"
                  v-show="(beneficiarios.length==0) ? false:beneficiarios[0].detalle_visible"
                >mdi-minus-box-outline</v-icon>
              </v-btn>
            </div>
          </th>
          <th>Id</th>
          <th>Estado</th>
          <th>RUN</th>
          <th>Nombre del representante</th>
          <!-- <th>Dirección</th> -->
          <th>Programa origen</th>
          <th>Teléfono</th>
          <th>Activo</th>
          <th>Nombre apoyo familiar</th>
          <th>Correo apoyo familiar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="beneficiarios.length == 0">
          <td colspan="20" class="text-center grey lighten-4">
            <strong>Sin información</strong>
          </td>
        </tr>
        <template v-for="(item, index) in beneficiarios">
          <tr :key="item.id">
            <td>
              <v-btn
                v-if="showBtnHabilitar(item.bit_estado_actual_id)"
                :disabled="!hasPermission('active.fam')"
                text
                small
                icon
                title="Habilitar familiar"
                color="green"
                @click="openDialogHabilitar(item)"
              >
                <v-icon>mdi-account-check-outline</v-icon>
              </v-btn>
              <v-btn
                v-if="showBtnDesestimar(item.bit_estado_actual_id)"
                :disabled="!hasPermission('cancel.fam')"
                text
                small
                icon
                title="Desestimar familiar"
                color="red"
                @click="openDialogDesestimar(item)"
              >
                <v-icon>mdi-account-cancel-outline</v-icon>
              </v-btn>
              <v-btn text small icon @click="toggleDetalleFamilia(index)">
                <v-icon
                  title="Mostrar detalles"
                  v-show="!beneficiarios[index].detalle_visible"
                >mdi-plus-box-outline</v-icon>
                <v-icon
                  title="Ocultar detalles"
                  v-show="beneficiarios[index].detalle_visible"
                >mdi-minus-box-outline</v-icon>
              </v-btn>
            </td>
            <td>{{ item.numero }}</td>
            <td>
              <a
                @click="showBitacoraDialog({
                        id:item.id,
                        tipo_entidad_id:4
                      })"
                title="Ver bitácora"
              >{{item.bit_estado_actual[0].estado}}</a>
            </td>
            <td>{{ item.rut_benef }}</td>
            <td>{{ item.nom_benef }}</td>
            <!-- <td>{{ item.direccion }}</td> -->
            <td>{{ item.nom_programa }}</td>
            <td>{{ item.telefono }}</td>
            <td>{{ item.activo }}</td>
            <td>{{ item.nom_apo_fam }}</td>
            <td>{{ item.email_apo_fam }}</td>
          </tr>
          <tr :key="'detalle_'+item.id" v-show="item.detalle_visible">
            <td colspan="20">
              <div style="margin-left:40px; margin-bottom:6px;">
                <v-expansion-panels multiple accordion>
                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      <div>
                        <v-badge
                          inline
                          color="blue"
                          :value="item.diagnosticos != null ? '1' : '0'"
                          :content="item.diagnosticos != null ? '1' : '0'"
                          @getData="$emit('getData')"
                        >Diagnóstico</v-badge>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-simple-table dense>
                        <thead>
                          <tr class="text-center red lighten-4">
                            <td>Acciones</td>
                            <td>Estado</td>
                            <td>Usuario</td>
                            <td>Fecha Inicio</td>
                            <td>Fecha Término</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="text-center">
                            <td>
                              <v-btn
                                :disabled="!showBtnDiagnosticar(item.bit_estado_actual_diag[0].id)"
                                depressed
                                x-small
                                color="primary"
                                title="Diagnosticar familia"
                                @click="openDialogDiagnosticar(item)"
                              >
                                <v-icon x-small title>mdi-pencil-outline</v-icon>
                              </v-btn>
                            </td>
                            <td>
                              <a
                                @click="showBitacoraDialog({
                                        id:item.id,
                                        tipo_entidad_id:6
                                      })"
                                title="Ver bitácora"
                              >{{item.bit_estado_actual_diag[0].estado}}</a>
                            </td>
                            <td>{{item.bitacora_diag[0].usuario}}</td>
                            <td>{{item.diag_fecha_inicio}}</td>
                            <td>{{item.diag_fecha_termino}}</td>
                          </tr>
                        </tbody>
                      </v-simple-table>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      <div>
                        <v-badge
                          inline
                          color="blue"
                          :value="item.soluciones.length"
                          :content="item.soluciones.length"
                          @getData="$emit('getData')"
                        >Soluciones</v-badge>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <soluciones :beneficiario_id="parseInt(item.id)"></soluciones>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      <div>
                        <v-badge
                          inline
                          color="blue"
                          :value="item.asesorias_familiares.length"
                          :content="item.asesorias_familiares.length"
                          @getData="$emit('getData')"
                        >Asesorías Familiares</v-badge>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <asesorias-familiares :beneficiario_id="parseInt(item.id)"></asesorias-familiares>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </v-simple-table>
    <!-- Dialogo Habilitar familia -->
    <v-dialog persistent v-model="dialog_habilitar" max-width="500">
      <v-card>
        <v-card-title>Habilitar Familia</v-card-title>
        <v-card-text class="text-center">
          <h3 class="py-10">¿Desea habilitar ésta familia?</h3>
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn small color="gray" @click="closeDialogHabilitar()">Cancelar</v-btn>
          <v-spacer />
          <v-btn small @click="habilitar()">Si, Habilitar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialogo Desestimar familia -->
    <v-dialog persistent v-model="dialog_desestimar" scrollable max-width="550">
      <v-card>
        <v-card-title>Desestimar Familia</v-card-title>
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
        <v-btn
          small
          v-show="beneficiarios.length > 0 && ifEnDiagnostico()"
          color="primary"
          @click="setVisadoByConvocatoria()"
        >VISAR FAMILIAS</v-btn>
      </v-col>
    </v-row>-->
    <diagnostico-visita-dialog ref="diagnostivoVisitaDialog" @getData="$emit('getData')"></diagnostico-visita-dialog>
    <!-- Bitacora -->
    <bitacora-dialog ref="bitacoraDialog"></bitacora-dialog>
  </section>
</template>

<script>
import AsesoriasFamiliares from "./familiasComponentes/AsesoriasFamiliares";
import Soluciones from "./familiasComponentes/Soluciones";
import Diagnosticos from "./familiasComponentes/Diagnosticos";
import {
  habilitarBeneficiarioFromApi,
  getMotivosParaDesestimarFromApi,
  desestimarBeneficiarioFromApi,
  setVisadoByConvocatoria,
  getBeneficiariosFromApi,
} from "../../api/propuestaFamilia";
import DiagnosticoVisitaDialog from "./familiasComponentes/DiagnosticoVisitaDialog.vue";
import BitacoraDialog from "../BitacoraDialog";

// import { getBitacoraFromApi } from "../api/bitacora";
// import { _download,
//          _download_image,
//        } from "../api/ejecucionPropuestas";

export default {
  name: "Familias",
  props: ["beneficiarios", "convocatoria"],
  components: {
    AsesoriasFamiliares,
    BitacoraDialog,
    DiagnosticoVisitaDialog,
    Soluciones,
    Diagnosticos,
  },
  data() {
    return {
      dialog_habilitar: false,
      dialog_desestimar: false,
      dialog_diagnostico_visita: false,

      familia: null,

      motivos_desestimar: [],
      motivo_seleccionado: "",
      motivo_otro: "",
      motivo_otro_show: false,
    };
  },
  mounted() {},
  methods: {
    toggleDetalleFamilia(index = null) {
      let vm = this;
      if (index == null) {
        if (vm.beneficiarios.length > 0) {
          let det_vis = vm.beneficiarios[0].detalle_visible;
          for (let index = 0; index < vm.beneficiarios.length; index++) {
            vm.beneficiarios[index].detalle_visible = !det_vis;
          }
        }
      } else {
        vm.beneficiarios[index].detalle_visible = !vm.beneficiarios[index]
          .detalle_visible;
      }
    },
    showBitacoraDialog(item) {
      this.$refs.bitacoraDialog.open(item);
    },

    showBtnHabilitar(bit_est_id) {
      return this.getBitEstado("FAM_DES") == bit_est_id;
    },
    showBtnDesestimar(bit_est_id) {
      let est = this.getUser().bit_estados;
      if (
        this.convocatoria.bit_estado_actual_id == est.CON_REGISTRO_FAMILIAS ||
        this.convocatoria.bit_estado_actual_id == est.CON_SELECCION_FAMILIAS ||
        this.convocatoria.bit_estado_actual_id == est.CON_DIAGNOSTICO ||
        this.convocatoria.bit_estado_actual_id == est.CON_PROPUESTAS_TECNICAS
      ) {
        if (bit_est_id == est.FAM_SEL) {
          return true;
        }
      }
      return false;
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
    openDialogHabilitar(item) {
      this.familia = item;
      this.dialog_habilitar = true;
    },
    closeDialogHabilitar() {
      this.familia = null;
      this.dialog_habilitar = false;
    },
    openDialogDesestimar(item) {
      // TODO: obtener motivos apra desestimar
      this.familia = item;
      this.getMotivosParaDesestimar();
    },
    closeDialogDesestimar() {
      this.motivo_seleccionado = "";
      this.motivo_otro = "";
      this.motivo_otro_show = false;
      this.familia = null;
      this.dialog_desestimar = false;
    },
    openDialogDiagnosticar(item) {
      this.familia = item;
      if (
        item.bit_estado_actual_diag_id == this.getBitEstado("FAM_DIA_NO_INI")
      ) {
        this.$refs.diagnostivoVisitaDialog.open(item);
      } else if (
        item.bit_estado_actual_diag_id == this.getBitEstado("FAM_DIA_DES") ||
        item.bit_estado_actual_diag_id == this.getBitEstado("FAM_DIA_FIN")
      ) {
        this.diagnosticar(this.familia.id);
      }
    },

    habilitar() {
      if (this.familia !== null) {
        habilitarBeneficiarioFromApi(
          this.familia.convocatoria_id,
          this.familia.id
        )
          .then((res) => {
            if (res.data.type == "success") {
              this.$emit("getData");
              this.closeDialogHabilitar();
              this.showMessage(res.data.message, res.data.type);
            }
          })
          .catch((err) => {
            this.closeDialogHabilitar();
            this.showMessage(
              "Error al intentar habilitar la familia.",
              "error"
            );
          });
      }
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
      desestimarBeneficiarioFromApi(
        this.familia.convocatoria_id,
        this.familia.id,
        motivo
      )
        .then((res) => {
          if (res.data.type == "success") {
            this.showMessage(
              "La familia ha sido desestimada con éxito.",
              res.data.type
            );
            this.$emit("getData");
            this.closeDialogDesestimar();
          } else {
            this.showMessage(res.data.error, "error");
          }
        })
        .catch((err) => {
          console.error(err);
          this.showMessage("Error al intentar desestimar la familia.", "error");
        });
    },
    setVisadoByConvocatoria() {
      if (this.beneficiarios[0].convocatoria_id == null) {
        this.beneficiarios = [];
      } else {
        setVisadoByConvocatoria(this.beneficiarios[0].convocatoria_id)
          .then((res) => {
            if (res.data.type == "success") {
              getBeneficiariosFromApi(this.beneficiarios[0].convocatoria_id)
                .then((res) => {
                  if (res.data.type == "success") {
                    this.$emit("getData_1");
                    let text = "Visado de familias está correcto.";
                    let type = res.data.type;
                    this.showMessage(text, type);
                  } else {
                    this.showMessage(res.data.message, "warning");
                  }
                })
                .catch((err) => {
                  this.showMessage(res.data.message, "warning");
                  console.error(err);
                });
            } else {
              this.showMessage(res.data.message, "warning");
            }
          })
          .catch((err) => {
            this.showMessage(res.data.message, "warning");
            console.error(err);
          });
      }
    },
    ifEnDiagnostico() {
      let convocatoria = this.convocatoria;
      let estado = parseInt(convocatoria.bit_estado_actual_id);
      if (estado == 3) {
        return true;
      } else {
        return false;
      }
    },
    diagnosticar(beneficiario_id) {
      // this.saveState();
      this.$router.push({
        name: "dfamilia",
        params: {
          id: beneficiario_id,
        },
      });
    },
  },
};
</script>