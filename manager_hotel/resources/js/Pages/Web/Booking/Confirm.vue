<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {ref} from "vue";

const props = defineProps({
    info_booking: Array,
    select_rooms: Array,
})

const form = useForm({
    name: '',
    address: '',
    gender: '',
    phone: '',
    email: '',
    identity_card: '',
    info_booking: props.info_booking,
});

// const price_each_room = props.info_booking.price_each_room.map(Number);

const payment = () => {
    form.get(route('web.booking.payment'))
};
</script>

<template>
    <Head title="Confirm booking"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 ftco-animate text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span>
                            </p>
                            <h1 class="mb-4 bread">Complete your booking</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <form @submit.prevent="payment" class="bg-white p-5 contact-form">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" v-model="form.name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>Gender *</label><br>
                                <div>
                                    <input type="radio" name="gender" value="1" v-model="form.gender">
                                    <label style="font-weight: bold">Male</label>
                                </div>
                                <div>
                                    <input type="radio" name="gender" value="0" v-model="form.gender">
                                    <label style="font-weight: bold">Female</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email * (to receive your booking confirmation)</label>
                                <input type="email" v-model="form.email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <label>Address *</label>
                                <input type="text" v-model="form.address" class="form-control" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="text" v-model="form.phone" class="form-control" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label>Identity card *</label>
                                <input type="text" v-model="form.identity_card" class="form-control"
                                       placeholder="Identity card">
                            </div>
                            <div class="form-group" style="text-align: center; padding: 20px">
                                <button type="submit" class="btn btn-primary py-3 px-5">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-wrap bg-light ftco-animate">
                            <h3 class="heading mb-4">Your Stay</h3>

                            <div class="fields">
<!--                                <div class="form-group">-->
<!--                                    From {{ info_booking.time_check_in }} to {{ info_booking.time_check_out }}<br>-->
<!--                                </div>-->
<!--                                <div class="form-group" v-for="(value, index) in select_rooms">-->
<!--                                    <div>-->
<!--                                        <span>Room {{value.name }} : {{info_booking.price_each_room[index]}}VND</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--&lt;!&ndash;                                    Total: {{ price_each_room.reduce((partialSum, a) => partialSum + a, 0) }}VND&ndash;&gt;-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
