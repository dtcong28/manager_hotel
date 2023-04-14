<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation : '',
    phone: '',
    gender: '',
    role: '',
});

const props = defineProps({
    gender: Array,
})

const data = ref({
    genderOptions: props.gender,
})

const storeEmployee = () => {
    form.post(route('employees.store'))
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<Link class="parent-item" :href="route('dashboard')">Home</Link>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li><Link class="parent-item" :href="route('employees.create')">Employee</Link>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Employee</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Add Employee</header>
                    </div>
                    <form @submit.prevent="storeEmployee">
                        <div class="card-body row pl-5 pr-5">
                            <div class="row">
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="name">Employee Name</label>
                                        <input type="text" v-model="form.name" class="form-control" id="name" name="name" placeholder="Enter name">
                                        <div v-if="form.errors.name" style="color: red">{{ form.errors.name[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <multiselect v-model="form.gender" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="data.genderOptions" :searchable="false" :allow-empty="false"></multiselect>
                                        <div v-if="form.errors.gender" style="color: red">{{ form.errors.gender[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" v-model="form.phone" class="form-control" id="phone" placeholder="Enter phone">
                                        <div v-if="form.errors.phone" style="color: red">{{ form.errors.phone[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" v-model="form.email" class="form-control" id="email" placeholder="Enter email">
                                        <div v-if="form.errors.email" style="color: red">{{ form.errors.email[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" v-model="form.password" class="form-control" id="password" placeholder="Enter password">
                                        <div v-if="form.errors.password" style="color: red">{{ form.errors.password[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="password_confirmation ">Password Confirm</label>
                                        <input type="password" name="password_confirmation" v-model="form.password_confirmation" class="form-control" id="password_confirmation " placeholder="Enter password confirm">
                                        <div v-if="form.errors.password_confirmation " style="color: red">{{ form.errors.password_confirmation [0] }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink" data-upgraded=",MaterialButton,MaterialRipple">Submit<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                                <Link :href="route('employees.index')" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-upgraded=",MaterialButton,MaterialRipple">Cancel<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
