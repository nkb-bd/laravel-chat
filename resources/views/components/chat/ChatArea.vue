<template>
    <div class="bg-gray-900 text-white flex-1 p-4 flex flex-col justify-between">
        <div v-if="loading">Loading messages...</div>
        <div v-else>
            <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>
            <div v-else-if="messages.length === 0">No messages available.</div>
            <div v-else >
                <div class="flex items-center mb-4" v-if="otherUser?.name">
                    <div class="rounded-full w-10 h-10 flex items-center justify-center bg-blue-700 text-white mr-3">
                        {{ otherUser.name.charAt(0) }}
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ otherUser.name }}</h3>
                        <p class="text-sm text-gray-400">Last active: {{ formatTime(messages[messages.length - 1].created_at) }}</p>
                    </div>
                </div>

                <div ref="messagesContainer" class="overflow-y-auto max-h-[60vh]">
                    <div
                        v-for="message in messages"
                        :key="message.id"
                        class="mb-4"
                    >
                        <div
                            class="flex items-start"
                            :class="{ 'justify-end': message.sender_id === currentUser.id }"
                        >
                            <div
                                v-if="message.sender_id !== currentUser.id"
                                class="rounded-full w-8 h-8 flex items-center justify-center bg-blue-700 text-white mr-3"
                            >
                                {{ message?.sender?.name.charAt(0) }}
                            </div>
                            <div
                                :class="message.sender_id === currentUser.id ? 'bg-blue-600' : 'bg-gray-800'"
                                class="p-3 rounded-lg"
                            >
                                <p>{{ message.text }}</p>
                                <span class="text-xs text-gray-400">{{ formatTime(message.created_at) }}</span>
                            </div>
                            <div
                                v-if="message.sender_id === currentUser.id"
                                class="rounded-full w-8 h-8 flex items-center justify-center bg-blue-700 text-white ml-3"
                            >
                                {{ currentUser.name.charAt(0) }}
                            </div>
                        </div>
                    </div>

                    <small v-if="isFriendTyping" class="text-gray-700">
                        {{ otherUser.name }} is typing...
                    </small>
                </div>
            </div>
        </div>

        <form @submit.prevent="sendMessage" class="flex items-center p-3 bg-gray-800 rounded-lg mt-4">
            <button type="button" class="text-gray-400 hover:text-white mr-3">
                <i class="fas fa-camera"></i>
            </button>
            <button type="button" class="text-gray-400 hover:text-white mr-3">
                <i class="fas fa-paperclip"></i>
            </button>

            <input
                type="text"
                v-model="newMessage"
                @keydown="sendTypingEvent"
                @keyup.enter="sendMessage"
                placeholder="Type a message..."
                class="flex-1 px-2 py-1 border focus:outline-none bg-gray-700  rounded-lg"
            />


            <button type="submit" class="text-blue-500 px-14 py-1 ml-2  bg-slate-700 rounded hover:text-blue-600 ml-3">
                Send
            </button>
        </form>
    </div>
</template>

<script setup>
    import {nextTick, onMounted, ref, watch} from 'vue';
    import { useRoute } from "vue-router";
    import axios from "axios";

    const props = defineProps({
        currentUser: {
            type: Object,
            required: true
        },
    });

    const newMessage = ref('');
    const loading = ref(true);
    const error = ref(null);
    const messages = ref([]);
    const otherUser = ref(null);
    const route = useRoute();
    const isFriendTyping = ref(false);
    const isFriendTypingTimer = ref(null);
    const messagesContainer = ref(null);


    const formatTime = (date) => {
        const options = { hour: '2-digit', minute: '2-digit' };
        return new Date(date).toLocaleTimeString([], options);
    };

    const sendMessage = () => {
        if (newMessage.value.trim() !== "") {
            axios
                .post(`/messages/${route.params.id}`, {
                    message: newMessage.value,
                })
                .then((response) => {
                    messages.value.push(response.data);
                    newMessage.value = "";
                });
        }
    };

    const sendTypingEvent = () => {
        Echo.private(`chat.${route.params.id}`).whisper("typing", {
            userID: props.currentUser.id,
        });
    };

    const fetchMessages = async (friendId) => {
        if (!friendId) {
            loading.value = false;
            return;
        }

        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get(`/messages/${friendId}`);
            if (response.data.messages) {
                messages.value = response.data.messages;
                otherUser.value = response.data.friend;
            } else {
                throw new Error('Invalid data structure received from API');
            }

        } catch (err) {
            console.error('Error fetching messages:', err);
            error.value = 'Failed to load messages. Please try again.';
            messages.value = [];
        } finally {
            loading.value = false;
        }
    };

    const setupEchoListeners = () => {
        Echo.private(`chat.${props.currentUser.id}`)
            .listen("MessageSent", (response) => {
                messages.value.push(response.message);
            })
            .listenForWhisper("typing", (response) => {
                isFriendTyping.value = response.userID !== props.currentUser.id; // Check if typing event is from friend

                if (isFriendTypingTimer.value) {
                    clearTimeout(isFriendTypingTimer.value);
                }

                isFriendTypingTimer.value = setTimeout(() => {
                    isFriendTyping.value = false;
                }, 2000);
            });
    };

    onMounted(() => {
        fetchMessages(route.params.id);
        setupEchoListeners(); // Set up Echo listeners on mount
    });

    watch(() => route.params.id, (newId) => {
        fetchMessages(newId);
        setupEchoListeners(); // Re-setup listeners when the route changes
    });
    watch(messages, () => {
            nextTick(() => {
                messagesContainer.value.scrollTo({
                    top: messagesContainer.value.scrollHeight,
                    behavior: "smooth",
                });
            });
        },
        { deep: true }
    );

</script>
