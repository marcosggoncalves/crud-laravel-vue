<template>
  <div>
    <v-dialog v-model="dialog" max-width="450">
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
                label="Produto(Descrição):"
                required
                variant="outlined"
                density="compact"
                v-model="cadastro.name"
                :error-messages="error.name"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="12">
              <v-autocomplete
                label="Categoria"
                required
                color="#DBA901"
                variant="outlined"
                density="compact"
                :items="categories"
                item-title="name"
                v-model="cadastro.category_id"
                :error-messages="error.category_id"
                item-value="id"
              ></v-autocomplete>
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
    <v-card dense title="Produtos" subtitle="Linha de produtos cadastrados!">
      <v-card-actions>
        <v-btn color="orange" @click="dialogOpen">Adicionar Novo Produto</v-btn>
      </v-card-actions>
      <center v-if="carregamento" class="pa-10">
        <v-progress-circular
          :size="35"
          indeterminate
          color="#DBA901"
        ></v-progress-circular>
      </center>
      <div v-else>
        <Table :columns="columns" :data="products" :actions="actions"> </Table>
        <div class="pa-4">
          <v-pagination
            color="#DBA901"
            v-model="pagination.page"
            :length="pagination.length"
            :total-visible="pagination.total"
            @update:model-value="getProducts"
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
import {
  getProductsList,
  productPost,
  productDelete,
} from "@/services/Products";

import { getCategoriesList } from "@/services/Categories";

const error = ref({});
const dialog = ref(false);
const products = ref([]);
const categories = ref([]);
const carregamento = ref(true);
const cadastro = reactive({ name: null });
const pagination = reactive({ page: 1, length: 2, total: 10 });

const columns = [
  { name: "ID", column: "id" },
  { name: "Produto", column: "name" },
  { name: "Categoria", column: "category", sub_column: "name" },
];

const actions = [
  { title: "Editar", function: editar },
  { title: "Excluir", function: deletar },
];

function dialogOpen() {
  cadastro.name = null;
  cadastro.category_id = null;
  cadastro.id = undefined;

  error.value = {};
  dialog.value = !dialog.value;
}

function getCategories() {
  getCategoriesList().then((result) => {
    categories.value = result.categories;
  });
}

function getProducts(page = 1) {
  carregamento.value = true;

  getProductsList(page).then((result) => {
    products.value = result.products.data;
    pagination.length = result.products.last_page;
    pagination.total = result.products.total;
    pagination.page = result.products.current_page;
    carregamento.value = false;
  });
}

function editar(item) {
  cadastro.id = item.id;
  cadastro.category_id = item.category_id;
  cadastro.name = item.name;
  dialog.value = true;
}

function salvar() {
  productPost(cadastro)
    .then((result) => {
      Swal.fire({
        icon: "success",
        title: result.message,
        showConfirmButton: false,
        timer: 1500,
      });

      dialogOpen();

      getProducts();
    })
    .catch((e) => {
      if (e.response && e.response.data) {
        return (error.value = e.response.data.error);
      }
    });
}

function deletar(item) {
  Swal.fire({
    title: "Excluir Produto!",
    text: "Deseja excluir essa produto? Tem Certeza?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DBA901",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, pode excluir",
  }).then((result) => {
    if (result.isConfirmed) {
      productDelete(item.id)
        .then((result) => {
          Swal.fire({
            icon: "success",
            title: result.message,
            showConfirmButton: false,
            timer: 1500,
          });

          getProducts();
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

onMounted(async () => {
  await getProducts();
  await getCategories();
});
</script>
    