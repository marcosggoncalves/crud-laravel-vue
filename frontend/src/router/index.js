// Composables
import { createRouter, createWebHistory } from 'vue-router';
import Usuarios from '@/views/Users.vue';
import Categories from '@/views/Categories.vue';
import Products from '@/views/Products.vue';
import Login from '@/views/Login.vue';
import Home from '@/views/Home.vue';

const auth = async (to, from, next) => {
  let token = window.localStorage.getItem('token_');

  if (!token) {
    return next('/login');
  }

  next();
};

const routes = [
  {
    path: '/login',
    component: () => Login,
    meta: {
      allowAnonymous: true
    }
  },
  {
    path: '/users',
    component: () => Usuarios,
    beforeEnter: auth
  },
  {
    path: '/',
    component: () => Home,
    beforeEnter: auth
  },
  {
    path: '/categories',
    component: () => Categories,
    beforeEnter: auth
  },
  {
    path: '/products',
    component: () => Products,
    beforeEnter: auth
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
