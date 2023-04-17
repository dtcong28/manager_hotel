<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import ConfirmationDialog from '@/Components/Admin/ConfirmationDialog.vue';

const props = defineProps({
    rooms: Array,
    bookingInfor: Array,
})

const selectRoom = ref([])
const sum = ref([])
const submitForm = true;

const form = useForm({
    customer: props.bookingInfor.customer,
    type_booking: props.bookingInfor.type_booking,
    number_people: props.bookingInfor.number_people,
    time_check_in: props.bookingInfor.time_check_in,
    time_check_out: props.bookingInfor.time_check_out,
    rooms: selectRoom,
    price_each_room: sum,
});

// Merge và loại bỏ những giá trị giống nhau trong mảng, khi khách đặt các phòng có số lượng người giống nhau
const mergedRoom = [].concat.apply([], props.rooms);

const uniqueElementsBy = (arr, fn) =>
    arr.reduce((acc, v) => {
        if (!acc.some(x => fn(v, x))) acc.push(v);
        return acc;
    }, []);

const arrayRoom = uniqueElementsBy(mergedRoom, (a, b) => a.id == b.id);
//----------------------------------------

const storeBooking = () => {
    form.post(route('booking.store'))
};

const handleBack = () => {
    window.history.back();
};

function select(key, room){
    this.selectRoom[key] = room;
}
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
                        <header>Rooms Available For {{ bookingInfor.customer.name }} - {{ bookingInfor.number_room }}
                            From {{ bookingInfor.time_check_in }} to {{ bookingInfor.time_check_out }}
                        </header>
                    </div>
                    <div class="card-body">
                        <div class="table-scrollable">
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center"> Select</th>
                                    <th class="center"> ID</th>
                                    <th class="center"> Img</th>
                                    <th class="center"> Type</th>
                                    <th class="center"> Name</th>
                                    <th class="center"> Status</th>
                                    <th class="center"> Number People</th>
                                    <th class="center"> Number Bed</th>
                                    <th class="center"> Rent per night</th>
                                    <th class="center"> Rent {{ bookingInfor.time_stay }} night</th>
                                </tr>
                                </thead>
                                <tbody v-for="(room,key) in rooms">
                                <h3>Room {{ key + 1 }}</h3>
                                <span v-if="room==''" style="color: red">
                                    <div class="d-none">{{ submitForm = false}}</div>
                                    No room available
                                </span>
                                <tr @click="select(key, data.id)" v-for="data in room" class="odd gradeX" :style="[selectRoom.includes(data.id) ? {'pointer-events': 'none'} : '']">
                                    <td>
                                        <input type="radio" :id="data.id" :value="data.id" v-model="selectRoom[key]"/>
                                        <div style="color: red; font-size: 15px" v-if="selectRoom.includes(data.id)">Selected</div>
                                    </td>
                                    <td class="center">{{ data.id }}</td>
                                    <td class="user-circle-img">
                                        <img :src="data.image" :alt="data.image" class="w-20 h-20 shadow">
                                    </td>
                                    <td class="center">{{ data.type_room.name }}</td>
                                    <td class="center">{{ data.name }}</td>
                                    <td class="center">{{ data.status_label }}</td>
                                    <td class="center">{{ data.number_people }}</td>
                                    <td class="center">{{ data.number_bed }}</td>
                                    <td class="center">{{ data.rent_per_night.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                    <td class="center">{{ (data.rent_per_night * bookingInfor.time_stay).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form @submit.prevent="storeBooking">
                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit" v-if="submitForm"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            <Link @click="handleBack"
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
                    </div>
                    <div class="card-body" v-for="(value, index) in selectRoom">
                        <div v-for="room in arrayRoom" :key="room.id">
                            <span class="center" v-if="value === room.id" :id="room.id">
                                Room {{ room.name }} : {{ (room.rent_per_night * bookingInfor.time_stay).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}
                                <div class="d-none">{{ sum[index] = room.rent_per_night * bookingInfor.time_stay }}</div>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Sum: {{ sum.reduce((partialSum, a) => partialSum + a, 0).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
