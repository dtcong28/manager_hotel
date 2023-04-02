<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head, useRemember} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {ref} from "vue";

const props = defineProps({
    rooms: Array,
    info_booking: Array,
})

const selectRoom = ref([])
const sum = ref([])

// Merge và loại bỏ những giá trị giống nhau trong mảng, khi khách đặt các phòng có số lượng người giống nhau
const mergedRoom = [].concat.apply([], props.rooms);

const uniqueElementsBy = (arr, fn) =>
    arr.reduce((acc, v) => {
        if (!acc.some(x => fn(v, x))) acc.push(v);
        return acc;
    }, []);

const arrayRoom = uniqueElementsBy(mergedRoom, (a, b) => a.id == b.id);
//----------------------------------------

const form = useForm({
    time_check_in: props.info_booking.time_check_in,
    time_check_out: props.info_booking.time_check_out,
    rooms: selectRoom,
    price_each_room: sum,
});

const confirmBooking = () => {
    form.get(route('web.booking.food'))
};
</script>

<template>
    <Head title="Booking"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span></p>
                            <h1 class="mb-4 bread">Choose Your Rooms</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" >
                        <div v-for="(room,key) in rooms">
                            <h3>Room {{ key + 1 }}</h3>
                            <div class="row" v-for="data in room">
                                <div class="col-sm col-md-6 col-lg-11">
                                    <div class="room">
                                        <a href="rooms-single.html" class="img d-flex justify-content-center align-items-center" :style="{ backgroundImage: 'url(' + data.image + ')' }">
                                            <div class="icon d-flex justify-content-center align-items-center">
                                                <span class="icon-search2"></span>
                                            </div>
                                        </a>
                                        <div class="text p-3 text-center">
                                            <h3 class="mb-3"><a href="rooms-single.html">Room {{ data.name }}</a></h3>
                                            <p><span class="price mr-2">{{ data.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></p>
                                            <div class="row">
                                                <ul class="list col">
                                                    <li><span>Max:</span> {{ data.number_people}} Persons</li>
                                                    <li><span>Size:</span> {{ data.size }}</li>
                                                </ul>
                                                <ul class="list col">
                                                    <li><span>View:</span> {{ data.view }}</li>
                                                    <li><span>Bed:</span> {{ data.number_bed }}</li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <p class="pt-1">Select Room <input type="radio" id="radio" :value="data.id" v-model="selectRoom[key]" :disabled="selectRoom.includes(data.id)"/><span class="icon-long-arrow-right"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-wrap bg-light">
                            <h3 class="heading mb-4">Your Stay</h3>
                            <form @submit.prevent="confirmBooking">
                                <div class="fields">
                                    <div class="form-group">
                                        From {{ info_booking.time_check_in }} to {{ info_booking.time_check_out }}<br>
                                        {{ info_booking.time_stay }} nights
                                    </div>
                                    <div class="form-group" v-for="(value, index) in selectRoom">
                                        <div v-for="room in arrayRoom" :key="room.id">
                                            <span v-if="value === room.id" :id="room.id">
                                                Room {{ room.name }} : {{ (room.rent_per_night * info_booking.time_stay).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}} VND
                                                <div class="d-none">{{sum[index] = room.rent_per_night * info_booking.time_stay }}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        Total: {{ sum.reduce((partialSum, a) => partialSum + a, 0).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}
                                    </div>
                                    <div v-if="selectRoom.length" class="form-group">
                                        <button type="submit" class="btn btn-primary py-3 px-5">Continue</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
