<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page mt-2">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Secciones</p>
            </div>
        </div>

        <div class="container mt-16">
            <div class="row justify-content-between">
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
                    <div class="col-md-5 col-12"></div>
                    <div class="col-md-4 col-12">
                        <div class="principal-div-custom-select">
                            <div class="second-div-custom-select">
                                <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                            </div>
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
                                                <input id="input_nombre" type="text" class="form-control" v-model="seccion.nombre">
                                                <!-- <p class="text-validation-red" v-if="v$.evento.nombre.$error">*Campo obligatorio</p> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_apellidoP">Color:</label>
                                                <input :style="inputColor" id="input_apellidoP" type="color" class="form-control" v-model="seccion.color">
                                                <!-- <p class="text-validation-red" v-if="v$.evento.organizador.$error">*Campo obligatorio</p> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row justify-content-between">
                                        <div class="col-md-4 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_fecha_i">Fecha inicial:</label>
                                                <input id="input_fecha_i" type="date" class="form-control" v-model="evento.fecha_i">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_fecha_i">Fecha final:</label>
                                                <input id="input_fecha_i" type="date" class="form-control" v-model="evento.fecha_f">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_fecha_f">Horario:</label>
                                                <input id="input_fecha_f" type="time" class="form-control" v-model="evento.horario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-6 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_apellidoM">Sede:</label>
                                                <input id="input_apellidoM" type="text" class="form-control" v-model="v$.evento.sede.$model">
                                                <p class="text-validation-red" v-if="v$.evento.sede.$error">*Campo obligatorio</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_apellidoM">Domicilio de la Sede:</label>
                                                <input id="input_apellidoM" type="text" class="form-control" v-model="evento.domicilio">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-12 col-12">
                                            <div class="div-custom-input-form">
                                                <label for="input_apellidoM">Ubicación en Google Maps:</label>
                                                <input id="input_apellidoM" type="text" class="form-control" v-model="evento.ubicacion">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div v-if="this.nuevo == 1" class="text-center mb-4 mt-2">
                                        <v-btn
                                            class="custom-button mr-2"
                                            color="#c4f45d"
                                            @click="guardarNuevoEvento()"
                                            >
                                            Guardar
                                        </v-btn>
                                    </div>
                                    <div v-else class="text-center mb-4 mt-2">
                                        <v-btn
                                            class="custom-button mr-2"
                                            color="#c4f45d"
                                            @click="guardarCambiosEditarEvento()"
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
                        <table class="table custom-border-table">
                            <thead class="headers-table">
                                <tr>
                                    <th class="custom-title-table">#</th>
                                    <th class="custom-title-table">Nombre</th>
                                    <th class="custom-title-table">Organizador</th>
                                    <th class="custom-title-table">Sede</th>
                                    <th class="custom-title-table">Fecha inicial</th>
                                    <th class="custom-title-table">Fecha final</th>
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
                                <tr v-else v-for="evento in datosPaginados" :key="evento.id">
                                    <td class="custom-data-table">
                                        {{evento.numero_registro}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{evento.nombre}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{evento.organizador}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{evento.sede}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{evento.fecha_i}}
                                    </td>
                                    <td class="custom-data-table text-uppercase">
                                        {{evento.fecha_f}}
                                    </td>
                                    <td>
                                        <div class="text-center row justify-content-center">
                                            <div>
                                                <v-icon
                                                    @click="abrirModalEditarEvento(evento)"
                                                    class="mr-1"
                                                    >
                                                    mdi-text-box-edit-outline
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Editar Evento</span>
                                                </v-tooltip>
                                            </div>
                                            <div>
                                                <v-icon
                                                    @click="abrirModalNuevoInvitado(evento)"
                                                    class="ml-1"
                                                    >
                                                    mdi-account-plus
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Agregar Invitado</span>
                                                </v-tooltip>
                                            </div>
                                            <div>
                                                <v-icon
                                                    @click="eliminarEvento(evento)"
                                                    class="ml-1"
                                                    >
                                                    mdi-trash-can
                                                </v-icon>

                                                <v-tooltip
                                                    activator="parent"
                                                    location="bottom"
                                                    >
                                                    <span style="font-size: 15px;">Eliminar Evento</span>
                                                </v-tooltip>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <template v-if="eventos && eventos.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="custom-text-show-results mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{eventos.length}}</span>
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
                                <p class="no-data-text">No hay eventos disponibles</p>
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
                    // sede:'',
                    // fecha_i:null,
                    // fecha_f: null,
                    // horario: null,
                    // domicilio: '',
                    // ubicacion: ''
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
                input_background_color: '#FFFFFF',
        }
    },
    setup() {
        return {
            v$: useValidate()
        }
    },
    validations(){

    },
    created(){

    },
    computed:{
        inputColor() {
                return {
                    "background-color": `${this.input_background_color}`,
                    "border": "none"
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
        'seccion.color': function() {
                this.input_background_color = this.$refs.color_seleccion.value
                this.areas.forEach(e => {
                    if (e.color == this.color) {
                        this.preregistro.area = e.id
                    }
                    document.getElementById('input_gafete').focus();
                })
            },
        buscar: function () {
            if (!this.buscar.length == 0) {
                this.datosPaginados = this.eventos.filter(item => {
                     return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                    || item.sede.toLowerCase().includes(this.buscar.toLowerCase())
                    || item.organizador.toLowerCase().includes(this.buscar.toLowerCase())
                    || item.fecha_i.toLowerCase().includes(this.buscar.toLowerCase())
                    || item.fecha_f.toLowerCase().includes(this.buscar.toLowerCase())
                    
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
    },
    methods:{
        logout() {
                this.$store.dispatch('logout')
            },
            totalPaginas() {
                return Math.ceil(this.eventos.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.eventos[index]) {
                        this.datosPaginados.push(this.eventos[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.eventos.length
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
    }
})
</script>
