// Composables
import { createRouter, createWebHistory } from 'vue-router';
import Default from '@/layouts/default/Default.vue';
import Home from '@/views/Home.vue';
import Categories from '@/views/Categories.vue';
import Products from '@/views/Products.vue';

const routes = [
  {
    path: '/',
    component: () => Home
  },
  {
    path: '/categories',
    component: () => Categories,
    children: [],
  },
  {
    path: '/products',
    component: () => Products,
    children: [],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
