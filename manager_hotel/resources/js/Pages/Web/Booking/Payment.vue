<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {ref} from "vue";

const props = defineProps({
    info_booking: Array,
})

// const form = useForm({
//     name: '',
//     address: '',
//     gender: '',
//     phone: '',
//     email: '',
//     identity_card: '',
//     info_booking: props.info_booking,
// });
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
                    <div class="col-md-9 ftco-animate text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span></p>
                            <h1 class="mb-4 bread">Complete your booking</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        Payment
    </WebLayout>
</template>
