<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
const form = useForm({
    name: '',
    type_room_id: '',
    status: '',
    max_person: '',
    size: '',
    view: '',
    number_bed: '',
    rent_per_night: '',
    description: '',
    note: '',
    images: '',
});

const storeRoom = () => {
    form.post(route('rooms.store'))
};

const props = defineProps({
    typesRoom: Array
})
</script>

<template>
    <Head title="Types Room"/>
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
                        <div class="card-body row">
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield">
                                    <input class="mdl-textfield__input" type="text" id="name" name="name"
                                           v-model="form.name">
                                    <label class="mdl-textfield__label">Room Name</label>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield" style="width: 124px;">
                                    <input class="mdl-textfield__input" type="text" id="type" name="type_room_id"
                                           tabindex="-1" v-model="form.type_room_id">
                                    <label for="type" class="pull-right margin-0">
                                        <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                    </label>
                                    <label for="type" class="mdl-textfield__label">Room Type</label>
                                    <div class="mdl-menu__container is-upgraded">
                                        <div class="mdl-menu__outline mdl-menu--bottom-left"></div>
                                        <ul data-mdl-for="list3" class="mdl-menu mdl-menu--bottom-left mdl-js-menu"
                                            data-upgraded=",MaterialMenu">
                                            <li class="mdl-menu__item" data-val="1" tabindex="-1">Single</li>
                                            <li class="mdl-menu__item" data-val="2" tabindex="-1">Double</li>
                                            <li class="mdl-menu__item" data-val="3" tabindex="-1">Quad</li>
                                            <li class="mdl-menu__item" data-val="4" tabindex="-1">King</li>
                                            <li class="mdl-menu__item" data-val="5" tabindex="-1">Suite</li>
                                            <li class="mdl-menu__item" data-val="6" tabindex="-1">Apartments</li>
                                            <li class="mdl-menu__item" data-val="7" tabindex="-1">Villa</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield" style="width: 124px;">
                                    <input class="mdl-textfield__input" type="text" id="status" tabindex="-1"
                                           name="status" v-model="form.status">
                                    <label for="status" class="pull-right margin-0">
                                        <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                    </label>
                                    <label for="status" class="mdl-textfield__label">Status</label>
                                    <div class="mdl-menu__container is-upgraded">
                                        <div class="mdl-menu__outline mdl-menu--bottom-left"></div>
                                        <ul data-mdl-for="sample2" class="mdl-menu mdl-menu--bottom-left mdl-js-menu"
                                            data-upgraded=",MaterialMenu">
                                            <li class="mdl-menu__item" data-val="DE" tabindex="-1">AC</li>
                                            <li class="mdl-menu__item" data-val="BY" tabindex="-1">Non AC</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield" style="width: 171px;">
                                    <input class="mdl-textfield__input" type="number" name="max_person" id="max_person"
                                           tabindex="-1" v-model="form.max_person">
                                    <label for="max_person" class="mdl-textfield__label">Max People</label>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield" style="width: 163px;">
                                    <input class="mdl-textfield__input" type="number" id="size" name="size"
                                           tabindex="-1" v-model="form.size">
                                    <label for="size" class="mdl-textfield__label">Size</label>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield" style="width: 124px;">
                                    <input class="mdl-textfield__input" type="text" id="view" tabindex="-1" name="view"
                                           v-model="form.view">
                                    <label for="view" class="mdl-textfield__label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div
                                    class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded"
                                    data-upgraded=",MaterialTextfield">
                                    <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?"
                                           id="number_bed" name="number_bed" v-model="form.number_bed">
                                    <label class="mdl-textfield__label" for="number_bed">Number Bed</label>
                                    <span class="mdl-textfield__error">Number required!</span>
                                </div>
                            </div>
                            <div class="col-lg-6 p-t-20">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded" data-upgraded=",MaterialTextfield">
                                    <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?"
                                           id="rent_per_night" name="rent_per_night" v-model="form.rent_per_night">
                                    <label class="mdl-textfield__label" for="rent_per_night">Rent Per Night</label>
                                    <span class="mdl-textfield__error">Number required!</span>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded" data-upgraded=",MaterialTextfield">
                                    <label for="images">Images</label>
                                    <input type="file" name="images[]" multiple @input="form.images = $event.target.files" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20">
                                <div class="mdl-textfield mdl-js-textfield txt-full-width is-upgraded"
                                     data-upgraded=",MaterialTextfield">
                                    <textarea class="mdl-textfield__input" rows="4" id="description" name="description"
                                              v-model="form.description"></textarea>
                                    <label class="mdl-textfield__label" for="description">Room Description</label>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20">
                                <div class="mdl-textfield mdl-js-textfield txt-full-width is-upgraded"
                                     data-upgraded=",MaterialTextfield">
                                    <textarea class="mdl-textfield__input" rows="4" id="note" name="note"
                                              v-model="form.note"></textarea>
                                    <label class="mdl-textfield__label" for="note">Note</label>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                        data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                                <button type="button"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                        data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
