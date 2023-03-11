<script setup>
import {defineProps,ref,onMounted,computed} from 'vue'
import {Link} from "@inertiajs/vue3";

const props= defineProps(['menuItem'])
const menuItem = props.menuItem
// const isParentActive = ref(route().current().includes(menuItem.routeName))
// const isParentActive = ref(menuItem.children.find(item => item.route === route().current()).length > 0)
const checkCurrentRoute = (checkRoute) => {
    return checkRoute === route().current()
}
const isParentActive = ref(false)

onMounted(() => {
    let found = menuItem.children.map(item => item.route )
    isParentActive.value = found.includes(route().current())
})

</script>
<template>
    <li class="nav-item " :class="{'active open': isParentActive}">
        <a :href="menuItem.route !== false ? menuItem.route : 'javascript:;'" @click="isParentActive = !isParentActive" class="nav-link nav-toggle">
            <i class="material-icons">{{menuItem.icon}}</i>
            <span class="title">{{menuItem.name}}</span>
            <span class="selected"></span>
            <span class="arrow" :class="{open: isParentActive}"></span>
        </a>
        <ul v-show="isParentActive" class="sub-menu" v-if="typeof (menuItem.children) !== 'undefined' && menuItem.children.length > 0">
            <li class="nav-item" v-for="(item,index) in menuItem.children" :key="index" :class="{active: checkCurrentRoute(item.route)}">
                <Link :href="route(item.route)" class="nav-link ">
                    <span class="title">{{item.name}}</span>
                </Link>
            </li>
        </ul>
    </li>
</template>

