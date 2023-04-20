<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, Head, router, useForm} from '@inertiajs/vue3';
import AllBooking from "@/Components/Admin/Booking/AllBooking.vue";
import {ref} from "vue";

const props = defineProps({
    bookings: Array,
    status: Array,
})

const route = ref('booking')
</script>

<template>
    <Head title="Booking"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
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
                    </div>
                    <AllBooking :bookings = "bookings"  :status="status"></AllBooking>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
