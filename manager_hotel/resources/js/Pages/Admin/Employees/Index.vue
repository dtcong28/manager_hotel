<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {Link, Head, router, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const form = useForm({})
const props = defineProps({
    employees: Object,
})

function searchData() {
    router.get('employees', { search: search.value }, { preserveState: true })
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

const deleteEmployee = (id) => {
    form.delete(route('employees.destroy', id), {
        onSuccess: () => closeModal()
    });
}

</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<Link class="parent-item" :href="route('dashboard')">Home</Link>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li><Link class="parent-item" :href="route('employees.index')">Employees</Link>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Employees</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Employees</header>
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
                                    <Link :href="route('employees.create')" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </Link>
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
                                    <th class="center"> Gender</th>
                                    <th class="center"> Phone</th>
                                    <th class="center"> Email</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="employees.data" v-for="employee in employees.data" :key="employee.id" class="odd gradeX">
                                    <td class="center">{{ employee.id }}</td>
                                    <td class="center">{{ employee.name }}</td>
                                    <td class="center">{{ employee.gender_label }}</td>
                                    <td class="center">{{ employee.phone }}</td>
                                    <td class="center">{{ employee.email }}</td>
                                    <td class="center">
                                        <Link :href="route('employees.edit', { id: employee.id })" class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <button @click="confirmDelete(employee.id)" class="btn btn-tbl-delete btn-xs"><i class="fa fa-trash-o "></i></button>
                                        <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete ?</h4>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="deleteEmployee(deleteID)">Delete</DangerButton>
                                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                                </div>
                                            </div>
                                        </Modal>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="employees.data == ''" style="color: red; text-align: center">No data</div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="employees.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
