<template>
  <div>
    <v-dialog v-model="dialog" max-width="350">
      <v-card>
        <v-card-title
          ><b>{{
            cadastro && cadastro.id ? "Alterar Cadastro" : "Novo Cadastro"
          }}</b></v-card-title
        >
        <v-divider></v-divider>
        <v-form ref="form" class="pa-5">
          <v-row density="compact">
            <v-col cols="12" md="12">
              <v-text-field
                color="#DBA901"
                label="Categoria(Descrição):"
                required
                variant="outlined"
                density="compact"
                v-model="cadastro.name"
                :error-messages="error.name"
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
    <v-card dense title="Categorias" subtitle="Todas categorias cadastradas!">
      <v-card-actions>
        <v-btn color="orange" @click="dialogOpen"
          >Adicionar Nova Categoria</v-btn
        >
      </v-card-actions>
      <center v-if="carregamento" class="pa-10">
        <v-progress-circular
          :size="35"
          indeterminate
          color="#DBA901"
        ></v-progress-circular>
      </center>
      <Table
        class="mb-5"
        v-else
        :columns="columns"
        :data="categories"
        :actions="actions"
      >
      </Table>
    </v-card>
  </div>
</template>
  
<script setup>
import Table from "@/components/Table.vue";
import Swal from "sweetalert2";
import { onMounted, reactive, ref } from "vue";
import {
  getCategoriesList,
  categoryPost,
  categoryDelete,
} from "@/services/Categories";

const error = ref({});
const dialog = ref(false);
const categories = ref([]);
const carregamento = ref(true);
const cadastro = reactive({ name: null });

const columns = [
  { name: "ID", column: "id" },
  { name: "Categoria", column: "name" },
];

const actions = [
  { title: "Editar", function: editar },
  { title: "Excluir", function: deletar },
];

function dialogOpen() {
  cadastro.name = null;
  cadastro.id = undefined;

  error.value = {};
  dialog.value = !dialog.value;
}

function getCategories() {
  carregamento.value = true;

  getCategoriesList().then((result) => {
    categories.value = result.categories;
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
  categoryPost(cadastro)
    .then((result) => {
      Swal.fire({
        icon: "success",
        title: result.message,
        showConfirmButton: false,
        timer: 1500,
      });

      dialogOpen();

      getCategories();
    })
    .catch((e) => {
      if (e.response && e.response.data) {
        return (error.value = e.response.data.error);
      }
    });
}

function deletar(item) {
  Swal.fire({
    title: "Excluir Categoria!",
    text: "Deseja excluir o cadastro desse usuário? Tem Certeza?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DBA901",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, pode excluir",
  }).then((result) => {
    if (result.isConfirmed) {
      categoryDelete(item.id)
        .then((result) => {
          Swal.fire({
            icon: "success",
            title: result.message,
            showConfirmButton: false,
            timer: 1500,
          });

          getCategories();
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

onMounted(async () => await getCategories());
</script>
  