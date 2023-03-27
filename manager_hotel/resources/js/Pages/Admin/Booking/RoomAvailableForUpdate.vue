<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {computed, ref} from "vue";

let props = defineProps({
    bookRoom: Array,
    bookingInfor: Array,
    filterRoom: Array,
    idBooking: Array,
})

let selectRoom = ref([])
let sum = ref([])
let count = 0

props.bookRoom.forEach((room) => {
    if(room.id) {
        selectRoom.value.push(room)
        sum.value.push(room.rent_per_night * props.bookingInfor.time_stay)
        count = count + 1
    }
})

let form = useForm({
    type_booking: props.bookingInfor.type_booking.value,
    time_check_in: props.bookingInfor.time_check_in,
    time_check_out: props.bookingInfor.time_check_out,
    select_rooms: selectRoom,
    book_room: props.bookRoom,
    price_each_room: sum,
});

// Merge và loại bỏ những giá trị giống nhau trong mảng, khi khách đặt các phòng có số lượng người giống nhau
let mergedRoom = (props.filterRoom) ? [].concat.apply([], props.filterRoom) : '';

let uniqueElementsBy = (arr, fn) =>
    arr.reduce((acc, v) => {
        if (!acc.some(x => fn(v, x))) acc.push(v);
        return acc;
    }, []);

let arrayRoom = (mergedRoom) ? uniqueElementsBy(mergedRoom, (a, b) => a.id == b.id) : '';
//----------------------------------------

const updateBooking = () => {
    router.post(`/admin/booking/${props.idBooking}`, {
        _method: 'put',
        form
    })
};
</script>

<template>
    <Head title="Filter Room"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Rooms Available</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card card-box">
                    <div class="card-head">
                        <header>Rooms Available {{ bookingInfor.customer.name }} - {{ bookingInfor.number_room }}
                            From {{ bookingInfor.time_check_in }} to {{ bookingInfor.time_check_out }}
                        </header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-scrollable">
                            <table v-if="props.filterRoom!=''" class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center"> Select</th>
                                    <th class="center"> img</th>
                                    <th class="center"> #</th>
                                    <th class="center"> Type</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Status</th>
                                    <th class="center"> Number People</th>
                                    <th class="center"> Number Bed</th>
                                    <th class="center"> Rent per night</th>
                                    <th class="center"> Rent {{ bookingInfor.time_stay }} night</th>
                                </tr>
                                </thead>
                                <tbody v-for="(room,key) in props.filterRoom">
                                <h3>Room {{ key + 1 }}</h3>
                                <tr v-for="data in room" class="odd gradeX">
                                    <td><input type="radio" id="radio" :value="data.id" v-model="selectRoom[count + key]" :disabled="selectRoom.includes(data.id)"/></td>
                                    <td class="user-circle-img">
                                        <img :src="data.image" :alt="data.image" class="w-20 h-20 shadow">
                                    </td>
                                    <td class="center">{{ data.id }}</td>
                                    <td class="center">{{ data.type_room_id }}</td>
                                    <td class="center">{{ data.name }}</td>
                                    <td class="center">{{ data.status }}</td>
                                    <td class="center">{{ data.number_people }}</td>
                                    <td class="center">{{ data.number_bed }}</td>
                                    <td class="center">{{ data.rent_per_night }}</td>
                                    <td class="center">{{ data.rent_per_night * bookingInfor.time_stay }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-for="(room,key) in props.bookRoom" class="odd gradeX">
                                <h3 v-if="!!room.id">
                                    Room {{ room.name }} : {{ room.number_people }} people - {{ room.rent_per_night * bookingInfor.time_stay }} VND
                                    <img :src="room.image" :alt="room.image" class="w-20 h-20 shadow">
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="updateBooking">
                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            <Link :href="route('booking.edit', { id: idBooking })"
                                  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                  data-upgraded=",MaterialButton,MaterialRipple">Back<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-box">
                    <div class="card-head">
                        <header>Total</header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body" v-for="(value, index) in selectRoom">
                        <span class="center" v-if="value.name">
                            Room {{ value.name }} : {{ value.rent_per_night * bookingInfor.time_stay }} VND
                        </span>
                        <div v-for="room in arrayRoom" :key="room.id">
                            <span class="center" v-if="value === room.id" :id="room.id">
                                Room {{ room.name }} : {{ room.rent_per_night * bookingInfor.time_stay }} VND
                                <div class="d-none">{{ sum[index] = room.rent_per_night * bookingInfor.time_stay }}</div>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Sum: {{ sum.reduce((partialSum, a) => partialSum + a, 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
