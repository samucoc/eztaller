<template>
  <v-card>
    <v-tabs class="top-mantenedores">
      <v-tab to="/operativa">Pantalla Operativa</v-tab>
     <!--<v-tab to="/gestion">Gestón de Cuentas</v-tab>
      <v-tab to="/estadistica">Estadísticas</v-tab>
      <v-tab to="/reportes">Reportes</v-tab>
      <v-tab to="/habitabilidad/tab/rfamilia">Registro de Familias Potenciales</v-tab>
       <v-tab to="/habitabilidad/lfamilia">Listado de familias a Diagnosticar</v-tab>
      <v-tab to="/habitabilidad/tab/pfamilia">Listado de Familias y Propuestas</v-tab>
      <v-tab to="/habitabilidad/tab/vfamilia">Visado de Soluciones y Asesorías</v-tab>
      <v-tab
        to="/habitabilidad/tab/dfamilia"
        v-show="$route.name === 'dfamilia'"
      >Diagnóstico familiar integral</v-tab>
                 <v-tab to="/habitabilidad/resumenc">Resumen diagóstico</v-tab>
       <v-tab to="/habitabilidad/propuesta-familias">Listado de familias y propuestas</v-tab>
      <v-tab
        to="/habitabilidad/tab/propuesta-pic"
        v-show="$route.name === 'propuesta_pic'"
      >Propuesta familiar integral</v-tab>
      <v-tab
        to="/habitabilidad/tab/propuesta-mod-pic"
        v-show="$route.name === 'propuesta_mod_pic'"
      >Propuesta familiar integral</v-tab>
      <v-tab
        to="/habitabilidad/tab/asesorias-grupales-pic"
        v-show="$route.name === 'asesorias_grupales_pic'"
      >Asesorías Grupales</v-tab>
      <v-tab
        to="/habitabilidad/tab/asesorias-grupales-mod-pic"
        v-show="$route.name === 'asesorias_grupales_mod_pic'"
      >Asesorías Grupales</v-tab>
      <v-tab
        to="/habitabilidad/tab/proceso-compra-adquisicion"
        v-show="$route.name === 'proceso_compra_adquisicion'"
      >Proceso de Compra / Adquisición</v-tab>
      <v-tab
        to="/habitabilidad/tab/ejecucion-propuestas"
        v-show="$route.name === 'ejecucion_propuestas'"
      >Estado Ejecución de Propuestas</v-tab>
      <v-tab
        to="/habitabilidad/tab/ejecucion-propuesta/"
        v-show="$route.name === 'ejecucion_propuesta'"
      >Seguimiento y Monitoreo</v-tab>
      <v-tab
        to="/habitabilidad/tab/ejecucion-propuesta-grupales/"
        v-show="$route.name === 'ejecucion_propuesta_grupales'"
      >Seguimiento y Monitoreo</v-tab> -->
    </v-tabs>
    <router-view class="pa-3" />
  </v-card>
</template>

<script>
export default {
  name: "View",
};
</script>

<style scoped>
</style>