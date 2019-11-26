<template>
    <div id="main">
        <Header/>
        <div class="container mt-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Header from './Header.vue';
    export default {
        name: 'main-app',
        components: {Header}
    }
</script>