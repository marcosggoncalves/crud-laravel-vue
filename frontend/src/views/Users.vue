<template>
  <div>
    <v-dialog v-model="dialog" max-width="900">
      <v-card>
        <v-card-title
          ><b>{{
            cadastro && cadastro.id ? "Alterar Cadastro" : "Novo Cadastro"
          }}</b></v-card-title
        >
        <v-divider></v-divider>
        <v-form ref="form" class="pa-5">
          <v-row density="compact">
            <v-col cols="12" md="4">
              <v-text-field
                color="#DBA901"
                label="Usuário:"
                required
                variant="outlined"
                density="compact"
                v-model="cadastro.name"
                :error-messages="error.name"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                color="#DBA901"
                label="Senha:"
                required
                type="password"
                variant="outlined"
                density="compact"
                :error-messages="error.password"
                v-model="cadastro.password"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                color="#DBA901"
                label="Email:"
                variant="outlined"
                density="compact"
                required
                :error-messages="error.email"
                v-model="cadastro.email"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-btn
            class="mt-5"
            color="#DBA901"
            variant="elevated"
            @click="salvar"
          >
            <v-icon dark> mdi-check </v-icon>
            Salvar
          </v-btn>
        </v-form>
      </v-card>
    </v-dialog>
    <v-card dense title="Usuários" subtitle="Todas usuários cadastradas!">
      <v-card-actions>
        <v-btn color="orange" @click="dialogOpen">
          Adicionar Novo Usuário</v-btn
        >
      </v-card-actions>
      <center v-if="carregamento" class="pa-10">
        <v-progress-circular
          :size="35"
          indeterminate
          color="#DBA901"
        ></v-progress-circular>
      </center>
      <div v-else>
        <Table :columns="columns" :data="users" :actions="actions"> </Table>
        <div class="pa-4">
          <v-pagination
            color="#DBA901"
            v-model="pagination.page"
            :length="pagination.length"
            :total-visible="pagination.total"
            @update:model-value="getUser"
          ></v-pagination>
        </div>
      </div>
    </v-card>
  </div>
</template>

<script setup>
import Table from "@/components/Table.vue";
import Swal from "sweetalert2";
import { onMounted, reactive, ref } from "vue";
import { getUsersList, userPost, userDelete } from "@/services/Users";

const users = ref([]);
const error = ref({});
const dialog = ref(false);
const carregamento = ref(true);

const pagination = reactive({ page: 1, length: 2, total: 10 });

const cadastro = reactive({
  name: null,
  email: null,
  password: null,
});

const columns = [
  { name: "ID", column: "id" },
  { name: "Usuário", column: "name" },
  { name: "E-mail", column: "email" },
];

const actions = [
  { title: "Editar", function: editar },
  { title: "Excluir", function: deletar },
];

function dialogOpen() {
  cadastro.email = null;
  cadastro.name = null;
  cadastro.password = null;
  cadastro.id = undefined;

  error.value = {};
  dialog.value = !dialog.value;
}

function getUser(page = 1) {
  carregamento.value = true;

  getUsersList(page).then((result) => {
    users.value = result.users.data;
    pagination.length = result.users.last_page;
    pagination.total = result.users.total;
    pagination.page = result.users.current_page;
    carregamento.value = false;
  });
}

function editar(item) {
  cadastro.id = item.id;
  cadastro.email = item.email;
  cadastro.name = item.name;
  cadastro.password = item.password;
  dialog.value = true;
}

function salvar() {
  userPost(cadastro)
    .then((result) => {
      Swal.fire({
        icon: "success",
        title: result.message,
        showConfirmButton: false,
        timer: 1500,
      });

      dialogOpen();

      getUser();
    })
    .catch((e) => {
      if (e.response && e.response.data) {
        return (error.value = e.response.data.error);
      }
    });
}

function deletar(item) {
  Swal.fire({
    title: "Excluir Usuário!",
    text: "Deseja excluir o cadastro desse usuário? Tem Certeza?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DBA901",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, pode excluir",
  }).then((result) => {
    if (result.isConfirmed) {
      userDelete(item.id)
        .then((result) => {
          Swal.fire({
            icon: "success",
            title: result.message,
            showConfirmButton: false,
            timer: 1500,
          });

          getUser();
        })
        .catch((e) => {
          Swal.fire({
            icon: "error",
            title: e.response.data.message,
            showConfirmButton: false,
            timer: 1000,
          });
        });
    }
  });
}

onMounted(async () => await getUser());
</script>
