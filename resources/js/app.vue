<template>
    <div class="container"> 
        <nav class="navbar navbar-expand-lg navbar-light bg-light">            
            <div class="navbar-nav">
                <router-link to="/admin/list" class="nav-item nav-link">URLs List</router-link>
                <router-link to="/admin/create" class="nav-item nav-link">Create URL</router-link>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>
 
<script>
    export default {}
</script>