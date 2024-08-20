<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page mt-8">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Invitados</p>
            </div>
        </div>
        <div class="container mt-6">
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-12">
                    <div class="div-custom-input-form">
                        <label for="select_evento">Seleccione un evento:</label>
                        <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="invitado.evento_id">
                            <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between mt-4">
                <div class="col-md-3 col-12 mt-4">
                    <v-btn
                        class="custom-button"
                        block
                        color="#c4f45d"
                        @click="abrirNuevoInvitado()"
                        >
                        Nuevo Invitado
                    </v-btn>
                </div>
                <div class="col-md-5 col-12 mt-4">
                    <v-btn
                        class="custom-button"
                        color="#c4f45d"
                        block
                        @click="exportarExcel()"
                        >
                        Exportar Datos
                    </v-btn>
                </div>
                <div class="col-md-4 col-12 mt-4">
                    <div class="principal-div-custom-select">
                        <!-- <div class="second-div-custom-select"> -->
                            <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <v-container>
                <v-expansion-panels v-if="panel_editar_invitado" v-model="panel_editar_invitado">
                    <v-expansion-panel>
                        <v-expansion-panel-title>
                        </v-expansion-panel-title>
                        <v-expansion-panel-content>
                            <v-expansion-panel-text>
                                <div class="row justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_nombre">Nombre:</label>
                                    <input id="input_nombre" type="text" class="form-control" autocomplete="off" v-model="v$.invitado.nombre.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.nombre.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_apellido_p">Apellido paterno:</label>
                                    <input id="input_apellido_p" type="text" class="form-control" autocomplete="off" v-model="v$.invitado.apellido_p.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.apellido_p.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_apellido_m">Apellido materno:</label>
                                    <input id="input_apellido_m" type="text" class="form-control" autocomplete="off" v-model="v$.invitado.apellido_m.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.apellido_m.$error">*Campo obligatorio</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_dependencia">Dependencia u Organismo:</label>
                                    <input id="input_dependencia" type="text" class="form-control" autocomplete="off" v-model="invitado.dependencia">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_cargo">Cargo:</label>
                                    <input id="input_cargo" type="text" class="form-control" autocomplete="off" v-model="invitado.cargo">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_area">Área:</label>
                                    <input id="input_area" type="text" class="form-control" autocomplete="off" v-model="invitado.area">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_telefono">Teléfono de la dependencia:</label>
                                    <input id="input_telefono" type="number" autocomplete="off" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" v-model="invitado.telefono">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_email">Correo:</label>
                                    <input id="input_email" type="email" autocomplete="off" class="form-control" v-model="v$.invitado.email.$model">
                                    <p class="text-validation-red" v-if="v$.invitado.email.$error">*Formato incorrecto</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_estado">Estado:</label>
                                    <input id="input_estado" type="text" autocomplete="off" class="form-control" v-model="invitado.estado">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="input_municipio">Municipio:</label>
                                    <input id="input_municipio" type="text" autocomplete="off" class="form-control" v-model="invitado.municipio">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="select_seccion">Seccion:</label>
                                    <select id="select_seccion" class="form-control minimal custom-select text-uppercase" v-model="invitado.seccion">
                                        <option  v-for="item in this.secciones" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content">
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="select_seccion">Estacionamiento:</label>
                                    <select id="select_seccion" class="form-control minimal custom-select text-uppercase" v-model="invitado.estacionamiento">
                                        <option  v-for="item in estacionamiento" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="div-custom-input-form">
                                    <label for="select_confirmo">¿Confirmo?:</label>
                                    <v-switch
                                        v-model="invitado.confirmo"
                                        :label="`${invitado.confirmo}`"
                                        false-value="NO"
                                        true-value="SI"
                                        hide-details
                                    ></v-switch>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-4 mt-6" v-if="this.nuevo_registro == 1">
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
                                @click="cerrarEditarInvitado()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                        <div class="text-center mb-4 mt-6" v-else>
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
                                @click="cerrarEditarInvitado()"
                                >
                                Cancelar
                            </v-btn>
                        </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>

            <!--INICIO DE LA TABLA INVITADOS-->
            <div class="my-2 mb-12 py-6">
                <div class="">
                    <div class="row justify-content-between">
                        <div class="table-responsive">
                            <table class="table custom-border-table">
                                <thead class="headers-table">
                                    <tr>
                                        <th class="custom-title-table">Id</th>
                                        <th class="custom-title-table">Nombre</th>
                                        <th class="custom-title-table">Dependencia</th>
                                        <th class="custom-title-table">Área</th>
                                        <th class="custom-title-table">Confirmado</th>
                                        <th class="custom-title-table">Sección</th>
                                        <th class="custom-title-table">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="loading">
                                        <th colspan="7">
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
                                            {{invitado.nombreC}}
                                        </td>
                                        <td class="custom-data-table text-uppercase">
                                            {{invitado.dependencia}}
                                        </td>
                                        <td class="custom-data-table text-uppercase">
                                            {{invitado.area}}
                                        </td>
                                        <td class="custom-data-table text-uppercase">
                                            {{invitado.confirmo}}
                                        </td>
                                        <td class="custom-data-table text-uppercase">
                                            {{invitado.zona}}
                                        </td>
                                        <td>
                                            <div class="text-center row justify-content-center">
                                                <div>
                                                    <v-icon
                                                        @click="abrirEditarInvitado(invitado)"
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
                                                <div>
                                                    <v-icon
                                                        @click="enviarCorreo(invitado)"
                                                        class="ml-1 mr-1"
                                                        >
                                                        mdi-email-fast-outline
                                                    </v-icon>

                                                    <v-tooltip
                                                        activator="parent"
                                                        location="bottom"
                                                        >
                                                        <span style="font-size: 15px;">Enviar correo</span>
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
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    import useValidate from '@vuelidate/core'
    import { required,email } from '@vuelidate/validators'

    export default defineComponent({
        name: 'invitados',
        data () {
            return {
                showNav: false,
                invitado: {
                    id: null,
                    nombreC:'',
                    nombre: '',
                    apellido_p:'',
                    apellido_m:'',
                    dependencia:'',
                    area:'',
                    telefono:'',
                    email:'',
                    evento_id: null,
                    estado:'',
                    municipio:'',
                    seccion: '',
                    cargo:'',
                    estacionamiento: null,
                    confirmo:''

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
                invitados:[],
                export: {
                    invitados: [],
                    evento_id: '',
                },
                estacionamiento: [
                    {
                        id: 1,
                        nombre: 'Si'
                    },
                    {
                        id: 0,
                        nombre: 'No'
                        
                    }
                ],
                panel_editar_invitado:[],
                panel_editar_invitado: false,
                nuevo_registro: 0,
                secciones:''
            
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
                        nombre:{
                            required
                        },
                        apellido_p:{
                            required
                        },
                        apellido_m:{
                            required
                        },
                        email:{
                            email
                        }
                    }
                }
        },
        created() {
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
            eventos() {
                    return this.$store.getters.getEventos
            },
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.invitados.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase()) 
                        || item.dependencia.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.area.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.confirmo.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.zona.toLowerCase().includes(this.buscar.toLowerCase())
                
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
            cerrarEditarInvitado(){
                this.panel_editar_invitado = []
                this.panel_editar_invitado = false
                this.invitado.id = null
                this.invitado.nombre = ''
                this.invitado.apellido_p = ''
                this.invitado.apellido_m = ''
                this.invitado.dependencia = ''
                this.invitado.area = ''
                this.invitado.cargo = ''
                this.invitado.estado = ''
                this.invitado.municipio = ''
                this.invitado.seccion = ''
                this.invitado.telefono = ''
                this.invitado.email = ''
                this.invitado.confirmo = ''
                this.v$.$reset()
            },
            abrirEditarInvitado(invitado){
                this.panel_editar_invitado = true
                this.panel_editar_invitado = [0]
                this.nuevo_registro = 0
                this.invitado.id = invitado.id
                this.invitado.nombreC = invitado.nombreC
                this.invitado.nombre = invitado.nombre
                this.invitado.apellido_p = invitado.apellido_p
                this.invitado.apellido_m = invitado.apellido_m
                this.invitado.dependencia = invitado.dependencia
                this.invitado.area = invitado.area
                this.invitado.cargo = invitado.cargo
                this.invitado.telefono = invitado.telefono
                this.invitado.email = invitado.email
                this.invitado.estado = invitado.estado
                this.invitado.municipio = invitado.municipio
                this.invitado.seccion = invitado.seccion
                this.invitado.estacionamiento = invitado.parking
                this.invitado.confirmo = invitado.confirmo
                this.BuscarSecciones()

            },
            abrirNuevoInvitado(){
                this.panel_editar_invitado = true
                this.panel_editar_invitado= [0]
                this.nuevo_registro = 1
                this.v$.$reset()                
                this.invitado.id = null
                this.invitado.nombreC = ''
                this.invitado.nombre = ''
                this.invitado.apellido_p = '' 
                this.invitado.apellido_m = ''
                this.invitado.dependencia = ''
                this.invitado.area = ''
                this.invitado.cargo = ''
                this.invitado.telefono = '' 
                this.invitado.email = ''
                this.invitado.estado = ''
                this.invitado.municipio = '' 
                this.invitado.seccion = ''
                this.invitado.estacionamiento = ''
                this.invitado.confirmo = ''
                this.BuscarSecciones()
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
                                this.loading2 = true
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
                                    this.getDataPagina(1)
                                    this.cerrarEditarInvitado()
                                    this.BuscarInvitado()
                                } else if(result.value.data.status==="exists"){
                                    warningSweetAlert(result.value.data.message)
                                    this.loading2 = false
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
                                    this.getDataPagina(1)
                                    this.cerrarEditarInvitado()
                                    this.BuscarInvitado()
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
                                this.BuscarInvitado()
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
                                                        link.download = `${invitado.nombreC}.pdf`
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
                            this.invitados = response.data.invitados
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
            async enviarCorreo(invitado) {
                this.loading = true
                try {                   
                    let response = await axios.post('/api/invitados/enviar-correo',invitado)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            successSweetAlert(response.data.message)
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
            async exportarExcel(){
                this.export.evento_id = this.invitado.evento_id
                // this.export.invitados = this.invitados
                let response = await axios.post('/api/invitados/exportar-excel',this.export,{
                    responseType: "blob",
                }).then((response)=>{    
                    var blob = new Blob([response.data], {
                        type: response.headers["content-type"],
                    });
                    const link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = `Invitados.xlsx`;
                    link.click();
                })
                this.loading2 = false 
            },
            async BuscarSecciones(){
                this.loading = true
                try {                   
                    let response = await axios.post('/api/secciones/buscar-secciones', this.invitado)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.secciones = response.data.secciones
                            this.getDataPagina(1)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener las secciones')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener las secciones')
                }
                this.loading = false
            },
        }
    }) 
</script>