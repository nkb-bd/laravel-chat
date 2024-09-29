<template>
    <div class="bg-gray-900 text-white w-64 p-4 flex flex-col justify-between">
        <div>
            <div class="flex items-center mb-8">
                <img
                    v-if="currentUser?.profilePicture"
                    :src="currentUser.profilePicture"
                    :alt="`${currentUser.name} profile picture`"
                    class="rounded-full w-10 h-10 mr-3"
                />
                <div>
                    <h2 class="text-lg font-semibold">{{ currentUser.name }}</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="mb-4">
                        <router-link to="/dashboard" class="flex items-center text-gray-400 hover:text-white">
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </router-link>
                    </li>
                    <li class="mb-4">
                        <router-link to="#" class="flex items-center text-white">
                            <i class="fas fa-comments mr-3"></i>
                            Chat Room
                            <span v-if="unreadMessages" class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                {{ unreadMessages }}
              </span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
        <div>
            <ul>
                <li class="mb-4">
                    <a href="#" class="flex items-center text-gray-400 hover:text-white">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="/logout" class="flex items-center text-gray-400 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';

    export default defineComponent({
        name: 'Sidebar',
        props: {
            currentUser: {
                type: Object,
                required: true
            },
            unreadMessages: {
                type: Number,
                default: 0
            }
        }
    });
</script>
