<script setup>
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    bookings: Array,
    customer: Array,
});
</script>

<template>
    <Head title="Your booking" />

    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Your booking</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section contact-section bg-light">
            <div class="container">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <h3>Information Booking</h3>
                        <div class="card-body pl-5 pr-5" style="line-height: 0.4">
                            <h5>Customer: {{ customer.name }}</h5><br>
                            <h5>Address: {{ customer.address }}</h5><br>
                            <h5>Phone: {{ customer.phone }}</h5><br>
                            <h5>Email: {{ customer.email }}</h5><br>
                            <h5>Indentity card: {{ customer.identity_card }}</h5><br>
                        </div>
                        <div style="line-height: 0.4" v-for="(booking, key) in bookings" :key="booking.id">
                            <h5 style="font-weight: bold">Booking {{ key + 1}}:</h5>
                            <div class="row">
                                <div class="col">
                                    <h5>Check in: {{ booking.time_check_in }} - Check out: {{ booking.time_check_out }}</h5><br>
                                    <h5>Number rooms: {{ booking.number_rooms }}</h5><br>
                                </div>
                                <div class="col">
                                    <h5>Status booking: {{ booking.status_booking_label }}</h5><br>
                                    <h5>Payment: {{ booking.status_payment_label }}</h5><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body" v-if="booking.booking_room.length">
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th> #</th>
                                                <th> Room</th>
                                                <th> Number people</th>
                                                <th> Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(value, key) in booking.booking_room" :key="value.id">
                                                <td> {{ key }}</td>
                                                <td> {{ value.room.name }}</td>
                                                <td> {{ value.number_people }}</td>
                                                <td> {{ value.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-body" v-if="booking.booking_food.length">
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
                                            <tr v-for="(value, key) in booking.booking_food" :key="value.id">
                                                <td> {{ key }}</td>
                                                <td> {{ value.food.name }}</td>
                                                <td> {{ value.amount }}</td>
                                                <td> {{ value.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
