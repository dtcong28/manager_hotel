<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/Admin/Auth/InputError.vue';
import InputLabel from '@/Components/Admin/Auth/InputLabel.vue';
import TextInput from '@/Components/Admin/Auth/TextInput.vue';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";

const props = defineProps({
    roles: Object,
    gender: Object,
})

const form = useForm({
    name: '',
    email: '',
    address: '',
    gender: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: false,
    roles: [],
});

const storeUser = () => {
    form.post(route('users.store'))
};

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Add User"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Employee</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Employee</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Add Employee</header>
                        </div>
                        <div class="card-body col-6" style="margin: auto" id="bar-parent">
                            <form @submit.prevent="storeUser">
                                <div>
                                    <InputLabel for="name" value="Name" />

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        autofocus
                                        autocomplete="name"
                                    />

                                    <InputError v-if="form.errors.name" class="mt-2" :message="form.errors.name[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        autocomplete="username"
                                    />

                                    <InputError v-if="form.errors.email" class="mt-2" :message="form.errors.email[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="phone" value="Phone" />

                                    <TextInput
                                        id="phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.phone"
                                        autofocus
                                        autocomplete="phone"
                                    />

                                    <InputError v-if="form.errors.phone" class="mt-2" :message="form.errors.phone[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="address" value="Address" />

                                    <TextInput
                                        id="address"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.address"
                                        autofocus
                                        autocomplete="address"
                                    />

                                    <InputError v-if="form.errors.address" class="mt-2" :message="form.errors.address[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="gender" value="Gender" />
                                    <multiselect v-model="form.gender" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="props.gender" :searchable="false" :allow-empty="false"></multiselect>

                                    <InputError v-if="form.errors.gender" class="mt-2" :message="form.errors.gender[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="password" value="Password" />

                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        autocomplete="new-password"
                                    />

                                    <InputError v-if="form.errors.password" class="mt-2" :message="form.errors.password[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="password_confirmation" value="Confirm Password" />

                                    <TextInput
                                        id="password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password_confirmation"
                                        autocomplete="new-password"
                                    />

                                    <InputError v-if="form.errors.password_confirmation" class="mt-2" :message="form.errors.password_confirmation[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="permissions" value="Roles" />
                                    <multiselect v-model="form.roles" tag-placeholder="Add this as new permission" placeholder="Search or add a permission" label="name" track-by="name" :options="roles" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                    <div v-if="$page.props.errors.roles" style="color: red">
                                        {{ $page.props.errors.roles[0] }}
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="btn btn-primary" style="display: flex; justify-content: center; margin: 0 auto">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
