<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";
import { useForm } from '@inertiajs/vue3';
import { useRemember, usePage } from '@inertiajs/inertia-vue3';

// const props = defineProps({
//     customers: Array,
//     typeBooking: Array,
// })
//
// const form = useForm({
//     name: '',
//     type_booking: '',
//     number_room: '',
//     room: [],
//     time_check_in: '',
//     time_check_out: '',
// });
//
// const data = ref({
//     customers: props.customers,
//     typeBooking: props.typeBooking,
//     numberRooms: [
//         {value: 1},
//         {value: 2},
//         {value: 3},
//         {value: 4},
//     ],
// })
//
// const filterRoom = () => {
//     form.get(route('booking.filter_room'))
// };

const propsData = defineProps({
    customers: Array,
    typeBooking: Array,
})

const { props } = usePage();

const customers = propsData.customers;
const typeBooking = propsData.typeBooking;
const numberRooms = [
    {value: 1},
    {value: 2},
    {value: 3},
    {value: 4},
];

const { data, post, errors, reset } = useForm({
    name: props.oldValues?.name ?? '',
    type_booking: props.oldValues?.type_booking ?? '',
    number_room: props.oldValues?.number_room ?? '',
    room: props.oldValues?.number_room ?? [],
    time_check_in: props.oldValues?.time_check_in ?? '',
    time_check_out: props.oldValues?.time_check_out ?? '',
});

const { set: setFormData, get: getFormData } = useRemember('form-data', {
    name: '',
    type_booking: '',
    number_room: '',
    room: [],
    time_check_in: '',
    time_check_out: '',
});

const handleSubmit = () => {
    post('/submit', {
        onSuccess: () => {
            // Remember the form data for the next request
            setFormData({
                name: data.name,
                type_booking: data.type_booking,
                number_room: data.number_room,
                room: data.room,
                time_check_in: data.time_check_in,
                time_check_out: data.time_check_out,
            });
            reset();
            window.history.back();
        },
    });
};
console.log(data)
const formData = getFormData();
Object.keys(formData).forEach((key) => {
    data[key] = formData[key];
});
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Add Booking Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Booking Details</li>
                </ol>
            </div>
        </div>
        <pre>{{ data }}</pre>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Add Booking Details</header>
                    </div>
                    <form @submit.prevent="handleSubmit">
                        <div class="card-body row pl-5 pr-5">
                            <div class="col-lg-6 p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Name Customer</label>
                                    <multiselect v-model="data.name" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one"
                                                 :options="customers" :searchable="false"
                                                 :allow-empty="false"></multiselect>
                                    <div v-if="errors.name" style="color: red">{{errors.name}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 p-t-20">
                                <div class="wrap">
                                    <label for="check_in">Check-in Date</label>
                                    <input name="time_check_in" id="check_in" v-model="data.time_check_in" type="date"
                                           class="form-control" placeholder="Check-in date">
                                    <div v-if="errors.time_check_in" style="color: red">
                                        {{ errors.time_check_in }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 p-t-20">
                                <div class="wrap">
                                    <label for="check_out">Check-out Date</label>
                                    <input name="time_check_out" id="check_out" v-model="data.time_check_out"
                                           type="date" class="form-control" placeholder="Check-out date">
                                    <div v-if="errors.time_check_out" style="color: red">
                                        {{ errors.time_check_out }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
<!--                    <form @submit.prevent="filterRoom">-->
<!--                        <div class="card-body row pl-5 pr-5">-->
<!--                            <div class="col-lg-6 p-t-20">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="typo__label">Name Customer</label>-->
<!--                                    <multiselect v-model="form.name" deselect-label="Can't remove this value"-->
<!--                                                 track-by="name" label="name" placeholder="Select one"-->
<!--                                                 :options="data.customers" :searchable="false"-->
<!--                                                 :allow-empty="false"></multiselect>-->
<!--                                    <div v-if="$page.props.errors.name" style="color: red">{{ $page.props.errors.name[0] }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-3 p-t-20">-->
<!--                                <div class="wrap">-->
<!--                                    <label for="check_in">Check-in Date</label>-->
<!--                                    <input name="time_check_in" id="check_in" v-model="form.time_check_in" type="date"-->
<!--                                           class="form-control" placeholder="Check-in date">-->
<!--                                    <div v-if="$page.props.errors.time_check_in" style="color: red">-->
<!--                                        {{ $page.props.errors.time_check_in[0] }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-3 p-t-20">-->
<!--                                <div class="wrap">-->
<!--                                    <label for="check_out">Check-out Date</label>-->
<!--                                    <input name="time_check_out" id="check_out" v-model="form.time_check_out"-->
<!--                                           type="date" class="form-control" placeholder="Check-out date">-->
<!--                                    <div v-if="$page.props.errors.time_check_out" style="color: red">-->
<!--                                        {{ $page.props.errors.time_check_out[0] }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 p-t-20">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="typo__label">Type Booking</label>-->
<!--                                    <multiselect v-model="form.type_booking" deselect-label="Can't remove this value"-->
<!--                                                 track-by="name" label="name" placeholder="Select one"-->
<!--                                                 :options="data.typeBooking" :searchable="false"-->
<!--                                                 :allow-empty="false"></multiselect>-->
<!--                                    <div v-if="$page.props.errors.type_booking" style="color: red">-->
<!--                                        {{ $page.props.errors.type_booking[0] }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 p-t-20">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="typo__label">Number Rooms</label>-->
<!--                                    <multiselect v-model="form.number_room" deselect-label="Can't remove this value"-->
<!--                                                 track-by="value" label="value" placeholder="Select one"-->
<!--                                                 :options="data.numberRooms" :searchable="false"-->
<!--                                                 :allow-empty="false"></multiselect>-->
<!--                                    <div v-if="$page.props.errors.number_room" style="color: red">-->
<!--                                        {{ $page.props.errors.number_room[0] }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-3 p-t-20" v-for="room in form.number_room.value" :key="room">-->
<!--                                <div class="form-group">-->
<!--                                    <label :for="'room_'+room" class="typo__label">Room {{ room }} - Number-->
<!--                                        People</label>-->
<!--                                    <input type="number" :name="'room_'+room" v-model="form.room[room]"-->
<!--                                           class="form-control" :id="'room_'+room" placeholder="Enter number people">-->
<!--                                    <div v-if="form.errors.room" style="color: red">{{ form.errors.room[0] }}</div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="col-lg-12 p-t-20 text-center">-->
<!--                                <button type="submit"-->
<!--                                        class="mdl-button mdl-js-button mdl-button&#45;&#45;raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"-->
<!--                                        data-upgraded=",MaterialButton,MaterialRipple">Continue<span-->
<!--                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>-->
<!--                                </button>-->
<!--                                <Link :href="route('booking.index')"-->
<!--                                      class="mdl-button mdl-js-button mdl-button&#45;&#45;raised mdl-js-ripple-effect m-b-10 btn-default"-->
<!--                                      data-upgraded=",MaterialButton,MaterialRipple">Cancel<span-->
<!--                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
