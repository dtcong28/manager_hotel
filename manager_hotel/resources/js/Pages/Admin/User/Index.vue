<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {ref} from "vue";
import {usePermission} from "@/Composables/permissions";
const { hasPermission } = usePermission();
const { hasRole } = usePermission();

const form = useForm({})
const props = defineProps({
    users: Array,
})

function searchData() {
    router.get('users', { search: search.value }, { preserveState: true })
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

const deleteUser = (id) => {
    form.delete(route('users.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>

<template>
    <Head title="User"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" :href="route('dashboard')">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Employee</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Employee</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All User</header>
                    </div>
                    <div class="card-body col-9" style="margin: auto">
                        <div v-if="hasPermission('create')" class="row p-b-20">
                            <div class="col-md-6 col-sm-6 col-6">
                                <div class="btn-group">
                                    <Link :href="route('users.create')" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="example4_filter" class="dataTables_filter">
                                <label>Search:
                                    <input type="search" id="search" v-model="search" @keyup="searchData"
                                           class="form-control form-control-sm" placeholder="" aria-controls="example4">
                                </label>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center"> ID</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Email</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in users.data" :key="user.id" class="odd gradeX">
                                    <td class="center">{{ user.id }}</td>
                                    <td class="center">{{ user.name }}</td>
                                    <td class="center">{{ user.email }}</td>
                                    <td class="center">
                                        <Link v-if="hasPermission('edit')" :href="route('users.edit', { id: user.id })"
                                              class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <button v-if="hasPermission('delete')" @click="confirmDelete(user.id)" class="btn btn-tbl-delete btn-xs"><i
                                            class="fa fa-trash-o "></i></button>
                                        <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete
                                                    ?</h4>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="deleteUser(deleteID)">Delete</DangerButton>
                                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                                </div>
                                            </div>
                                        </Modal>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="users.data == ''" style="color: red; text-align: center">No data</div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="users.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
