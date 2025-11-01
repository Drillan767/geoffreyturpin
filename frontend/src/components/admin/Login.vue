<template>
  <div>
    <h1>Admin Login</h1>
    <div>
      <a href="/">Back to Home</a>
    </div>
    <form @submit.prevent="handleLogin">
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input v-model="password" type="password" required />
      </div>
      <button type="submit">Login</button>
      <div v-if="error" style="color: red;">{{ error }}</div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { login } from '../../utils/auth'

const router = useRouter()
const email = ref('')
const password = ref('')
const error = ref('')

const handleLogin = async () => {
  try {
    error.value = ''
    await login(email.value, password.value)
    router.push('/admin/dashboard')
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Login failed'
  }
}
</script>
