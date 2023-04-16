<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {ref} from "vue";

const form = useForm({})
const props = defineProps({
    roles: Array,
})

const showConfirmDeleteModal = ref(false)
const deleteID = ref('')

const confirmDelete = (id) => {
    showConfirmDeleteModal.value = true
    deleteID.value = id
}

const closeModal = () => {
    showConfirmDeleteModal.value = false;
}

const deleteRole = (id) => {
    form.delete(route('roles.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>

<template>
    <Head title="Role"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Role</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Role</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>All Role</header>
                    </div>
                    <div class="card-body col-6" style="margin: auto">
                        <div class="row p-b-20">
                            <div class="col-md-6 col-sm-6 col-6">
                                <div class="btn-group">
                                    <Link :href="route('roles.create')" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                <th class="center"> ID</th>
                                <th class="center"> Name</th>
                                <th class="center"> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles" :key="role.id" class="odd gradeX">
                                <td class="center">{{ role.id }}</td>
                                <td class="center">{{ role.name }}</td>
                                <td class="center">
                                    <Link :href="route('roles.edit', { id: role.id })"
                                          class="btn btn-tbl-edit btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </Link>
                                    <button @click="confirmDelete(role.id)" class="btn btn-tbl-delete btn-xs"><i
                                        class="fa fa-trash-o "></i></button>
                                    <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                        <div class="p-6">
                                            <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete
                                                ?</h4>
                                            <div class="mt-6 flex space-x-4">
                                                <DangerButton @click="deleteRole(deleteID)">Delete</DangerButton>
                                                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div v-if="roles == ''" style="color: red; text-align: center">No data</div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
