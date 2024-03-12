<template>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <div class="container">
            <router-link class="navbar-brand" to="/">Formify</router-link>

            <div>
                <ul class="navbar-nav ml-auto" v-if="user.name===false">
                    <li class="nav-item">
                    <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li class="nav-item">
                    <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto" v-else>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ user.name }}</a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" @click="handleLogout">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';

    export default {
        props: ['user'],
        methods: {
            getToken() {
                return localStorage.getItem('token')
            },
            handleLogout() {
                axios.post(import.meta.env.VITE_BASE_API_URL+'/authentication/logout', {token: this.getToken()})
                    .then((res) => {
                        localStorage.removeItem('user')
                        localStorage.removeItem('token')
                        this.$emit("updateUser")
                        this.$router.push('/login')
                    })
                    .catch((err) => {alert(err.response.data.message)})
            }
        }
    }
</script>