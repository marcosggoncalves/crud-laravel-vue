<template>
  <v-card width="300px">
    <v-form :disabled="carregamento" ref="form">
      <v-card-title>
        <span class="text-title">System</span><br />
        <span class="text-caption">Faça login para continuar</span>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="login.email"
          :error-messages="error.email"
          color="#DBA901"
          label="E-mail"
          variant="outlined"
          density="compact"
          hide-details="auto"
        />
        <v-text-field
          class="my-2"
          v-model="login.password"
          :error-messages="error.password"
          label="Senha"
          color="#DBA901"
          variant="outlined"
          type="password"
          density="compact"
          hide-details="auto"
        />
      </v-card-text>
      <v-card-actions class="d-flex justify-center">
        <v-btn
          small
          depressed
          color="#DBA901"
          @click="entrar"
          :loading="carregamento"
          >Entrar</v-btn
        >
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script setup>
import Swal from "sweetalert2";
import { reactive, ref } from "vue";
import { authLogin } from "@/services/UsersAuth";
import { useRouter } from "vue-router";

const error = ref({});
const carregamento = ref(false);
const login = reactive({ email: null, password: null });
const router = useRouter();

function entrar() {
  carregamento.value = true;

  authLogin(login)
    .then((result) => {
      window.localStorage.setItem("token_", result.token);
      window.localStorage.setItem("user", JSON.stringify(result.usuario));
      router.push({ path: "/" });

      carregamento.value = false;
    })
    .catch((e) => {
      if (e.response && e.response.data.error) {
        carregamento.value = false;
        error.value = e.response.data.error;
        return;
      }

      Swal.fire({
        icon: "error",
        title: e.response.data.message,
        showConfirmButton: false,
        timer: 1500,
      });

      error.value = {};
      carregamento.value = false;
    });
}
</script>