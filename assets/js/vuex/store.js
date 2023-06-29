import {createStore} from 'vuex'
import axios from 'axios';
import router from './../routes';

export default createStore({
    state: {
        teamsTableData: {}
    },
    actions: {
        GET_TEAMS_FROM_API({commit}, pageData = {page:1, per_page: 10}) {
            return axios('/api/teams?page='+pageData.page+'&per_page='+pageData.per_page).then((response) => {
                commit('SET_TEAMS_TABLE_DATA', response.data)
            })
        },
        ADD_TEAM({commit}, teamData) {
            return axios.post('/api/teams', teamData)
                        .then((response) => {
                            router.push('/')
                        })
                        .catch(function (error) {
                            alert(JSON.stringify(error.response.data.errors))
                        });
        },
        ADD_PLAYER({commit}, playerData) {
            return axios.post('/api/teams/' + playerData.teamId + '/players', {firstName: playerData.firstName, lastName: playerData.lastName})
                        .then((response) => {
                            router.push('/')
                        })
                        .catch(function (error) {
                            alert(JSON.stringify(error.response.data.errors))
                        });
        },
        TRANSFER({commit}, transferData) {
            return axios.put('/api/transfer', transferData)
                .then((response) => {
                    router.push('/')
                })
                .catch(function (error) {
                    alert(JSON.stringify(error.response.data.errors))
                });
        },
    },
    mutations: {
        SET_TEAMS_TABLE_DATA: (state, teamsTableData) => {
            state.teamsTableData = teamsTableData
        }
    },
    getters: {
        TEAMS(state) {
            return state.teamsTableData
        }
    }
})