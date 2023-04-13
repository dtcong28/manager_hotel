<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {ref} from "vue";

</script>

<template>
    <Head title="Permissions"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Permissions</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Permissions</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Permissions</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>All Permissions</header>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
