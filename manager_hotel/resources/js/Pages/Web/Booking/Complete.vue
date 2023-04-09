<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import LayoutBooking from '@/Layouts/Web/LayoutBooking.vue';
import {ref} from "vue";
</script>

<template>
    <Head title="Complete booking"/>
    <LayoutBooking>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Complete Booking</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
                Complete
            </div>
        </section>
    </LayoutBooking>
</template>
