<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';

const props = defineProps({
    permission: Object,
})

const form = useForm({
    name: props.permission.name,
});

const updatePermission = () => {
    router.post(`/admin/permissions/${props.permission.id}`, {
        _method: 'put',
        name: form.name,
    })
};

</script>

<template>
    <Head title="Add Permission"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Permission</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Permission</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Permission</header>
                        </div>
                        <div class="card-body " id="bar-parent">
                            <form @submit.prevent="updatePermission">
                                <div class="form-group">
                                    <label for="name">Name permission</label>
                                    <input type="text" v-model="form.name" class="form-control col-4" id="name" name="name" placeholder="Enter permission">
                                    <div v-if="$page.props.errors.name" style="color: red">{{ $page.props.errors.name[0] }}</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
