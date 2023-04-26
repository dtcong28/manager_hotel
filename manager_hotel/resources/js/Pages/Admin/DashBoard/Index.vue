<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, Head, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import { usePermission } from "@/Composables/permissions"
const { hasRole } = usePermission();
const { hasPermission } = usePermission();
import AllBooking from "@/Components/Admin/Booking/AllBooking.vue";
import Multiselect from 'vue-multiselect'
import {Inertia} from "@inertiajs/inertia";

const dataReport = ref();

const props = defineProps({
    totalCheckIn: Array,
    totalCheckOut: Array,
    totalEA: Array,
    totalMoney: Array,
    totalRooms: Array,
    totalEmployee: Array,
    totalCustomer: Array,
    totalFood: Array,
    bookings: Array,
    status: Array,
})

const selectedValues = ref({name: 'all time', value: 0});

const data = ref({
    default : {name: 'all time', value: 0},
    time: [
        {name: 'all time', value: 0},
        {name: '1 day', value: 1},
        {name: '1 week', value: 2},
        {name: '1 month', value: 3},
        {name: '1 year', value: 4},
    ],
})

const getListByTime = () => {
    axios.post(route('dashboard.report'), { time: selectedValues.value })
        .then(response => {
            dataReport.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

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
        <div class="state-overview pb-4">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-b-pink">
                        <span class="info-box-icon push-bottom"><i class="fa fa-user-circle-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Employee</span>
                            <span class="info-box-number">{{ totalEmployee }}</span>
                            <div class="progress">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-b-black">
                        <span class="info-box-icon push-bottom"><i class="fa fa-vcard"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customer</span>
                            <span class="info-box-number">{{ totalCustomer }}</span>
                            <div class="progress">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-b-green">
                        <span class="info-box-icon push-bottom"><i class="fa fa-eercast"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Food</span>
                            <span class="info-box-number">{{totalFood}}</span>
                            <div class="progress">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-b-yellow">
                        <span class="info-box-icon push-bottom"><i class="fa fa-imdb"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Room</span>
                            <span class="info-box-number"></span><span>{{ totalRooms }}</span>
                            <div class="progress">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- start widget -->
        <div class="state-overview">
            <div class="row col-2 pb-3">
                <multiselect v-model="selectedValues" deselect-label="Can't remove" @update:modelValue="getListByTime"
                             track-by="value" label="name" placeholder="Select one"
                             :options="data.time" :searchable="false"
                             :allow-empty="false"></multiselect>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-blue">
                        <span class="info-box-icon push-bottom"><i class="material-icons">style</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Expected arrival</span>
                            <span class="info-box-number">{{ selectedValues.value == 0 ? totalEA : dataReport.report.totalBookingEA }}</span>
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
                            <span class="info-box-number">{{ selectedValues.value == 0 ? totalCheckIn : dataReport.report.totalBookingCheckIn }}</span>
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
                            <span class="info-box-number">{{ selectedValues.value == 0 ? totalCheckOut : dataReport.report.totalBookingCheckOut }}</span>
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
                            <span class="info-box-number"></span>
                            <span>
                            {{ selectedValues.value == 0 ? (totalMoney.total_money == null ? 0 : parseInt(totalMoney.total_money).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })) : (dataReport.report.totalMoney.total_money == null ? 0 : parseInt(dataReport.report.totalMoney.total_money).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }))}}
                            </span>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>Chart Survey</header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body no-padding height-9">
                        <div class="row text-center">
                            <div class="col-sm-3 col-6">
                                <h4 class="margin-0">$ 209 </h4>
                                <p class="text-muted"> Today's Income</p>
                            </div>
                            <div class="col-sm-3 col-6">
                                <h4 class="margin-0">$ 837 </h4>
                                <p class="text-muted">This Week's Income</p>
                            </div>
                            <div class="col-sm-3 col-6">
                                <h4 class="margin-0">$ 3410 </h4>
                                <p class="text-muted">This Month's Income</p>
                            </div>
                            <div class="col-sm-3 col-6">
                                <h4 class="margin-0">$ 78,000 </h4>
                                <p class="text-muted">This Year's Income</p>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                </div>
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
