import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.js';
import MasonryWall from '@yeger/vue-masonry-wall';
import './scss/base.scss';

const app = createApp(App)

app.use(MasonryWall).use(router).mount('#app');

