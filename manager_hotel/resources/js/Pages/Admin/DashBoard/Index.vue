<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link,Head} from '@inertiajs/vue3';
import {ref} from "vue";
import { usePermission } from "@/Composables/permissions"
const { hasRole } = usePermission();
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
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
        {{ hasRole('admin') }}
        <!-- start widget -->
        <div class="state-overview">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-blue">
                        <span class="info-box-icon push-bottom"><i class="material-icons">style</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Orders</span>
                            <span class="info-box-number">450</span>
                            <div class="progress">
                                <div class="progress-bar width-60"></div>
                            </div>
                            <span class="progress-description">
					                    60% Increase in 28 Days
					                  </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-orange">
                        <span class="info-box-icon push-bottom"><i class="material-icons">card_travel</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">New Booking</span>
                            <span class="info-box-number">155</span>
                            <div class="progress">
                                <div class="progress-bar width-40"></div>
                            </div>
                            <span class="progress-description">
					                    40% Increase in 28 Days
					                  </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="info-box bg-purple">
                        <span class="info-box-icon push-bottom"><i class="material-icons">phone_in_talk</i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inquiry</span>
                            <span class="info-box-number">52</span>
                            <div class="progress">
                                <div class="progress-bar width-80"></div>
                            </div>
                            <span class="progress-description">
					                    80% Increase in 28 Days
					                  </span>
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
                            <span class="info-box-number">13,921</span><span>$</span>
                            <div class="progress">
                                <div class="progress-bar width-60"></div>
                            </div>
                            <span class="progress-description">
					                    60% Increase in 28 Days
					                  </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- end widget -->
        <!-- chart start -->
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
                            <div id="area_line_chart" class="width-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart end -->
    </AdminLayout>
</template>
