<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {reactive, ref} from "vue";
import FormPicker from '@/Components/Admin/FormPicker.vue';

const props = defineProps({
    typeBooking: Array,
    bookingRoom: Object,
    idBooking: Array,
})

const newBooking = props.bookingRoom.booking_room.map(function (booking) {
    return {
        'id': booking.room.id,
        'name': booking.room.name,
        'number_people': booking.room.number_people,
    }
})

const data = ref({
    typeBooking: props.typeBooking,
    counter: 0,
    rooms: newBooking,
})

function addField(rooms) {
    data.value.rooms.push({});
}

function removeField(index, rooms) {
    data.value.rooms.splice(index, 1);
}

const range = ref({
    start: props.bookingRoom.time_check_in,
    end: props.bookingRoom.time_check_out,
})

const form = useForm({
    name: props.bookingRoom.customer.name,
    range: range,
    type_booking: '',
    rooms : data.value.rooms,
    id_booking: props.idBooking
});

data.value.typeBooking.forEach((type) => {
    if (type.value == props.bookingRoom.type_booking) {
        form.type_booking = type;
    }
})

const filterRoom = () => {
    form.get(route('booking.edit_filter_room'))
};
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
                    <form @submit.prevent="filterRoom">
                        <div class="card-body row pl-5 pr-5" id="edit-form">
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Name Customer</label>
                                    <input type="text" readonly class="form-control" id="name" name="name"
                                           v-model="form.name">
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

                            <div class="col-lg-3 p-t-20" v-for="(input, index) in data.rooms" :id="`room-$(index)`">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="typo__label">Room {{ input.name }} - Number People</label>
                                        <input type="number" name="rooms" v-model="input.number_people"
                                               class="form-control">
                                    </div>
                                    <div>
                                        <a @click.prevent="addField(rooms)" href=""><i
                                            class="fa fa-plus-circle"></i></a>
                                        <a v-if="index != 0" @click.prevent="removeField(index, rooms)" href=""><i
                                            class="fa fa-minus-circle text-danger"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Continue<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            <Link :href="route('booking.index')"
                                  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                  data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
