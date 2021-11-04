import Vue from 'vue'
import Router from 'vue-router'

import AdminHome from './components/admin/HomeComponent'
import AdminFollower from './components/admin/FollowerComponent'
import AdminOther from './components/admin/OtherComponent'
import AdminTest from './components/admin/TestComponent'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: AdminHome,
        },
        {
            path: '/home/follower/:mid',
            name: 'follower',
            component: AdminFollower,
        },
        {
            path: '/home/other',
            name: 'other',
            component: AdminOther,
        },
        {
            path: '/home/test',
            name: 'test',
            component: AdminTest,
        },
    ],
})