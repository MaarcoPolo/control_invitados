<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page mt-8">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Secciones</p>
            </div>
        </div>
        <div class="container mt-6">
            <div class="row justify-content-center">
                <div class="col-md-8 col-12">
                    <div class="div-custom-input-form">
                        <label for="select_evento">Seleccione un evento:</label>
                        <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="seccion.evento_id">
                            <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between mt-6">
                <div class="col-md-3 col-12">
                    <v-btn
                        class="custom-button"
                        block
                        color="#c4f45d"
                        @click="abrir()"
                        >
                        Nueva Seccion
                    </v-btn>
                </div>
                <div class="col-md-5 col-12 mt-4"></div>
                    <div class="col-md-4 col-12">
                        <div class="principal-div-custom-select">
                            <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                        </div>
                    </div>
            </div>
            <v-container>
                <v-expansion-panels v-model="panel">
                    <v-expansion-panel>
                        <v-expansion-panel-title >
                        </v-expansion-panel-title>
                        <v-expansion-panel-content>
                            <v-expansion-panel-text>
                                    <div class="text-center my-3 custom-border">
                                        <div class="custom-subtitle">
                                            <p>Datos</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-6 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_nombre">Nombre:</label>
                                                <input id="input_nombre" type="text" class="form-control" v-model="v$.seccion.nombre.$model">
                                                <p class="text-validation-red" v-if="v$.seccion.nombre.$error">*Campo obligatorio</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_apellidoP">Color:</label>
                                                <input id="input_apellidoP" type="color" class="form-control" v-model="v$.seccion.color.$model">
                                                <p class="text-validation-red" v-if="v$.seccion.color.$error">*Campo obligatorio</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="this.nuevo == 1" class="text-center mb-4 mt-2">
                                        <v-btn
                                            class="custom-button mr-2"
                                            color="#c4f45d"
                                            @click="guardarNuevaSeccion()"
                                            >
                                            Guardar
                                        </v-btn>
                                    </div>
                                    <div v-else class="text-center mb-4 mt-2">
                                        <v-btn
                                            class="custom-button mr-2"
                                            color="#c4f45d"
                                            @click="guardarCambiosSeccion()"
                                            >
                                            Guardar
                                        </v-btn>
                                    </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>
            <div class="my-2 mb-12 py-6">
                <div class="">
                    <div class="row justify-content-between">
                        <div class="table-responsive">
                            <table class="table custom-border-table">
                                <thead class="headers-table">
                                    <tr>
                                        <th class="custom-title-table">#</th>
                                        <th class="custom-title-table">Nombre</th>
                                        <th class="custom-title-table">Color</th>
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
                                    <tr v-else v-for="seccion in datosPaginados" :key="seccion.id">
                                        <td class="custom-data-table">
                                            {{seccion.numero_registro}}
                                        </td>
                                        <td class="custom-data-table text-uppercase">
                                            {{seccion.nombre}}
                                        </td>
                                        <td :bgcolor="seccion.color"></td>
                                        <td>
                                            <div class="text-center row justify-content-center">
                                                <div>
                                                    <v-icon
                                                        @click="abrirModalEditarSeccion(seccion)"
                                                        class="mr-1"
                                                        >
                                                        mdi-text-box-edit-outline
                                                    </v-icon>

                                                    <v-tooltip
                                                        activator="parent"
                                                        location="bottom"
                                                        >
                                                        <span style="font-size: 15px;">Editar Seccion</span>
                                                    </v-tooltip>
                                                </div>
                                                <div>
                                                    <v-icon
                                                        @click="eliminarSeccion(seccion)"
                                                        class="ml-1"
                                                        >
                                                        mdi-trash-can
                                                    </v-icon>

                                                    <v-tooltip
                                                        activator="parent"
                                                        location="bottom"
                                                        >
                                                        <span style="font-size: 15px;">Eliminar Seccion</span>
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
                        <template v-if="secciones && secciones.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="custom-text-show-results mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{secciones.length}}</span>
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
                                <p class="no-data-text">No hay secciones disponibles</p>
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
import { required, email } from '@vuelidate/validators'

export default defineComponent({
    name: 'secciones',
    data(){
        return{
            nuevo: 0,
            panel: [],
            showNav: false,
            seccion: {
                    id: 0,
                    nombre: '',
                    color:'',
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
                secciones: ''
                // input_background_color: '#D6AAED',
        }
    },
    setup() {
        return {
            v$: useValidate()
        }
    },
    validations(){
        return{
            seccion:{
                nombre: {
                    required
                },
                color: {
                    required
                },
            }
        }

    },
    created(){
        this.getEventos()
    },
    computed:{
        eventos() {
            return this.$store.getters.getEventos
        },
        inputColor() {
                return {
                    
                    "backgraund_color": `${this.input_background_color}`,
                    
                }
        },
        pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
        },
        
    },
    watch:{
            'panel': function() {
                
                if(!this.panel){
                    this.nuevo = 1
                    this.v$.$reset()
                    this.seccion.id = null
                    this.seccion.nombre =''
                    this.seccion.color =''
                }
            },
        buscar: function () {
            if (!this.buscar.length == 0) {
                this.datosPaginados = this.secciones.filter(item => {
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
        'seccion.evento_id': function(){
            this.BuscarSecciones()
        }
    },
    methods:{
        logout() {
                this.$store.dispatch('logout')
            },
            totalPaginas() {
                return Math.ceil(this.secciones.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.secciones[index]) {
                        this.datosPaginados.push(this.secciones[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.secciones.length
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
            abrir(){
                this.nuevo = 1
                this.v$.$reset()
                this.panel = [0]
                this.seccion.nombre =''
                this.seccion.color =''
                this.seccion.id = null
            },
            abrirModalEditarSeccion(seccion){
                this.nuevo= 0
                this.panel = [0] 
                this.seccion.id = seccion.id
                this.seccion.nombre = seccion.nombre
                this.seccion.color = seccion.color
            },
            cerrarPanel(){
                this.panel = []
                this.seccion.nombre = ''
                this.seccion.color = ''
                this.seccion.id = null
                this.v$.reset()

            },
            async guardarNuevaSeccion() {
                const isFormCorrect = await this.v$.seccion.$validate()              
                if (!isFormCorrect) return
                Swal.fire({
                    title: '¿Guardar nueva Seccion?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                                let response = await axios.post('/api/secciones/crear-seccion', this.seccion)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar la Seccion.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setSecciones', result.value.data.secciones)
                                    this.BuscarSecciones()
                                    this.cerrarPanel()
                                }
                                else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar el Evento.')
                            }
                        }
                    })
                    this.v$.$reset()
            },
            async guardarCambiosSeccion() {
                const isFormCorrect = await this.v$.seccion.$validate()              
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

                                let response = await axios.post('/api/secciones/actualizar-seccion', this.seccion)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos de la seccion.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setSecciones', result.value.data.secciones)
                                    this.BuscarSecciones()
                                    this.cerrarPanel()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos de la seccion.')
                            }
                        }
                    })
            },
            async eliminarSeccion(seccion) {
                Swal.fire({
                    title: '¿Eliminar Seccion?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            let response = await axios.post('/api/secciones/eliminar-seccion', seccion)
                            return response
                        } catch (error) {
                            errorSweetAlert('Ocurrió un error al eliminar la Seccion.')
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.$store.commit('setSecciones', result.value.data.secciones)
                                this.BuscarSecciones()
                            } else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al eliminar la Seccion.')
                        }
                    }
                })
            },
            async getEventos() {
                this.loading = true
                try {                   
                    let response = await axios.get('/api/eventos')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setEventos', response.data.eventos)
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
            async BuscarSecciones() {
                this.loading = true
                try {                   
                    let response = await axios.post('/api/secciones/buscar-secciones', this.seccion)
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
