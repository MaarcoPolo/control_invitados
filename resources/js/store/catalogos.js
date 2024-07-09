export default{
    store: {
        tipoUsuarios:[]
    },
    getters:{
        getTipoUsuarios(state) {
            return state.tipoUsuarios
        },
    },
    mutations:{
        setTipoUsuarios(state, payload) {
            state.tipoUsuarios = payload
        }
    }
}