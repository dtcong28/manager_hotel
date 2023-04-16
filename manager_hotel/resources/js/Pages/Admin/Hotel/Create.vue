<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import {usePermission} from "@/Composables/permissions";

const {hasPermission} = usePermission();

const props = defineProps({
    hotel: Object,
})

const form = useForm({
    name: props.hotel.name,
    introduce: props.hotel.introduce,
    phone: props.hotel.phone,
    website: props.hotel.website,
    email: props.hotel.email,
    address: props.hotel.address,
});

const storeHotel = () => {
    form.post(route('hotel.store'))
};

</script>

<template>
    <Head title="Hotel"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Hotel</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Information</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Hotel Information</header>
                    </div>
                    <div class="card-body col-6" style="margin: auto">
                        <form @submit.prevent="storeHotel">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" v-model="form.name" class="form-control" id="name" name="name"
                                       placeholder="Enter name">
                                <div v-if="form.errors.name" style="color: red">{{ form.errors.name[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="text" v-model="form.phone" class="form-control" id="phone" name="phone"
                                       placeholder="Enter phone">
                                <div v-if="form.errors.phone" style="color: red">{{ form.errors.phone[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name">Website</label>
                                <input type="text" v-model="form.website" class="form-control" id="website"
                                       name="website" placeholder="Enter website">
                                <div v-if="form.errors.website" style="color: red">{{ form.errors.website[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" v-model="form.email" class="form-control" id="email" name="email"
                                       placeholder="Enter email">
                                <div v-if="form.errors.email" style="color: red">{{ form.errors.email[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" v-model="form.address" class="form-control" id="address"
                                       name="address" placeholder="Enter address">
                                <div v-if="form.errors.address" style="color: red">{{ form.errors.address[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="introduce">Introduce</label>
                                <textarea id="introduce" name="introduce" v-model="form.introduce" class="form-control"
                                          rows="3" placeholder="Enter introduce"></textarea>
                                <div v-if="form.errors.introduce" style="color: red">{{form.errors.introduce[0] }}
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center" v-if="hasPermission('create')">
                                <button type="submit"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                        data-upgraded=",MaterialButton,MaterialRipple">Save<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
