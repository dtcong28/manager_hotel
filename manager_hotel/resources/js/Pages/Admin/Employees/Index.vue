<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link,Head} from '@inertiajs/vue3';

const props = defineProps({
    employees: Array
})

</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">All Staffs</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Staffs</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">All Staffs</li>
                </ol>
            </div>
        </div>
        <ul class="nav nav-pills nav-pills-rose">
            <li class="nav-item tab-all"><a class="nav-link active show" href="#tab1" data-toggle="tab">List View</a>
            </li>
            <li class="nav-item tab-all"><a class="nav-link" href="#tab2" data-toggle="tab">Grid View</a></li>
        </ul>
        <div class="tab-content tab-space">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="employee in employees" :key="employee.id">
                    <th scope="row">{{ employee.id }}</th>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>
                        <Link :href="`/admin/employees/${employee.id}/edit`">Edit</Link>
                        <br/>
                        <Link :href="`/admin/employees/${employee.id}`" method="delete" type="button">Delete</Link>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
