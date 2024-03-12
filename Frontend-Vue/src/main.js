import { createApp } from 'vue'
import './assets/css/bootstrap.min.css'
import './assets/css/custom.css'
import './assets/js/bootstrap'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.globalProperties.$getToken = () => {
    return localStorage.getItem('token')
}

app.use(router).mount('#app')