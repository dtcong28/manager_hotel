<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/Admin/Auth/InputError.vue';
import InputLabel from '@/Components/Admin/Auth/InputLabel.vue';
import PrimaryButton from '@/Components/Admin/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Admin/Auth/TextInput.vue';
import Multiselect from 'vue-multiselect'
import {onMounted} from "vue";

const props = defineProps({
    user: Object,
    permissions: Object,
    roles: Object,
})

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    permissions: [],
    roles: [],
});

const updateUser = () => {
    router.post(`/admin/users/${props.user.id}`, {
        _method: 'put',
        name: form.name,
        email: form.email,
        permissions: form.permissions,
        roles: form.roles,
    })
};

onMounted(() =>{
    form.permissions = props.user?.permissions;
    form.roles = props.user?.roles;
})
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
                    <li><a class="parent-item" href="">User</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add User</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>User</header>
                        </div>
                        <div class="card-body " id="bar-parent">
                            <form @submit.prevent="updateUser">
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

                                    <InputError v-if="$page.props.errors.name" class="mt-2" :message="$page.props.errors.name[0]" />
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

                                    <InputError v-if="$page.props.errors.email" class="mt-2" :message="$page.props.errors.email[0]" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="permissions" value="Roles" />
                                    <multiselect v-model="form.roles" tag-placeholder="Add this as new permission" placeholder="Search or add a permission" label="name" track-by="name" :options="roles" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                    <div v-if="$page.props.errors.roles" style="color: red">
                                        {{ $page.props.errors.roles[0] }}
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="permissions" value="Permissions" />
                                    <multiselect v-model="form.permissions" tag-placeholder="Add this as new permission" placeholder="Search or add a permission" label="name" track-by="name" :options="permissions" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                    <div v-if="$page.props.errors.permissions" style="color: red">
                                        {{ $page.props.errors.permissions[0] }}
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Submit
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
