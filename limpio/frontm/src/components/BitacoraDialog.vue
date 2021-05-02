<template>
  <section>
    <v-dialog v-model="show_dialog" width="80%">
      <v-card>
        <v-card-title>{{ title }}</v-card-title>
        <v-card-text>
          <v-simple-table>
            <thead>
              <tr>
                <th>Estado</th>
                <th>Fecha inicio</th>
                <th>Fecha término</th>
                <th>Auto / Manual</th>
                <th style="width:400px;">Comentario</th>
                <th>Usuario</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="item in data">
                <tr v-bind:key="item.id">
                  <td>{{ item.estado }}</td>
                  <td>{{ item.fecha_inicio }}</td>
                  <td>{{ item.fecha_termino }}</td>
                  <td >{{ item.auto == '1' ? 'AUTO' : 'MANUAL' }}</td>
                  <td >{{ item.comentario }}</td>
                  <td>{{ item.usuario }}</td>
                </tr>
              </template>
            </tbody>
          </v-simple-table>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="close">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import { getBitacoraFromApi } from "../api/bitacora";
// import { _download,
//          _download_image,
//        } from "../api/ejecucionPropuestas";
// import { getFilename } from "../services/util";

export default {
  name: "BitacoraDialog",
  data() {
    return {
      item: null,
      title: "",
      show_dialog: false,
      data: [],
      data_comentario: false,
    };
  },
  mounted() {},
  methods: {
    open(item) {
      this.getBitacora(item);
    },
    close() {
      this.show_dialog = false;
    },
    getBitacora(item) {
      this.data_comentario = item.comentario;
      getBitacoraFromApi(item)
        .then((res) => {
          if (res.data.code == 200) {
            this.data = res.data.data;
            this.title = res.data.title;
            this.show_dialog = true;
          } else {
            alert("error");
          }
        })
        .catch((error) => {
          console.error(error);
          // Mensaje de error
        });
    },
  },
};
</script>

<style scoped>
/* .medios-carousel-item-img {
  height: 250px;
  object-fit: cover;
}

.medios-carousel-btn-download {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 999999;
} */
</style>