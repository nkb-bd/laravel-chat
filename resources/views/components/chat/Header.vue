<template>
    <div class="bg-gray-800 text-white p-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold flex items-center">
            <i class="fas fa-users mr-3"></i>
            {{ title }}
        </h1>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';

    export default defineComponent({
        name: 'Header',
        props: {
            title: {
                type: String,
                required: true
            }
        }
    });
</script>
