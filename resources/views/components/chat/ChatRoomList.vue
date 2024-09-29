<template>
    <div class="flex flex-col h-full">
        <Header title="Chat Rooms" />
        <div class="flex-1 overflow-y-auto h-full">
            <ConversationList
                :conversations="conversations"
                @select-conversation="selectConversation"
            />
        </div>
    </div>
</template>

<script setup>
    import { useRouter } from 'vue-router';
    import Header from './Header.vue';
    import ConversationList from './ConversationList.vue';

    const props = defineProps(['conversations']);

    const emit = defineEmits(['select-conversation']);

    // Router hook
    const router = useRouter();

    const selectConversation = (conversation) => {
        emit('select-conversation', conversation);

        router.push({ name: 'conversation', params: { id: conversation.partner_id } });
    };
</script>
