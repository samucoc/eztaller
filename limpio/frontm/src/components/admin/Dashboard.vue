<template>
  <section>
    <v-breadcrumbs :items="breadcrumbs">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="2">...</v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      breadcrumbs: [
        {
          text: "Home",
          disabled: true,
          href: "dashboard",
        },
        {
          text: "Dashboard",
          disabled: true,
          href: "dashboard",
        },
      ],
    };
  },
};
</script>
