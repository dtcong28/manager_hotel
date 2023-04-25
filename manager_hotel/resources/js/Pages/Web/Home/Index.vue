<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';
import {onMounted} from "vue";

const props = defineProps({
    rooms: Array,
    typesRoom: Array,
    totalRooms: Array,
    totalEmployee: Array,
    totalCustomer: Array,
    totalFood: Array,
    feedBack: Array,
})

const form = useForm({
    time_check_in: '',
    time_check_out: '',
    number_room: '',
    room: [],
});

function handleChange() {
    for (const [key, value] of Object.entries(form.room)) {
        if(key > form.number_room) {
            form.room[key] = null
        }
    }
}

function checkAvailable() {
    console.log(1235)
}

const filterRoom = () => {
    form.get(route('web.booking.filter_room'))
};

// onMounted(() => {
//     const scripts = [
//         "/frontend/js/owl.carousel.min.js",
//     ];
//
//     scripts.forEach(script => {
//         const recaptchaScript = document.createElement("script");
//         recaptchaScript.setAttribute("src", script );
//         document.head.appendChild(recaptchaScript);
//         console.log('js has been loaded');
//     });
// })
</script>

<template>
    <Head title="Home"/>
    <WebLayout>
        <section class="home-slider owl-carousel">
            <div class="slider-item" v-bind:style="{ 'background-image': 'url(/frontend/images/bg_1.jpg)' }">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center">
                        <div class="col-md-12 ftco-animate text-center">
                            <div class="text mb-5 pb-3">
                                <h1 class="mb-3">Welcome To Deluxe</h1>
                                <h2>Hotels &amp; Resorts</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-item" v-bind:style="{ 'background-image': 'url(/frontend/images/bg_2.jpg)' }">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center">
                        <div class="col-md-12 ftco-animate text-center">
                            <div class="text mb-5 pb-3">
                                <h1 class="mb-3">Enjoy A Luxury Experience</h1>
                                <h2>Join With Us</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ftco-booking">
            <div class="container" style="max-width: 80%">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="get" action="/booking/filter-room" class="booking-form" target="_blank" style="display: flex; justify-content: center;">
                            <div class="row">
                                <div class="col-md-2.5 d-flex">
                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">
                                        <div class="wrap">
                                            <label for="time_check_in">Check-in Date</label>
                                            <input name="time_check_in" id="time_check_in" v-model="form.time_check_in" type="date" class="form-control" placeholder="Check-in date">
                                            <div v-if="$page.props.errors.time_check_in" style="color: red">{{$page.props.errors.time_check_in[0] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2.5 d-flex">
                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">
                                        <div class="wrap">
                                            <label for="time_check_out">Check-out Date</label>
                                            <input name="time_check_out" id="time_check_out" v-model="form.time_check_out" type="date" class="form-control" placeholder="Check-out date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2.5 d-flex">
                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">
                                        <div class="wrap">
                                            <label for="number_room">Number Room</label>
                                            <div class="form-field">
                                                <div class="select-wrap">
                                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                    <select name="number_room" v-model="form.number_room" id="number_room" class="form-control" @change="handleChange">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1.5 d-flex" v-for="room in Number(form.number_room)" :key="room">
                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">
                                        <div class="wrap">
                                            <label>Room {{ room }}</label>
                                            <div class="form-field">
                                                <div class="select-wrap">
                                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                    <select name="room[]" v-model="form.room[room]" class="form-control">
                                                        <option value="1">1 Adult</option>
                                                        <option value="2">2 Adult</option>
                                                        <option value="3">3 Adult</option>
                                                        <option value="4">4 Adult</option>
                                                        <option value="5">5 Adult</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1.5 d-flex">
                                    <div class="form-group d-flex align-self-stretch">
                                        <button type="submit" value="Check Availability" @click="checkAvailable" class="btn btn-primary py-3 px-4 align-self-stretch">Check Availability</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section ftc-no-pb ftc-no-pt">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                         v-bind:style="{ 'background-image': 'url(/frontend/images/bg_2.jpg)' }">
                    </div>
                    <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                        <div class="heading-section heading-section-wo-line pt-md-5 pl-md-5 mb-5">
                            <div class="ml-md-0">
                                <span class="subheading">Welcome to {{ $page.props.info_hotel.name }} Hotel</span>
                                <h2 class="mb-4">Welcome To Our Hotel</h2>
                            </div>
                        </div>
                        <div class="pb-md-5">
                            {{ $page.props.info_hotel.introduce }}
                            <ul class="ftco-social d-flex">
                                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                                <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-md-3 d-flex align-self-stretch ftco-animate">
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
                    <div class="col-md-3 d-flex align-self-stretch ftco-animate">
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
                    <div class="col-md-3 d-flex align-sel Searchf-stretch ftco-animate">
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
                    <div class="col-md-3 d-flex align-self-stretch ftco-animate">
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

        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <h2 class="mb-4">Our Rooms</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm col-md-6 col-lg-4" v-for="room in rooms" :key="room.id">
                        <div class="room">
                            <Link :href="route('web.rooms.detail', { id: room.id })" class="img d-flex justify-content-center align-items-center"
                               :style="{ backgroundImage: 'url(' + room.image + ')' }">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-search2"></span>
                                </div>
                            </Link>
                            <div class="text p-3 text-center">
                                <h3 class="mb-3"><Link :href="route('web.rooms.detail', { id: room.id })">Room {{ room.name }}</Link></h3>
                                <span>Type room: {{ room.type_room }}</span>
                                <p><span class="price mr-2">{{ room.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></p>
                                <hr>
                                <p class="pt-1"><Link :href="route('web.rooms.detail', { id: room.id })" class="btn-custom">View Room Details <span
                                    class="icon-long-arrow-right"></span></Link></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ftco-section ftco-counter img" id="section-counter"
                 v-bind:style="{ 'background-image': 'url(/frontend/images/bg_1.jpg)' }">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalCustomer">{{ props.totalCustomer }}</strong>
                                        <span>Happy Guests</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalRooms">{{ props.totalRooms }}</strong>
                                        <span>Rooms</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                                <div class="block-18 text-center">
                                    <div class="text">
                                        <strong class="number" :data-number="props.totalEmployee">{{ props.totalEmployee }}</strong>
                                        <span>Staffs</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
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
        <section v-if="feedBack" class="ftco-section testimony-section bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 ftco-animate">
                        <div class="row ftco-animate">
                            <div class="col-md-12">
                                <div class="carousel-testimony owl-carousel ftco-owl">
                                    <div class="item" v-for="value in feedBack" :key="value.id">
                                        <div class="testimony-wrap py-4 pb-5">
                                            <div class="user-img mb-4" v-bind:style="{ 'background-image': 'url(/frontend/images/avatar.png)' }"><span class="quote d-flex align-items-center justify-content-center"><i class="icon-quote-left"></i></span></div>
                                            <div class="text text-center">
                                                <p class="mb-4">{{ value.content }}</p>
                                                <p class="name">{{ value.customer.name }}</p>
                                                <span class="position">Guests</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>

</template>

