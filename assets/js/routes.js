import {createRouter, createWebHashHistory} from 'vue-router'
import Teams from './pages/Teams.vue'
import Transfer from './pages/Transfer.vue'
import AddTeam from './pages/AddTeam.vue'
import AddPlayer from './pages/AddPlayer.vue'


export default createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/', component: Teams },
        { path: '/transfer', component: Transfer },
        { path: '/add-team', component: AddTeam },
        { path: '/add-player', component: AddPlayer },
    ],
})