<template>
  <div>
    <h2>Simple Vue Form</h2>
    <div>
      <label>Field 1:</label>
      <input v-model="field1" type="text" />
    </div>
    <div>
      <label>Field 2:</label>
      <input v-model="field2" type="text" />
    </div>
    <button @click="handleClick">Submit</button>
    <div v-if="message">{{ message }}</div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const field1 = ref('')
const field2 = ref('')
const message = ref('')

const handleClick = () => {
  message.value = `Field 1: ${field1.value}, Field 2: ${field2.value}`
}
</script>
