<template>
    <section class="quizes">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h1">Certificaciones</h2>
                    <p class="text-lead">
                        Elige cual de certificaciones quieres tomar
                    </p>
                    <hr>
                </div>
                <div class="col-lg-4 mb-4" v-for="q in quizes" :key="q.id">
                    <a class="card" :href="'quiz/' + q.slug" v-on:click="saveSlug(q.slug)">
                        <div class="card-header p-2">
                            <h4 class="h4 col-12 text-truncate" v-text="q.title"></h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text" v-text="q.description">
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                quizes: [],

            }
        },
        mounted() {
            this.getQuizes()
        },
        methods: {
            getQuizes() {
                let url = '/all-quizes-act'
                axios.get(url).then(response => {
                    this.quizes = response.data
                }).catch(e => {
                    console.log (e)
                })
            },
            saveSlug(href){
                let slug = JSON.stringify(href);
                localStorage.setItem('QuizSlug', slug);
            }
        }
    }
</script>
