<script setup>
import Checkbox from '@/Components/Admin/Auth/Checkbox.vue';
import InputError from '@/Components/Admin/Auth/InputError.vue';
import InputLabel from '@/Components/Admin/Auth/InputLabel.vue';
import PrimaryButton from '@/Components/Admin/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Admin/Auth/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('web.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login"/>
    <WebLayout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100" v-bind:style="{'background-image': 'url(/frontend/images/bg_2.jpg)'}" style="height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email"/>

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError v-if="form.errors.email" class="mt-2" :message="form.errors.email[0]"/>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password"/>

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError v-if="form.errors.password" class="mt-2" :message="form.errors.password[0]"/>
                    </div>

                    <div class="block mt-4">
                        <span>If you don't have an account, please <Link style="text-decoration: underline;" :href="route('web.home')">make a reservation</Link> to register for a member account</span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </WebLayout>
</template>
