import { createWebHistory, createRouter } from "vue-router";
import store from './store'
import Login from './pages/Login.vue'
import Home from './pages/Home.vue'
import Usuarios from './pages/Usuarios.vue'
import Eventos from './pages/Eventos.vue'
import Invitados from './pages/Invitados.vue'
import ValidarInvitado from './pages/ValidarInvitado.vue'
import ConfirmarInvitacion from './pages/ConfirmarInvitacion.vue'
import Secciones from './pages/Secciones.vue'
import Ingresados from './pages/Ingresados.vue'
import EscanearCodigos from './pages/EscanearCodigos.vue'

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
        beforeEnter: (to, from, next) => {
            if (store.state.user.user.tipo_usuario_id == 2 || store.state.user.user.tipo_usuario_id == 1) {
                next()
            }
            else {
                next({name: 'Ingresados'})
            }
        }
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
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            if (store.state.user.user.tipo_usuario_id == 4 || store.state.user.user.tipo_usuario_id == 3) {
                next()
            }
            else {
                next({name: ''})
            }
        }
    },
    {
        path: '/confirmacion',
        name: 'ConfirmarInvitacion',
        component: ConfirmarInvitacion,
    },
    {
        path: '/escanear-codigos',
        name: 'EscanearCodigos',
        component: EscanearCodigos,
        meta: {
            requiresAuth: true
        },
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