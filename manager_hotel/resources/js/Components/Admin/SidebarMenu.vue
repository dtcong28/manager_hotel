<script setup>
import SidebarMenuItem from "@/Components/Admin/SidebarMenuItem.vue";
import { Link } from '@inertiajs/vue3'
const menus = [
    {
        name: 'Employee',
        icon: 'group',
        route: false,
        children: [
            {
                name: 'View All Employees',
                route: 'employees.index',
            },
            {
                name: 'Add Employee',
                route: 'employees.create',
            },
        ],
    },
    {
        name: 'User',
        icon: 'group',
        route: false,
        children: [
            {
                name: 'Role',
                route: 'roles.index',
            },
            {
                name: 'Permissions',
                route: 'permissions.index',
            },
            {
                name: 'User',
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
                name: 'View All Types Room',
                route: 'types-room.index',
            },
            {
                name: 'Add Types Room',
                route: 'types-room.create',
            },
            {
                name: 'View All Rooms',
                route: 'rooms.index',
            },
            {
                name: 'Add Room',
                route: 'rooms.create',
            },

        ],
    },
    {
        name: 'Customer',
        icon: 'person_outline',
        route: false,
        children: [
            {
                name: 'View All Customers',
                route: 'customers.index',
            },
            {
                name: 'Add Customers',
                route: 'customers.create',
            },

        ],
    },
    {
        name: 'Booking',
        icon: 'business_center',
        route: false,
        children: [
            {
                name: 'View All Booking',
                route: 'booking.index',
            },
            {
                name: 'Add Booking',
                route: 'booking.create',
            },

        ],
    },
    {
        name: 'Restaurant',
        icon: 'store',
        route: false,
        children: [
            {
                name: 'View All Food',
                route: 'food.index',
            },
            {
                name: 'Add Food',
                route: 'food.create',
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
                            <div class="row">
                                <div class="sidebar-userpic">
                                    <img src="/backend/assets/img/dp.jpg" class="img-responsive" alt="">
                                </div>
                            </div>
                            <div class="profile-usertitle">
                                <div class="sidebar-userpic-name">{{ $page.props.auth.user.name }}</div>
                                <div class="profile-usertitle-job"> Admin</div>
                            </div>
                            <div class="sidebar-userpic-btn">
                                <Link class="tooltips" :href="route('profile.edit')" data-placement="top"
                                   data-original-title="Profile">
                                    <i class="material-icons">person_outline</i>
                                </Link>
                                <a class="tooltips" href="email_inbox.html" data-placement="top"
                                   data-original-title="Mail">
                                    <i class="material-icons">mail_outline</i>
                                </a>
                                <a class="tooltips" href="chat.html" data-placement="top"
                                   data-original-title="Chat">
                                    <i class="material-icons">chat</i>
                                </a>
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
