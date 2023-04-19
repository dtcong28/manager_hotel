<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import LayoutBooking from '@/Layouts/Web/LayoutBooking.vue';
import {ref} from "vue";

const form = useForm({
    name: '',
    address: '',
    gender: '',
    phone: '',
    email: '',
    identity_card: '',
    booking: props.booking,
});

const props = defineProps({
    booking: Array,
    select_rooms: Array,
    select_foods: Array,
})

const price_each_room = props.booking.info_booking.price_each_room.map(Number);

function sum(obj) {
    return Object.keys(obj).reduce((sum,key)=>sum+parseFloat(obj[key]||0),0);
}

const totalMoney = props.booking.price_food ? price_each_room.reduce((partialSum, a) => partialSum + a, 0) + sum(props.booking.price_food) : price_each_room.reduce((partialSum, a) => partialSum + a, 0)

const payment = () => {
    form.get(route('web.booking.payment'), { preserveState: true })
};
</script>

<template>
    <Head title="Confirm booking"/>
    <LayoutBooking>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
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
                                <input type="text" name="name" v-model="form.name" class="form-control" placeholder="Your Name">
                                <div v-if="$page.props.errors.name" style="color: red">{{ $page.props.errors.name[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label>Gender *</label><br>
                                <div class="row">
                                    <div class="col-2">
                                        <input type="radio" id="male" name="gender" value="1" v-model="form.gender">
                                        <label for="male" style="font-weight: bold">Male</label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" id="female" name="gender" value="0" v-model="form.gender">
                                        <label for="female" style="font-weight: bold">Female</label>
                                    </div>
                                </div>
                                <div v-if="$page.props.errors.gender" style="color: red">{{ $page.props.errors.gender[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label>Email * (to receive your booking confirmation)</label>
                                <input type="email" name="email" v-model="form.email" class="form-control" placeholder="Your Email">
                                <div v-if="$page.props.errors.email" style="color: red">{{ $page.props.errors.email[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label>Address *</label>
                                <input type="text" v-model="form.address" class="form-control" placeholder="Address">
                                <div v-if="$page.props.errors.address" style="color: red">{{ $page.props.errors.address[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="text" v-model="form.phone" class="form-control" placeholder="Phone">
                                <div v-if="$page.props.errors.phone" style="color: red">{{ $page.props.errors.phone[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label>Identity card *</label>
                                <input type="text" v-model="form.identity_card" class="form-control" placeholder="Identity card">
                                <div v-if="$page.props.errors.identity_card" style="color: red">{{ $page.props.errors.identity_card[0] }}</div>
                            </div>
                            <div class="form-group" style="text-align: center; padding: 20px">
                                <button type="submit" class="btn btn-primary py-3 px-5">Confirm</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-wrap bg-light box-detail">
                            <h3 class="heading mb-4">Your Stay</h3>
                            <div class="fields">
                                <div class="form-group">
                                    From {{ booking.info_booking.time_check_in }} to {{ booking.info_booking.time_check_out }}<br>
                                </div>
                                <div class="form-group" v-for="(value, index) in select_rooms">
                                    <div>
                                        <span>Room {{value.name }} : {{parseInt(booking.info_booking.price_each_room[index]).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}}</span>
                                    </div>
                                </div>
                                <div class="form-group" v-for="(value, index) in select_foods">
                                    <div v-if="booking.price_food[value.id]!=null">
                                        <span>{{value.name }} - Amount {{ booking.select_food[value.id] }} : {{ parseInt(booking.price_food[value.id]).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Total: {{ totalMoney.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </LayoutBooking>
</template>
