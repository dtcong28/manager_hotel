<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";
import {useForm} from '@inertiajs/vue3';
import {useRemember, usePage} from '@inertiajs/inertia-vue3';

const props = defineProps({
    customers: Array,
    typeBooking: Array,
})

const form = useForm({
    name: '',
    type_booking: '',
    number_room: '',
    room: [],
    time_check_in: '',
    time_check_out: '',
});

const data = ref({
    customers: props.customers,
    typeBooking: props.typeBooking,
    numberRooms: [
        {value: 1},
        {value: 2},
        {value: 3},
        {value: 4},
    ],
})
function handleChange() {
    for (const [key, value] of Object.entries(form.room)) {
        if(key > form.number_room.value) {
            form.room[key] = null
        }
    }
}

function back() {
    window.history.back();
}

const filterRoom = () => {
    form.get(route('booking.filter_room'), {preserveState: true})
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Customer"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Booking</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Booking</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Add Booking</header>
                    </div>
                    <form @submit.prevent="filterRoom">
                        <div class="card-body col-5" style="margin: auto">
                            <div class="p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Name Customer</label>
                                    <multiselect v-model="form.name" deselect-label="Can't remove this value"
                                                 track-by="name" label="name" placeholder="Select one"
                                                 :options="data.customers" :searchable="false"
                                                 :allow-empty="false"></multiselect>
                                    <div v-if="$page.props.errors.name" style="color: red">{{$page.props.errors.name[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="row p-t-20">
                                <div class="wrap col">
                                    <label for="check_in">Check-in Date</label>
                                    <input name="time_check_in" id="check_in" v-model="form.time_check_in" type="date"
                                           class="form-control" placeholder="Check-in date">
                                    <div v-if="$page.props.errors.time_check_in" style="color: red">
                                        {{ $page.props.errors.time_check_in[0] }}
                                    </div>
                                </div>
                                <div class="wrap col">
                                    <label for="check_out">Check-out Date</label>
                                    <input name="time_check_out" id="check_out" v-model="form.time_check_out"
                                           type="date" class="form-control" placeholder="Check-out date">
                                    <div v-if="$page.props.errors.time_check_out" style="color: red">
                                        {{ $page.props.errors.time_check_out[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Type Booking</label>
                                    <multiselect v-model="form.type_booking" deselect-label="Can't remove this value"
                                                 track-by="name" label="name" placeholder="Select one"
                                                 :options="data.typeBooking" :searchable="false"
                                                 :allow-empty="false"></multiselect>
                                    <div v-if="$page.props.errors.type_booking" style="color: red">
                                        {{ $page.props.errors.type_booking[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-t-20">
                                <div class="form-group">
                                    <label class="typo__label">Number Rooms</label>
                                    <multiselect v-model="form.number_room" deselect-label="Can't remove this value"
                                                 track-by="value" label="value" placeholder="Select one"
                                                 :options="data.numberRooms" :searchable="false"
                                                 :allow-empty="false" @update:modelValue="handleChange"></multiselect>
                                    <div v-if="$page.props.errors.number_room" style="color: red">
                                        {{ $page.props.errors.number_room[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-t-20" v-for="room in form.number_room.value" :key="room">
                                <div class="form-group">
                                    <label :for="'room_'+room" class="typo__label">Room {{ room }} - Number
                                        People</label>
                                    <input type="number" :name="'room_'+room" v-model="form.room[room]"
                                           class="form-control" :id="'room_'+room" placeholder="Enter number people">
                                    <div v-if="form.errors.room" style="color: red">{{ form.errors.room[0] }}</div>
                                </div>
                            </div>

                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                        data-upgraded=",MaterialButton,MaterialRipple">Continue<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                                <button @click="back"
                                      class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                      data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
