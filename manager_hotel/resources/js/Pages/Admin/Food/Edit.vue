<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import {ref} from "vue";

const props = defineProps({
    food: Object,
})

const data = ref({
    url: [],
})

const form = useForm({
    name: props.food.name,
    price: props.food.price,
    description: props.food.description,
    images: props.food.images,
});

const updateFood = () => {
    router.post(`/admin/food/${props.food.id}`, {
        _method: 'put',
        name: form.name,
        price: form.price,
        description: form.description,
        images: form.images,
    })
};

function previewImage(e) {
    const file = e.target.files;
    if (file) {
        data.value.url = []
    }

    const arrayFile = Object.entries(file);
    arrayFile.forEach((value) => {
        data.value.url[value[0]] = URL.createObjectURL(value[1]);
    })
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <Head title="Create Room"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Food</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Edit Food</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Edit Food</header>
                    </div>
                    <div class="card-body col-6" style="margin: auto">
                        <form @submit.prevent="updateFood">
                            <div class="row">
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" v-model="form.name" class="form-control" id="name"
                                               name="name" placeholder="Enter name">
                                        <div v-if="$page.props.errors.name" style="color: red">{{ $page.props.errors.name[0] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-t-20">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" name="price" v-model="form.price" class="form-control"
                                               id="price" placeholder="Enter price">
                                        <div v-if="$page.props.errors.price" style="color: red">{{$page.props.errors.price[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-t-15">
                                    <div
                                        class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded"
                                        data-upgraded=",MaterialTextfield">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" id="images" multiple @change="previewImage"
                                               @input="form.images = $event.target.files"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <div style="display: flex">
                                            <div v-for="url in data.url">
                                                <img :src="url" :alt="image" class="w-20 h-20 shadow">
                                            </div>
                                        </div>
                                        <div v-if="$page.props.errors.images" style="color: red">{{$page.props.errors.images[0] }}
                                        </div>
                                    </div>
                                    <div style="display: flex" v-if="form.images != '[object FileList]'">
                                        <div v-for="image in form.images">
                                            <img :src="image" :alt="image" class="w-20 h-20 shadow">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-t-20">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" v-model="form.description"
                                                  class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        <div v-if="$page.props.errors.description" style="color: red">{{$page.props.errors.description[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                        data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                                <Link :href="route('food.index')"
                                      class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                      data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
