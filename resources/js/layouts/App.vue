<template>
    <div class="wrapper" v-if="user">
        <header class="main-head">
            <div class="custom-page-header">
                <div class="separador">
                    <h1 class="title-head"><span>Control de eventos</span></h1>
                </div>
                <div class="custom-image-header">
                    <picture>
                        <img loading="lazy" src="../../../public/img/logo_poder_judicial_gris.svg" alt="Logo Poder Judicial del Estado de Puebla">
                    </picture>
                </div>
                <div class="separador-mobile">
                    <h1 class="title-head"><span>Control de eventos</span></h1>
                    <div class="separador-mobile">
                        <button class="menu-toggle" @click="toggleMenu">
                            <span class="hamburger-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="custom-navbar">
                <!-- Botón de menú hamburguesa -->
                <ul class="custom-ul-navbar" :class="{ 'active': menuOpen }">
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irInicio(); closeMenu()">Inicio</li>
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irEventos(); closeMenu()">Eventos</li>
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irInvitado(); closeMenu()">Invitados</li>
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irUsuarios(); closeMenu()">Usuarios</li>
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irZonas(); closeMenu()">Secciones</li>
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irIngresados(); closeMenu()">Ingresos</li>
                    <li @click="logout()">Cerrar Sesión</li>
                </ul>
                
                
            </div>
        </header>
        <main class="content">
            <router-view></router-view>
        </main>
        <footer class="footer">
            <div class="footer-first-line"></div>
            <div class="footer-content">
                <p>&#169; 2024 Poder Judicial del Estado de Puebla</p>
            </div>
        </footer>
    </div>
    <div v-else>
        <router-view></router-view>
    </div>
</template>

<script>
    import { defineComponent } from "vue";

    export default defineComponent({
        name: 'app',
        data() {
            return {
                menuOpen: false
            }
        },
        created() {
            const userInfo = localStorage.getItem('user')
            if (userInfo) {
                const userData = JSON.parse(userInfo)
                this.$store.commit('setUserData', userData)
            }
            axios.interceptors.response.use(
                response => response,
                error => {
                    if (error.response.status === 401) {
                        this.$store.dispatch('logout')
                    }
                    return Promise.reject(error)
                }
            )
        
        },
        computed: {
            user() {
                return this.$store.getters.user
            },
            currentRoute() {
                return this.$route.name
            }
        },
        methods: {
            logout() {
                this.$store.dispatch('logout')
            },
            irInicio() {
                this.$router.push('/')
            },
            irZonas() {
                this.$router.push('/secciones')
            },
            irEventos() {
                this.$router.push('/eventos')
            },
            irUsuarios() {
                this.$router.push('/usuarios')
            },
            irInvitado() {
                this.$router.push('/invitados')
            },
            irIngresados() {
                this.$router.push('/ingresados')
            },
            toggleMenu() {
                this.menuOpen = !this.menuOpen;
            },
            closeMenu() {
                this.menuOpen = false;
            },
            handleClickOutside(event) {
                const menuToggle = this.$el.querySelector('.menu-toggle');
                const menu = this.$el.querySelector('.custom-ul-navbar');
                if (this.menuOpen && !menuToggle.contains(event.target) && !menu.contains(event.target)) {
                    this.closeMenu();
                }
            },
            mounted() {
                document.addEventListener('click', this.handleClickOutside);
            },
            beforeUnmount() {
                document.removeEventListener('click', this.handleClickOutside);
            }
        }
    })
</script>