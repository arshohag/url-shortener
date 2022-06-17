<template>
    <div>
        <h2 class="text-center">URLs List</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>                
                <th>URL</th>
                <th>Shortener URL</th>                
            </tr>
            </thead>
            <tbody>
            <tr v-for="url in urls" :key="url.id">
                <td>{{ url.id }}</td>                
                <td><a :href="url.old_url" target="_blank">{{ url.old_url }}</a></td>
                <td><a :href="url.new_url" target="_blank">{{ url.new_url }}</a></td>
                <td>
                    <div class="btn-group" role="group">                     
                        <button class="btn btn-danger" @click="deleteUrl(url.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                urls: []
            }
        },
        created() {
            this.axios
                .get(process.env.MIX_APP_URL+'/api/urls/')
                .then(response => {
                    this.urls = response.data;
                });
        },
        methods: {
            deleteUrl(id) { 
                this.axios
                    .delete(process.env.MIX_APP_URL+`/api/urls/${id}`)
                    .then(response => {
                        let i = this.urls.map(data => data.id).indexOf(id);
                        this.urls.splice(i, 1)
                    });
            }
        }
    }
</script>