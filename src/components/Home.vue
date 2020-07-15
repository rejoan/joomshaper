<template>
    <div class="hello">
        <div class="container text-center">
            <h1>Media Library</h1>
        </div>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4" v-for="item in 6" :key="item.message">
                        <div class="card mb-4 p-3">
                            <svg class="img-fluid rounded" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                            <p class="card-text">img.png</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <form id="uploadForm" role="form" enctype="multipart/form-data" >
                            <input type="file" id="miofile" name="miofile" multiple @change="fieldChange">
                            <input type="button" value="Upload" @click="uploadFile" >
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
                attachments : []
            }
        },
        methods: {
            fieldChange(e) {
                this.attachments = [];
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i = 0; i < selectedFiles.length; i++) {
                    this.attachments.push(selectedFiles[i]);
                }

                console.log(this.attachments);
            },
            uploadFile() {
                for (let i = 0; i < this.attachments.length; i++) {
                    this.form.append('userfile[]', this.attachments[i]);
                }
                const config = {headers: {'Content-Type': 'application/form-dataa'}};
                axios.post('http://localhost/joomshaper/api/Uploader.php', this.form, config).then(response => {
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
            axios.get('http://localhost/joomshaper/api/Imager.php').then(response => {
                    console.log(response)
                }).catch(response => {
                    console.log(response)
                });
        },
    }
</script>

