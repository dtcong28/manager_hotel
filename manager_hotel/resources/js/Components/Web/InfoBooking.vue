<script setup>

const props = defineProps({
    bookings: Array,
})

</script>
<template>
    <div style="line-height: 0.4" v-for="(booking, key) in bookings" :key="booking.id">
        <h5 style="font-weight: bold">Booking {{ key + 1}}:</h5>
        <div class="row">
            <div class="col">
                <h5>Check in: {{ booking.time_check_in }} - Check out: {{ booking.time_check_out }}</h5><br>
                <h5>Number rooms: {{ booking.number_rooms }}</h5><br>
            </div>
            <div class="col">
                <h5>Status booking: {{ booking.status_booking_label }}</h5><br>
                <h5>Payment: {{ booking.status_payment_label }}</h5><br>
            </div>
        </div>
        <div class="row">
            <div class="card-body" v-if="booking.booking_room.length">
                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> Room</th>
                            <th> Number people</th>
                            <th> Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(value, key) in booking.booking_room" :key="value.id">
                            <td> {{ key }}</td>
                            <td> {{ value.room.name }}</td>
                            <td> {{ value.number_people }}</td>
                            <td> {{ value.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body" v-if="booking.booking_food.length">
                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> Food</th>
                            <th> Amount</th>
                            <th> Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(value, key) in booking.booking_food" :key="value.id">
                            <td> {{ key }}</td>
                            <td> {{ value.food.name }}</td>
                            <td> {{ value.amount }}</td>
                            <td> {{ value.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


