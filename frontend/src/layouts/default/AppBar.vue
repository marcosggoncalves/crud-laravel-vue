<template>
  <v-app-bar flat  color="#DBA901">
    <v-container class=" d-flex align-center">
      <v-avatar class="me-8 ms-2" color="white" size="42">
        <v-img src="https://us.123rf.com/450wm/bellaxbudhonk/bellaxbudhonk2101/bellaxbudhonk210100332/162102943-boomerang-logo-ic%C3%B4ne-illustration-vectorielle-design-plat.jpg?ver=6"/>
      </v-avatar>

      <v-btn v-for="link in links" :key="link.name" :to="link.route" variant="text" color="white">
        {{ link.name }}
      </v-btn>
    </v-container>
  </v-app-bar>
</template>

<script setup>
const links = [
  { name: "Categorias", route: "/categories" },
  { name: "Produtos", route: "/products" },
];
</script>
