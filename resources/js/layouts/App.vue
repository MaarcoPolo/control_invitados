<template>
    <div class="wrapper" v-if="user">
        <div class="main-head">
            <div class="custom-page-header">
                <div class="separador">
                    <h1 class="title-head"><span>Control de invitados</span></h1>
                </div>
                <div class="logo">
                    <picture>
                        <img class="custom-image-header" loading="lazy" src="../../../public/img/logo_poder_judicial_gris.svg" alt="Logo Poder Judicial del Estado de Puebla">
                    </picture>
                </div>
                <div class="separador-mobile">
                    <h1 class="title-head"><span>Control de invitados</span></h1>
                </div>
            </div>
            <div class="custom-navbar">
                <ul class="custom-ul-navbar m-0">
                    <li @click="irInicio()">Inicio</li>   
                    <li v-if="user.user.tipo_usuario_id == 1" @click="irUsuarios()">Usuarios</li>   

                    <li @click="logout()">Cerrar Sesión</li>
                </ul>
            </div>
            <div class="col-md-4 col-12">
                <div class="text-center py-1 mt-8">
                </div>
            </div>
        </div>
        <div class="content">
            <router-view></router-view>
        </div>
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
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name: 'app',
        data() {
            return {
            
            }
        },
        created() {
        
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
            irUsuarios() {
                this.$router.push('/usuarios')
            },
        }
    })
</script>