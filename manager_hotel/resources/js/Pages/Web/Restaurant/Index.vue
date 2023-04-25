<script setup>
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';

const props = defineProps({
    foods: Array,
})

</script>

<template>
    <Head title="Restaurant"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Restaurants</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section ftc-no-pb ftc-no-pt">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 p-md-5 img img-2 img-3 d-flex justify-content-center align-items-center" v-bind:style="{'background-image': 'url(/frontend/images/about.jpg)'}">
                    </div>
                    <div class="col-md-7 py-5 wrap-about pb-md-5 ">
                        <div class="heading-section heading-section-wo-line pt-md-4 mb-5">
                            <div class="ml-md-0">
                                <span class="subheading">Our Restaurants</span>
                                <h2 class="mb-4">We Are Food Lover</h2>
                            </div>
                        </div>
                        <div class="pb-md-4" style="height: 250px">
                            {{ $page.props.info_hotel.introduce_restaurant }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ">
                        <h2>Our Menu</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="pricing-entry d-flex" v-for="(food,key) in foods" :key="food.id">
                            <div class="img" :style="{ backgroundImage: 'url(' + food.image + ')' }"></div>
                            <div class="desc pl-3">
                                <div class="d-flex text align-items-center">
                                    <h3><span>{{ food.name }}</span></h3>
                                    <span class="price">{{ food.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span>
                                </div>
                                <div class="d-block">
                                    <p>{{ food.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </WebLayout>

</template>

