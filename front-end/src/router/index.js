//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import( /* webpackChunkName: "home" */ '../views/home.vue')
    },
    {
        path: '/projects',
        name: 'projects.index',
        component: () => import( /* webpackChunkName: "index" */ '../views/projects/index.vue')
    },
    {
        path: '/create',
        name: 'projects.create',
        component: () => import( /* webpackChunkName: "create" */ '../views/projects/create.vue')
    },
    {
        path: '/edit/:id',
        name: 'projects.edit',
        component: () => import( /* webpackChunkName: "edit" */ '../views/projects/edit.vue')
    }
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes // <-- routes,
})

export default router