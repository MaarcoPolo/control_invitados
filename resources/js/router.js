import { createWebHistory, createRouter } from "vue-router";
import store from './store'
import Login from './pages/Login.vue'
import Home from './pages/Home.vue'
import Usuarios from './pages/Usuarios.vue'
import Eventos from './pages/Eventos.vue'
import Invitados from './pages/Invitados.vue'
import ValidarInvitado from './pages/ValidarInvitado.vue'
import Secciones from './pages/Secciones.vue'
import Ingresados from './pages/Ingresados.vue'

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },

    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/usuarios',
        name: 'Usuarios',
        component: Usuarios,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/eventos',
        name: 'Eventos',
        component: Eventos,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/invitados',
        name: 'Invitados',
        component: Invitados,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/secciones',
        name: 'Secciones',
        component: Secciones,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/ingresados',
        name: 'Ingresados',
        component: Ingresados,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/validar-invitado',
        name: 'ValidarInvitado',
        component: ValidarInvitado,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const currentUser = store.state.user

    if (requiresAuth && !currentUser) {
        next('/login')
    } else if (to.path == '/login' && currentUser) {
        next('/')
    } else {
        next()
    }
})

export default router