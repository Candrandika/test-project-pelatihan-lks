import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

import NextPageComponent from "./components/NextPageComponent.vue";

function isLoggedIn() {
    const token = localStorage.getItem('token')
    const user = JSON.parse(localStorage.getItem('user'))

    if(token && user) return true
    return false
}

const routes = [
    {
        path: "",
        component: NextPageComponent,
        beforeEnter: ((from, to, next) => {
            const isAuth = isLoggedIn()
            if(isAuth) next()
            else next('/login')
        }),
        children: [
            {
                path: "",
                component: () => import('./pages/DashboardPage.vue'),
                name: 'dashboard'
            }, {
                path: "form",
                component: () => import('./pages/FormListPage.vue'),
                name: 'list-form'
            }, {
                path: "form/create",
                component: () => import('./pages/FormCreatePage.vue'),
                name: 'create-form'
            }, {
                path: "form/:form_id",
                component: () => import('./pages/FormDetail.vue'),
                name: 'detail-form',
                props: true
            }
        ]
    }, {
        path: "",
        component: NextPageComponent,
        beforeEnter: ((from, to, next) => {
            const isAuth = isLoggedIn()
            if(isAuth) next('/')
            else next()
        }),
        children: [
            {
                path: "/login",
                component: () => import('./pages/LoginPage.vue'),
                name: 'login'
            },
            {
                path: "/register",
                component: () => import('./pages/RegisterPage.vue'),
                name: 'register'
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router