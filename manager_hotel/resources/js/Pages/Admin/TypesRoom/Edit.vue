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
                    <div class="page-title">Edit Types Room</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">Rooms</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Edit Type Room</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Types Room</header>
                    </div>
                    <div class="card-body " id="bar-parent">
                        <form @submit.prevent="updateTypeRoom">
                            <div class="form-group">
                                <label for="name">Room Type</label>
                                <input type="text" v-model="form.name" class="form-control col-4" id="name" name="name" placeholder="Enter room type">
                                <div v-if="form.errors.name" style="color: red">{{ form.errors.name[0] }}</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
