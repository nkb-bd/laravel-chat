import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue/dist/vue.esm-bundler';
import chat from '../views/components/Chat.vue';
import router from './router.js';
import chatApp from '../views/components/ChatApp.vue';
const app = createApp({});
app.use(router);
app.component('chat', chat);
app.component('chatApp', chatApp);
app.mount('#app');

