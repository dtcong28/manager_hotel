<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {ref} from "vue";

const props = defineProps({
    info_booking: Array,
    select_rooms: Array,
    foods: Array,
})

const selectFood = ref({})
const price_each_room = props.info_booking.price_each_room.map(Number);
const price_each_food = ref({})

const form = useForm({
    select_food: selectFood,
    info_booking: props.info_booking,
    price_food: price_each_food,
});

function sum(obj) {
    return Object.keys(obj).reduce((sum,key)=>sum+parseFloat(obj[key]||0),0);
}

const confirm = () => {
    form.get(route('web.booking.confirm'))
};
</script>

<template>
    <Head title="Booking Food"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span>
                            </p>
                            <h1 class="mb-4 bread">Booking Food</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <section class="ftco-section" style="padding-top: 0px">
                            <div class="container">
                                <div class="row justify-content-center mb-5 pb-3">
                                    <div class="col-md-7 heading-section text-center">
                                        <h2>Our Menu</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="pricing-entry d-flex" v-for="(food,key) in foods" :key="food.id">
                                        <div class="img" v-bind:style="{ 'background-image': 'url(/frontend/images/menu-1.jpg)' }"></div>
                                        <div class="desc pl-3">
                                            <div class="d-flex text align-items-center">
                                                <h3><span>{{ food.name }}</span></h3>
                                                <span class="price">{{ food.price }}VND</span>
                                            </div>
                                            <div class="d-block">
                                                <p>{{ food.description }}</p>
                                            </div>
                                            <span>Amount</span>
                                            <input type="number" v-model="selectFood[food.id]" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-wrap bg-light">
                            <h3 class="heading mb-4">Your Stay</h3>

                            <div class="fields">
                                <form @submit.prevent="confirm">
                                    <div class="form-group">
                                        From {{ info_booking.time_check_in }} to {{ info_booking.time_check_out }}<br>
                                    </div>
                                    <div class="form-group" v-for="(value, index) in select_rooms">
                                        <div>
                                            <span>Room {{value.name }} : {{info_booking.price_each_room[index]}}VND</span>
                                        </div>
                                    </div>
                                    <div class="form-group" v-for="(value, key) in selectFood">
                                        <div v-for="(data, index) in foods">
                                        <span v-if="data.id == key && value">
                                            {{ data.name }}: {{ data.price*value }}VND
                                            <div class="d-none">{{ price_each_food[key] = data.price*value }}</div>
                                        </span>
                                        </div>
                                        <div class="d-none" v-if="value == ''">{{price_each_food[key] = null}}</div>
                                    </div>
                                    <div class="form-group">
                                        Total: {{ price_each_room.reduce((partialSum, a) => partialSum + a, 0) + sum(price_each_food) }}VND
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary py-3 px-5">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>
</template>
