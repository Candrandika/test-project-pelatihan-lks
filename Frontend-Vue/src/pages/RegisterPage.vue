<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form class="card card-default" @submit.prevent="registerHandle">
            <div class="card-header">
              <h4 class="mb-0">Register Account</h4>
            </div>
            <div class="card-body">
              <div class="form-group row align-items-center mb-3">
                <div class="col-4 text-right">Name</div>
                <div class="col-8">
                  <input v-model="user.name" type="text" class="form-control" />
                </div>
              </div>
              <div class="form-group row align-items-center mb-3">
                <div class="col-4 text-right">Email</div>
                <div class="col-8">
                  <input v-model="user.email" type="email" class="form-control" />
                </div>
              </div>
              <div class="form-group row align-items-center mb-3">
                <div class="col-4 text-right">Password</div>
                <div class="col-8">
                  <input v-model="user.password" type="password" class="form-control" />
                </div>
              </div>
              <div class="form-group row align-items-center">
                <div class="col-4 text-right">Password Confirmation</div>
                <div class="col-8">
                  <input v-model="user.password_confirmation" type="password" class="form-control" />
                </div>
              </div>
              <div class="form-group row align-items-center mt-4">
                <div class="col-4"></div>
                <div class="col-8">
                  <button class="btn btn-primary" type="submit">Login</button>
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
          name: '',
          password: '',
          password_confirmation: ''
        }
      }
    },
    beforeCreate() {
      this.$emit('changePageTitle', 'Formify')
    },
    methods: {
      registerHandle() {
        axios.post(import.meta.env.VITE_BASE_API_URL+'/authentication/register', this.user)
          .then((res) => {
            alert(res.data.message)
            this.$router.push('/login')
          }).catch((err) => {
            alert(err.response.data.message)
          })
      }
    }
  }
</script>