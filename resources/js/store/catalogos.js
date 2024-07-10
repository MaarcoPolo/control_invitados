export default{
    store: {
        tipoUsuarios:[],
        invitados:[]
    },
    getters:{
        getTipoUsuarios(state){
            return state.tipoUsuarios
        },
        getInvitados(state){
            return state.invitados
        }
    },
    mutations:{
        setTipoUsuarios(state, payload){
            state.tipoUsuarios = payload
        },
        setInvitados(state,payload){
            state.invitados = payload
        }
    }
}