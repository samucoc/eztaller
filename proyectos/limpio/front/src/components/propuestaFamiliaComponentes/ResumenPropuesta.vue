<template>
  <section>
    <v-simple-table>
      <thead>
        <tr>
          <th>Familias Estimadas</th>
          <th>Nº Familias Comprometidas</th>
          <th>Nº Asesorías</th>
          <th>Nº Soluciones</th>
          <th>% Cobertura</th>
          <th class="text-right">$ Aporte Total</th>
          <th class="text-right">$ Aporte MDS</th>
          <th class="text-right">$ Aporte Local</th>
          <th class="text-right">$ Otros Aportes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>0</td>
          <td>0</td>
          <td>0</td>
          <td>0</td>
          <td>0</td>
          <td class="text-right">0</td>
          <td class="text-right">0</td>
          <td class="text-right">0</td>
          <td class="text-right">0</td>
        </tr>
      </tbody>
    </v-simple-table>
    <v-row class="pt-2 px-2">
      <v-col cols="6">
        <v-btn small color="primary">VISAR SOLUCIONES</v-btn>
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small color="success">APROBAR SOLUCIONES</v-btn>
      </v-col>
      <v-col cols="6">
        <v-btn small color="primary">VISAR ASESORÍAS</v-btn>
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small color="success">APROBAR ASESORÍAS</v-btn>
      </v-col>
      <v-col cols="6">
      </v-col>
      <v-col cols="6" class="text-right">
        <v-btn small color="success">APROBAR PROPUESTA</v-btn>
      </v-col>
    </v-row>
  </section>
</template>

<script>
// import { getBitacoraFromApi } from "../api/bitacora";
// import { _download,
//          _download_image,
//        } from "../api/ejecucionPropuestas";
// import { getFilename } from "../services/util";

export default {
  name: "ResumenPropuesta",
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>