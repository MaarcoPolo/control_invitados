<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card-titulo-page">
                <img class="icono-page" src="../../../public/icons/ventanilla.png" alt="">
                <p>Ingresados</p>
            </div>
        </div>
        <div class="container">
            <!-- INICIO BOTON NUEVO Y BUSCADOR -->
            <div class="row justify-content-center mt-6">
                <div class="col-md-8 col-12">
                    <div class="div-custom-input-form">
                        <label for="select_evento">Seleccione primero un evento:</label>
                        <select id="select_evento" class="form-control minimal custom-select text-uppercase" v-model="ingresado.evento_id">
                            <option  v-for="item in eventos" :key="item.id" :value="item.id">{{item.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-flex-start mt-6">
                <div class="col-md-4 col-12">
                    <v-btn
                        class="custom-button mr-2"
                        color="#c4f45d"
                        @click="SeccionesConteo()"
                        >
                        Actualizar ingresos
                    </v-btn>
                </div>
                <div class="col-md-4 col-12"></div>
                <div class="col-md-4 col-12">
                    <div class="principal-div-custom-select">
                        <div class="second-div-custom-select">
                            <input id="buscar" v-model="buscar" placeholder="Buscar invitado general" type="search" autocomplete="off" class="form-control custom-input">
                        </div>
                    </div>
                </div>
            </div>
            <v-container>
                <v-expansion-panels v-model="panel">
                    <v-expansion-panel>
                        <v-expansion-panel-title><h3>Información del conteo de los invitados</h3></v-expansion-panel-title>
                        <v-expansion-panel-text>
                            <!--INICIO DE LA TABLA INVITADOS-->
                            <div class="my-2 mb-12 py-6">
                                <div class="">
                                    <div class="row justify-content-between">
                                        <table class="table custom-border-table">
                                            <thead class="headers-table">
                                                <tr>
                                                    <th class="custom-title-table">Sección</th>
                                                    <th class="custom-title-table">Confirmados</th>
                                                    <th class="custom-title-table">Ingresados</th>
                                                    <th class="custom-title-table">Pendientes</th>
                                                    <th class="custom-title-table">Total de sección</th>
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
                                                <tr v-else v-for="secciones in datosPaginados" :key="secciones.id">
                                                    <td class="custom-data-table2" @click="BusquedaInvitados(secciones)">
                                                        {{secciones.nombre}}
                                                    </td>
                                                    <td class="custom-data-table text-uppercase" @click="BusquedaInvitados(secciones)">
                                                        {{secciones.confirmados}}
                                                    </td>
                                                    <td class="custom-data-table text-uppercase" @click="BusquedaInvitados(secciones)">
                                                        {{secciones.ingresados}}
                                                    </td>
                                                    <td class="custom-data-table text-uppercase" @click="BusquedaInvitados(secciones)">
                                                        {{secciones.pendientes}}
                                                    </td>
                                                    <td class="custom-data-table text-uppercase" @click="BusquedaInvitados(secciones)">
                                                        {{secciones.total_seccion}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <template v-if="secciones && secciones.length > 0">
                                            <div class="row justify-content-between container">
                                                <!-- <div>
                                                    <p class="custom-text-show-results mt-2">
                                                        Mostrando
                                                        <span>{{from}}</span>
                                                        -
                                                        <span>{{to}}</span>
                                                        de
                                                        <span>{{secciones.length}}</span>
                                                        resultados
                                                    </p>
                                                </div> -->
                                                <!-- <div>
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
                                                </div> -->
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
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>
            <!-- ///////////////////////////////////////////////////////// -->
            <v-container>
                <v-expansion-panels v-if="panel2" v-model="panel2">
                    <v-expansion-panel>
                        <v-expansion-panel-title><h3>Información de la busqueda de los invitados</h3></v-expansion-panel-title>
                        <v-expansion-panel-text>
                            <div class="row justify-content-flex-start mt-6">
                                <div class="col-md-4 col-12"></div>
                                <div class="col-md-4 col-12"></div>
                                <div class="col-md-4 col-12">
                                    <div class="principal-div-custom-select">
                                        <div class="second-div-custom-select">
                                            <input id="buscar" v-model="buscar2" placeholder="Buscar invitado" type="search" autocomplete="off" class="form-control custom-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-2 mb-12 py-6" id="busqueda">
                                <div class="">
                                    <div class="row justify-content-between">
                                        <table class="table custom-border-table">
                                            <thead class="headers-table">
                                                <tr>
                                                    <th class="custom-title-table">Nombre</th>
                                                    <th class="custom-title-table">Dependencia</th>
                                                    <th class="custom-title-table">Area</th>
                                                    <th class="custom-title-table">Cargo</th>
                                                    <th class="custom-title-table">Zona</th>
                                                    <th class="custom-title-table">Confirmo</th>
                                                    <th class="custom-title-table">Ingreso</th>
                                                    <th class="custom-title-table">Hora de ingreso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="loading2">
                                                    <th colspan="7">
                                                        <p class="text-center text-loading-data-table">Cargando datos...</p>
                                                        <div class="linear-activity">
                                                            <div class="indeterminate"></div>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr v-else v-for="invitados in datosPaginados2" :key="invitados.id">
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.nombreC}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.nombreC}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.dependencia}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.dependencia}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.area}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.area}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.cargo}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.cargo}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.zona}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.zona}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.confirmado}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.confirmado}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.verificado}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.verificado}}
                                                    </td>
                                                    <td v-if="invitados.verificado == 'si'" class="custom-data-table-color text-uppercase">
                                                        {{invitados.hora}}
                                                    </td>
                                                    <td v-else class="custom-data-table text-uppercase">
                                                        {{invitados.hora}}
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
                                                        <span>{{from2}}</span>
                                                        -
                                                        <span>{{to2}}</span>
                                                        de
                                                        <span>{{invitados.length}}</span>
                                                        resultados
                                                    </p>
                                                </div>
                                                <div>
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination pagination-lg justify-content-center">
                                                            <li class="page-item cursor-paginator" @click="getFirstPage2()">
                                                                <a class="page-link" aria-label="Previous">
                                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                                    <span class="sr-only">First</span>
                                                                </a>
                                                            </li>
                                                            <li class="page-item cursor-paginator" @click="getPreviousPage2()">
                                                                <a class="page-link" aria-label="Previous">
                                                                    <span aria-hidden="true">&lt;</span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                            </li>
                                                            <li v-for="pagina in pages2" @click="getDataPagina2(pagina), setCurrentPage2(pagina)" :key="pagina" class="page-item cursor-paginator" :class="isActive2(pagina)">
                                                                <a class="page-link">
                                                                    {{pagina}}
                                                                </a>
                                                            </li>
                                                            <li class="page-item cursor-paginator" @click="getNextPage2()">
                                                                <a class="page-link" aria-label="Next">
                                                                    <span aria-hidden="true">&gt;</span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </li>
                                                            <li class="page-item cursor-paginator" @click="getLastPage2()">
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
                                        <template v-else-if="!loading2">
                                            <div class="text-center">
                                                <p class="no-data-text">No hay invitados disponibles</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    // import { onUnmounted } from "vue";


    export default defineComponent({
        name: 'ingresados',
        data () {
            return {
                secciones:[],
                showNav: false, 
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
                ingresado:{
                    evento_id:'',
                },
                busqueda:{
                    evento_id:'',
                    seccion_id:''
                },
                panel:[],
                panel2:[],

                invitados:[],
                loading2: false,
                elementosPorPagina2: 10,
                paginaActual2: 1,
                datosPaginados2: [],
                mostrar2: false,
                from2: '',
                to2: '',
                numShown2: 5,
                current2: 1,
                buscar2: '',

                tiempo:null,
            }
        },
        created() {
            this.SeccionesConteo()
            this.getEventos()
        },
        mounted(){
            // this.recargar()       
        },
        computed: {
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
            pages2() {
                const numShown2 = Math.min(this.numShown2, this.totalPaginas2())
                let first = this.current2 - Math.floor(numShown2 / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas2() - numShown2 + 1)
                return [...Array(numShown2)].map((k, i) => i + first)
            },
            eventos() {
                    return this.$store.getters.getEventos
            }
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados2 = this.invitados.filter(item => {
                        return item.nombreC.toLowerCase().includes(this.buscar.toLowerCase())
                    })
                    this.panel = []
                    this.panel2 = [0]
                    // this.detener()
                } else {
                    this.getDataPagina2(1)
                }
            },
            buscar2: function () {
                if (!this.buscar2.length == 0) {
                    this.datosPaginados2 = this.invitados.filter(item => {
                        return item.nombreC.toLowerCase().includes(this.buscar2.toLowerCase())
                    })
                    this.panel = []
                    this.panel2 = [0]
                    // this.detener()
                } else {
                    this.getDataPagina2(1)
                }
            },
            mostrar: function () {
                if (this.mostrar) {
                    this.getDataPagina(1)
                }
            },
            mostrar2: function () {
                if (this.mostrar2) {
                    this.getDataPagina2(1)
                }
            },
            'ingresado.evento_id': function(){
                this.SeccionesConteo()
                this.BusquedaGeneral()
            },
        },
        methods: {
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
            async SeccionesConteo() {
                this.panel = [0]
                this.panel2 = false
                this.loading = true
                try {                   
                    let response = await axios.post('/api/secciones/contar-invitados',this.ingresado)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.secciones = response.data.secciones;
                            this.mostrar = true
                            this.loading = false
                            this.buscar = ''
                            this.buscar2 = ''
                            this.getDataPagina(1)
                            this.BusquedaGeneral()

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
            async BusquedaInvitados(secciones){
                this.busqueda.seccion_id = secciones.id;
                this.busqueda.evento_id = this.ingresado.evento_id;
                this.loading2 = true
                this.panel2 = true
                this.panel2 = [0]
                this.panel = []
                try {                   
                    let response = await axios.post('/api/secciones/buscar-invitados',this.busqueda)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.invitados = response.data.invitados;
                            this.mostrar2 = true
                            this.loading2 = false
                            this.buscar = ''
                            this.buscar2 = ''
                            this.getDataPagina2(1)

                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los invitados')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los invitados')
                }
                this.loading2 = false
            },
            totalPaginas2() {
                return Math.ceil(this.invitados.length / this.elementosPorPagina2)
            },
            getDataPagina2(noPagina) {
                this.paginaActual2 = noPagina
                this.datosPaginados2 = []

                let ini = (noPagina * this.elementosPorPagina2) - this.elementosPorPagina2
                let fin = (noPagina * this.elementosPorPagina2)

                for (let index = ini; index < fin; index++) {
                    if (this.invitados[index]) {
                        this.datosPaginados2.push(this.invitados[index])
                    }
                }
                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from2 = ini+1
                if (noPagina < this.totalPaginas2()) {
                    this.to = fin
                } else {
                    this.to = this.invitados.length
                }
            },
            getFirstPage2() {
                this.paginaActual2 = 1
                this.setCurrentPage2(this.paginaActual2)
                this.getDataPagina2(this.paginaActual2)
            },
            getPreviousPage2() {
                if (this.paginaActual2 > 1) {
                    this.paginaActual2--
                }
                this.setCurrentPage2(this.paginaActual2)
                this.getDataPagina2(this.paginaActual2)
            },
            getNextPage2() {
                if (this.paginaActual2 < this.totalPaginas2()) {
                    this.paginaActual2++
                }
                this.setCurrentPage2(this.paginaActual2)
                this.getDataPagina2(this.paginaActual2)
            },
            getLastPage2() {
                this.paginaActual2 = this.totalPaginas2()
                this.setCurrentPage2(this.paginaActual2)
                this.getDataPagina2(this.paginaActual2)
            },
            isActive2(noPagina) {
                return noPagina == this.paginaActual2 ? 'active' : ''
            },
            setCurrentPage2(pagina) {
                this.current2 = pagina
            },
            async BusquedaGeneral(){
                this.busqueda.evento_id = this.ingresado.evento_id;
                this.loading2 = true
                try {                   
                    let response = await axios.post('/api/secciones/buscar-generales',this.busqueda)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.invitados = response.data.invitados;
                            this.mostrar2 = true
                            this.loading2 = false
                            this.buscar = ''
                            this.buscar2 = ''
                            this.getDataPagina2(1)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener los invitados')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener los invitados')
                }
                this.loading2 = false
            },
            
            // recargar(){
            //     this.tiempo = setInterval(() => {

            //             this.SeccionesConteo()

            //     }, 1000);
            // },
            // detener(){
            //         clearInterval(this.tiempo);
            // }
        },                
    })
</script>