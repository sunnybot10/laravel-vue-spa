<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel ">

        <div class="container">
            <router-link class="navbar-brand" to="/">My Vue App</router-link>

            <button class="navbar-toggler" 
            type="button" 
            data-toggle="collapse" 
            data-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ml-auto">
            <template v-if="!currentUser">
                <li class="nav-item">
                    <router-link class="nav-link" to="/register">Register</router-link>
                </li>
            </template>
            <template v-else>
                <li>
                    <router-link class="nav-link" to="/profile">
                    <i class="fa fa-user" aria-hidden="true"></i> Profile
                    </router-link>
                </li>
                <li>
                    <router-link class="nav-link" to="/product">
                    <i class="fas fa-barcode"></i> Product
                    </router-link>
                </li>
                <li>
                    <router-link class="nav-link" to="/user">
                    <i class="fas fa-users"></i> Users
                    </router-link>
                </li>
                <li>
                    <router-link class="nav-link" to="/customer">
                    <i class="fas fa-users"></i> Customers
                    </router-link>
                </li>
                <li class="nav-item dropdown">
                    <a  id="navbarDropdown" 
                    class="nav-link dropdown-toggle" 
                    href="#" 
                    role="button" 
                    data-toggle="dropdown" 
                    aria-expanded="false" 
                    aria-haspopup="true">
                    {{ currentUser.name }} 
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a>
                </div>
            </li>
        </template>
    </ul>
</div>
</div>
</nav>
</template>

<script>
    export default {
        name: 'app-header',
        methods: {
            logout(){
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser;
            }
        }
    }
</script>
