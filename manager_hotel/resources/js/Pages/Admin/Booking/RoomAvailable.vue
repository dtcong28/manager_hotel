<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {computed, ref} from "vue";

const props = defineProps({
    rooms: Array,
    bookingInfor: Array
})

const selectRoom = ref([])

const sum = selectRoom

const form = useForm({
    customer: props.bookingInfor.customer,
    type_booking: props.bookingInfor.type_booking,
    number_people: props.bookingInfor.number_people,
    time_check_in: props.bookingInfor.time_check_in,
    time_check_out: props.bookingInfor.time_check_out,
    rooms: selectRoom,
});

function checkInArray(value) {
    selectRoom.includes(value);
    return disabled;
}

const storeBooking = () => {
    form.post(route('booking.store'))
};

</script>

<template>
    <Head title="Employees"/>
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
        <div v-if="$page.props.flash.action_success" class="alert alert-success">
            {{ $page.props.flash.action_success }}
        </div>
        <div v-if="$page.props.flash.action_failed" class="alert alert-danger">
            {{ $page.props.flash.action_failed }}
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="card card-box">
                    <div class="card-head">
                        <header>Rooms Available For {{ bookingInfor.customer.name }} - {{ bookingInfor.number_room }}
                            Room: From {{ bookingInfor.time_check_in }} to {{ bookingInfor.time_check_out }}
                        </header>
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-scrollable">
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
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
                                    <th class="center"> Rent</th>
                                </tr>
                                </thead>
                                <tbody v-for="(room,key) in rooms">
                                <h3>Room {{ key + 1 }}</h3>
                                <tr v-for="data in room" class="odd gradeX">
                                    <td><input type="radio" id="radio" :value="data.id" v-model="selectRoom[key]"/>
                                    </td>
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
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form @submit.prevent="storeBooking">
                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Continue<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            <Link :href="route('booking.index')"
                                  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                  data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
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
                    <div class="card-body" v-for="value in selectRoom">
                        <div v-for="room in rooms" :key="room.id">
                                <span class="center" v-if="value === room.id">
                                    {{ room.name }} : {{ room.rent_per_night }} VND
                                </span>
                        </div>
                    </div>
                    -----------------------------
                    <span>Sum : {{ sum }}</span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
