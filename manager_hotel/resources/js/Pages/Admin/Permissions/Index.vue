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
    permissions: Array,
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

const deletePermission = (id) => {
    form.delete(route('permissions.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>

<template>
    <Head title="Permissions"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Permissions</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Permissions</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Permissions</header>
                    </div>
                    <div class="card-body col-6" style="margin: auto">
                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                <th class="center"> ID</th>
                                <th class="center"> Name</th>
                                <!--                                    <th class="center"> Action</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="permission in permissions" :key="permission.id" class="odd gradeX">
                                <td class="center">{{ permission.id }}</td>
                                <td class="center">{{ permission.name }}</td>
                                <!--                                    <td class="center">-->
                                <!--                                        <Link :href="route('permissions.edit', { id: permission.id })"-->
                                <!--                                              class="btn btn-tbl-edit btn-xs">-->
                                <!--                                            <i class="fa fa-pencil"></i>-->
                                <!--                                        </Link>-->
                                <!--                                        <button @click="confirmDelete(permission.id)" class="btn btn-tbl-delete btn-xs"><i-->
                                <!--                                            class="fa fa-trash-o "></i></button>-->
                                <!--                                        <Modal :show="showConfirmDeleteModal" @close="closeModal">-->
                                <!--                                            <div class="p-6">-->
                                <!--                                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete-->
                                <!--                                                    ?</h4>-->
                                <!--                                                <div class="mt-6 flex space-x-4">-->
                                <!--                                                    <DangerButton @click="deletePermission(deleteID)">Delete</DangerButton>-->
                                <!--                                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>-->
                                <!--                                                </div>-->
                                <!--                                            </div>-->
                                <!--                                        </Modal>-->
                                <!--                                    </td>-->
                            </tr>
                            </tbody>
                        </table>
                        <div v-if="permissions == ''" style="color: red; text-align: center">No data</div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
