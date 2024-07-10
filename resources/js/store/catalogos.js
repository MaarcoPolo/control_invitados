export default{
    store: {
        tipoUsuarios:[],
        eventos:[]
    },
    getters:{
        getTipoUsuarios(state) {
            return state.tipoUsuarios
        },
        getEventos(state) {
            return state.eventos
        },
    },
    mutations:{
        setTipoUsuarios(state, payload) {
            state.tipoUsuarios = payload
        },
        setEventos(state, payload) {
            state.eventos = payload
        }
    }
}