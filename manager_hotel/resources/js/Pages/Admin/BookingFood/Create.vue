<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    foods: Array,
    booking_id: Array,
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
    booking_id: props.booking_id,
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
                <div class=" pull-left">
                    <div class="page-title">Add Booking Food</div>
                </div>
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
                        <div class="tools">
                            <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                            <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                            <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                        </div>
                    </div>
                    <form @submit.prevent="storeBookingFood">
                        <div class="card-body">
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
                                        <td class="center">{{ food.price }}</td>
                                        <td class="center"><input type="number" v-model="selectFood[food.id]" min="1">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

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
        </div>
    </AdminLayout>
</template>
