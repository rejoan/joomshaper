<template>
    <div class="hello">
        <div class="container text-center">
            <h1>Media Library</h1>
        </div>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4" v-for="item in items">
                        <div class="card mb-4 p-3">
                            <router-link v-bind:to="/edit/+item[0]"><img class="img img-thumbnail rounded" :src="baseUrl+'/Gallery/'+item[1]"></router-link>
                            <p class="card-text">img.png</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p>Upload Images</p>
                    </div>
                    <div class="col-md-8 bg-white p-2">
                        <form id="uploadForm" role="form" enctype="multipart/form-data" >
                            <input type="file" id="miofile" name="miofile" multiple @change="fieldChange">
                            <input class="btn btn-primary" type="button" value="Upload" @click="uploadFile" >
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        data() {
            return {
                form : new FormData(),
                attachments : [],
                items : [],
                baseUrl : 'http://localhost/joomshaper'
            }
        },
        methods: {
            showEdit(){
                this.$router.push({name: 'edit', params: {id:50 }});
            },
            fieldChange(e) {
                this.attachments = [];
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i = 0; i < selectedFiles.length; i++) {
                    this.attachments.push(selectedFiles[i]);
                }

                //console.log(this.attachments);
            },
            uploadFile() {
                for (let i = 0; i < this.attachments.length; i++) {
                    this.form.append('userfile[]', this.attachments[i]);
                }
                const config = {headers: {'Content-Type': 'application/form-dataa'}};
                axios.post(this.baseUrl+'/api/Uploader.php', this.form, config).then(response => {
                    //success
                    this.resetData()
                    this.$router.go()
                }).catch(response => {
                    console.log(response)
                });
            },
            resetData() {
                this.form = new FormData()
                this.attachments = []
            },
        },
        mounted(){
            axios.get(this.baseUrl+ '/api/Imager.php').then(response => {
                   this.items = response.data.files
                   //console.log(response.data.files)
                   
                }).catch(response => {
                    console.log()
                });
        },
    }
</script>

