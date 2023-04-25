<script setup>
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3';
import {onBeforeMount, onMounted} from 'vue';
import $ from 'jquery';
import { defineAsyncComponent } from 'vue';
import ToastSuccess from '@/Components/Notification/ToastSuccess.vue';
import ToastFail from '@/Components/Notification/ToastFail.vue';

onMounted(() => {
    const styles = [
        "https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700",
        "https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i",
        "/frontend/css/open-iconic-bootstrap.min.css",
        "/frontend/css/animate.css",
        "/frontend/css/owl.carousel.min.css",
        "/frontend/css/owl.theme.default.min.css",
        "/frontend/css/magnific-popup.css",
        "/frontend/css/aos.css",
        "/frontend/css/ionicons.min.css",
        "/frontend/css/bootstrap-datepicker.css",
        "/frontend/css/jquery.timepicker.css",
        "/frontend/css/flaticon.css",
        "/frontend/css/icomoon.css",
        "/frontend/css/style.css",
    ];
    styles.forEach(style => {
        let tag = document.head.querySelector(`[src="${style}"`);
        if (!tag) {
            tag = document.createElement("link");
            tag.setAttribute("href", style);
            tag.setAttribute("rel", 'stylesheet');
            document.head.appendChild(tag);
        }
    });

    const scripts = [
        "/frontend/js/jquery.min.js",
        "/frontend/js/jquery-migrate-3.0.1.min.js",
        "/frontend/js/popper.min.js",
        "/frontend/js/bootstrap.min.js",
        "/frontend/js/jquery.easing.1.3.js",
        "/frontend/js/jquery.waypoints.min.js",
        "/frontend/js/jquery.stellar.min.js",
        "/frontend/js/owl.carousel.min.js",
        "/frontend/js/jquery.magnific-popup.min.js",
        "/frontend/js/aos.js",
        "/frontend/js/jquery.animateNumber.min.js",
        // "/frontend/js/bootstrap-datepicker.js",
        // "/frontend/js/jquery.timepicker.min.js",
        "/frontend/js/scrollax.min.js",
        "https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false",
        // "/frontend/js/google-map.js",
        "/frontend/js/main.js",
    ];

    scripts.forEach(script => {
        // let tag = document.head.querySelector(`[src="${script}"`);
        // if (!tag) {
        //     tag = document.createElement("script");
        //     tag.setAttribute("src", script);
        //     tag.setAttribute("type", 'text/javascript');
        //     document.head.appendChild(tag);
        //     console.log('scrollax.min.js has been loaded 123');
        // }
        const recaptchaScript = document.createElement("script");
        recaptchaScript.setAttribute("src", script );
        document.head.appendChild(recaptchaScript);
        console.log('js has been loaded');
    });
})
</script>

<template>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <Link class="navbar-brand" :href="route('web.home')">{{ $page.props.info_hotel.name }}</Link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><Link :href="route('web.home')" class="nav-link">Home</Link></li>
                    <li class="nav-item"><Link :href="route('web.rooms.index')" class="nav-link">Rooms</Link></li>
                    <li class="nav-item"><Link :href="route('web.restaurant.index')" class="nav-link">Restaurant</Link></li>
                    <li class="nav-item"><Link :href="route('web.about.index')" class="nav-link">About</Link></li>
                    <li class="nav-item"><Link :href="route('web.contact.index')" class="nav-link">Contact</Link></li>
                    <li v-if="!$page.props.web_login" class="nav-item"><Link :href="route('web.login')" class="nav-link">Login</Link></li>
                    <li v-if="$page.props.web_login" class="nav-item"><Link :href="route('web.profile.edit')" class="nav-link">Profile</Link></li>
                    <li v-if="$page.props.web_login" class="nav-item"><Link :href="route('web.booking.show')" class="nav-link">Your Booking</Link></li>
                    <li v-if="$page.props.web_login" class="nav-item"><Link :href="route('web.logout')" method="post" class="nav-link">Logout</Link></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <div v-if="$page.props.toast.action_success">
        <ToastSuccess :toast="$page.props.toast"></ToastSuccess>
    </div>
    <div v-if="$page.props.toast.action_failed">
        <ToastFail :toast="$page.props.toast"></ToastFail>
    </div>
    <slot />

    <section class="instagram">
        <div class="container-fluid">
            <div class="row no-gutters justify-content-center pb-5">
                <div class="col-md-7 text-center heading-section">
                    <h2><span>Instagram</span></h2>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-sm-12 col-md">
                    <Link class="insta-img image-popup"
                       v-bind:style="{ 'background-image': 'url(/frontend/images/insta-1.jpg)' }">
                        <div class="icon d-flex justify-content-center">
                            <span class="icon-instagram align-self-center"></span>
                        </div>
                    </Link>
                </div>
                <div class="col-sm-12 col-md">
                    <Link href="/frontend/images/insta-2.jpg" class="insta-img image-popup"
                       v-bind:style="{ 'background-image': 'url(/frontend/images/insta-2.jpg)' }">
                        <div class="icon d-flex justify-content-center">
                            <span class="icon-instagram align-self-center"></span>
                        </div>
                    </Link>
                </div>
                <div class="col-sm-12 col-md">
                    <a href="/frontend/images/insta-3.jpg" class="insta-img image-popup"
                       v-bind:style="{ 'background-image': 'url(/frontend/images/insta-3.jpg)' }">
                        <div class="icon d-flex justify-content-center">
                            <span class="icon-instagram align-self-center"></span>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md">
                    <Link href="/frontend/images/insta-4.jpg" class="insta-img image-popup"
                       v-bind:style="{ 'background-image': 'url(/frontend/images/insta-4.jpg)' }">
                        <div class="icon d-flex justify-content-center">
                            <span class="icon-instagram align-self-center"></span>
                        </div>
                    </Link>
                </div>
                <div class="col-sm-12 col-md">
                    <Link href="/frontend/images/insta-5.jpg" class="insta-img image-popup"
                       v-bind:style="{ 'background-image': 'url(/frontend/images/insta-5.jpg)' }">
                        <div class="icon d-flex justify-content-center">
                            <span class="icon-instagram align-self-center"></span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">{{ $page.props.info_hotel.name }} Hotel</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the blind texts.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Useful Links</h2>
                        <ul class="list-unstyled">
                            <li><Link :href="route('web.home')" class="py-2 d-block">Home</Link></li>
                            <li><Link :href="route('web.rooms.index')" class="py-2 d-block">Rooms</Link></li>
                            <li><Link :href="route('web.restaurant.index')" class="py-2 d-block">Restaurant</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Privacy</h2>
                        <ul class="list-unstyled">
                            <li><Link :href="route('web.about.index')" class="py-2 d-block">About</Link></li>
                            <li><Link :href="route('web.contact.index')" class="py-2 d-block">Contact</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">{{ $page.props.info_hotel.address }}</span>
                                </li>
                                <li><a href="#"><span class="icon icon-phone"></span><span
                                    class="text">{{ $page.props.info_hotel.phone }}</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">{{ $page.props.info_hotel.email }}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- loader -->
<!--    <div id="ftco-loader" class="show fullscreen">-->
<!--        <svg class="circular" width="48px" height="48px">-->
<!--            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>-->
<!--            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"-->
<!--                    stroke="#F96D00"/>-->
<!--        </svg>-->
<!--    </div>-->
    </body>

</template>


