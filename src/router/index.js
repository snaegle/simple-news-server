import { createRouter, createWebHistory } from 'vue-router';
import LatestNews from '../views/LatestNewsView.vue';


const routes = [
  {
    path: '/',
    name: 'LatestNewsView',
    component: LatestNews
  },
  {
    path: '/new',
    name: 'NewNewsItemView',
    component: () =>
      import(/* webpackChunkName: 'about */ '../views/NewNewsItemView.vue'),
  },
  {
    path: '/edit/:id',
    name: 'EditNewsItemView',
    component: () =>
      import(/* webpackChunkName: 'about */ '../views/EditNewsItemView.vue'),
    props: route => ({ id: Number(route.params.id) }),
  },
  {
    path: '/delete/:id',
    name: 'DeleteNewsItemView',
    component: () =>
      import(/* webpackChunkName: 'about */ '../views/DeleteNewsItemView.vue'),
    props: route => ({ id: Number(route.params.id) }),
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;

