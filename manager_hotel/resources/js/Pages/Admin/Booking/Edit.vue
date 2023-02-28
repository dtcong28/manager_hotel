<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {reactive, ref} from "vue";
import FormPicker from '@/Components/Admin/FormPicker.vue';

const props = defineProps({
    typeBooking: Array,
    bookingRoom: Object,
})

const data = ref({
    typeBooking: props.typeBooking,
    numberRooms: [
        {value : 1},
        {value : 2},
        {value : 3},
        {value : 4},
    ],
    counter: 0,
})

const range = ref({
    start: props.bookingRoom.time_check_in,
    end: props.bookingRoom.time_check_out,
})

const form = useForm({
    name: props.bookingRoom.customer.name,
    range: range,
    type_booking: '',
    number_room: '',
    rooms : props.bookingRoom.booking_room,
});

data.value.typeBooking.forEach((type) => {
    if (type.value == props.bookingRoom.type_booking) {
        form.type_booking = type;
    }
})

data.value.numberRooms.forEach((data) => {
    if (data.value == props.bookingRoom.booking_room.length) {
        form.number_room = data;
    }
})

function handleClick() {
    this.active = true;
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Edit Booking Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Edit Booking Details</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Edit Booking Details</header>
                    </div>
                    <pre>{{ props.bookingRoom }}</pre>
                    <form @submit.prevent="filterRoom">
                        <div class="card-body row pl-5 pr-5">
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Name Customer</label>
                                    <input type="text" readonly class="form-control" id="name" name="name" v-model="form.name">
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <FormPicker v-model="form.range"/>
                                </div>
                            </div>

                            <div class="col-lg-12 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Type Booking</label>
                                    <multiselect v-model="form.type_booking" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="data.typeBooking" :searchable="false" :allow-empty="false"></multiselect>
                                </div>

                            </div>

                            <div class="col-lg-12 p-t-20" v-if="form.rooms.length < 4 && (form.rooms.length + data.counter) < 4">
                                <i class="fa fa-plus-square" @click="data.counter += 1"></i> Add Room
                            </div>

                            <div class="col-lg-3 p-t-20" v-for="data in form.rooms" :id="data.room.name">
                                <div class="form-group">
                                    <label class="typo__label">Room {{ data.room.name }}</label>
                                    <input type="number" name="rooms" v-model="data.room.number_people" class="form-control">
                                </div>
                                <i class="fa fa-minus-square" @click="handleClick"></i>
                            </div>

                            <div class="col-lg-3 p-t-20" v-for="index in data.counter" :id="index">
                                <div class="form-group">
                                    <label class="typo__label">Room - Number People</label>
                                    <input type="number" name="rooms" v-model="data.room" class="form-control">
                                </div>
                                <i class="fa fa-minus-square"></i>
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
