<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";

const form = useForm({
    name: '',
    type_room_id: '',
    status: '',
    number_people: '',
    size: '',
    view: '',
    number_bed: '',
    rent_per_night: '',
    description: '',
    images: '',
});

const storeRoom = () => {
    form.post(route('rooms.store'))
};

const props = defineProps({
    typesRoom: Array,
    status: Array,
})

const data = ref({
    options: props.typesRoom.data,
    statusOptions: props.status,
})
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Room"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Add Room Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Room Details</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Add Room Details</header>
                    </div>
                    <form @submit.prevent="storeRoom">
                        <div class="card-body row pl-5 pr-5">
                            <div class="row">
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="name">Room Name</label>
                                        <input type="text" v-model="form.name" class="form-control" id="name"
                                               name="name" placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label class="typo__label">Types Room</label>
                                        <multiselect v-model="form.type_room_id" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="data.options" :searchable="false" :allow-empty="false"></multiselect>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <multiselect v-model="form.status" deselect-label="Can't remove this value"
                                                     track-by="name" label="name" placeholder="Select one"
                                                     :options="data.statusOptions" :searchable="false"
                                                     :allow-empty="false"></multiselect>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="number_people">Number people</label>
                                        <input type="number" name="number_people" v-model="form.number_people"
                                               class="form-control" id="number_people" placeholder="Enter number people">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="size">Size</label>
                                        <input type="number" name="size" v-model="form.size" class="form-control"
                                               id="size" placeholder="Enter size">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="view">View</label>
                                        <input type="text" name="view" v-model="form.view" class="form-control"
                                               id="view" placeholder="Enter view">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="number_bed">Number bed</label>
                                        <input type="number" name="number_bed" v-model="form.number_bed"
                                               class="form-control" id="number_bed" placeholder="Enter number bed">
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="rent_per_night">Rent per night</label>
                                        <input type="number" name="rent_per_night" v-model="form.rent_per_night"
                                               class="form-control" id="rent_per_night"
                                               placeholder="Enter rent per night">
                                    </div>
                                </div>
                                <div class="col-lg-12 p-t-20">
                                    <div
                                        class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded"
                                        data-upgraded=",MaterialTextfield">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" id="images" multiple @input="form.images = $event.target.files" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" v-model="form.description" class="form-control"
                                              rows="3" placeholder="Enter ..."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink" data-upgraded=",MaterialButton,MaterialRipple">Submit<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>
                                <Link :href="route('rooms.index')" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-upgraded=",MaterialButton,MaterialRipple">Cancel<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
