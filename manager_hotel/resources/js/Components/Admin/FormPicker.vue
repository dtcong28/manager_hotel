<script setup>
import { ref, reactive } from 'vue'
import { DatePicker } from 'v-calendar'
import 'v-calendar/dist/style.css'

const date = ref(new Date())
date.value.setDate(Number(date.value.getDate()) + 1)
const range = reactive({
    start: new Date(),
    end: date.value
})
</script>

<template>
    <DatePicker v-model="range" mode="dateTime" :columns="2" is-range>
        <template v-slot="{ inputValue, inputEvents }">
            <div class="group">
                <label class="button groupItem" for="start">Start</label>
                <input type="text" id="start" :value="inputValue.start" v-on="inputEvents.start" class="input groupItem">
                <label class="button groupItem" for="end">End</label>
                <input type="text" id="end" :value="inputValue.end" readonly class="input groupItem">
            </div>
        </template>
    </DatePicker>
</template>

<style scoped>
@use form {
    field: label, group, input, button;
}
</style>
