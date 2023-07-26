<template>
  <v-app class="bg-grey-lighten-3" v-if="$route.meta.allowAnonymous">
    <v-container class="d-view d-flex justify-center align-center">
      <router-view />
    </v-container>
  </v-app>
  <DefaultBar v-else />
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import DefaultBar from "../src/layouts/default/Default.vue";
import { authCheck } from "./services/UsersAuth";

const route = useRoute();

onMounted(async () => {
  if (route && !route.meta.allowAnonymous) await authCheck();
});
</script>

<style>
.d-view {
  height: 90vh;
}
</style>