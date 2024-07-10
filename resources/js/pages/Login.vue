<template>
    <div class="conteiner-seg">
        <div class="imagen animate__animated animate__slideInLeft">
            <div>
                <img style="height: 91rem; width: 91rem;" src="../../../public/img/image-login.png" alt="">
            </div>
        </div>
        <div class="custom-border-login-1"></div>
        <div class="custom-border-login-2"></div>
        <div class="app animate__animated animate__zoomIn">
            <div class="div-titulo-login">
                <img style="width: 30.3rem; height: 21rem;" src="../../../public/img/logo-login.png" alt="">
            </div>
            <form class="form-login" autocomplete="off" @submit.prevent>
                <br>
                <h1 class="titulo-bienvenido">Bienvenido</h1>
                <div class="principal-class mt-8">
                    <div class="div-custom-input-login">
                        <img src="../../../public/icons/user.png" alt="">
                    </div>
                    <div>
                        <input type="text" name="usuario" id="usuario" class="custom-input-login" autocomplete="off" placeholder="Usuario" required autofocus v-model="form.usuario">
                    </div>
                </div>
                <div class="principal-class mt-2">
                    <div class="div-custom-input-login">
                        <img src="../../../public/icons/key.png" alt="">
                    </div>
                    <div>
                        <input type="password" name="password" id="password" class="custom-input-login" autocomplete="off" placeholder="Contraseña" required v-model="form.password" @keydown.enter.prevent="login()">
                    </div>
                </div>
                <div class="col-md-12 form-group mt-6 mb-12">
                    <button v-if="!loading" class="btn" type="submit" @click="login()">Entrar</button>
                    <span v-else class="loader-ventanilla"></span>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "vue";

    export default defineComponent({
        name: 'login',
        components: {
        },
        data() {
            return {
                form: {
                    usuario: '',
                    password: '',
                },
                valid: true,
                show: false,
                usuarioRules: [
                    v => !!v || 'El nombre de usuario es requerido'
                ],
                passwordRules: [
                    v => !!v || 'La contraseña es requerida'
                ],
            }
        },
        computed: {
            loading() {
                return this.$store.getters.getLoading
            }
        },
        methods: {
            login(){
                this.$store.dispatch('login', {
                    usuario: this.form.usuario,
                    password: this.form.password
                }).then(() => {

                }).catch(err => {
                    console.log(err)
                })
            }
        }
    })
</script>