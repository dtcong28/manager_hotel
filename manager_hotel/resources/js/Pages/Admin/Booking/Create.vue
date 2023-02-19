<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";
import FormPicker from '@/Components/Admin/FormPicker.vue';

const form = useForm({
    name: '',
    type_booking: '',
    number_people: '',
    number_room: '',
    range: '',
});

const props = defineProps({
    customers: Array,
    typeBooking: Array,
})

const data = ref({
    customers: props.customers,
    typeBooking: props.typeBooking,
})

const filterRoom = () => {
    form.post(route('booking.filter_room'))
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Add Booking Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Booking Details</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Add Booking Details</header>
                    </div>
                    <form @submit.prevent="filterRoom">
                        <div class="card-body row pl-5 pr-5">
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Name Customer</label>
                                    <multiselect v-model="form.name" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="data.customers" :searchable="false" :allow-empty="false"></multiselect>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Type Booking</label>
                                    <multiselect v-model="form.type_booking" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="data.typeBooking" :searchable="false" :allow-empty="false"></multiselect>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label for="number_people">Number people</label>
                                    <input type="number" name="number_people" v-model="form.number_people" class="form-control" id="number_people" placeholder="Enter number people">
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label for="number_room">Number room</label>
                                    <input type="number" name="number_room" v-model="form.number_room" class="form-control" id="number_room" placeholder="Enter number room">
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <FormPicker v-model="form.range"/>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink" data-upgraded=",MaterialButton,MaterialRipple">Continue<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                                <Link :href="route('booking.index')" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-upgraded=",MaterialButton,MaterialRipple">Cancel<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
