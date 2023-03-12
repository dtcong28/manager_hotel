<script setup>
import SidebarMenuItem from "@/Components/Admin/SidebarMenuItem.vue";
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
                name: 'Add Employee Details',
                route: 'employees.create',
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
                name: 'Add Room Details',
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
                name: 'Add Customers Details',
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
                name: 'Add Booking Details',
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
                name: 'Food',
                route: 'food.index',
            },
            {
                name: 'Add Food',
                route: 'food.create',
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
                                <div class="sidebar-userpic-name"> John Deo</div>
                                <div class="profile-usertitle-job"> Manager</div>
                            </div>
                            <div class="sidebar-userpic-btn">
                                <a class="tooltips" href="user_profile.html" data-placement="top"
                                   data-original-title="Profile">
                                    <i class="material-icons">person_outline</i>
                                </a>
                                <a class="tooltips" href="email_inbox.html" data-placement="top"
                                   data-original-title="Mail">
                                    <i class="material-icons">mail_outline</i>
                                </a>
                                <a class="tooltips" href="chat.html" data-placement="top"
                                   data-original-title="Chat">
                                    <i class="material-icons">chat</i>
                                </a>
                                <form method="post" :action="route('logout')">
                                    <button class="tooltips" data-placement="top"
                                       data-original-title="Logout">
                                        <i class="material-icons">input</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="menu-heading">
                        <span>-- Main</span>
                    </li>
                    <SidebarMenuItem v-for="(menu,index) in menus" :key="index" :menuItem="menu"/>
                </ul>
            </div>
        </div>
    </div>
</template>
