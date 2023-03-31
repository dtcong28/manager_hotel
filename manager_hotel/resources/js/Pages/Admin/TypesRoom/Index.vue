<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import {Link, router} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    typesRoom: Array
})

function searchData() {
    router.get('types-room', { search: search.value }, { preserveState: true })
}
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Type Rooms</header>
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
                                    <a :href="route('types-room.create')" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="example4_filter" class="dataTables_filter">
                                <label>Search:
                                    <input type="search" id="search" v-model="search" @keyup="searchData" class="form-control form-control-sm" placeholder="" aria-controls="example4">
                                </label>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center"> #</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="typeRoom in typesRoom.data" :key="typeRoom.id" class="odd gradeX">
                                    <td class="center">{{ typeRoom.id }}</td>
                                    <td class="center">{{ typeRoom.name }}</td>
                                    <td class="center">
                                        <Link :href="route('types-room.edit', { id: typeRoom.id })" class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <Link :href="route('types-room.destroy', { id: typeRoom.id })" method="delete" class="btn btn-tbl-delete btn-xs">
                                            <i class="fa fa-trash-o "></i>
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="props.typesRoom.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
