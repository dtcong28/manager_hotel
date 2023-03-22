<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import { loadStripe } from '@stripe/stripe-js';
import {ref, onMounted} from "vue";
import axios from 'axios';

const props = defineProps({
    info_booking: Array,
    select_rooms: Array,
    select_foods: Array,
})

const price_each_room = props.info_booking.booking.info_booking.price_each_room.map(Number);
function sum(obj) {
    return Object.keys(obj).reduce((sum,key)=>sum+parseFloat(obj[key]||0),0);
}
// payment
// const stripe = ref({});
// const cardElement = ref({});
// const paymentProcessing = ref(false);
//
// loadStripe('pk_test_51Jx6KYDUPq2rGFP34yvQKqaB4UGuIS02zayHVDihCvgMmx95EcufynhpzCS9HUCB7Fzar7efixcOob3Nh9wJO39y00qEc9z9cM').then((stripeInstance) => {
//     stripe.value = stripeInstance;
//
//     const elements = stripeInstance.elements();
//     cardElement.value = elements.create('card', {
//         classes: {
//             base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
//         }
//     });
//
//     cardElement.value.mount('#card-element');
// });
//
// const processPayment = async () => {
//     paymentProcessing.value = true;
//     const { paymentMethod, error } = await stripe.createPaymentMethod(
//         'card',
//         cardElement,
//         {
//             booking_details: {
//                 name: props.info_booking.name,
//                 email: props.info_booking.email,
//                 address: props.info_booking.address,
//                 gender: props.info_booking.gender,
//                 phone: props.info_booking.phone,
//                 identity_card: props.info_booking.identity_card,
//                 booking: props.info_booking.booking
//             },
//         }
//     );
//     if (error) {
//         paymentProcessing.value = false;
//         console.error(error);
//     } else {
//         console.log(paymentMethod);
//         axios
//             .post('/booking')
//             .then((response) => {
//                 paymentProcessing.value = false;
//                 console.log(response);
//             })
//             .catch((error) => {
//                 paymentProcessing.value = false;
//                 console.error(error);
//             });
//     }
// };
//
// onMounted(async () => {
//     await stripe;
//     // Stripe is ready to use.
// });
</script>

<script>
import { loadStripe } from '@stripe/stripe-js';

export default {
    props: {
        info_booking: Array,
        select_rooms: Array,
        select_foods: Array,
    },
    data() {
        return {
            stripe: {},
            cardElement: {},
            paymentProcessing: false,
            price_each_room: this.info_booking.booking.info_booking.price_each_room.map(Number),
        }
    },
    async mounted() {
        this.stripe = await loadStripe('pk_test_51Jx6KYDUPq2rGFP34yvQKqaB4UGuIS02zayHVDihCvgMmx95EcufynhpzCS9HUCB7Fzar7efixcOob3Nh9wJO39y00qEc9z9cM');

        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
            }
        });

        this.cardElement.mount('#card-element');
    },
    methods: {
        sum(obj) {
            return Object.keys(obj).reduce((sum,key)=>sum+parseFloat(obj[key]||0),0);
        },
        async processPayment() {
            this.paymentProcessing = true;
            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        name: this.info_booking.name,
                        email: this.info_booking.email,
                        address: this.info_booking.address,
                        phone: this.info_booking.phone,
                        // gender: this.info_booking.gender,
                        // identity_card: this.info_booking.identity_card,
                        // booking: this.info_booking.booking
                    }
                }
            );
            if (error) {
                this.paymentProcessing = false;
                console.error(error);
            } else {
                console.log(paymentMethod);
                this.info_booking.payment_method_id = paymentMethod.id;
                this.info_booking.amount = this.price_each_room.reduce((partialSum, a) => partialSum + a, 0) + this.sum(this.info_booking.booking.price_food);
                axios.post('/booking',  this.info_booking)
                    .then((response) => {
                        this.paymentProcessing = false;
                        console.log(response);
                    })
                    .catch((error) => {
                        this.paymentProcessing = false;
                        console.error(error);
                    });
            }
        }
    },
}

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
        {{ info_booking }}
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Payment</h3>
                        <div class="flex flex-wrap -mx-2 mt-4">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="card-element" class="leading-7 text-sm text-gray-600">Credit Card Info</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <button
                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" @click="processPayment" :disabled="paymentProcessing" v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
                            ></button>
                        </div>
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
                                <div class="form-group" v-for="value in select_foods">
                                    <div>
                                        <span>{{value[0] }} - Amount {{ info_booking.booking.select_food[value[1]] }} : {{ info_booking.booking.price_food[value[1]] }} VND</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Total: {{ price_each_room.reduce((partialSum, a) => partialSum + a, 0) + sum(info_booking.booking.price_food) }} VND
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
