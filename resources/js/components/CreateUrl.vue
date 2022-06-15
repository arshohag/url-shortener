<template>
    <div>
        <h3 class="text-center">Create URL</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addUrl">
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" class="form-control" v-model="url.url">
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
                url: {}
            }
        },
        methods: {
            addUrl() {
                this.axios
                    .post('https://url-shortener.test/api/urls', this.url)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>