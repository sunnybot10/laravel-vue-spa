import Home from './components/Home.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import CustomerMain from './components/customers/Main.vue';
import CustomersList from './components/customers/List.vue';
import NewCustomer from './components/customers/New.vue';
import Customer from './components/customers/View.vue';


export const routes = [
	{
		path: '/',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/home',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/login',
        component: Login
	},
	{
		path: '/register',
        component: Register
	},
	{
		path: '/customer',
		component: CustomerMain,
		meta: {
			requiresAuth: true
		},
		children: [
			 {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: NewCustomer
            },
            {
                path: ':id',
                component: Customer
            }
		]
	}
]