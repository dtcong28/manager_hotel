<script setup>
import AdminLayout from '@/Layouts/Admin/Auth/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import Modal from '@/Components/Admin/Modal.vue';
import DangerButton from '@/Components/Admin/DangerButton.vue';
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue';
import {Link, Head, router, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import {usePermission} from "@/Composables/permissions";
const { hasPermission } = usePermission();

const form = useForm({})
const props = defineProps({
    bookings: Array,
    status: Array,
})

const search = ref('')
const payment = ref('')

function searchData(route) {
    router.get(route, { search: search.value }, { preserveState: true })
}

const showConfirmDeleteModal = ref(false)
const deleteID = ref('')

const confirmDelete = (id) => {
    showConfirmDeleteModal.value = true
    deleteID.value = id
}

const closeModal = () => {
    showConfirmDeleteModal.value = false;
}

const deleteBooking = (id) => {
    form.delete(route('booking.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>
<template>
    <div class="card-body ">
        <div v-if="hasPermission('create')" class="row p-b-20">
            <div v-if="$page.component != 'Admin/DashBoard/Index'" class="col-md-6 col-sm-6 col-6">
                <div class="btn-group">
                    <Link :href="route('booking.create')" id="addRow" class="btn btn-info">
                        Add New <i class="fa fa-plus"></i>
                    </Link>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="example4_filter" class="dataTables_filter">
                <label>Search:
                    <input type="search" id="search" v-model="search" @keyup="($page.component == 'Admin/DashBoard/Index') ? searchData('dashboard') : searchData('booking')" class="form-control form-control-sm" placeholder="" aria-controls="example4">
                </label>
            </div>
        </div>
        <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width" id="example4">
                <thead>
                <tr>
                    <th class="center"> ID</th>
                    <th class="center"> Name</th>
                    <th class="center"> Phone</th>
                    <th class="center"> Email</th>
                    <th class="center"> Check in</th>
                    <th class="center"> Check out</th>
                    <th class="center"> Payment</th>
                    <th class="center"> Status</th>
                    <th v-if="$page.component != 'Admin/DashBoard/Index'" class="center"> Detail</th>
                    <th v-if="$page.component != 'Admin/DashBoard/Index'" class="center"> Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(booking, key) in props.bookings.data" :key="booking.id" class="odd gradeX">
                    <td class="center">{{ booking.id }}</td>
                    <td class="center">{{ booking.name }}</td>
                    <td class="center">{{ booking.phone }}</td>
                    <td class="center">{{ booking.email }}</td>
                    <td class="center">{{ booking.time_check_in }}</td>
                    <td class="center">{{ booking.time_check_out }}</td>
                    <td class="center"><span
                        :class="status[key].payment_class">{{ booking.status_payment_label }}</span></td>
                    <td class="center"><span
                        :class="status[key].booking_class">{{ booking.status_booking_label }}</span></td>
                    <td v-if="$page.component != 'Admin/DashBoard/Index'" class="center"><Link :href="route('booking.detail', { id: booking.id })"
                                             class="btn deepPink btn-outline btn-circle m-b-10">View</Link>
                    </td>
                    <td v-if="$page.component != 'Admin/DashBoard/Index'" class="center">
                        <Link v-if="hasPermission('edit')" :href="route('booking.edit', { id: booking.id })"
                              class="btn btn-tbl-edit btn-xs">
                            <i class="fa fa-pencil"></i>
                        </Link>
                        <Link :href="route('booking_food.create', { id: booking.id })"
                              class="btn btn-tbl-delete btn-info btn-xs">
                            <i class="fa fa-cutlery "></i>
                        </Link>
                        <button v-if="hasPermission('delete')" @click="confirmDelete(booking.id)" class="btn btn-tbl-delete btn-xs"><i class="fa fa-trash-o "></i></button>
                        <Modal :show="showConfirmDeleteModal" @close="closeModal">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-slate-800">Are you sure to delete ?</h4>
                                <div class="mt-6 flex space-x-4">
                                    <DangerButton @click="deleteBooking(deleteID)">Delete</DangerButton>
                                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                </div>
                            </div>
                        </Modal>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="props.bookings.data==''" style="color: red; text-align: center">No data</div>
        <div class="col-sm-12 col-md-7">
            <pagination class="mt-6" :links="props.bookings.links"/>
        </div>
    </div>
</template>

