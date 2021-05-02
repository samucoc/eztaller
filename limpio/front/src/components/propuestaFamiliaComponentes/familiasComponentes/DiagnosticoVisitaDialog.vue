<template>
  <section>
    <v-dialog persistent v-model="show_dialog" max-width="700">
      <v-card>
        <v-card-title>Diagnosticar Familia</v-card-title>
        <v-card-text>
          <h4 class="mb-2">Registro de visita</h4>
          <v-form ref="diagnosticoVisitaForm" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-menu
                  v-model="show_datepicker"
                  ref="datepicker"
                  :close-on-content-click="false"
                  :return-value.sync="visita.fecha"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-on="on"
                      :value="date2fecha(visita.fecha)"
                      label="Fecha de la visita"
                      prepend-icon="mdi-calendar"
                      :rules="field_rules"
                      required
                      readonly
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="visita.fecha"
                    no-title
                    scrollable
                    locale="es"
                    first-day-of-week="1"
                  >
                    <v-btn small @click="show_datepicker = false">Cancelar</v-btn>
                    <v-spacer />
                    <v-btn small @click="$refs.datepicker.save(visita.fecha)">Aceptar</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-menu
                  ref="timepicker"
                  v-model="show_timepicker"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="visita.hora"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-on="on"
                      v-model="visita.hora"
                      label="Hora de la visita"
                      prepend-icon="mdi-clock"
                      :rules="field_rules"
                      required
                      readonly
                    ></v-text-field>
                  </template>
                  <v-time-picker
                    v-if="show_timepicker"
                    v-model="visita.hora"
                    full-width
                    @click:minute="$refs.timepicker.save(visita.hora)"
                  />
                </v-menu>
              </v-col>
              <v-col cols="12" sm="12" md="4">
                <span>
                  <label class="label-visita">¿Se realizó la visita?</label>
                  <v-radio-group
                    v-model="visita.visita"
                    row
                    class="radio-group ma-0 pa-0"
                    :rules="field_rules"
                    required
                  >
                    <v-radio label="Si" :value="1" />
                    <v-radio label="No" :value="2" />
                  </v-radio-group>
                </span>
              </v-col>
              <v-col cols="12" v-if="visita.visita === 2">
                <label
                  class="label-visita"
                >Seleccione un motivo por el cual no se realizó la visita:</label>
                <v-radio-group
                  class="mt-0"
                  v-model="motivo_seleccionado"
                  :rules="field_rules"
                  required
                >
                  <v-radio
                    v-for="item in motivos"
                    :key="item.id"
                    :label="`${item.nombre}`"
                    :value="`${item.nombre}`"
                    @change="selectMotivoNoVisita(item.nombre)"
                  />
                  <v-radio
                    label="Otro"
                    value="0"
                    :rules="field_rules"
                    required
                    @change="selectMotivoNoVisita(0)"
                  />
                </v-radio-group>
                <v-text-field
                  v-model="motivo_otro"
                  label="Escriba un motivo"
                  v-if="show_motivo_otro"
                  :rules="field_rules"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
          <v-row v-show="visitas.length">
            <v-col cols="12" class="pb-0">
              <h4 class>Registro de visita</h4>
            </v-col>
            <v-col cols="12">
              <v-data-table
                dense
                class="text-no-wrap"
                :headers="visitasHeader"
                :items="visitas"
                no-data-text="Sin datos que mostrar"
                item-key="id"
              >
                <template v-slot:item.estado="{item}">
                  <span v-if="item.visita === '1'">Exitoso</span>
                  <span v-else>Fallido</span>
                </template>

                <template v-slot:item.fecha="{item}">{{ date2fecha(item.fecha) }} {{item.hora}}</template>
              </v-data-table>
            </v-col>
          </v-row>
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn @click="close()">Cancelar</v-btn>
          <v-spacer />
          <v-btn @click="guardarVisita()">ACEPTAR</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import moment from "moment";
import { required } from "../../../services/rules";
import {
  getMotivosNoVisitaFromApi,
  getVisitasFromApi,
  guardarVisitaFromApi,
} from "../../../api/propuestaFamilia";

export default {
  name: "DiagnosticoVisitaDialog",
  data() {
    return {
      show_dialog: false,
      show_datepicker: false,
      show_timepicker: false,
      show_motivo_otro: false,

      motivo_seleccionado: "",
      motivo_otro: "",

      visita: this.emptyVisita(),
      visitas: [],
      visitasHeader: [
        { text: "Estado", value: "estado" },
        { text: "Fecha de visita", value: "fecha" },
        { text: "Motivo", value: "motivo_no_visita" },
        { text: "Usuario", value: "user.nombre" },
      ],
      field_rules: [required],
      motivos: [],
    };
  },
  mounted() {
    // TODO: Obtener los motivos
  },
  methods: {
    open(item) {
      this.visitas = [];
      this.visita = this.emptyVisita();
      this.motivo_seleccionado = "";
      this.motivo_otro = "";

      getVisitasFromApi(item.id)
        .then((res) => {
          if (res.data.type == "success") {
            this.visitas = res.data.data;
          } else {
            this.visitas = [];
          }
          getMotivosNoVisitaFromApi()
            .then((res) => {
              this.motivos = res.data.data;
              this.visita.beneficiario_id = item.id;
              this.show_dialog = true;
            })
            .catch((err) => {
              console.error(err);
              this.showMessage("Ha ocurrido un error.", "error");
            });
        })
        .catch((err) => {
          console.error(err);
          this.showMessage(
            "Ha ocurrido un error al intentar obtener las visitas de la familia.",
            "error"
          );
        });
    },
    close() {
      this.visita = this.emptyVisita();
      this.show_dialog = false;
    },

    emptyVisita() {
      return {
        visita: 0,
        fecha: moment().format("YYYY-MM-DD"),
        hora: moment().format("HH:mm"),
        motivo_no_visita: "",
        beneficiario_id: null,
      };
    },
    date2fecha(date) {
      let fecha = moment(date);
      return fecha.isValid() ? fecha.format("DD-MM-YYYY") : date;
    },

    selectMotivoNoVisita(item) {
      this.motivo_otro = "";
      this.show_motivo_otro = item == "0";
    },

    guardarVisita() {
      if (this.$refs.diagnosticoVisitaForm.validate()) {
        this.visita.motivo_no_visita =
          this.motivo_seleccionado == "0"
            ? this.motivo_otro
            : this.motivo_seleccionado;
        guardarVisitaFromApi(this.visita)
          .then((res) => {
            if (res.data.type == "success") {
              if (res.data.data.visita == 1) {
                this.diagnosticar(this.visita.beneficiario_id);
              } else {
                this.$emit("getBeneficiarios");
                this.close();
              }
            } else {
              this.showMessage(res.data.message, res.data.type);
            }
          })
          .catch((err) => {
            console.error(err);
            this.showMessage(
              "Error al intentar guardar la información.",
              "error"
            );
          });
      }
    },
    diagnosticar(familia_id) {
      this.saveState();
      this.$router.push({
        name: "dfamilia",
        params: {
          id: familia_id,
        },
      });
    },

    saveState() {
      this.$store.dispatch("list_data", this.$data).finally();
    },
  },
  computed: {},
};
</script>