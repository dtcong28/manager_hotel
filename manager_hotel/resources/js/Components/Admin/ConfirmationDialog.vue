<template>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg w-96">
                <div class="px-6 py-4">
                    <h2 class="font-bold text-lg mb-2">{{ title }}</h2>
                    <p class="text-gray-700">{{ message }}</p>
                </div>
                <div class="px-6 py-4 flex justify-end">
                    <button
                        type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mr-2"
                        @click="onCancel()"
                    >
                        {{ cancelButtonText }}
                    </button>
                    <button
                        type="button"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center"
                        @click="onConfirm()"
                    >
                        {{ confirmButtonText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: 'Confirm Action'
        },
        message: {
            type: String,
            default: ''
        },
        cancelButtonText: {
            type: String,
            default: 'Cancel'
        },
        confirmButtonText: {
            type: String,
            default: 'Confirm'
        }
    },
    methods: {
        onCancel() {
            this.$emit('cancel');
        },
        onConfirm() {
            this.$emit('confirm');
        }
    }
}
</script>
