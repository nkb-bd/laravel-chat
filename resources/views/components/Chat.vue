<template>
    <div>
        <div class="flex flex-col justify-end h-80">
            <div ref="messagesContainer" class="p-4 overflow-y-auto max-h-fit space-y-3">
                <div
                    v-for="message in messages"
                    :key="message.id"
                    class="flex"
                    :class="[
        message.sender_id === currentUser.id ? 'justify-end' : 'justify-start'
      ]"
                >
                    <div
                        class="max-w-[70%] rounded-lg p-3"
                        :class="[
          message.sender_id === currentUser.id
            ? 'bg-blue-800 text-black rounded-br-none'
            : 'bg-indigo text-gray-800 rounded-bl-none'
        ]"
                    >
                        {{ message.text }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <input
                type="text"
                v-model="newMessage"
                @keydown="sendTypingEvent"
                @keyup.enter="sendMessage"
                placeholder="Type a message..."
                class="flex-1 px-2 py-1 border rounded-lg"
            />
            <button
                @click="sendMessage"
                class="px-14 py-1 ml-2 text-blue-500 bg-red-700 rounded-lg"
            >
                Send
            </button>
        </div>
        <small v-if="isFriendTyping" class="text-gray-700">
            {{ friend.name }} is typing...
        </small>
    </div>
</template>

<script setup>
    import axios from "axios";
    import { nextTick, onMounted, ref, watch } from "vue";

    const props = defineProps({
        friend: {
            type: Object,
            required: true,
        },
        currentUser: {
            type: Object,
            required: true,
        },
    });

    const messages = ref([]);
    const newMessage = ref("");
    const messagesContainer = ref(null);
    const isFriendTyping = ref(false);
    const isFriendTypingTimer = ref(null);

    watch(
        messages,
        () => {
            nextTick(() => {
                messagesContainer.value.scrollTo({
                    top: messagesContainer.value.scrollHeight,
                    behavior: "smooth",
                });
            });
        },
        { deep: true }
    );

    const sendMessage = () => {
        if (newMessage.value.trim() !== "") {
            axios
                .post(`/messages/${props.friend.id}`, {
                    message: newMessage.value,
                })
                .then((response) => {
                    messages.value.push(response.data);
                    newMessage.value = "";
                });
        }
    };

    const sendTypingEvent = () => {
        Echo.private(`chat.${props.friend.id}`).whisper("typing", {
            userID: props.currentUser.id,
        });
    };

    onMounted(() => {
        axios.get(`/messages/${props.friend.id}`).then((response) => {
            console.log(response.data);
            messages.value = response.data;
        });

        Echo.private(`chat.${props.currentUser.id}`)
            .listen("MessageSent", (response) => {
                messages.value.push(response.message);
            })
            .listenForWhisper("typing", (response) => {
                isFriendTyping.value = response.userID === props.friend.id;

                if (isFriendTypingTimer.value) {
                    clearTimeout(isFriendTypingTimer.value);
                }

                isFriendTypingTimer.value = setTimeout(() => {
                    isFriendTyping.value = false;
                }, 1000);
            });
    });
</script>
<style>
    .bg-indigo{
        background: #9ca3af;
        padding: 5px 10px;
        margin-bottom: 5px;
    }
    .bg-blue-800{
        border: 1px solid #efefef;
        padding: 5px 10px;

    }
</style>

