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
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Login</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
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

                        <InputError class="mt-2" :message="form.errors.email"/>
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

                        <InputError class="mt-2" :message="form.errors.password"/>
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember"/>
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <span>If you don't have an account, please <Link style="text-decoration: underline;" :href="route('web.home')">make a reservation</Link> to register for a member account</span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Forgot your password?
                        </Link>

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
