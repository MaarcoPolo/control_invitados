export default{
    store: {
        tipoUsuarios:[],
        eventos:[],
        invitados:[]
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
        }
    }
}