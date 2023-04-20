<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link,Head} from '@inertiajs/vue3';
import {ref} from "vue";
import { usePermission } from "@/Composables/permissions"
const { hasRole } = usePermission();
const { hasPermission } = usePermission();
import AllBooking from "@/Components/Admin/Booking/AllBooking.vue";

const props = defineProps({
    totalCheckIn: Array,
    totalCheckOut: Array,
    totalEA: Array,
    totalMoney: Array,
    bookings: Array,
    status: Array,
})
</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Dashboard</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- start widget -->
        <div class="state-overview">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-blue">
                        <span class="info-box-icon push-bottom"><i class="material-icons">style</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Expected arrival</span>
                            <span class="info-box-number">{{ totalEA }}</span>
                            <div class="progress">
                                <div class="progress-bar width-60"></div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-orange">
                        <span class="info-box-icon push-bottom"><i class="material-icons">phone_in_talk</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Check in</span>
                            <span class="info-box-number">{{ totalCheckIn }}</span>
                            <div class="progress">
                                <div class="progress-bar width-40"></div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-purple">
                        <span class="info-box-icon push-bottom"><i class="material-icons">card_travel</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Check out</span>
                            <span class="info-box-number">{{ totalCheckOut }}</span>
                            <div class="progress">
                                <div class="progress-bar width-80"></div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-success">
                        <span class="info-box-icon push-bottom"><i class="material-icons">monetization_on</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Earning</span>
                            <span class="info-box-number">{{ totalMoney.total_money ? parseInt(totalMoney.total_money).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) : 0}}</span><span></span>
                            <div class="progress">
                                <div class="progress-bar width-60"></div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- end widget -->
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
