<template>
    <div>
        <!-- <template v-if="user"> -->
            <!-- <div class="col-12">
                <p class="boton-logout text-center mt-4" @click="logout()"><b>CERRAR SESIÓN</b></p>
            </div> -->
        <!-- </template> -->
    </div>
</template>

<script>
    import { defineComponent } from "vue";
    import { errorSweetAlert, successSweetAlert, warningSweetAlert } from "../helpers/sweetAlertGlobals"
    export default defineComponent({
        name: 'validar-invitado',
        data(){
            return {
                buscar_folio:{
                    folio:''
                },
                invitado:{
                    nombre:'',
                    dependencia:'',
                    area:'',
                    folio:'',
                    verificado:'',
                    evento_id:'',
                    archivo_oficio: [],   
                },
            }
        },
        
        created() {
            this.buscarFolio()
            // if(this.user){
            //     this.buscarOficio()
            // }
        },
        computed: {
            user() {
                return this.$store.getters.user
            }
        },
        methods:{
            logout() {
                this.$store.dispatch('logout')
            },
            async buscarFolio() {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);

                // console.log(urlParams.get('folio'))

                let folio = urlParams.get('folio')

                // console.log("folio", folio)

                if(folio)
                {
                    this.buscar_folio.folio = folio

                    try {
                        let response = await axios.post('/api/invitados/buscar-folio', this.buscar_folio)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                Swal.fire({
                                    title: "Verificado",
                                    text: "Acceso permitido",
                                    icon: "success",
                                    allowOutsideClick: false,
                                    });
                            } else if(response.data.status === "usado"){
                                Swal.fire({
                                    title: "Usado",
                                    text: "El codigo ya fue escaneado",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                    });
                            }
                            else if(response.data.status === "no_existe"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "No existe",
                                    text: "El codigo no esta registrado",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    });
                            }
                            else {
                                errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al buscar cita.')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error al buscar el folio.')
                    }
                }
            }
        }
    })
    
</script>