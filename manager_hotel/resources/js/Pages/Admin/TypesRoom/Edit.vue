<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';

const props = defineProps({
    typeRoom: Object,
})

const form = useForm({
    name: props.typeRoom.name,
});

const updateTypeRoom = () => {
    router.post(`/admin/types-room/${props.typeRoom.id}`, {
        _method: 'put',
        name: form.name,
    })
};
</script>

<template>
    <Head title="Types Room"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Add Types Room</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Add Type Room</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Types Room</header>
                    </div>
                    <form @submit.prevent="updateTypeRoom">
                        <div class="card-body row">
                            <div
                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width is-upgraded"
                                data-upgraded=",MaterialTextfield">
                                <input class="mdl-textfield__input" type="text" v-model="form.name" id="name"
                                       name="name"/>
                                <label class="mdl-textfield__label" for="name">Room Type</label>
                            </div>
                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit"
                                        class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink"
                                        data-upgraded=",MaterialButton,MaterialRipple">Submit<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </button>
                                <a type="button"
                                   class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default"
                                   :href="route('types-room.create')"
                                   data-upgraded=",MaterialButton,MaterialRipple">Cancel<span
                                    class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
