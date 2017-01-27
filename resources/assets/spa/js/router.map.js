import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';
import ContaBancariaList from './components/conta-bancaria/ContaBancariaList.vue';

export default {
    '/login': {
        name: 'auth.login',
        component: LoginComponent,
        auth: false
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent,
        auth: true
    },
    '/contas-bancarias': {
        component: {template: "<router-view></router-view"},
        subRoutes: {
            '/': {
                name: 'conta-bancaria.list',
                component: ContaBancariaList
            },
            '/:id/update': {
                name: 'conta-bancaria.update',
                component: ContaBancariaList
            }
        }
    }
}