<template>
  <v-app id="inspire" class="cMain">
    <header >
      
      <h1 class="titulo1">Capitalia</h1>
      <h2 class="titulo2">Prototipo</h2>
      <p class="titulo3">Versión v1.0</p>
    </header>
    <v-main class="cContent">
      <v-container class="fill-height" f  luid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Login</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    label="Usuario"
                    v-model="username"
                    name="username"
                    prepend-icon="mdi-account"
                    type="email"
                  />

                  <v-text-field
                    label="Contraseña"
                    v-model="password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                  />
                </v-form>
              </v-card-text>
              <v-alert type="warning" v-if="isError" dark transition="scale-transition" dismissible>
                <div>{{ responseMessage }}</div>
              </v-alert>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="login()">Acceder</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <footer class="titulo4 fondo">
      <div class="cBicolor">
        <span class="blue"></span>
        <span class="red"></span>
      </div>
      <p style="padding-top: 5px">
        Proydb - Viña del mar - Chile - 2021
        <a>Políticas de Privacidad</a> - <span class="text--disabled">Prototipo</span>
      </p>
    </footer>
  </v-app>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
      isError: false,
      responseMessage: "",
    };
  },
  methods: {
    login() {
      let { username, password } = this;
      this.$store
        .dispatch("login", { username, password })
        .then((res) => {
          if (typeof res.data.type !== "undefined") {
            this.isError = true;
            this.responseMessage = res.data.message;
            setTimeout(() => (this.isError = false), 10000);
          } else {
            this.$router.push("/");
          }
        })
        .catch((err) => {
          this.isError = true;
          this.responseMessage = "Ha ocurrido un error desconocido.";
          setTimeout(() => (this.isError = false), 10000);
        });
    },
    clearMessage() {
      this.isError = false;
    },
  },
};
</script>

<style scoped>
.fondo {
  background-color: white;
}
header.fondo {
  padding-left: 25px;
}
.titulo1 {
  font-family: "Titillium Web", sans-serif;
  position: relative;
  font-size: 28px;
  color: #2874a6;
}

.titulo2 {
  font-family: "Titillium Web", sans-serif;
  position: relative;
  font-size: 22px;
  color: #2874a6;
}

.titulo3 {
  font-family: "Titillium Web", sans-serif;
  position: relative;
  font-size: 15px;
  color: #2874a6;
}

.titulo4 {
  font-family: "Titillium Web", sans-serif;
  position: relative;
  font-size: 12px;
  color: #000000;
}
.ex1 {
  padding-left: 50px;
}

header .cBicolor {
  margin: 0px;
  width: 170px;
  height: 20px;
}

.cBicolor span {
  display: block;
  float: left;
  width: 50%;
  height: 100%;
}

.cBicolor span.sBlue {
  background: #0168b3;
}

.cBicolor span.sRed {
  background: #ee3a43;
}

.cMain {
  width: 80%;
  margin: auto;
}

.cContent {
  border-top-width: 2px;
  border-top-style: solid;
  border-top-color: #2762b8;
}
footer .cBicolor {
  height: 2px;
  padding-left: 0 !important;
  margin-top: 10px;
}
</style>