<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import {Link} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    bookings: Array,
    status: Array,
})

const search = ref('')
const payment = ref('')

function searchData() {
    router.get('booking', { search: search.value }, { preserveState: true })
}

</script>

<template>
    <Head title="Booking"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Booking</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Booking</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Booking</header>
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
                                    <a :href="route('booking.create')" id="addRow" class="btn btn-info">
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
                                    <th class="center"> ID</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Phone</th>
                                    <th class="center"> Email</th>
                                    <th class="center"> Check in</th>
                                    <th class="center"> Check out</th>
                                    <th class="center"> Payment</th>
                                    <th class="center"> Status</th>
                                    <th class="center"> Detail</th>
                                    <th class="center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(booking, key) in props.bookings.data" :key="booking.id" class="odd gradeX">
                                    <td class="center">{{ booking.id }}</td>
                                    <td class="center">{{ booking.name }}</td>
                                    <td class="center">{{ booking.phone }}</td>
                                    <td class="center">{{ booking.email }}</td>
                                    <td class="center">{{ booking.time_check_in }}</td>
                                    <td class="center">{{ booking.time_check_out }}</td>
                                    <td class="center"><span
                                        :class="status[key].payment_class">{{ booking.status_payment_label }}</span></td>
                                    <td class="center"><span
                                        :class="status[key].booking_class">{{ booking.status_booking_label }}</span></td>
                                    <td class="center"><a :href="route('booking.detail', { id: booking.id })"
                                                          class="btn deepPink btn-outline btn-circle m-b-10">View</a>
                                    </td>
                                    <td class="center">
                                        <Link :href="route('booking.edit', { id: booking.id })"
                                              class="btn btn-tbl-edit btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <Link :href="route('booking.destroy', { id: booking.id })" method="delete"
                                              class="btn btn-tbl-delete btn-xs">
                                            <i class="fa fa-trash-o "></i>
                                        </Link>
                                        <Link :href="route('booking_food.create', { id: booking.id })"
                                              class="btn btn-tbl-delete btn-info btn-xs">
                                            <i class="fa fa-cutlery "></i>
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <pagination class="mt-6" :links="props.bookings.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
