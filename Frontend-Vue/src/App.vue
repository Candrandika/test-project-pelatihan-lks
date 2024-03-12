<script setup>
  import NavComponent from './components/NavComponent.vue'
  import HeadTitleComponent from './components/HeadTitleComponent.vue'
  import FooterComponent from './components/FooterComponent.vue'
</script>

<template>
  <NavComponent :user="user" @update-user="getUserLoggedIn"/>
  <main>
    <HeadTitleComponent :title="page_title" />
    <router-view @update-user="getUserLoggedIn" @change-page-title="changePageTitle"></router-view>
  </main>
  <FooterComponent />
</template>

<script>
  import axios from 'axios'

  export default {
    data() {
      return {
        user: {
          name: false
        },
        page_title: ''
      }
    },
    mounted() {
      this.getUserLoggedIn()
    },
    methods: {
      getUserLoggedIn() {
        const token = localStorage.getItem('token')
        if(!token) this.user.name = false
        else {
          axios.get(import.meta.env.VITE_BASE_API_URL+'/authentication/me?token='+token)
          .then((res) => {
            localStorage.setItem('user', JSON.stringify(res.data.user))
            this.user = res.data.user
          })
          .catch((err) => {
            localStorage.removeItem('user')
            localStorage.removeItem('token')
            this.user.name = false
          })
        }
      },
      changePageTitle(title) {
        this.page_title = title
      }
    }
  }
</script>