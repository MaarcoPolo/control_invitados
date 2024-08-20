<template>
    <div>

    </div>
</template>

<script>
    import { defineComponent } from "vue";
    import { errorSweetAlert, successSweetAlert, warningSweetAlert } from "../helpers/sweetAlertGlobals"
    export default defineComponent({
        name: 'confirmacion',
        data(){
            return {
                buscar_folio:{
                    folio:''
                },
            }
        },
        
        created() {
            this.confirmacion()
        },
        computed: {
        },
        methods:{
            async confirmacion() {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);

                // console.log(urlParams.get('folio'))

                let folio = urlParams.get('folio')

                // console.log("folio", folio)

                if(folio)
                {
                    this.buscar_folio.folio = folio

                    try {
                        let response = await axios.post('/api/invitados/confirmar-asistencia', this.buscar_folio)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                Swal.fire({
                                    title: "ASISTENCIA CONFIRMADA",
                                    html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>CARGO:</strong> "+`${response.data.cargo}`+"<br><strong>ZONA:</strong> "+`${response.data.zona}`,
                                    // text: "ASISTENCIA CONFIRMADA",
                                    icon: "success",
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                    }).then((result) =>{
                                            if (result.isConfirmed) {
                                            window.location.href = "/login";
                                    }
                                    });
                            } else if(response.data.status === "usado"){
                                Swal.fire({
                                    title: "CONFIRMACION YA REALIZADA",
                                    text: "ASISTENCIA CONFIRMADA CON ANTERIORIDAD",
                                    // html: "<strong>NOMBRE:</strong> "+`${response.data.nombre}`+"<br><strong>HORA INGRESO:</strong> "+`${response.data.hora}`,
                                    // text: "Nombre: "+`${response.data.nombre}`+'<br>'+"Hora:",
                                    icon: "warning",
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