<script setup xmlns="http://www.w3.org/1999/html">
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";

const props = defineProps({
    booking: Array,
    customer: Array,
    bookingRoom: Array,
    bookingFood: Array,
    status: Array,
})

const sum = ref([])

props.bookingRoom.forEach((room) => {
    sum.value.push(room.price)
})

props.bookingFood.forEach((food) => {
    sum.value.push(food.price)
})

const form = useForm({
    status_payment: props.booking.status_payment,
    status_booking: props.booking.status_booking,
});

const updateStatus= () => {
    router.post(`/admin/booking/${props.booking.id}/update-status`, {
        _method: 'PATCH',
        status_payment: form.status_payment,
        status_booking: form.status_booking,
        time_check_in: props.booking.time_check_in,
        time_check_out: props.booking.time_check_out,
        rooms: props.bookingRoom,
    })
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Detail</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Detail booking</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Information Booking</header>
                    </div>
                    <div class="row">
                        <div class="card-body pl-5 pr-5" style="line-height: 0.4">
                            <h4>Customer: {{ customer.name }}</h4><br>
                            <h4>Address: {{ customer.address }}</h4><br>
                            <h4>Phone: {{ customer.phone }}</h4><br>
                            <h4>Email: {{ customer.email }}</h4><br>
                            <h4>Indentity card: {{ customer.identity_card }}</h4><br>
                        </div>
                        <div class="card-body pl-5 pr-5" style="line-height: 0.4">
                            <h4>Check in: {{ booking.time_check_in }} - Check out: {{ booking.time_check_out }}</h4><br>
                            <h4>Number rooms: {{ booking.number_rooms }}</h4><br>
                            <h4>Status:
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="btn btn-warning deepPink-bgcolor">
                                            <input type="radio" name="status_booking" v-model="form.status_booking"
                                                   value="2" :checked="form.status_booking == 2" :disabled="booking.status_booking == 0 || booking.status_booking == 1" v-bind:style= "[booking.status_booking == 0 || booking.status_booking == 1 ? 'opacity: 0.3' : '']">
                                            Expected arrival
                                        </label>
                                        <label class="btn btn-info deepPink-bgcolor">
                                            <input type="radio" name="status_booking" v-model="form.status_booking"
                                                   value="1" :checked="form.status_booking == 1" :disabled="booking.status_booking == 0" v-bind:style= "[booking.status_booking == 0 ? 'opacity: 0.3' : '']">
                                            Check in
                                        </label>
                                        <label class="btn btn-danger deepPink-bgcolor">
                                            <input type="radio" name="status_booking" v-model="form.status_booking"
                                                   value="0" :checked="form.status_booking == 0" :disabled="booking.status_booking == 2" v-bind:style= "[booking.status_booking == 2 ? 'opacity: 0.3' : '']">
                                            Check out
                                        </label>
                                    </div>
                                </div>
                            </h4><br>
                            <h4>Payment:
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="btn btn-success deepPink-bgcolor">
                                            <input type="radio" name="payment" v-model="form.status_payment" value="1"
                                                   :checked="form.status_payment == 1"> Paid
                                        </label>
                                        <label class="btn btn-danger deepPink-bgcolor">
                                            <input type="radio" name="payment" v-model="form.status_payment" value="0"
                                                   :checked="form.status_payment == 0"> Unpaid
                                        </label>
                                    </div>
                                </div>
                            </h4>
                            <br>
                            <h4>Total Money: {{ sum.reduce((partialSum, a) => partialSum + a, 0).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body" v-if="bookingRoom.length">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Room</th>
                                        <th> Status</th>
                                        <th> Number people</th>
                                        <th> Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(value, key) in bookingRoom" :key="value.id">
                                        <td> {{ key }}</td>
                                        <td> {{ value.room.name }}</td>
                                        <td>
                                            <div v-for="data in status">
                                                <span v-if="data.value==value.room.status">{{ data.name }}</span>
                                            </div>
                                        </td>
                                        <td> {{ value.number_people }}</td>
                                        <td> {{ value.price }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body" v-if="bookingFood.length">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Food</th>
                                        <th> Amount</th>
                                        <th> Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(value, key) in bookingFood" :key="value.id">
                                        <td> {{ key }}</td>
                                        <td> {{ value.food.name }}</td>
                                        <td> {{ value.amount }}</td>
                                        <td> {{ value.price }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="updateStatus">
                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Submit<span
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
