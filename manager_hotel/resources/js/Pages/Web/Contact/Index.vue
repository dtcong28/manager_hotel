<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import WebLayout from '@/Layouts/Web/WebLayout.vue';

const form = useForm({
    subject: '',
    content: '',
    star_rate: '',
});

const sendFeedBack = () => {
    form.post(route('web.feedback'), {
        onFinish: () =>  {
            form.subject = '';
            form.content = '';
            form.star_rate = '';
        },
    })
};
</script>

<template>
    <Head title="Contact"/>
    <WebLayout>
        <div class="hero-wrap" v-bind:style="{'background-image': 'url(/frontend/images/bg_1.jpg)'}">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                    <div class="col-md-9 text-center d-flex align-items-end justify-content-center">
                        <div class="text">
                            <h1 class="mb-4 bread">Contact</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="ftco-section contact-section bg-light">
            <div class="container">
                <div class="row d-flex mb-5 contact-info">
                    <div class="col-md-12 mb-4">
                        <h2 class="h3">Contact Information</h2>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <p><span>Address:</span>{{ $page.props.info_hotel.address }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <p><span>Phone:</span> <a href="tel://1234567920">{{ $page.props.info_hotel.phone }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <p><span>Email:</span> <a href="mailto:info@yoursite.com">{{ $page.props.info_hotel.email }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <p><span>Website</span> <a href="#">{{ $page.props.info_hotel.website }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="row block-9">
                    <div class="col-md-6 order-md-last d-flex">
                        <form v-if="$page.props.web_login" @submit.prevent="sendFeedBack" class="bg-white p-5 contact-form">
                            <h3>Feedback</h3>
                            <div class="form-group">
                                <input type="text" v-model="form.subject" name="subject" class="form-control" placeholder="Subject">
                                <div v-if="form.errors.subject" style="color: red">{{ form.errors.subject[0] }}</div>
                            </div>
                            <div class="form-group">
                                <textarea name="content" v-model="form.content" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                                <div v-if="form.errors.content" style="color: red">{{ form.errors.content[0] }}</div>
                            </div>
                            <div class="sidebar-wrap bg-light"><h3 class="heading mb-4">Star Rating</h3>
                                <div class="star-rating">
                                    <div class="form-check"><input type="radio" class="form-check-input" name="star_rate" value="5" v-model="form.star_rate"
                                                                   id="5"><label class="form-check-label" style="cursor: pointer"
                                                                                             for="5"><p
                                        class="rate"><span><i class="icon-star"></i><i class="icon-star"></i><i
                                        class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></span>
                                    </p></label></div>
                                    <div class="form-check"><input type="radio" class="form-check-input" name="star_rate" value="4" v-model="form.star_rate"
                                                                   id="4"><label class="form-check-label" style="cursor: pointer"
                                                                                             for="4"><p
                                        class="rate"><span><i class="icon-star"></i><i class="icon-star"></i><i
                                        class="icon-star"></i><i class="icon-star"></i><i
                                        class="icon-star-o"></i></span></p></label></div>
                                    <div class="form-check"><input type="radio" class="form-check-input" name="star_rate" value="3" v-model="form.star_rate"
                                                                   id="3"><label class="form-check-label" style="cursor: pointer"
                                                                                             for="3"><p
                                        class="rate"><span><i class="icon-star"></i><i class="icon-star"></i><i
                                        class="icon-star"></i><i class="icon-star-o"></i><i
                                        class="icon-star-o"></i></span></p></label></div>
                                    <div class="form-check"><input type="radio" class="form-check-input" name="star_rate" value="2" v-model="form.star_rate"
                                                                   id="2"><label class="form-check-label" style="cursor: pointer"
                                                                                             for="2"><p
                                        class="rate"><span><i class="icon-star"></i><i class="icon-star"></i><i
                                        class="icon-star-o"></i><i class="icon-star-o"></i><i
                                        class="icon-star-o"></i></span></p></label></div>
                                    <div class="form-check"><input type="radio" class="form-check-input" name="star_rate" value="1" v-model="form.star_rate"
                                                                   id="1"><label class="form-check-label" style="cursor: pointer"
                                                                                             for="1"><p
                                        class="rate"><span><i class="icon-star"></i><i class="icon-star-o"></i><i
                                        class="icon-star-o"></i><i class="icon-star-o"></i><i
                                        class="icon-star-o"></i></span></p></label></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                            </div>
                        </form>
                        <div v-if="!$page.props.web_login">You need login to send feedback !</div>
                    </div>

                    <div class="col-md-6 d-flex">
                        <iframe class="bg-white" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29793.980453127915!2d105.81636412211103!3d21.022778419204496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2zSGFub2ksIEhvw6BuIEtp4bq_bSwgSGFub2ksIFZpZXRuYW0!5e0!3m2!1sen!2s!4v1681961817027!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </WebLayout>

</template>

