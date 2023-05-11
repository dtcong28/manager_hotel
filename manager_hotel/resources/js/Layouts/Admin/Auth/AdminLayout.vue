<script setup>
import SidebarMenu from '@/Components/Admin/SidebarMenu.vue';
import Header from "@/Components/Admin/Header.vue";
import Footer from "@/Components/Admin/Footer.vue";
import Setting from "@/Components/Admin/Setting.vue";
import {Link, Head} from '@inertiajs/vue3'
import {onBeforeMount, onMounted} from 'vue';

import '/public/backend/assets/plugins/bootstrap/css/bootstrap.min.css';
import '/public/backend/assets/plugins/material/material.min.css';
import '/public/backend/assets/css/material_style.css';
import '/public/backend/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css';
import '/public/backend/assets/css/pages/animate_page.css';
// import '@/backend/assets/css/plugins.min.css';
import '/public/backend/assets/css/style.css';
import '/public/backend/assets/css/responsive.css';
import '/public/backend/assets/css/theme-color.css';
import '/public/backend/assets/plugins/simple-line-icons/simple-line-icons.min.css';
import '/public/backend/assets/plugins/font-awesome/css/font-awesome.min.css';
import '/public/backend/assets/img/favicon.ico';

onBeforeMount(() => {
    let style = document.createElement('link');
    style.type = "text/css";
    style.rel = "stylesheet";
    style.href = 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700';
    document.head.appendChild(style);

    const scripts = [
        "/backend/assets/plugins/bootstrap/js/bootstrap.min.js",
        "/backend/assets/js/app.js",
        "/backend/assets/js/layout.js",
        "/backend/assets/js/theme-color.js",
        "/backend/assets/plugins/datatables/jquery.dataTables.min.js",
        // "/backend/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js",
        // "/backend/assets/js/pages/table/table_data.js",
        "/backend/assets/plugins/material/material.min.js",
        "/backend/assets/js/pages/material_select/getmdl-select.js",
        "/backend/assets/plugins/material-datetimepicker/moment-with-locales.min.js",
        "/backend/assets/plugins/material-datetimepicker/bootstrap-material-datetimepicker.js",
        "/backend/assets/plugins/material-datetimepicker/datetimepicker.js",
        "/backend/assets/js/pages/ui/animations.js",
        "/backend/assets/plugins/popper/popper.min.js",
        "/backend/assets/plugins/jquery-blockui/jquery.blockui.min.js",
        "/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
    ];
    scripts.forEach(script => {
        // let tag = document.head.querySelector(`[src="${script}"`);
        // if (!tag) {
        //     tag = document.createElement("script");
        //     tag.setAttribute("src", script);
        //     tag.setAttribute("type", 'text/javascript');
        //     document.head.appendChild(tag);
        // }
        const recaptchaScript = document.createElement("script");
        recaptchaScript.setAttribute("src", script);
        document.head.appendChild(recaptchaScript);
        console.log('js has been loaded');
    });
})
</script>

<template>
    <!--    <div class="page-wrapper">-->
    <Header>
        <link rel="stylesheet" href="{{ mix('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<!--        <link rel="stylesheet" href="{{ mix('backend/assets/plugins/material/material.min.css') }}">-->
        <link rel="stylesheet" href="{{ mix('backend/assets/css/material_style.css') }}">
        <link rel="stylesheet"
              href="{{ mix('backend/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/css/pages/animate_page.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/css/plugins.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/css/theme-color.css') }}">
        <link rel="stylesheet"
              href="{{ mix('backend/assets/plugins/simple-line-icons/simple-line-icons.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/plugins/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/assets/img/favicon.ico') }}">
    </Header>
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <!-- start page container -->
    <div class="page-wrapper">
        <div class="page-container">

            <SidebarMenu></SidebarMenu>

            <!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div style="min-height: 100vh">
                        <slot/>
                    </div>
                </div>
            </div>
            <!-- end page content -->

            <Setting></Setting>

        </div>
        <!-- end page container -->
    </div>
    <Footer></Footer>
    <!--        <script src="{{ mix('backend/assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>-->
    </body>
    <!--    </div>-->
</template>


