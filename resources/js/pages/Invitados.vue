<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page mt-2">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Invitados</p>
            </div>
        </div>
        <div class="container mt-16">
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
            <div class="row justify-content-center mt-6">
                <div class="col-md-8 col-12">
                    <div class="div-custom-input-form">
                        <label for="select_evento">Seleccione un evento:</label>
                        <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="invitado.evento_id">
                            <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-flex-start mt-6">
                <div class="col-md-4 col-12"></div>
                <div class="col-md-4 col-12"></div>
                <div class="col-md-4 col-12">
                    <div class="principal-div-custom-select">
                        <div class="second-div-custom-select">
                            <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                        </div>
                    </div>
                </div>
            </div>

            <!--INICIO DE LA TABLA INVITADOS-->
            <div class="my-2 mb-12 py-6">
                <div class="">
                    <div class="row justify-content-between">
                        <table class="table custom-border-table">
                            <thead class="headers-table">
                                <tr>
                                    <th class="custom-title-table">Id</th>
                                    <th class="custom-title-table">Nombre</th>
                                    <th class="custom-title-table">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <th colspan="5">
                                        <p class="text-center text-loading-data-table">Cargando datos...</p>
                                        <div class="linear-activity">
                                            <div class="indeterminate"></div>
                                        </div>
                                    </th>
                                </tr>
                                <tr v-else v-for="invitado in datosPaginados" :key="invitado.id">
                                    <td class="custom-data-table">
                                        {{invitado.numero_registro}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{invitado.nombre}}
                                    </td>
                                    <td>
                                        <div class="text-center row justify-content-center">
                                            <div>
                                                <v-icon
                                                    @click="abrirModalEditarInvitado(invitado)"
                                                    class="mr-1"
                                                    >
                                                    mdi-text-box-edit-outline
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Editar Invitado</span>
                                                </v-tooltip>
                                            </div>
                                            <div>
                                                <v-icon
                                                    @click="eliminarInvitado(invitado)"
                                                    class="ml-1"
                                                    >
                                                    mdi-trash-can
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Eliminar Invitado</span>
                                                </v-tooltip>
                                            </div>
                                            <div>
                                                <v-icon
                                                    @click="descargarCodigoInvitado(invitado)"
                                                    class="ml-1 mr-1"
                                                    >
                                                    mdi-qrcode
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Descargar Código</span>
                                                </v-tooltip>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <template v-if="invitados && invitados.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="custom-text-show-results mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{invitados.length}}</span>
                                        resultados
                                    </p>
                                </div>
                                <div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-lg justify-content-center">
                                            <li class="page-item cursor-paginator" @click="getFirstPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                    <span class="sr-only">First</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getPreviousPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li v-for="pagina in pages" @click="getDataPagina(pagina), setCurrentPage(pagina)" :key="pagina" class="page-item cursor-paginator" :class="isActive(pagina)">
                                                <a class="page-link">
                                                    {{pagina}}
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getNextPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getLastPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;&gt;</span>
                                                    <span class="sr-only">Last</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="!loading">
                            <div class="text-center">
                                <p class="no-data-text">No hay invitados disponibles</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <v-dialog v-model="dialogNuevoInvitado" max-width="100rem" persistent>
                <v-card>
                    <v-card-title class="text-center">
                        <h3 class="mt-5 custom-dialog-title">Nuevo Invitado</h3>
                    </v-card-title>
                    <v-card-text>
                        <div class="text-center my-3 custom-border">
                            <div class="custom-subtitle">
                                <p>Datos</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_nombre">Nombre:</label>
                                    <input id="input_nombre" type="text" class="form-control" v-model="v$.invitado.nombre.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.nombre.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_dependencia">Dependencia u Organismo:</label>
                                    <input id="input_dependencia" type="text" class="form-control" v-model="invitado.dependencia">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_area">Área:</label>
                                    <input id="input_area" type="text" class="form-control" v-model="invitado.area">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_telefono">Teléfono:</label>
                                    <input id="input_telefono" type="text" autocomplete="off" class="form-control" v-model="invitado.telefono">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_email">Correo:</label>
                                    <input id="input_email" type="text" autocomplete="off" class="form-control" v-model="invitado.email">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="select_evento">Seleccione un evento:</label>
                                    <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="invitado.evento_id">
                                        <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-4 mt-6">
                            <v-btn
                                class="custom-button mr-2"
                                color="#c4f45d"
                                @click="guardarNuevoInvitado()"
                                >
                                Guardar
                            </v-btn>
                            <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarModalNuevoInvitado()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <!-- INICIO MODAL PARA EDITAR DATOS DEL INVITADO -->
            <v-dialog v-model="dialogEditarInvitado" max-width="100rem" persistent>
                <v-card>
                    <v-card-title class="text-center">
                        <h3 class="mt-2 custom-dialog-title">Editar invitado</h3>
                    </v-card-title>
                    <v-card-text>
                        <div class="text-center my-8 custom-border">
                            <div class="custom-subtitle">
                                <p>Datos</p>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_nombre">Nombre:</label>
                                    <input id="input_nombre" type="text" class="form-control" v-model="v$.invitado.nombre.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.nombre.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_dependencia">Dependencia u Organismo:</label>
                                    <input id="input_dependencia" type="text" class="form-control" v-model="invitado.dependencia">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_area">Área:</label>
                                    <input id="input_area" type="text" class="form-control" v-model="invitado.area">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between mt-4">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_telefono">Teléfono:</label>
                                    <input id="input_telefono" type="text" autocomplete="off" class="form-control" v-model="invitado.telefono">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_email">Correo:</label>
                                    <input id="input_email" type="text" autocomplete="off" class="form-control" v-model="invitado.email">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="select_evento">Seleccione un evento:</label>
                                    <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="invitado.evento_id">
                                        <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-4 mt-6">
                            <v-btn
                                class="custom-button mr-2"
                                color="#c4f45d"
                                @click="guardarCambiosEditarInvitado()"
                                >
                                Guardar
                            </v-btn>
                            <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarModalNuevoInvitado()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    import useValidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'

    export default defineComponent({
        name: 'invitados',
        data () {
            return { 
                showNav: false,
                dialogNuevoInvitado: false,
                dialogEditarInvitado: false,
                invitado: {
                    id: null,
                    nombre: '',
                    dependencia:'',
                    area:'',
                    telefono:'',
                    email:'',
                    evento_id: null
                },               
                loading: false,
                elementosPorPagina: 10,
                paginaActual: 1,
                datosPaginados: [],
                mostrar: false,
                from: '',
                to: '',
                numShown: 5,
                current: 1,
                buscar: '',
            }
        },
        setup() {
            return {
                v$: useValidate()
            }
        },
        validations() {
                return {
                    invitado: {
                        nombre: {
                            required
                        },
                    }
                }
        },
        created() {
            this.getInvitados()
            this.getEventos()
            
        },
        computed: {
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
            invitados() {
                    return this.$store.getters.getInvitados
            },
            eventos() {
                    return this.$store.getters.getEventos
            }
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.invitados.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())                    
                    })
                } else {
                    this.getDataPagina(1)
                }
            },
            mostrar: function () {
                if (this.mostrar) {
                    this.getDataPagina(1)
                }
            },
            'invitado.evento_id': function () {
                this.BuscarInvitado()
            },
        },
        methods: {
        logout() {
                this.$store.dispatch('logout')
            },
            totalPaginas() {
                return Math.ceil(this.invitados.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.invitados[index]) {
                        this.datosPaginados.push(this.invitados[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.invitados.length
                }
            },
            getFirstPage() {
                this.paginaActual = 1
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getPreviousPage() {
                if (this.paginaActual > 1) {
                    this.paginaActual--
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getNextPage() {
                if (this.paginaActual < this.totalPaginas()) {
                    this.paginaActual++
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getLastPage() {
                this.paginaActual = this.totalPaginas()
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            isActive (noPagina) {
                return noPagina == this.paginaActual ? 'active' : ''
            },
            setCurrentPage(pagina) {
                this.current = pagina
            },
            abrirModalNuevoInvitado(){
                this.dialogNuevoInvitado = true
            },
            async getInvitados() {
                this.loading = true
                try {                   
                    let response = await axios.post('/api/invitados')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setInvitados', response.data.invitados)
                            this.mostrar = true
                            this.loading = false
                            this.getDataPagina(1)

                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los invitados')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los invitados')
                }
                this.loading = false
            },
            cerrarModalNuevoInvitado(){
                this.dialogNuevoInvitado = false
                this.dialogEditarInvitado = false
                this.invitado.id = ''
                this.invitado.nombre =''
                this.invitado.dependencia =''
                this.invitado.area =''
                this.invitado.telefono = ''
                this.invitado.email = ''
            },
            abrirModalEditarInvitado(invitado){
                this.dialogEditarInvitado = true 
                this.invitado.id = invitado.id
                this.invitado.nombre = invitado.nombre
                this.invitado.dependencia = invitado.dependencia
                this.invitado.area = invitado.area
                this.invitado.telefono = invitado.telefono
                this.invitado.email = invitado.email
            },
            async guardarNuevoInvitado() {
                const isFormCorrect = await this.v$.invitado.$validate()              
                if (!isFormCorrect) return
                Swal.fire({
                    title: '¿Guardar nuevo Invitado?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                                this.loading = true
                                let response = await axios.post('/api/invitados/crear-invitado', this.invitado)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar al invitado.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setInvitados', result.value.data.invitados)
                                    this.loading = false
                                    this.cerrarModalNuevoInvitado()
                                    this.getDataPagina(1)
                                } else if(result.value.data.status==="exists"){
                                    warningSweetAlert(result.value.data.message)
                                    this.loading = false
                                }else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar al invitado.')
                            }
                        }
                    })
            },
            async guardarCambiosEditarInvitado() {
                const isFormCorrect = await this.v$.invitado.$validate()              
                if (!isFormCorrect) return
                    Swal.fire({
                        title: '¿Guardar cambios?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {

                                let response = await axios.post('/api/invitados/actualizar-invitado', this.invitado)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del invitado.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setInvitados', result.value.data.invitados)
                                    this.cerrarModalNuevoInvitado()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del invitado.')
                            }
                        }
                    })
            },
            async eliminarInvitado(invitado) {
                    Swal.fire({
                    title: '¿Eliminar Invitado?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            
                            let response = await axios.post('/api/invitados/eliminar-invitado', invitado)
                            return response
                        } catch (error) {
                            errorSweetAlert('Ocurrió un error al eliminar este Invitado.')
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.$store.commit('setInvitados', result.value.data.invitados)
                                this.getDataPagina(1)
                            } else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al eliminar el invitado.')
                        }
                    }
                })
            },
            async descargarCodigoInvitado(invitado){
                try{
                    let response = await axios.post('/api/invitados/generar-codigo-qr',invitado,{
                                                    responseType: 'arraybuffer'
                                                    }).then((response)=>{    
                                                        let blob = new Blob([response.data], { type: 'application/pdf' })
                                                        let link = document.createElement('a')
                                                        link.href = window.URL.createObjectURL(blob)
                                                        link.download = `${invitado.nombre}.pdf`
                                                        // link.download = 'codigoQR.pdf'
                                                        link.click()
                                                    })   
                                                }catch (error) {
                        errorSweetAlert('Ocurrió un error al descargar el archivo PDF')
                    }  
            },
            async getEventos() {
                this.loading = true
                try {                   
                    let response = await axios.get('/api/eventos')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setEventos', response.data.eventos)
                            
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los Eventos')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los Eventos')
                }
                this.loading = false
            },
            async BuscarInvitado() {
                this.loading = true
                try {                   
                    let response = await axios.post('/api/invitados/buscar-invitados', this.invitado)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setInvitados', response.data.invitados)
                            this.getDataPagina(1)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los Eventos')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los Eventos')
                }
                this.loading = false
            },
        }
    })
</script>