<script setup>
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import InfoBooking from "@/Components/Web/InfoBooking.vue";

const props = defineProps({
    bookingCheckIn: Array,
    bookingCheckOut: Array,
    bookingCheckEA: Array,
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
                        <h3>Discount</h3>
                        <div v-for="discount in customer.discount" class="card-body pl-5 pr-5" style="line-height: 0.4">
                            <span>Percent: {{ discount.percent }}%</span> -
                            <span>Status: {{ discount.status_label }}</span> -
                            <span>Expiration Date: {{ discount.expiration_date }}</span>
                        </div>
                        <h3 v-if="bookingCheckIn.length != 0" class="text-center">Check In</h3>
                        <InfoBooking :bookings="bookingCheckIn"></InfoBooking>
                        <h3 v-if="bookingCheckOut.length != 0" class="text-center">Check Out</h3>
                        <InfoBooking :bookings="bookingCheckOut"></InfoBooking>
                        <h3 v-if="bookingCheckEA.length != 0" class="text-center">Expected arrival</h3>
                        <InfoBooking :bookings="bookingCheckEA"></InfoBooking>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
