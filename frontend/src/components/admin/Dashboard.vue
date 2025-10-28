<template>
  <div>
    <h1>Admin Dashboard</h1>
    <div>
      <a href="/">Back to Home</a>
    </div>
    <p>Welcome to the admin dashboard!</p>
    <button @click="handleLogout">Logout</button>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { logout } from '../../utils/auth'

const router = useRouter()

const handleLogout = () => {
  logout()
  router.push('/login')
}
</script>
