<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    rooms: Array
})
</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Rooms</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Rooms</li>
                </ol>
            </div>
        </div>
        <div v-if="$page.props.flash.action_success" class="alert alert-success">
            {{ $page.props.flash.action_success }}
        </div>
        <div v-if="$page.props.flash.action_failed" class="alert alert-danger">
            {{ $page.props.flash.action_failed }}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Bookings</header>
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
                                    <a href="add_room.html" id="addRow" class="btn btn-info">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <div class="btn-group pull-right">
                                    <a class="btn deepPink-bgcolor  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-print"></i> Print </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <div id="example4_wrapper"
                                 class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="example4_length"><label>Show <select
                                            name="example4_length" aria-controls="example4"
                                            class="form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="example4_filter" class="dataTables_filter"><label>Search:<input
                                            type="search" class="form-control form-control-sm" placeholder=""
                                            aria-controls="example4"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dataTables_scroll">
                                            <div class="dataTables_scrollHead"
                                                 style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                                <div class="dataTables_scrollHeadInner"
                                                     style="box-sizing: content-box; width: 1016px; padding-right: 0px;">
                                                    <table
                                                        class="table table-hover table-checkable order-column full-width dataTable no-footer"
                                                        role="grid" style="margin-left: 0px; width: 1016px;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="center sorting_asc" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 50.4688px;" aria-sort="ascending"
                                                                aria-label=" img : activate to sort column descending">
                                                                img
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 27.375px;"
                                                                aria-label=" # : activate to sort column ascending"> #
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 55.5469px;"
                                                                aria-label=" Type : activate to sort column ascending">
                                                                Type
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 114.891px;"
                                                                aria-label=" AC/Non AC : activate to sort column ascending">
                                                                Status
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 91.7656px;"
                                                                aria-label=" Meal : activate to sort column ascending">
                                                                Size
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 136.016px;"
                                                                aria-label=" Bad Capacity : activate to sort column ascending">
                                                                Max people
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 82.7031px;"
                                                                aria-label=" Phone : activate to sort column ascending">
                                                                Number bed
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 52.5312px;"
                                                                aria-label=" Rent : activate to sort column ascending">
                                                                Rent
                                                            </th>
                                                            <th class="center sorting" tabindex="0"
                                                                aria-controls="example4" rowspan="1" colspan="1"
                                                                style="width: 70.7031px;"
                                                                aria-label=" Action : activate to sort column ascending">
                                                                Action
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="room in rooms" :key="room.id" class="gradeX odd" role="row">
                                                            <td class="user-circle-img sorting_1">
                                                                <img src="{{ }}" alt="">
                                                            </td>
                                                            <td class="center">{{ room.id }}</td>
                                                            <td class="center">{{ room.type_room_id }}</td>
                                                            <td class="center">{{ room.status }}</td>
                                                            <td class="center">{{ room.size }}</td>
                                                            <td class="center">{{ room.max_person }}</td>
                                                            <td class="center">{{ room.number_bed }}</td>
                                                            <td class="center">{{ room.rent_per_night }}</td>
                                                            <td class="center">
                                                                <a class="btn btn-tbl-edit btn-xs">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-tbl-delete btn-xs">
                                                                    <i class="fa fa-trash-o "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="example4_info" role="status"
                                             aria-live="polite">Showing 1 to 10 of 12 entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="example4_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="example4_previous"><a href="#" aria-controls="example4"
                                                                              data-dt-idx="0" tabindex="0"
                                                                              class="page-link">Previous</a></li>
                                                <li class="paginate_button page-item active"><a href="#"
                                                                                                aria-controls="example4"
                                                                                                data-dt-idx="1"
                                                                                                tabindex="0"
                                                                                                class="page-link">1</a>
                                                </li>
                                                <li class="paginate_button page-item "><a href="#"
                                                                                          aria-controls="example4"
                                                                                          data-dt-idx="2" tabindex="0"
                                                                                          class="page-link">2</a></li>
                                                <li class="paginate_button page-item next" id="example4_next"><a
                                                    href="#" aria-controls="example4" data-dt-idx="3" tabindex="0"
                                                    class="page-link">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content tab-space">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="room in rooms" :key="room.id">
                    <th scope="row">{{ room.id }}</th>
                    <td>{{ room.name }}</td>
                    <td>
                        <Link :href="`/admin/rooms/${room.id}/edit`">Edit</Link>
                        <br/>
                        <Link :href="`/admin/rooms/${room.id}`" method="delete" type="button">Delete</Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
