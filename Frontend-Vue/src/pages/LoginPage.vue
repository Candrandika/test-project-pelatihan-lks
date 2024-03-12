<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="handleLogin" class="card card-default">
                    <div class="card-header">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center mb-3">
                            <div class="col-4 text-right">Email</div>
                            <div class="col-8">
                                <input v-model="user.email" type="email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-4 text-right">Password</div>
                            <div class="col-8">
                                <input v-model="user.password" type="password" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row align-items-center mt-4">
                            <div class="col-4"></div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                }
            }
        },
        beforeCreate() {
            this.$emit('changePageTitle', 'Formify')
        },
        methods: {
            handleLogin() {
                axios.post(import.meta.env.VITE_BASE_API_URL+'/authentication/login', this.user)
                    .then((res) => {
                        localStorage.setItem('token', res.data.token)
                        localStorage.setItem('user', JSON.stringify(res.data.user))
                        this.$emit("updateUser")
                        this.$router.push('/')
                    })
                    .catch((err) => {
                        alert(err.response.data.message)
                    })
            }
        }
    }
</script>