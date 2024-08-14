<template>
    <div class="container-fluid">
        <div class="pt-6">
            <div class="row justify-content-between">
                <div class="col-md-6 col-12 botones-inicio">
                    <img class="botones-img" src="../../../public/img/icono-eventos.png" @click="irEventos()" alt="Eventos">
                </div>
                <div class="col-md-6 col-12 botones-inicio">
                    <img class="botones-img" src="../../../public/img/icono-invitados.png" @click="irInvitados()" alt="Invitados">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "vue";

    export default defineComponent({
        name: 'home',
        data() {
            return {
                
            }
        },
        methods: {
            irInvitados() {
                this.$router.push('/invitados')
            },
            irEventos() {
                this.$router.push('/eventos')
            }
        }
    })
</script>