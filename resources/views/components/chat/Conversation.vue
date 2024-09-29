<template>
    <div class="flex flex-col h-full">
        <Header :title="conversationTitle" />
        <div class="flex h-full">
            <ConversationList
                :conversations="conversations"
                @select-conversation="onSelect"
            />
            <ChatArea
                :current-user="currentUser"
                :active-conversation="activeConversation"
                @send-message="sendMessage"
            />
        </div>

    </div>
</template>

<script setup>
    import {computed, onMounted} from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import Header from './Header.vue';
    import ChatArea from './ChatArea.vue';
    import ConversationList from './ConversationList.vue';
    import axios from "axios";

    // Define props
    const props = defineProps({
        currentUser: {
            type: Object,
            required: true
        },
        activeConversation: {
            type: Object,
        },
        conversations: {
            type: Object,
        }
    });

    // Use router
    const router = useRouter();

    // Computed property for conversation title
    const conversationTitle = computed(() => {
        return 'Chat';
    });

    const sendMessage = (message) => {

    };

    // Method to select a conversation
    const onSelect = (conversation) => {
        // console.log(conversation);
        router.push({ name: 'conversation', params: { id: conversation.partner_id } });
    };



</script>
