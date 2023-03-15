<script setup>
import SidebarMenu from '@/Components/Admin/SidebarMenu.vue';
import Header from "@/Components/Admin/Header.vue";
import Footer from "@/Components/Admin/Footer.vue";
import Setting from "@/Components/Admin/Setting.vue";

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

import '/public/backend/assets/plugins/popper/popper.min.js';
</script>

<script>
export default {
    mounted()
    {
        let style = document.createElement('link');
        style.type = "text/css";
        style.rel = "stylesheet";
        style.href = 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700';
        document.head.appendChild(style);
    }
}
</script>
<template>
    <div class="page-wrapper">
        <Header>
            <link rel="stylesheet" href="{{ mix('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/plugins/material/material.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/material_style.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/pages/animate_page.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/plugins.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/style.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/responsive.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/css/theme-color.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/plugins/simple-line-icons/simple-line-icons.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/plugins/font-awesome/css/font-awesome.min.css') }}">
            <link rel="stylesheet" href="{{ mix('backend/assets/img/favicon.ico') }}">
        </Header>
        <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
        <!-- start page container -->
        <div class="page-container">

            <SidebarMenu></SidebarMenu>

            <!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div v-if="$page.props.flash.action_success" class="alert alert-success">
                        {{ $page.props.flash.action_success }}
                    </div>
                    <div v-if="$page.props.flash.action_failed" class="alert alert-danger">
                        {{ $page.props.flash.action_failed }}
                    </div>
                    <slot />
                </div>
            </div>
            <!-- end page content -->

            <Setting></Setting>

        </div>
        <!-- end page container -->

        <Footer></Footer>
        </body>
    </div>
</template>


