<script setup>
import SidebarMenu from '@/Components/Admin/SidebarMenu.vue';
import Header from "@/Components/Admin/Header.vue";
import Footer from "@/Components/Admin/Footer.vue";
import Setting from "@/Components/Admin/Setting.vue";
</script>

<template>
    <div class="page-wrapper">
        <Header></Header>

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
    </div>
</template>


