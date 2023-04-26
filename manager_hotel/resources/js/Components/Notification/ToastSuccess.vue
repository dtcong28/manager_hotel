<script setup>
import {ref, watchEffect } from "vue";

const props = defineProps({
    toast: Object,
    required: true,
})

const visible = ref(false);
const timeout = ref(null);

watchEffect(() => {
    if (props.toast) {
        visible.value = true;

        if(timeout.value){
            clearTimeout(timeout.value);
        }

        timeout.value = setTimeout(() => {
            visible.value = false;
        }, 1500);
    }
});

</script>
<template>
    <transition name="slide-fade">
        <div v-if="toast && visible" id="toast-success" class="fixed top-4 right-4 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-green-100 rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ml-3 text-sm font-normal">{{ toast.action_success }}</div>
        </div>
    </transition>
</template>

<style>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>

