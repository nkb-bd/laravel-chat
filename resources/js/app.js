import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue/dist/vue.esm-bundler';
import router from './router.js';
import Chat from '../views/components/Chat.vue';
import ChatApp from '../views/components/ChatApp.vue';

const app = createApp({});

app.use(router);

app.component('Chat', Chat);
app.component('ChatApp', ChatApp);

app.mount('#app');
