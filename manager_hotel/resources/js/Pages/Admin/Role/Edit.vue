<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {onMounted} from "vue";

const props = defineProps({
    role: Object,
    permissions: Object
})

const form = useForm({
    name: props.role.name,
    permissions: [],
});

const updateRole = () => {
    router.post(`/admin/roles/${props.role.id}`, {
        _method: 'put',
        name: form.name,
        permissions: form.permissions,
    })
};

onMounted(() =>{
    form.permissions = props.role?.permissions;
})

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Edit Role"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Role</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Role</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Update Role</header>
                        </div>
                        <div class="card-body col-6" style="margin: auto" id="bar-parent">
                            <form @submit.prevent="updateRole">
                                <div class="form-group">
                                    <label for="name">Name Role</label>
                                    <input type="text" v-model="form.name" class="form-control" id="name"
                                           name="name" placeholder="Enter role">
                                    <div v-if="$page.props.errors.name" style="color: red">{{$page.props.errors.name[0] }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="typo__label">Permission</label>
                                    <multiselect v-model="form.permissions" tag-placeholder="Add this as new permission" placeholder="Search or add a permission" label="name" track-by="name" :options="permissions" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                    <div v-if="$page.props.errors.permissions" style="color: red">
                                        {{ $page.props.errors.permissions[0] }}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="display: flex; justify-content: center; margin: 0 auto">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
