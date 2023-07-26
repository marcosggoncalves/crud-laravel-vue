<template>
  <v-banner lines="two" icon="mdi-check" color="#DBA901" class="my-4">
    <v-banner-text>
      <h2>Seja bem vindo ao System!</h2>
      Aproveite as melhores funcionalidades do sistema!
    </v-banner-text>
    <v-banner-text>
      Usuário: {{ user.name }} | E-mail: ({{ user.email }})
    </v-banner-text>
    <template v-slot:actions>
      <v-btn @click="sair()">Sair do Sistema</v-btn>
    </template>
  </v-banner>
</template> 

<script setup>
import Swal from "sweetalert2";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const user = ref({});

const router = useRouter();

function sair() {
  Swal.fire({
    title: "Finalizar sessão!",
    text: "Deseja finalizar a sessão no sistema?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DBA901",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, pode excluir",
  }).then((result) => {
    if (result.isConfirmed) {
      window.localStorage.clear();
      router.go();
    }
  });
}

onMounted(() => {
  user.value = JSON.parse(window.localStorage.getItem("user"));
});
</script>