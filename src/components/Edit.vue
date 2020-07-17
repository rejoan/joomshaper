<template>
    <div class="hello">
        <div class="container text-center">
            <router-link :to="{ name:'Home'}"><a class="btn btn-dark" href="/Home">Home</a></router-link>
            <h1 class="header">Edit Image</h1>
        </div>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6 mx-auto">
                        <div class="text-center">
                            <img class="img img-thumbnail rounded" :class="filter" :src="baseUrl+'/Gallery/'+image">
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded" @click="original()" :class="selectImg('')" :src="baseUrl+'/Gallery/'+image">
                        <small class="form-text text-muted">Original</small>
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded grayscale" @click="grayscale()" :class="selectImg('grayscale')" :src="baseUrl+'/Gallery/'+image">
                        <small class="form-text text-muted">Grayscale</small>
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded sepia" @click="sepia()" :class="selectImg('sepia')" :src="baseUrl+'/Gallery/'+image">
                        <small class="form-text text-muted">Sepia</small>
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded invert" @click="invert()" :class="selectImg('invert')" :src="baseUrl+'/Gallery/'+image">
                        <small class="form-text text-muted">Invert</small>
                    </div>
                </div>
                <div class="row mt-3 bg-white p-2">
                    <div class="col-md-12">
                        <div class="row text-right">
                            <div class="col-md-1">
                                <router-link :to="{ name:'Home'}"><a class="btn btn-outline-secondary" href="/Home">Back</a></router-link>
                            </div>
                            <div class="col-md-1">
                                <form role="form" method="POST">
                                    <input type="hidden"  id="imgStyles" ref="imgStyles" :value="filter"/>
                                    <button class="btn btn-primary" @click.prevent="saveStyles()">Save</button>
                                </form> 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>
<style>
    .original{
        filter: '';
    }
    .grayscale{
        filter: gray;
        -webkit-filter: grayscale(1);
        filter: grayscale(1);
    }
    .sepia{
        filter: sepia(100%);
    }
    .invert{
        filter: invert(100%);
    }
</style>
<script>
    export default {
        name: 'Edit',
        data() {
            return {
                image : '',
                baseUrl : 'http://localhost/joomshaper',
                filter : 'original',
                imageId : this.$route.params.id,
                formData: {
                    imgID: '',
                    style: ''
                }
            }
        },
        methods: {
            selectImg:function(name){
              return (this.filter == name) ? "border border-primary":""
            },
            original: function () {
               this.filter = ""
            },
            grayscale:function(){
                this.filter = "grayscale"
            },
            sepia:function(){
                this.filter = "sepia"
            },
            invert:function(){
                this.filter = "invert"
            },
            
            saveStyles:function(){
                let formData = new FormData()
                formData.append('style', this.filter)
                formData.append('imgID', this.imageId)
                axios({
                    method: 'post',
                    url: this.baseUrl+ '/api/Saver.php',
                    data: formData
                }).then(response => {
                    console.log(response)
                    this.filter =  response.data.style
                    this.$router.go()
                }).catch(response => {
                    console.log(response)
                });
            }
            
        },
        mounted(){
            axios.get(this.baseUrl+ '/api/Editor.php?id='+this.imageId).then(response => {
                this.image = response.data.file
                this.filter = response.data.filter
            }).catch(response => {
                console.log(response)
            });
        },
    }
</script>

