<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    typesRoom: Array
})
</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Types Room</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Types Room</li>
                </ol>
            </div>
        </div>
        <div v-if="$page.props.flash.action_success" class="alert alert-success">
            {{ $page.props.flash.action_success }}
        </div>
        <div v-if="$page.props.flash.action_failed" class="alert alert-danger">
            {{ $page.props.flash.action_failed }}
        </div>
        <div class="tab-content tab-space">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="typeRoom in typesRoom" :key="typeRoom.id">
                    <th scope="row">{{ typeRoom.id }}</th>
                    <td>{{ typeRoom.name }}</td>
                    <td>
                        <Link :href="`/admin/types-room/${typeRoom.id}/edit`">Edit</Link>
                        <br/>
                        <Link :href="`/admin/types-room/${typeRoom.id}`" method="delete" type="button">Delete</Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
