<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';

const props = defineProps({
    feedBack: Array,
})

const form = useForm({
    status: props.feedBack.status,
});

const updateStatus = () => {
    router.post(`/admin/feed-back/${props.feedBack.id}`, {
        _method: 'put',
        status: form.status,
    })
};
</script>

<template>
    <Head title="Edit FeedBack"/>
    <AdminLayout>
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="">FeedBack</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Edit FeedBack</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="card-head">
                        <header>Edit FeedBack</header>
                    </div>
                    <div class="card-body col-6" style="margin: auto" id="bar-parent">
                        <h4>Customer: {{ feedBack.customer.name }}</h4>
                        <h4>Subject: {{ feedBack.subject }}</h4>
                        <h4>Content: {{ feedBack.content }}</h4>
                        <h4>Star Rate: {{ feedBack.star_rate }}</h4>
                        <h4>Status:</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="btn btn-success deepPink-bgcolor">
                                    <input type="radio" name="status" v-model="form.status" value="1"
                                           :checked="form.status == 1"> Active
                                </label>
                                <label class="btn btn-danger deepPink-bgcolor">
                                    <input type="radio" name="status" v-model="form.status" value="0"
                                           :checked="form.status == 0"> Inactive
                                </label>
                            </div>
                        </div>

                        <form @submit.prevent="updateStatus">
                            <button type="submit" class="btn btn-primary" style="display: flex; justify-content: center; margin: 0 auto">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
