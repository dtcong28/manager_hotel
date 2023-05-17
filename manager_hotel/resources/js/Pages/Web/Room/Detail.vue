<script setup>
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import { onMounted, onUnmounted } from 'vue'
import $ from 'jquery';

const props = defineProps({
    room: Object,
    typesRoom: Array,
    amountEachType: Array,
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
                                    </ul>
                                    <ul class="list ml-md-5">
                                        <li><span>View:</span> {{ room.view }}</li>
                                        <li><span>Bed:</span> {{ room.number_bed }}</li>
                                    </ul>
                                    <ul class="list ml-md-5">
                                        <li><span class="price mr-2">{{ room.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></li>
                                        <li><span>Type Room:</span> {{ room.type_room.name }}</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 sidebar ">
                        <div class="sidebar-box ">
                            <div class="categories">
                                <h3>Type Room</h3>
                                <li v-for="type in amountEachType"><a href="#">{{type.type_room.name}} <span>({{ type.amountTypeRoom }})</span></a></li>
                            </div>
                        </div>

                        <div class="sidebar-box ftco-animate">
                            <h3>Tag Cloud</h3>
                            <div class="tagcloud">
                                <a href="#" class="tag-cloud-link">dish</a>
                                <a href="#" class="tag-cloud-link">menu</a>
                                <a href="#" class="tag-cloud-link">food</a>
                                <a href="#" class="tag-cloud-link">sweet</a>
                                <a href="#" class="tag-cloud-link">tasty</a>
                                <a href="#" class="tag-cloud-link">delicious</a>
                                <a href="#" class="tag-cloud-link">desserts</a>
                                <a href="#" class="tag-cloud-link">drinks</a>
                            </div>
                        </div>

                        <div class="sidebar-box ftco-animate">
                            <h3>Paragraph</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa sapiente consectetur similique, inventore eos fugit cupiditate numquam!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- .section -->
    </WebLayout>

</template>

