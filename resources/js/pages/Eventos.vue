<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page mt-8">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Eventos</p>
            </div>
        </div>
        <div class="container mt-16">
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
            <div class="row justify-content-between">
                <div class="col-md-3 col-12">
                    <v-btn
                        class="custom-button"
                        block
                        color="#c4f45d"
                        @click="abrir()"
                        >
                        Nuevo Evento
                    </v-btn>
                </div>
                <div class="col-md-5 col-12 mt-6"></div>
                    <div class="col-md-4 col-12">
                        <div class="principal-div-custom-select">
                            <!-- <div class="second-div-custom-select"> -->
                                <input v-model="buscar" placeholder="Buscar..." type="search" autocomplete="off" class="form-control custom-input">
                            <!-- </div> -->
                        </div>
                    </div>
            </div>
            <v-container>
                <v-expansion-panels v-if="panel_evento" v-model="panel_evento">
                    <v-expansion-panel>
                        <v-expansion-panel-title > Registro de evento </v-expansion-panel-title>
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
                                            <input id="input_nombre" type="text" class="form-control" v-model="v$.evento.nombre.$model">
                                            <p class="text-validation-red" v-if="v$.evento.nombre.$error">*Campo obligatorio</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_apellidoP">Organizador:</label>
                                            <input id="input_apellidoP" type="text" class="form-control" v-model="v$.evento.organizador.$model">
                                            <p class="text-validation-red" v-if="v$.evento.organizador.$error">*Campo obligatorio</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-4 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_fecha_i">Fecha inicial:</label>
                                            <input id="input_fecha_i" type="date" class="form-control" v-model="evento.fecha_i">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_fecha_f">Fecha final:</label>
                                            <input id="input_fecha_f" type="date" class="form-control" v-model="evento.fecha_f">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_horario">Horario:</label>
                                            <input id="input_horario" type="time" class="form-control" v-model="evento.horario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-6 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_sede">Sede:</label>
                                            <input id="input_sede" type="text" class="form-control" v-model="v$.evento.sede.$model">
                                            <p class="text-validation-red" v-if="v$.evento.sede.$error">*Campo obligatorio</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_dom_sede">Domicilio de la Sede:</label>
                                            <input id="input_dom_sede" type="text" class="form-control" v-model="evento.domicilio">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-12 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_ubi">Ubicación en Google Maps:</label>
                                            <input id="input_ubi" type="url" class="form-control" v-model="v$.evento.ubicacion.$model">
                                            <p class="text-validation-red" v-if="v$.evento.ubicacion.$error">*No es un URL valido</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-6 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_logo">Logo para la invitación:</label>
                                            <v-file-input 
                                                v-model="evento.logo"
                                                show-size
                                                accept="image/*"
                                                variant="outlined">
                                            </v-file-input>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="div-custom-input-form">
                                            <label for="input_fondo">Fondo para la invitación:</label>
                                            <v-file-input 
                                                v-model="evento.fondo"
                                                show-size
                                                accept="image/*"
                                                variant="outlined">
                                            </v-file-input>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="this.nuevo == 1" class="text-center mb-4 mt-2">
                                    <v-btn
                                        class="custom-button mr-2"
                                        color="#c4f45d"
                                        @click="guardarNuevoEvento()"
                                        >
                                        Guardar
                                    </v-btn>
                                    <v-btn
                                        class="custom-button ml-2"
                                        color="#6a73a0"
                                        @click="cerrarNuevoEvento()"
                                        >
                                        Cerrar
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
                                    <v-btn
                                        class="custom-button ml-2"
                                        color="#6a73a0"
                                        @click="cerrarNuevoEvento()"
                                        >
                                        Cerrar
                                    </v-btn>
                                </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
                <v-expansion-panels v-if="panel_invitado" v-model="panel_invitado">
                    <v-expansion-panel>
                        <v-expansion-panel-title> Registo de invitado </v-expansion-panel-title>
                        <v-expansion-panel-content>
                            <v-expansion-panel-text>
                                <div class="text-center my-3 custom-border">
                                    <div class="custom-subtitle">
                                        <p>Datos</p>
                                    </div>
                                </div>
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
                                            <label for="select_estacionamiento">Estacionamiento:</label>
                                            <select id="select_estacionamiento" class="form-control minimal custom-select text-uppercase" v-model="invitado.estacionamiento">
                                                <option  v-for="item in estacionamiento" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mb-4 mt-2">
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
                                        @click="cerrarNuevoInvitado()"
                                        >
                                        Cerrar
                                    </v-btn>
                                </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>
            <!--INICIO DE LA TABLA EVENTOS-->
            <div class="my-2 mb-12 py-6">
                <div class="">
                    <div class="row justify-content-between">
                        <div class="table-responsive">
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
                                                        @click="abrirEditarEvento(evento)"
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
                                                        @click="abrirNuevoInvitado(evento)"
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
                                                        @click="abrirModalExcel(evento)"
                                                        class="ml-1"
                                                        >
                                                        mdi-account-arrow-down-outline                                          
                                                        </v-icon>

                                                    <v-tooltip
                                                        activator="parent"
                                                        location="bottom"
                                                        >
                                                        <span style="font-size: 15px;">subir invitados</span>
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
                                                <div>
                                                    <v-icon
                                                        @click="enviarCorreos(evento)"
                                                        class="ml-1"
                                                        >
                                                        mdi-email-arrow-right
                                                    </v-icon>

                                                    <v-tooltip
                                                        activator="parent"
                                                        location="bottom"
                                                        >
                                                        <span style="font-size: 15px;">Enviar Invitaciones</span>
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
    <v-dialog v-model="dialogExcel" max-width="100rem" persistent>
        <v-card>
            <v-card-title class="text-center">
                <h3 class="mt-5 custom-dialog-title">Subir archivo de invitados</h3>
            </v-card-title>
                <v-card-text>
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-12">
                            <div class="div-custom-input-form">
                                <label for="select_seccion">Selecciona la sección a la cual pertenecen tus invitados:</label>
                                <select id="select_seccion" class="form-control minimal custom-select text-uppercase" v-model="archivo.zona_id">
                                    <option  v-for="item in this.secciones" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-12 mt-6">
                            <v-file-input
                                v-model="archivo.archivo"
                                show-size
                                label="invitados"
                                variant="outlined"
                            ></v-file-input>  
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class=" text-center col-md-4 col-12  mt-8">
                            <v-btn
                                class="custom-button ml-2"
                                color="#c4f45d"
                                @click="EventSubir()"
                                >
                                Importar
                            </v-btn>
                        </div>
                        <div class=" text-center col-md-4 col-12  mt-8">
                            <v-btn
                                class="custom-button ml-2"
                                color="#6a73a0"
                                @click="cerrarDialogExcel()"
                                >
                                Cerrar
                            </v-btn>
                        </div>
                    </div>
                </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    import useValidate from '@vuelidate/core'
    import { required, email, url } from '@vuelidate/validators'

    export default defineComponent({
        name: 'eventos',
        data () {
            return { 
                archivo: {
                    evento_id: null,
                    zona_id: null,
                    archivo: ''
                },
                notificacion: {
                    evento_id: null,
                },
                nuevo: 0,
                panel_evento: [],
                showNav: false,
                evento: {
                    id: null,
                    nombre: '',
                    organizador:'',
                    sede: '',
                    fecha_i: null,
                    fecha_f: null,
                    horario: null,
                    domicilio: '',
                    ubicacion: '',
                    logo: [],
                    fondo: []
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
                
                invitado: {
                    id: null,
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

                },
                dialogExcel: false,

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
                panel_invitado: [],
                panel_invitado: false,
                panel_evento: false,
                secciones: '',
                peticion: {
                    evento_id: null
                }
            }
        },
        setup() {
            return {
                v$: useValidate()
            }
        },
        validations() {
                return {
                    evento: {
                        nombre: {
                            required
                        },
                        organizador: {
                            required
                        },
                        sede: {
                            required
                        },
                        ubicacion:{
                            url
                        }

                    },
                    invitado:{
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
        methods: {
            abrir(){
                this.panel_evento = [0]
                this.panel_invitado = false
                this.nuevo = 1
                this.v$.$reset()
                this.evento.nombre =''
                this.evento.organizador =''
                this.evento.sede =''
                this.evento.fecha_i = ''
                this.evento.fecha_f = ''
                this.evento.horario =''
                this.evento.domicilio = ''
                this.evento.ubicacion = ''
                this.evento.id = null
                this.evento.logo = []
                this.evento.fondo = []
            },
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
            cerrarNuevoEvento(){
                this.panel_evento = []
                this.panel_evento = false
                this.evento.nombre =''
                this.evento.organizador =''
                this.evento.sede =''
                this.evento.fecha_i = ''
                this.evento.fecha_f = ''
                this.evento.horario =''
                this.evento.domicilio = ''
                this.evento.ubicacion = ''
                this.evento.id = null
                this.evento.logo = []
                this.evento.fondo = []
                this.v$.$reset()
            },
            abrirEditarEvento(evento){
                this.nuevo = 0
                this.panel_evento = [0] 
                this.panel_invitado = false
                this.evento.id = evento.id
                this.evento.nombre = evento.nombre
                this.evento.organizador = evento.organizador
                this.evento.sede = evento.sede
                this.evento.fecha_i = evento.fecha_i
                this.evento.fecha_f = evento.fecha_f
                this.evento.horario = evento.horario
                this.evento.domicilio = evento.domicilio_sede
                this.evento.ubicacion = evento.ubicacion
            },
            async guardarNuevoEvento() {
                const isFormCorrect = await this.v$.evento.$validate()              
                if (!isFormCorrect) return
                Swal.fire({
                    title: '¿Guardar nuevo Evento?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    customClass: {
                    container: 'swal2-container',
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    content: 'swal2-content',
                    actions: 'swal2-actions',
                    confirmButton: 'swal2-styled'
                },
                    preConfirm: async () => {
                        try {
                                // this.loading = true
                                let response = await axios.post('/api/eventos/crear-evento', this.evento,{
                                    headers: {
                                        'Content-Type':'multipart/form-data'
                                    }
                                })
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar el Evento.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        // this.loading = true
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setEventos', result.value.data.eventos)
                                    // this.loading = false
                                    this.cerrarNuevoEvento()
                                    this.getDataPagina(1)

                                } else if(result.value.data.status==="exists"){
                                    warningSweetAlert(result.value.data.message)
                                    // this.loading = false
                                }else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar el Evento.')
                            }
                        }
                    })
                    this.v$.$reset()
            },
            async guardarCambiosEditarEvento() {
                const isFormCorrect = await this.v$.evento.$validate()              
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

                                let response = await axios.post('/api/eventos/actualizar-evento', this.evento,{
                                    headers: {
                                        'Content-Type':'multipart/form-data'
                                    }
                                })
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del evento.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setEventos', result.value.data.eventos)
                                    this.cerrarNuevoEvento()
                                    this.getDataPagina(1)
                    
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del evento.')
                            }
                        }
                    })
            },
            async eliminarEvento(evento) {
            
                    Swal.fire({
                    title: '¿Eliminar Evento?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            
                            let response = await axios.post('/api/eventos/eliminar-evento', evento)
                            return response
                        } catch (error) {
                            errorSweetAlert('Ocurrió un error al eliminar este Evento.')
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.$store.commit('setEventos', result.value.data.eventos)
                                this.getDataPagina(1)
                            } else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al eliminar el Evento.')
                        }
                    }
                })
            },
            
            // funciones para el invitado 
            abrirNuevoInvitado(evento){
                this.archivo.evento_id = evento.id
                this.panel_invitado = [0]
                this.invitado.evento_id = evento.id
                this.panel_evento = false
                this.v$.$reset()
                this.BuscarSecciones('invitado')
            },
            cerrarNuevoInvitado(){
                this.panel_invitado = []
                this.panel_invitado = false
                this.invitado.id = null
                this.invitado.nombre =''
                this.invitado.apellido_p =''
                this.invitado.apellido_m =''
                this.invitado.dependencia =''
                this.invitado.area =''
                this.invitado.telefono = ''
                this.invitado.email = ''
                this.invitado.estado =''
                this.invitado.municipio = ''
                this.invitado.seccion = ''
                this.invitado.estacionamiento = ''
                this.invitado.cargo = ''
                this.invitado.seccion = ''
                this.v$.$reset()

            },
            limpiarPanelInvitado(){
                this.invitado.id = nulL
                this.invitado.nombre =''
                this.invitado.apellido_p =''
                this.invitado.apellido_m =''
                this.invitado.dependencia =''
                this.invitado.area =''
                this.invitado.telefono = ''
                this.invitado.email = ''
                this.invitado.estado =''
                this.invitado.municipio = ''
                this.invitado.seccion = ''
                this.invitado.estacionamiento = ''
                this.invitado.cargo = ''
                this.invitado.seccion = ''
                this.v$.$reset()
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
                                    this.limpiarPanelInvitado()
                                    this.loading2 = false
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
            async EventSubir(){
                let formData = new FormData();
                formData.append('file', this.archivo.archivo);
                formData.append('evento_id', this.archivo.evento_id);
                formData.append('zona_id', this.archivo.zona_id);

                let response  =  await axios.post( '/api/invitados/import',formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }}).then((response) => {
                        if(response.status === 200){
                            if(response.data.status === "ok"){
                                successSweetAlert('Se subio el archivo correctamente')
                                this.cerrarDialogExcel()
                            }
                            else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        }
                        else {
                        errorSweetAlert('Ocurrió un error al obtener los invitados')
                        }
                }).catch(function(){
                    errorSweetAlert('Ocurrió un error al agregar los invitados.')
                });
            },
            abrirModalExcel(evento){
                this.archivo.evento_id = evento.id
                this.dialogExcel = true
                this.BuscarSecciones('archivo')
            },
            cerrarDialogExcel(){
                this.dialogExcel = false
                this.archivo.archivo = ''
                this.archivo.evento_id = null
                this.archivo.zona_id = ''
            },

            async enviarCorreos(evento) {  
                this.notificacion.evento_id = evento.id              

                this.loading = true
                console.log(this.notificacion)
                try {                   
                    let response = await axios.post('/api/invitados/eviarCorreos',this.notificacion)
                    console.log(response)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            Swal.fire({
                            title: "Correos enviados con éxito.",
                            html: "<strong>Se mandaron "+`${response.data.total}`+" correos</strong>",
                            icon: "success"
                                });

                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al enviar los correos')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los correos')
                }
                this.loading = false
            },
            async BuscarSecciones(ban){
                if(ban == 'archivo'){
                    this.peticion.evento_id = this.archivo.evento_id
                
                }else{
                    this.peticion.evento_id = this.invitado.evento_id
                }
                this.loading = true
                try {                   
                    let response = await axios.post('/api/secciones/buscar-secciones', this.peticion)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.secciones = response.data.secciones
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