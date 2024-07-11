<template>
    <div class="container-fluid">
        <div class="pt-6">
            <div class="row justify-content-between">
                <div class="col-md-6 col-12 botones-inicio">
                    <img style="height: 40rem; width: 40rem;" src="../../../public/img/icono-eventos.png" @click="irEventos()">
                </div>
                <div class="col-md-6 col-12 botones-inicio">
                    <img style="height: 40rem; width: 40rem;" src="../../../public/img/icono-invitados.png" @click="irInvitados()">
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