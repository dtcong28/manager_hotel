<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {usePermission} from "@/Composables/permissions";
const { hasPermission } = usePermission();

const props = defineProps({
    customer: Object,
    discounts: Object,
})

const form = useForm({
    percent: '',
    expiration_date: '',
    customer_id: props.customer.id,
    status: 0,
});

const discount = () => {
    form.post(route('customers.store_discount'))
};

const showConfirmDeleteModal = ref(false)
const deleteID = ref('')

const confirmDelete = (id) => {
    showConfirmDeleteModal.value = true
    deleteID.value = id
}

const closeModal = () => {
    showConfirmDeleteModal.value = false;
}

const deleteDiscount = (id) => {
    form.delete(route('customers.destroy_discount', id), {
        onSuccess: () => closeModal()
    });
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Customer</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Discount Customer</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Discount For {{ props.customer.name }}</header>
                    </div>
                    <div class="card-body col-7" style="margin: auto">
                        <div v-if="props.discounts != ''">
                            <div class="table-scrollable">
                                <table class="table table-hover table-checkable order-column full-width" id="example4">
                                    <thead>
                                    <tr>
                                        <th class="center"> #</th>
                                        <th class="center"> Percent</th>
                                        <th class="center"> Expiration Date</th>
                                        <th class="center"> Status</th>
                                        <th class="center"> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="discount in props.discounts" :key="discount.id" class="odd gradeX">
                                        <td class="center">{{ discount.id }}</td>
                                        <td class="center">{{ discount.percent }}%</td>
                                        <td class="center">{{ discount.expiration_date }}</td>
                                        <td class="center">
                                            <span v-if="discount.status == 0" class="label label-sm label-danger">{{ discount.status_label }}</span>
                                            <span v-if="discount.status == 1" class="label label-sm label-success">{{ discount.status_label }}</span>
                                        </td>
                                        <td class="center">
                                            <button v-if="hasPermission('delete')" @click="confirmDelete(discount.id)" class="btn btn-tbl-delete btn-xs"><i class="fa fa-trash-o "></i></button>
                                            <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                                <div class="p-6">
                                                    <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete</h4>
                                                    <div class="mt-6 flex space-x-4">
                                                        <DangerButton @click="deleteDiscount(deleteID)">Delete</DangerButton>
                                                        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                                    </div>
                                                </div>
                                            </Modal>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="discount">
                        <div class="card-body col-7" style="margin: auto">
                            <div class="row">
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="percent">Percent</label>
                                        <input type="text" v-model="form.percent" class="form-control" id="percent" name="percent" placeholder="Enter percent discount">
                                        <div v-if="form.errors.percent" style="color: red">{{ form.errors.percent[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label>Expiration Date</label>
                                        <input name="expiration_date" id="expiration_date"
                                               v-model="form.expiration_date" type="date"
                                               class="form-control">
                                        <div v-if="$page.props.errors.expiration_date" style="color: red">
                                            {{ $page.props.errors.expiration_date[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink" data-upgraded=",MaterialButton,MaterialRipple">Submit<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                                <Link :href="route('customers.index')" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-upgraded=",MaterialButton,MaterialRipple">Cancel<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
