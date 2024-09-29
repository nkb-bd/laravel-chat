<template>

    <div class="bg-gray-800 text-white w-1/3 p-4 h-full chat-list overflow-y-auto">
        <h2 class="text-lg font-semibold mb-4">Messages</h2>
        <ul>
            <li
                v-for="conversation in conversations"
                :key="conversation.id"
                class="mb-4"
            >
                <a
                    href="#"
                    class="flex items-center bg-blue-600 p-3 rounded-lg hover:bg-gray-700"
                    @click.prevent="$emit('select-conversation', conversation)"
                >
                    <div class="rounded-full w-10 h-10 flex items-center justify-center bg-blue-700 text-white mr-3">
                        <img
                            v-if="conversation.sender?.profilePicture"
                            :src="conversation.sender.profilePicture"
                            :alt="`${conversation.sender.name} profile picture`"
                            class="rounded-full"
                        />
                    </div>
                    <div>
                        id : {{conversation.partner_id}}
                        <h3 class="font-semibold">{{ conversation.last_message.sender.name }}</h3>
                        <p class="text-sm text-gray-300">{{ conversation.last_message.text }}</p>
                    </div>
                    <span class="ml-auto text-xs text-gray-300">
                      Sent {{ conversation.created_at_diff }}
                    </span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script setup>
    import {defineProps, inject, onMounted} from 'vue';
    import axios from "axios";
    import {useRoute} from "vue-router";

    // Define props using defineProps
    const props = defineProps({
        conversations: {
            type: Object,
            required: true
        },
    });

    // Inject dependencies
    const currentUser = inject('currentUser');
    const unreadMessages = inject('unreadMessages');

    // Define a function to format the date
    const formatDate = (date) => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString(undefined, options);
    };

    // Emit events
    const emit = defineEmits(['select-conversation']);

</script>
