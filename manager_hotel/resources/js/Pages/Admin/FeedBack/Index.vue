<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm, usePage} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {ref} from "vue";
import {usePermission} from "@/Composables/permissions";

const { hasPermission } = usePermission();
const form = useForm({})
const props = defineProps({
    feedBack: Array,
})

const dataSelect = ref();

const selected= ref(0);

function searchData() {
    router.get('feed-back', { search: search.value }, { preserveState: true })
}

function handleChange(status, id) {
    usePage().props.flash.action_success = null
    axios.post(route('feed-back.report'), { id: id, status: status})
        .then(response => {
            usePage().props.flash.action_success = response.data.message
        })
        .catch(error => {
            console.error(error);
        });
}

</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<Link class="parent-item" :href="route('dashboard')">Home</Link>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><Link class="parent-item" href="">FeedBack</Link>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All FeedBack</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All FeedBack</header>
                    </div>
                    <div class="card-body col-7" style="margin: auto">
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
                                    <th class="center"> Customer</th>
                                    <th class="center"> Subject</th>
                                    <th class="center"> Content</th>
                                    <th class="center"> Start rate</th>
                                    <th class="center"> Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="value in feedBack.data" :key="value.id" class="odd gradeX">
                                    <td class="center">{{ value.id }}</td>
                                    <td class="center">{{ value.name }}</td>
                                    <td class="center">{{ value.subject }}</td>
                                    <td class="center">{{ value.content }}</td>
                                    <td class="center">{{ value.star_rate }}</td>
                                    <td class="center">
                                        <div class="col-md-12">
                                            <label class="btn btn-success deepPink-bgcolor">
                                                <input type="radio" :name="value.id" v-model="value.active" value="1" @change="handleChange(1, value.id)"> Active
                                            </label>
                                            <label class="btn btn-danger deepPink-bgcolor">
                                                <input type="radio" :name="value.id" v-model="value.active" value="0" @change="handleChange(0, value.id)"> Inactive
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="feedBack.data == ''" style="color: red; text-align: center">No data</div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="feedBack.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
