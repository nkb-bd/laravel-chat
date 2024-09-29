import { createRouter, createWebHistory } from 'vue-router';
import ChatRoomList from '../views/components/chat/ChatRoomList.vue';
import Conversation from '../views/components/chat/Conversation.vue';
const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: ChatRoomList,
    },
    {
        path: '/conversation/:id',
        name: 'conversation',
        component: Conversation,
        props: true,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
