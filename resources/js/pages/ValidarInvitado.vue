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
                                    title: "ACCESO PERMITIDO",
                                    // text: "Acceso permitido",
                                    html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>CARGO:</strong> "+`${response.data.cargo}`+"<br><strong>ZONA:</strong> "+`${response.data.zona}`,
                                    icon: "success",
                                    allowOutsideClick: false,
                                    // background: "#D6AAED",
                                    confirmButtonText: "Ok",
                                    }).then((result) =>{
                                            if (result.isConfirmed) {
                                            window.location.href = "/login";
                                    }
                                    });
                            } else if(response.data.status === "usado"){
                                Swal.fire({
                                    title: "ACCESO USADO",
                                    html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>HORA INGRESO:</strong> "+`${response.data.hora}`,
                                    // text: "Nombre: "+`${response.data.nombre}`+'<br>'+"Hora:",
                                    icon: "warning",
                                    confirmButtonText: "Ok",
                                    allowOutsideClick: false,
                                }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
                                    });
                            }
                            else if(response.data.status === "no_existe_e"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "NO EXISTE",
                                    text: "El acceso al evento no está registrado",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    
                                    }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
                                    });
                            }
                            else if(response.data.status === "entro"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "ACCESO PERMITIDO",
                                    html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>CARGO:</strong> "+`${response.data.cargo}`+"<br><strong>ZONA:</strong> "+`${response.data.zona}`,
                                    icon: "success",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    
                                    }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
                                    });
                            }
                            else if(response.data.status === "entro_antes"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "ACCEDIO CON ANTERIORIDAD",
                                    html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>CARGO:</strong> "+`${response.data.cargo}`+"<br><strong>ZONA:</strong> "+`${response.data.zona}`,
                                    icon: "warning",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    
                                    }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
                                    });
                            }
                            else if(response.data.status === "sin_estacionamiento"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "SIN ACCESO",
                                    text: "No tiene acceso al estacionamiento",                                    icon: "error",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    
                                    }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
                                    });
                            }
                            else if(response.data.status === "no_existe"){
                                Swal.fire({
                                    // timer: 20000,
                                    title: "NO EXISTE",
                                    text: "El acceso al estacionamiento no está registrado",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    
                                    }).then((result) =>{
                                        if (result.isConfirmed) {
                                        window.location.href = "/login";
                                    }
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