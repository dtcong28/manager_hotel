<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";

const form = useForm({})
const props = defineProps({
    rooms: Array,
    record: Array,
})

function searchData() {
    router.get('rooms', { search: search.value }, { preserveState: true })
}

const showConfirmDeleteModal = ref(false)
const deleteID = ref('')

const confirmDelete = (id) => {
    showConfirmDeleteModal.value = true
    deleteID.value = id
}

const closeModal = () => {
    showConfirmDeleteModal.value = false;
}

const deleteRoom = (id) => {
    form.delete(route('rooms.destroy', id), {
        onSuccess: () => closeModal()
    });
}
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
                                    <a :href="route('rooms.create')" id="addRow" class="btn btn-info">
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
                                    <th class="center"> img</th>
                                    <th class="center"> #</th>
                                    <th class="center"> Type</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Status</th>
                                    <th class="center"> Number People</th>
                                    <th class="center"> Number Bed</th>
                                    <th class="center"> Rent</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="room in rooms" :key="room.id" class="odd gradeX">
                                    <td class="user-circle-img">
                                        <img :src="room.image" :alt="room.image" class="w-20 h-20 shadow">
                                    </td>
                                    <td class="center">{{ room.id }}</td>
                                    <td class="center">{{ room.type_room }}</td>
                                    <td class="center">{{ room.name }}</td>
                                    <td class="center">{{ room.status_label }}</td>
                                    <td class="center">{{ room.number_people }}</td>
                                    <td class="center">{{ room.number_bed }}</td>
                                    <td class="center">{{ room.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                    <td class="center">
                                        <Link :href="route('rooms.edit', { id: room.id })" class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <button @click="confirmDelete(room.id)" class="btn btn-tbl-delete btn-xs"><i class="fa fa-trash-o "></i></button>
                                        <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete ?</h4>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="deleteRoom(deleteID)">Delete</DangerButton>
                                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                                </div>
                                            </div>
                                        </Modal>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="rooms == ''" style="color: red; text-align: center">No data</div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="record.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
