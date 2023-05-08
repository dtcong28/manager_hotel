<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    foods: Array,
    booking: Array,
    booked_food: Array,
})

const selectFood = ref({})

if(props.booked_food) {
    props.booked_food.forEach((item) => {
        selectFood.value[item.food_id] = item.amount
    })
}

const form = useForm({
    select_food: selectFood,
    booking: props.booking[0].id,
    meal_time: props.booking[0].meal_time,
    note_booking_food: props.booking[0].note_booking_food,
    time_check_in: props.booking[0].time_check_in,
    time_check_out: props.booking[0].time_check_out,
});

const storeBookingFood = () => {
    form.post(route('booking_food.store'))
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
                    <li><a class="parent-item" href="">Customer</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Booking Food</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-head">
                        <header>Booking Food</header>
                    </div>
                    <form @submit.prevent="storeBookingFood">
                        <div class="card-body col-7" style="margin: auto">
                            <div class="table-scrollable">
                                <table class="table table-hover table-checkable order-column full-width" id="example4">
                                    <thead>
                                    <tr>
                                        <th class="center"> #</th>
                                        <th class="center"> Image</th>
                                        <th class="center"> Name</th>
                                        <th class="center"> Price</th>
                                        <th class="center"> Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(food,key) in foods" :key="food.id" class="odd gradeX">
                                        <td class="center">{{ food.id }}</td>
                                        <td class="user-circle-img" style="display: flex; justify-content: center;">
                                            <img :src="food.image" :alt="food.image" class="w-20 h-20 shadow">
                                        </td>
                                        <td class="center">{{ food.name }}</td>
                                        <td class="center">{{ food.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                                        <td class="center"><input style="width: 70px" type="number" v-model="selectFood[food.id]" min="1">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body col-5" style="margin: auto">
                            <label for="meal_time">Meal time </label>
                            <input name="meal_time" id="meal_time" v-model="form.meal_time" type="datetime-local" class="form-control" placeholder="Meal time">
                            <div v-if="$page.props.errors.meal_time" style="color: red">{{ $page.props.errors.meal_time[0] }}</div>

                            <textarea name="note_booking_food" v-model="form.note_booking_food" cols="30" rows="5" class="form-control" placeholder="Note for booking food"></textarea>
                        </div>
                        <div class="col-lg-12 p-t-20 text-center">
                            <button type="submit" v-if="booking[0].status_booking != 0"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                    data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                            <Link :href="route('booking.index')"
                                  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                  data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
