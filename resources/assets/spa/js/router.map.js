import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';

import ContaBancariaListComponent from './components/conta-bancaria/ContaBancariaList.vue';
import ContaBancariaCreateComponent from './components/conta-bancaria/ContaBancariaCreate.vue';
import ContaBancariaUpdateComponent from './components/conta-bancaria/ContaBancariaUpdate.vue';

import CategoriaListComponent from './components/categoria/CategoriaList.vue';

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
                component: ContaBancariaListComponent,
                auth: true
            },
            '/create': {
                name: 'conta-bancaria.create',
                component: ContaBancariaCreateComponent,
                auth: true,
            },
            '/:id/update': {
                name: 'conta-bancaria.update',
                component: ContaBancariaUpdateComponent,
                auth: true
            }
        }
    },
    '/categorias': {
        name: 'categoria.list',
        component: CategoriaListComponent,
        auth: true
    }
}