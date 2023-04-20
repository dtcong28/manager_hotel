<script setup>
import SidebarMenuItem from "@/Components/Admin/SidebarMenuItem.vue";
import { Link } from '@inertiajs/vue3'
const menus = [
    {
        name: 'Dashboard',
        icon: 'dashboard',
        route: false,
        children: [
            {
                name: 'Dashboard',
                route: 'dashboard',
            },
        ],
    },
    {
        name: 'Employee',
        icon: 'group',
        route: false,
        children: [
            {
                name: 'List Role',
                route: 'roles.index',
            },
            {
                name: 'List Employee',
                route: 'users.index',
            },
        ],
    },
    {
        name: 'Rooms',
        icon: 'vpn_key',
        route: false,
        children: [
            {
                name: 'List Types Room',
                route: 'types-room.index',
            },
            {
                name: 'List Rooms',
                route: 'rooms.index',
            },
        ],
    },
    {
        name: 'Customer',
        icon: 'person_outline',
        route: false,
        children: [
            {
                name: 'List Customers',
                route: 'customers.index',
            },
        ],
    },
    {
        name: 'Booking',
        icon: 'business_center',
        route: false,
        children: [
            {
                name: 'List Booking',
                route: 'booking.index',
            },
        ],
    },
    {
        name: 'Restaurant',
        icon: 'store',
        route: false,
        children: [
            {
                name: 'List Food',
                route: 'food.index',
            },
        ],
    },
    {
        name: 'Hotel',
        icon: 'store',
        route: false,
        children: [
            {
                name: 'Information',
                route: 'hotel.create',
            },
        ],
    },
]
</script>

<template>
    <div class="sidebar-container">
        <div class="sidemenu-container navbar-collapse fixed-menu">
            <div id="remove-scroll">
                <ul class="sidemenu page-header-fixed p-t-20" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li class="sidebar-toggler-wrapper hide">
                        <div class="sidebar-toggler">
                            <span></span>
                        </div>
                    </li>
                    <li class="sidebar-user-panel">
                        <div class="user-panel">
                            <div class="profile-usertitle">
                                <div class="sidebar-userpic-name">{{ $page.props.auth.user.name }}</div>
                                <div class="profile-usertitle-job"> {{ $page.props.auth.user.roles[0] }}</div>
                            </div>
                            <div class="sidebar-userpic-btn">
                                <Link class="tooltips" :href="route('profile.edit')" data-placement="top"
                                   data-original-title="Profile">
                                    <i class="material-icons">person_outline</i>
                                </Link>
                                <Link :href="route('logout')" method="post">
                                    <button class="tooltips" data-placement="top"
                                       data-original-title="Logout">
                                        <i class="material-icons">input</i>
                                    </button>
                                </Link>
                            </div>
                        </div>
                    </li>
                    <SidebarMenuItem v-for="(menu,index) in menus" :key="index" :menuItem="menu"/>
                </ul>
            </div>
        </div>
    </div>
</template>
