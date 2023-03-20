<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {ref} from "vue";

const props = defineProps({
    info_booking: Array,
    select_rooms: Array,
    select_foods: Array,
})

const form = useForm({

});
//
// const payment = () => {
//     form.get(route('web.booking.payment'))
// };
</script>

<template>
    <Head title="Confirm booking"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span></p>
                            <h1 class="mb-4 bread">Payment your booking</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ select_foods }}
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                    Payment
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-wrap bg-light">
                            <h3 class="heading mb-4">Your Stay</h3>

                            <div class="fields">
                                <div class="form-group">
                                    From {{ info_booking.booking.info_booking.time_check_in }} to {{ info_booking.booking.info_booking.time_check_out }}<br>
                                </div>
                                <div class="form-group" v-for="(value, index) in select_rooms">
                                    <div>
                                        <span>Room {{value }} : {{info_booking.booking.info_booking.price_each_room[index]}}VND</span>
                                    </div>
                                </div>
<!--                                <div class="form-group" v-for="(value, index) in select_foods">-->
<!--                                    <div>-->
<!--                                        <span>{{value }} - Amount  : {{ info_booking.booking.info_booking.price_food[index] }} VND</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    Total: {{ price_each_room.reduce((partialSum, a) => partialSum + a, 0) + sum(booking.price_food) }} VND-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
