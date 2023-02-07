<script setup>

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
                                <a class="tooltips" href="login.html" data-placement="top"
                                   data-original-title="Logout">
                                    <i class="material-icons">input</i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="menu-heading">
                        <span>-- Main</span>
                    </li>
                    <li class="nav-item start active">
                        <a href="#" class="nav-link nav-toggle">
                            <i class="material-icons">group</i>
                            <span class="title">Staff</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a :href="route('employees.create')" class="nav-link ">
                                    <span class="title">Add Staff Details</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a :href="route('employees.index')" class="nav-link ">
                                    <span class="title">View All Staffs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="edit_staff.html" class="nav-link ">
                                    <span class="title">Edit Staff Details</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
