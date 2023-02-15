<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    rooms: Array
})
</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Rooms</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Rooms</li>
                </ol>
            </div>
        </div>
        <div v-if="$page.props.flash.action_success" class="alert alert-success">
            {{ $page.props.flash.action_success }}
        </div>
        <div v-if="$page.props.flash.action_failed" class="alert alert-danger">
            {{ $page.props.flash.action_failed }}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Rooms</header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row p-b-20">
                            <div class="col-md-6 col-sm-6 col-6">
                                <div class="btn-group">
                                    <a href="add_room.html" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center"> img </th>
                                    <th class="center"> # </th>
                                    <th class="center"> Type </th>
                                    <th class="center"> Name </th>
                                    <th class="center"> Status </th>
                                    <th class="center"> Max Person </th>
                                    <th class="center"> Number Bed </th>
                                    <th class="center"> Rent </th>
                                    <th class="center"> Action </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="room in rooms" :key="room.id" class="odd gradeX">
                                    <td class="user-circle-img">
                                        <img src="{{ room.id }}" alt="">
                                    </td>
                                    <td class="center">{{ room.id }}</td>
                                    <td class="center">{{ room.type_room_id }}</td>
                                    <td class="center">{{ room.name }}</td>
                                    <td class="center">{{ room.status }}</td>
                                    <td class="center">{{ room.max_person }}</td>
                                    <td class="center">{{ room.number_bed }}</td>
                                    <td class="center">{{ room.rent_per_night }}</td>
                                    <td class="center">
                                        <a href="edit_room.html" class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-tbl-delete btn-xs">
                                            <i class="fa fa-trash-o "></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
