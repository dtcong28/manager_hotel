<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const form = useForm({
    name: '',
    email: '',
});

const storeEmployee = () => {
    form.post(route('employees.store'))
};

</script>

<template>
    <Head title="Employees"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Add Staff Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Staff</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Staff Details</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Basic Information</header>
                        <button id="panel-button"
                                class="mdl-button mdl-js-button mdl-button--icon pull-right"
                                data-upgraded=",MaterialButton">
                            <i class="material-icons">more_vert</i>
                        </button>
                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                            data-mdl-for="panel-button">
                            <li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action</li>
                            <li class="mdl-menu__item"><i class="material-icons">print</i>Another action</li>
                            <li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else here</li>
                        </ul>
                    </div>
                    <div class="card-body " id="bar-parent">
                        <form>
                            <div class="row">
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormEmail">Email address</label>
                                        <input type="email" class="form-control" id="simpleFormEmail"
                                               placeholder="Enter email address">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormEmail">Email address</label>
                                        <input type="email" class="form-control" id="simpleFormEmail"
                                               placeholder="Enter email address">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="simpleFormPassword">Password</label>
                                        <input type="password" class="form-control" id="simpleFormPassword"
                                               placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-icon-black">
                                    <input id="rememberChk1" type="checkbox" checked="checked">
                                    <label for="rememberChk1">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
