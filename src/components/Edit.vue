<template>
    <div class="hello">
        <div class="container text-center">
            <h1>Edit Image</h1>
        </div>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img img-thumbnail rounded" :src="baseUrl+'/Gallery/'+image">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Edit',
        data() {
            return {
                image : '',
                baseUrl : 'http://localhost/joomshaper'
            }
        },
        methods: {
            
        },
        mounted(){
          let imageId = this.$route.params.id
            axios.get(this.baseUrl+ '/api/Editor.php?id='+imageId).then(response => {
                   this.image = response.data.file
                }).catch(response => {
                    console.log()
                });
        },
    }
</script>

