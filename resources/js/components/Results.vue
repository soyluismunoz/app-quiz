<template>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Resultados</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">Resultado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="result in results" :key="result.id">
                                <th scope="row" v-text="result.user.name"></th>
                                <td v-text="result.quiz.title"></td>
                                <td v-if="result.correct_answers >= result.quiz.approve_with">
                                    <span class="badge badge-success">Aprobado</span>
                                </td>
                                <td v-else>
                                    <span class="badge badge-dark">Reprobado</span>
                                </td>
                                <td>
                                    <button  class="btn btn-sm btn-info" data-toggle="modal" 
                                    data-target="#view" @click="view(result)" type="button">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Resultado de {{ name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group list-group-flush">
                                    <a class="list-group-item list-group-item-action">
                                        Nombre: <b> {{ name }} </b>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                        Certificacion: <b>{{ quiz }}</b>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                        Preguntas Respondidas correctamente : <b>{{ correctAnswer }}</b>
                                    </a>
                                    <a class="list-group-item list-group-item-action">
                                        Cantidad de preguntas : <b>{{ questionCount }}</b>
                                    </a>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <div class="d-flex justify-content-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link"  @click="getResults(page - 1)" aria-label="Previous" v-if="page > 1">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item" v-for="item in lastPage" :key="item">
                                    <a class="page-link" @click="getResults(item)" v-text="item"></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" @click="getResults(page + 1)" aria-label="Next" v-if="page < lastPage">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                name: '',
                quiz: '',
                correctAnswer: '',
                questionCount: '',
                lastPage: 0,
                page: 0,
                results: '',
            }
        },
        methods:{
            getResults(index){
                this.page = index
                let url = "/all-results-dash?page=" + this.page
                axios.get(url).then(response => {
                    this.results = response.data.data
                    this.lastPage = response.data.last_page
                    console.log(url)
                }).catch(e => {
                    console.log(e)
                })
            },
            view(result){
                this.name = result.user.name
                this.quiz = result.quiz.title
                this.correctAnswer = result.correct_answers
                this.questionCount = result.questions_count
            }
        },
        created(){
            this.getResults(1)
        }
    }
</script>