<template>
  <section>
    <v-sheet elevation="0">
      <v-slide-group v-model="images" center-active show-arrows>
        <v-slide-item v-for="image in images">
          <v-card elevation="0" class="ma-0 pa-0">
            <v-btn
              title="Descagar imagen"
              class="ma-1 pa-1 white--text medios-carousel-btn-download"
              elevation="0"
              x-small
              @click="downloadImage(image.id,category)"
              color="blue-grey"
              fab
            >
              <v-icon small dark>mdi-file-download</v-icon>
            </v-btn>
            <v-card
              elevation="1"
              :title="image.original_name"
              class="ma-4 grey lighten-5"
              width="345"
              @click="showCarouselDialog(image.url)"
            >
              <v-img class="medios-carousel-item-img" :src="image.url"></v-img>
              <v-card-text class="pa-2">
                <div class="subtitle-3 text--secondary">{{image.original_name}}</div>
              </v-card-text>
            </v-card>
          </v-card>
        </v-slide-item>
      </v-slide-group>
    </v-sheet>
    <v-dialog v-model="carousel_dialog" width="80%">
      <v-card>
        <v-img :src="carousel_dialog_img"></v-img>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="closeCarouselDialog">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import {
  _download,
  _download_image,
  downloadEjecucionPropuestaPhotoFromApi,
} from "../api/ejecucionPropuestas";
import { getFilename } from "../services/util";

export default {
  name: "MediosSlide",
  data() {
    return {
      carousel_dialog: false,
      carousel_dialog_img: null,
      carousel_key: 0,
    };
  },
  props: ["images", "category"],
  methods: {
    downloadImage(id, category) {
      if (category == "soluciones") {
        downloadEjecucionPropuestaPhotoFromApi(id, category)
          .then((response) => {
            let fileURL = window.URL.createObjectURL(new Blob([response.data]));
            let fileLink = document.createElement("a");
            fileLink.href = fileURL;
            fileLink.setAttribute("download", getFilename(response));
            document.body.appendChild(fileLink);
            fileLink.click();
          })
          .catch((err) => {
            console.error(err);
            this.showMessage("Error al intentar descargar la imagen.", "error");
          });
      } else {
        _download_image(id, category)
          .then((response) => {
            let fileURL = window.URL.createObjectURL(new Blob([response.data]));
            let fileLink = document.createElement("a");
            fileLink.href = fileURL;
            fileLink.setAttribute("download", getFilename(response));
            document.body.appendChild(fileLink);
            fileLink.click();
          })
          .catch((err) => {
            console.error(err);
            this.showMessage("Error al intentar descargar la imagen.", "error");
          });
      }
    },
    showCarouselDialog(img) {
      this.carousel_dialog = true;
      this.carousel_dialog_img = img;
    },
    closeCarouselDialog(img) {
      this.carousel_dialog = false;
      this.carousel_dialog_img = null;
    },
  },
};
</script>

<style scoped>
.medios-carousel-item-img {
  height: 250px;
  object-fit: cover;
}

.medios-carousel-btn-download {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 999999;
}
</style>