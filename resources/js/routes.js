import AllUrl from './components/AllUrl.vue';
import CreateUrl from './components/CreateUrl.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/admin/list',
        component: AllUrl
    },
    {
        name: 'create',
        path: '/admin/create',
        component: CreateUrl
    }
];