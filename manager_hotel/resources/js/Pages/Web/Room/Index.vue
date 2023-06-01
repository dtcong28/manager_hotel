<script setup>
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';

const props = defineProps({
    rooms: Array,
    typesRoom: Array,
})

const form = useForm({
    time_check_in: '',
    time_check_out: '',
    type_room: '',
    number_people: '',
});

const searchData = () => {
    form.get(route('web.rooms.index'), { preserveState: true })
};
</script>

<template>
    <Head title="Rooms"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Rooms</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-sm col-md-6 col-lg-4" v-for="room in rooms" :key="room.id">
                                <div class="room">
                                    <Link :href="route('web.rooms.detail', { id: room.id })" class="img d-flex justify-content-center align-items-center" :style="{ backgroundImage: 'url(' + room.image + ')' }">
                                        <div class="icon d-flex justify-content-center align-items-center">
                                            <span class="icon-search2"></span>
                                        </div>
                                    </Link>
                                    <div class="text p-3 text-center">
                                        <h3 class="mb-3"><Link :href="route('web.rooms.detail', { id: room.id })">Room {{ room.name }}</Link></h3>
                                        <p><span class="price mr-2">{{ room.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></p>
                                        <ul class="list">
<!--                                            <li><span>Type room:</span>{{ room.type_room }}</li>-->
                                            <li><span>Max:</span> {{ room.number_people }} Persons</li>
                                            <li><span>Size:</span> {{ room.size }} m2</li>
                                            <li><span>View:</span> {{ room.view }}</li>
                                            <li><span>Bed:</span> {{ room.number_bed }}</li>
                                        </ul>
                                        <hr>
                                        <p class="pt-1"><Link :href="route('web.home')" class="btn-custom">Book Now <span class="icon-long-arrow-right"></span></Link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 sidebar">
                        <div class="sidebar-wrap bg-light ">
                            <h3 class="heading mb-4">Advanced Search</h3>
                            <form @submit.prevent="searchData">
                                <div class="fields">
                                    <div class="form-group">
                                        <label for="time_check_in">Check-in Date</label>
                                        <input v-model="form.time_check_in" type="date" id="time_check_in" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="time_check_out">Check-out Date</label>
                                        <input v-model="form.time_check_out" type="date" id="time_check_out" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <div class="select-wrap one-third">
                                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                            <select name="type_room" v-model="form.type_room" class="form-control">
                                                <option value="">Room Type</option>
                                                <option v-for="type in typesRoom" :value="type.id">{{ type.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="select-wrap one-third">
                                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                            <select name="number_people" v-model="form.number_people" class="form-control">
                                                <option value="">Number people</option>
                                                <option value="1">1 Adult</option>
                                                <option value="2">2 Adult</option>
                                                <option value="3">3 Adult</option>
                                                <option value="4">4 Adult</option>
                                                <option value="5">5 Adult</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary py-3 px-5">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>

</template>

