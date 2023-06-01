<script setup>
import ApplicationLogo from '@/Components/Admin/Auth/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" v-bind:style="{'background-image': 'url(/frontend/images/bg_2.jpg)'}" style="height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div>
            <div style="font-size: 40px">ADMIN HOTEL</div>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
