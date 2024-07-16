export default{
    store: {
        tipoUsuarios:[],
        eventos:[],
        invitados:[],
        secciones:[]
    },
    getters:{
        getTipoUsuarios(state){
            return state.tipoUsuarios
        },
        getEventos(state) {
            return state.eventos
        },
        getInvitados(state){
            return state.invitados
        },
        getSecciones(state){
            return state.secciones
        }
    },
    mutations:{
        setTipoUsuarios(state, payload){
            state.tipoUsuarios = payload
        },
        setEventos(state, payload) {
            state.eventos = payload
        },
        setInvitados(state,payload){
            state.invitados = payload
        },
        setSecciones(state,payload){
            state.secciones = payload
        }
    }
}