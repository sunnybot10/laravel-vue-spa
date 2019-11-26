import Home from './components/Home.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';

import CustomerMain from './components/customers/Main.vue';
import CustomersList from './components/customers/List.vue';
import CustomerView from './components/customers/View.vue';

import Profile from './components/Profile.vue';

import UserMain from './components/users/Main.vue';
import UserList from './components/users/List.vue';

import ProductMain from './components/products/Main.vue';
import ProductsList from './components/products/List.vue';
import ProductView from './components/products/View.vue';

export const routes = [
	{
		path: '/',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/profile',
		component: Profile,
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
		path: '/user',
		component: UserMain,
		meta: {
			requiresAuth: true
		},
		children: [
			 {
                path: '/',
                component: UserList
            },
		]
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
                path: ':id',
                component: CustomerView
            }
		]
	},
	{
		path: '/product',
		component: ProductMain,
		meta: {
			requiresAuth: true
		},
		children: [
			{
                path: '/',
                component: ProductsList
            },
            {
                path: ':id',
                component: ProductView
            }
		]
	}
]