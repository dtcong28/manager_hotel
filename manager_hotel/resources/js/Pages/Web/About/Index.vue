<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';

const props = defineProps({
    totalRooms: Array,
    totalEmployee: Array,
    totalCustomer: Array,
    totalFood: Array,
})
</script>

<template>
    <Head title="About us"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">About us</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_2.jpg);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalCustomer">{{ props.totalCustomer }}</strong>
                                        <span>Happy Guests</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalRooms">{{ props.totalRooms }}</strong>
                                        <span>Rooms</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalEmployee">{{ props.totalEmployee }}</strong>
                                        <span>Staffs</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalFood">{{ props.totalFood }}</strong>
                                        <span>Food</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section ftc-no-pb ftc-no-pt">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 p-md-5 img img-2 img-3 d-flex justify-content-center align-items-center" v-bind:style="{ 'background-image': 'url(/frontend/images/bg_2.jpg)' }">
                    </div>
                    <div class="col-md-7 py-5 wrap-about pb-md-5 ">
                        <div class="heading-section heading-section-wo-line pt-md-5 pl-md-5 mb-5">
                            <div class="ml-md-0">
                                <span class="subheading">Welcome to {{ $page.props.info_hotel.name }} Homestay</span>
                                <h2 class="mb-4">Welcome To Our Homestay</h2>
                            </div>
                        </div>
                        <div class="pb-md-5">
                            {{ $page.props.info_hotel.introduce }}
                            <ul class="ftco-social d-flex">
                                <li class=""><a href="#"><span class="icon-twitter"></span></a></li>
                                <li class=""><a href="#"><span class="icon-facebook"></span></a></li>
                                <li class=""><a href="#"><span class="icon-google-plus"></span></a></li>
                                <li class=""><a href="#"><span class="icon-instagram"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-md-3 d-flex align-self-stretch ">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-reception-bell"></span>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-2">
                                <h3 class="heading mb-3">25/7 Front Desk</h3>
                                <p>A small river named Duden flows by their place and supplies.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-self-stretch ">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-serving-dish"></span>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-2">
                                <h3 class="heading mb-3">Restaurant Bar</h3>
                                <p>A small river named Duden flows by their place and supplies.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-sel Searchf-stretch ">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-car"></span>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-2">
                                <h3 class="heading mb-3">Transfer Services</h3>
                                <p>A small river named Duden flows by their place and supplies.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-self-stretch ">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-spa"></span>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-2">
                                <h3 class="heading mb-3">Spa Suites</h3>
                                <p>A small river named Duden flows by their place and supplies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>

