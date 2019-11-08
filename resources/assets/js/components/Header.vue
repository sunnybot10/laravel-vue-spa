<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">

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
                    <li class="nav-item">
                        <a class="nav-link active" href="/login">Login</a>
                    </li>
                </ul>
            </div>
            
        </div>

    </nav>
</template>

<script>
    export default {
        name: 'app-header'
    }
</script>
