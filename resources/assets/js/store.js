import {getLocalUser} from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        customers: [],
        users: [],
        products:[],
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        customers(state) {
            return state.customers;
        },
        users(state) {
            return state.users;
        },
        products(state) {
            return state.products;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateCustomers(state, payload) {
            state.customers = payload.data;
        },
        updateUsers(state, payload) {
            state.users = payload;
        },
        updateProducts(state, payload) {
            state.products = payload;
        }
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        getCustomers(context, page) {
            axios.get('api/customer/all')
            .then((response)=>{
                context.commit('updateCustomers', response.data);
            })
            .catch((error)=>{

            })
        },
        getProducts(context) {
            axios.get('/api/product/all')
            .then((response)=>{
                context.commit('updateProducts', response.data.product);
            })
            .catch((error)=>{

            })
        },
        getUsers(context, page) {
            axios.get('/api/user/all?page=' + page)
            .then((response)=>{
                context.commit('updateUsers', response.data);
            })
            .catch((error)=>{

            })
        }
    }
};