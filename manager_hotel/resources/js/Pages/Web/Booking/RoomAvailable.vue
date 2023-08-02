<script setup>
import {useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import LayoutBooking from '@/Layouts/Web/LayoutBooking.vue';
import {computed, ref} from "vue";

const props = defineProps({
    rooms: Array,
    info_booking: Array,
    discounts: Array,
})

const selectRoom = ref([])
const sum = ref([])

// Merge và loại bỏ những giá trị giống nhau trong mảng, khi khách đặt các phòng có số lượng người giống nhau
const mergedRoom = [].concat.apply([], props.rooms);

const uniqueElementsBy = (arr, fn) =>
    arr.reduce((acc, v) => {
        if (!acc.some(x => fn(v, x))) acc.push(v);
        return acc;
    }, []);

const arrayRoom = uniqueElementsBy(mergedRoom, (a, b) => a.id == b.id);
//----------------------------------------

const form = useForm({
    time_check_in: props.info_booking.time_check_in,
    time_check_out: props.info_booking.time_check_out,
    rooms: selectRoom,
    price_each_room: sum,
    note_booking_room: '',
    discount: '',
});

const formBooking = useForm({
    time_check_in: '',
    time_check_out: '',
    number_room: '',
    room: [],
});

const confirmBooking = () => {
    form.get(route('web.booking.food'))
};

// select lại room
const totalSelectRoom = computed(() => selectRoom.value.filter(el => el != null).length)

function handleChange() {
    for (const [key, value] of Object.entries(formBooking.room)) {
        if(key > formBooking.number_room) {
            formBooking.room[key] = null
        }
    }
}

function handleAlert(id){
    if(selectRoom.value.includes(id))
    {
        window.alert('Room is selected');
    }
}

// const filterRoom = () => {
//     formBooking.get(route('web.booking.filter_room'))
// };

const filterRoom = () => {
    try {
        formBooking.get(route('web.booking.filter_room') , { preserveState: true })
        selectRoom.value = []
        sum.value = []

    } catch (error) {
        throw error
    }
};
</script>

<style>
.custom-radio span {
    display: inline-block;
    position: relative;
    padding: 10px 20px;
    border: 2px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    user-select: none;
}

.custom-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.custom-radio input:checked ~ span {
    background-color: #2196F3;
    color: #fff;
    border-color: #2196F3;
}
</style>

<template>
    <Head title="Booking room"/>
    <LayoutBooking>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Choose Your Rooms</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section bg-light">
            <div class="container">
<!--                <div class="row pb-8">-->
<!--                    <div class="col-lg-12">-->
<!--                        <form @submit.prevent="filterRoom" class="booking-form" style="display: flex; justify-content: center;">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-2.5 d-flex">-->
<!--                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">-->
<!--                                        <div class="wrap">-->
<!--                                            <label for="time_check_in">Check-in Date</label>-->
<!--                                            <input name="time_check_in" id="time_check_in" v-model="formBooking.time_check_in" type="date" class="form-control" placeholder="Check-in date">-->
<!--                                            <div v-if="$page.props.errors.time_check_in" style="color: red">{{$page.props.errors.time_check_in[0] }}</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-2.5 d-flex">-->
<!--                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">-->
<!--                                        <div class="wrap">-->
<!--                                            <label for="time_check_out">Check-out Date</label>-->
<!--                                            <input name="time_check_out" id="time_check_out" v-model="formBooking.time_check_out" type="date" class="form-control" placeholder="Check-out date">-->
<!--                                            <div v-if="$page.props.errors.time_check_out" style="color: red">{{$page.props.errors.time_check_out[0] }}</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-2.5 d-flex">-->
<!--                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">-->
<!--                                        <div class="wrap">-->
<!--                                            <label for="number_room">Number Room</label>-->
<!--                                            <div class="form-field">-->
<!--                                                <div class="select-wrap">-->
<!--                                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>-->
<!--                                                    <select name="number_room" v-model="formBooking.number_room" id="number_room" class="form-control" @change="handleChange">-->
<!--                                                        <option value="1">1</option>-->
<!--                                                        <option value="2">2</option>-->
<!--                                                        <option value="3">3</option>-->
<!--                                                    </select>-->
<!--                                                    <div v-if="$page.props.errors.number_room" style="color: red">{{$page.props.errors.number_room[0] }}</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-1.5 d-flex" v-for="room in Number(formBooking.number_room)" :key="room">-->
<!--                                    <div class="form-group p-4 align-self-stretch d-flex align-items-end">-->
<!--                                        <div class="wrap">-->
<!--                                            <label>Room {{ room }}</label>-->
<!--                                            <div class="form-field">-->
<!--                                                <div class="select-wrap">-->
<!--                                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>-->
<!--                                                    <select name="room[]" v-model="formBooking.room[room]" class="form-control">-->
<!--                                                        <option value="1">1 Adult</option>-->
<!--                                                        <option value="2">2 Adult</option>-->
<!--                                                        <option value="3">3 Adult</option>-->
<!--                                                        <option value="4">4 Adult</option>-->
<!--                                                        <option value="5">5 Adult</option>-->
<!--                                                    </select>-->
<!--                                                    <div v-if="$page.props.errors.room" style="color: red">{{$page.props.errors.room[0] }}</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-1.5 d-flex">-->
<!--                                    <div class="form-group d-flex align-self-stretch">-->
<!--                                        <button type="submit" value="Check Availability" class="btn btn-primary py-3 px-4 align-self-stretch">Check Availability</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="row">
                    <div class="col-lg-8" >
                        <div v-if="rooms" v-for="(room,key) in rooms">
                            <h3>Select Room {{ key + 1 }}</h3>
                            <div v-if="room==''">
                                <span style="color: red">No room available</span>
                            </div>
                            <div class="row" v-for="data in room">
                                <div class="col-sm col-md-6 col-lg-11">
                                    <div class="room">
                                        <a :href="route('web.rooms.detail', { id: data.id })" target="_blank" class="img d-flex justify-content-center align-items-center" :style="{ backgroundImage: 'url(' + data.image + ')' }">
                                            <div class="icon d-flex justify-content-center align-items-center">
                                                <span class="icon-search2"></span>
                                            </div>
                                        </a>
                                        <div class="text p-3 text-center">
                                            <h3 class="mb-3"><a :href="route('web.rooms.detail', { id: data.id })" target="_blank">Room {{ data.name }}</a></h3>
                                            <p><span class="price mr-2">{{ data.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</span> <span class="per">per night</span></p>
                                            <div class="row">
                                                <ul class="list col">
                                                    <li><span>Max:</span> {{ data.number_people}} Persons</li>
                                                    <li><span>Size:</span> {{ data.size }} m2</li>
                                                </ul>
                                                <ul class="list col">
                                                    <li><span>View:</span> {{ data.view }}</li>
                                                    <li><span>Bed:</span> {{ data.number_bed }}</li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <label class="pt-1 custom-radio">
                                                <input type="radio" :id="data.id" :value="data.id" v-model="selectRoom[key]" :disabled="selectRoom.includes(data.id)"/>
                                                <span @click="handleAlert(data.id)">Select Room</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 sidebar">
                        <div class="box-detail">
                            <div class="sidebar-wrap bg-light">
                                <h3 class="heading mb-4">Your Stay</h3>
                                <form @submit.prevent="confirmBooking">
                                    <div class="fields">
                                        <div class="form-group">
                                            From {{ info_booking.time_check_in }} to {{ info_booking.time_check_out }}<br>
                                            {{ info_booking.time_stay }} nights
                                        </div>
                                        <div class="form-group" v-for="(value, index) in selectRoom">
                                            <div v-for="room in arrayRoom" :key="room.id">
                                            <span v-if="value === room.id" :id="room.id">
                                                Room {{ room.name }} : {{ (room.rent_per_night * info_booking.time_stay).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}}
                                                <div class="d-none">{{sum[index] = room.rent_per_night * info_booking.time_stay }}</div>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            Total: {{ sum.reduce((partialSum, a) => partialSum + a, 0).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}
                                        </div>
                                        <div v-if="props.discounts != ''" class="form-group">
                                            Discount for price room:<br>
                                            <div v-for="discount in props.discounts">
                                                <input v-model="form.discount" type="radio" :id="discount.percent" name="discount" :value="discount.percent">
                                                <label :for="discount.percent">{{ discount.percent }}%</label><br>
                                            </div>
                                        </div>
                                        <div v-if="rooms.length == totalSelectRoom" class="form-group">
                                            <button type="submit" class="btn btn-primary py-3 px-5">Continue</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <textarea name="note_booking_room" v-model="form.note_booking_room" cols="30" rows="5" class="form-control" placeholder="Note for booking room"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </LayoutBooking>
</template>
