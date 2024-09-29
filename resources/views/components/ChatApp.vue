<template>
    <div class="flex chat-container">
        <!-- Sidebar -->
        <Sidebar :current-user="currentUser" :unread-messages="unreadMessages" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Router View -->
            <router-view
                :current-user="currentUser"
                :conversations="conversations"
                :active-conversation="activeConversation"
                @select-conversation="setActiveConversation"
                @send-message="sendMessage"
            ></router-view>
        </div>
    </div>
</template>
<script setup>
    import { ref, computed, provide } from 'vue';
    import Sidebar from './chat/Sidebar.vue';
    import ConversationList from './chat/ConversationList.vue';
    import ChatArea from './chat/ChatArea.vue';

    // Props
    const props = defineProps({
        currentUser: {
            type: Object,
            required: true
        },
        conversations: {
            type: Object,
            required: true
        },
        activeConversation: {
            type: Object,
            default: null
        }
    });

    // Data with refs
    const activeConversation = ref(props.activeConversation);
    const unreadMessages = computed(() => {
        return 1
    });

    // Provide values for child components to access
    provide('currentUser', props.currentUser);
    provide('unreadMessages', unreadMessages);

    // Methods
    function setActiveConversation(conversationId) {
        // const conversation = props.conversations.find(c => c.id === conversationId);
        // if (conversation) {
        //     activeConversation.value = {
        //         ...conversation,
        //         messages: [
        //             {
        //                 id: 1,
        //                 sender_id: conversation.sender.id,
        //                 text: conversation.text,
        //                 created_at: conversation.updated_at,
        //             },
        //         ],
        //     };
        //     conversation.unread = false; // Mark as read
        // }
    }

    function sendMessage(message) {
        if (message.trim() && activeConversation.value) {
            const newMessage = {
                id: Date.now(),
                sender_id: props.currentUser.id,
                text: message,
                created_at: new Date().toISOString(),
            };
            activeConversation.value.messages.push(newMessage);

            // Update the conversation list
            const updatedConversation = props.conversations.find(c => c.id === activeConversation.value.id);
            if (updatedConversation) {
                updatedConversation.text = message;
                updatedConversation.updated_at = newMessage.created_at;
            }
        }
    }
</script>

