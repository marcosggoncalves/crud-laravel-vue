<template>
  <div>
    <v-table density="compact">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.column" class="text-left">
            {{ column.name }}
          </th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data" :key="item.name">
          <td v-for="column_item in columns" :key="column_item.name">
            {{
              column_item && column_item.sub_column
                ? item[column_item.column][column_item.sub_column]
                : item[column_item.column]
            }}
          </td>
          <td class="text-center">
            <v-menu transition="scale-transition" aria-describedat="">
              <template v-slot:activator="{ props }">
                <v-btn variant="text" v-bind="props">
                  <v-icon>mdi-dots-vertical</v-icon></v-btn
                >
              </template>
              <v-list>
                <v-list-item
                  v-for="(action, i) in actions"
                  :key="i"
                  @click="() => action.function(item)"
                >
                  <v-list-item-title>{{ action.title }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<script setup>
defineProps({
  columns: {
    required: true,
  },
  data: {
    required: true,
  },
  actions: {
    required: true,
  },
});
</script>
