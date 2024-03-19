<template>
    <div>
        <h3 class="text-center">Create URL</h3>
        <div class="row">
            <div class="col-md-6">                                
                <form @submit.prevent="addUrl">
                    <div class="form-group">
                        <label>URL</label>                        
                        <input type="text" class="form-control" v-model="url.url">
                        <div v-for="(errorArray, idx) in errors" :key="idx">
                            <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                <span class="text-danger">{{ allErrors}} </span>
                            </div>
                        </div>
                    </div>
                    <br>                 
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                url: {},
                errors: []
            }
        },
        methods: {
            addUrl() {
                this.axios
                    .post(process.env.MIX_APP_URL+'/api/urls', this.url)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => {
                        this.errors = err.response.data.errors
                        console.log(err)
                    })
                    .finally(() => this.loading = false)
            }
        }
    }
</script>