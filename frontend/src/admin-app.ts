import { createApp } from 'vue'
import AdminApp from './components/AdminApp.vue'
import router from './router'

const app = createApp(AdminApp)
app.use(router)
app.mount('#admin-app')
