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
                            <img :style="filters" class="img img-thumbnail rounded" id="main-img" :src="baseUrl+'/Gallery/'+image">
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded" @click="original()" :src="baseUrl+'/Gallery/'+image">
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded grayscale" @click="grayscale()" :src="baseUrl+'/Gallery/'+image">
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded sepia" @click="sepia()" :src="baseUrl+'/Gallery/'+image">
                    </div>
                    <div class="col-md-3">
                        <img class="img img-thumbnail rounded invert" @click="invert()" :src="baseUrl+'/Gallery/'+image">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                       
                    </div>
                    <div class="col-md-8 bg-white p-2">
                        <router-link :to="{ name:'Home'}"><a class="btn btn-outline-secondary" href="/Home">Back</a></router-link>
                        <a class="btn btn-primary" href="">Save</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>
<style>
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
                filters:{"filter":""}
            }
        },
        methods: {
            original: function () {
               this.filters = {
                   
               };
            },
            grayscale:function(){
                this.filters = {
                    "filter":"gray",
                    "-webkit-filter":"grayscale(1)",
                    
                }
                return this.filters;
            },
            sepia:function(){
                this.filters = {
                   "filter": "sepia(100%)"
                }
                return this.filters;
            },
            invert:function(){
                this.filters = {
                   "filter": "invert(100%)"
                }
            }
            
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

