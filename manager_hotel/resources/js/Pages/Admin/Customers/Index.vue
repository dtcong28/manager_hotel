<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {ref} from "vue";

const form = useForm({})
const props = defineProps({
    customers: Object,
})

function searchData() {
    router.get('customers', { search: search.value }, { preserveState: true })
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

const deleteCustomer = (id) => {
    form.delete(route('customers.destroy', id), {
        onSuccess: () => closeModal()
    });
}

</script>

<template>
    <Head title="Customers"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Customers</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Customers</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Customers</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Customers</header>
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
                                    <a :href="route('customers.create')" id="addRow" class="btn btn-info">
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
                                    <th class="center"> Address</th>
                                    <th class="center"> Gender</th>
                                    <th class="center"> Phone</th>
                                    <th class="center"> Email</th>
                                    <th class="center"> Identity card</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="customer in customers.data" :key="customer.id" class="odd gradeX">
                                    <td class="center">{{ customer.id }}</td>
                                    <td class="center">{{ customer.name }}</td>
                                    <td class="center">{{ customer.address }}</td>
                                    <td class="center">{{ customer.gender_label }}</td>
                                    <td class="center">{{ customer.phone }}</td>
                                    <td class="center">{{ customer.email }}</td>
                                    <td class="center">{{ customer.identity_card }}</td>
                                    <td class="center">
                                        <Link :href="route('customers.edit', { id: customer.id })" class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <button @click="confirmDelete(customer.id)" class="btn btn-tbl-delete btn-xs"><i class="fa fa-trash-o "></i></button>
                                        <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                            <div class="p-6">
                                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete ?</h4>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="deleteCustomer(deleteID)">Delete</DangerButton>
                                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                                </div>
                                            </div>
                                        </Modal>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="customers.data == ''" style="color: red; text-align: center">No data</div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="customers.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
