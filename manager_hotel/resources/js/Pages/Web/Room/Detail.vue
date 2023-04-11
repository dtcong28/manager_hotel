<script setup>
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import { onMounted, onUnmounted } from 'vue'
import $ from 'jquery';

const props = defineProps({
    room: Object,
    typesRoom: Array,
})

// onMounted(() => {
//     $(document).ready(function() {
//         $('.owl-carousel').owlCarousel({
//             // Your options here
//         });
//     });
// })
</script>

<template>
    <Head title="Room detail"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Detail Room</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12 ">
                                <h2 class="mb-4">Room {{ room.name }}</h2>
                                <div class="single-slider owl-carousel">
                                    <div class="item" v-for="image in room.images">
                                        <div class="room-img" :style="{ backgroundImage: 'url(' + image + ')' }"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 room-single mt-4 mb-5 ">
                                <p>{{ room.description }}</p>
                                <div class="d-md-flex mt-5 mb-5">
                                    <ul class="list">
                                        <li><span>Max:</span> {{ room.number_people }} Persons</li>
                                        <li><span>Size:</span> {{ room.size }} m2</li>
                                        <li><span class="price mr-2">{{ room.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></li>
                                    </ul>
                                    <ul class="list ml-md-5">
                                        <li><span>View:</span> {{ room.view }}</li>
                                        <li><span>Bed:</span> {{ room.number_bed }}</li>
                                    </ul>
                                </div>
                            </div>

<!--                            <div class="col-md-12 room-single  mb-5 mt-5">-->
<!--                                <h4 class="mb-4">Available Room</h4>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-sm col-md-6 ">-->
<!--                                        <div class="room">-->
<!--                                            <a href="rooms.html" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/room-1.jpg);">-->
<!--                                                <div class="icon d-flex justify-content-center align-items-center">-->
<!--                                                    <span class="icon-search2"></span>-->
<!--                                                </div>-->
<!--                                            </a>-->
<!--                                            <div class="text p-3 text-center">-->
<!--                                                <h3 class="mb-3"><a href="rooms.html">Suite Room</a></h3>-->
<!--                                                <p><span class="price mr-2">$120.00</span> <span class="per">per night</span></p>-->
<!--                                                <hr>-->
<!--                                                <p class="pt-1"><a href="room-single.html" class="btn-custom">View Room Details <span class="icon-long-arrow-right"></span></a></p>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm col-md-6 ">-->
<!--                                        <div class="room">-->
<!--                                            <a href="rooms.html" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/room-2.jpg);">-->
<!--                                                <div class="icon d-flex justify-content-center align-items-center">-->
<!--                                                    <span class="icon-search2"></span>-->
<!--                                                </div>-->
<!--                                            </a>-->
<!--                                            <div class="text p-3 text-center">-->
<!--                                                <h3 class="mb-3"><a href="rooms.html">Family Room</a></h3>-->
<!--                                                <p><span class="price mr-2">$20.00</span> <span class="per">per night</span></p>-->
<!--                                                <hr>-->
<!--                                                <p class="pt-1"><a href="room-single.html" class="btn-custom">View Room Details <span class="icon-long-arrow-right"></span></a></p>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                        </div>
                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 sidebar ">
                        <div class="sidebar-box ">
                            <div class="categories">
                                <h3>Categories</h3>
                                <li><a href="#">Properties <span>(12)</span></a></li>
                                <li><a href="#">Home <span>(22)</span></a></li>
                                <li><a href="#">House <span>(37)</span></a></li>
                                <li><a href="#">Villa <span>(42)</span></a></li>
                                <li><a href="#">Apartment <span>(14)</span></a></li>
                                <li><a href="#">Condominium <span>(140)</span></a></li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- .section -->
    </WebLayout>

</template>

