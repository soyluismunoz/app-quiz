<template>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Quizes</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush text-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Quiz</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Se Aprueba con:</th>
                                <th scope="col">Tiempo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(quiz, index) in quizes" :key="quiz.id">
                                <th scope="row" v-text="quiz.title"></th>
                                <td class="px-1">
                                    <span v-text="quiz.description.substring(0, 20) + '...'"></span>
                                </td>
                                <td v-text="quiz.approve_with"></td>
                                <td v-text="quiz.hour + ':' + quiz.min + ':' + quiz.seg"></td>
                                <td v-if="quiz.status == 'active'">
                                    <span class="badge badge-success">Activo</span>
                                </td>
                                <td v-else>
                                    <span class="badge badge-dark">Inactivo</span>
                                </td>
                                <td>
                                    <button  class="btn btn-sm btn-info" data-toggle="modal" 
                                    data-target="#view" @click="view(quiz)" type="button">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <a  class="btn btn-sm btn-warning text-white" @click="editQuiz(quiz.id)" >
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a  class="btn btn-sm btn-danger text-white" @click="deleteQuiz(quiz.id, index)" type="button" >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <div class="d-flex justify-content-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link"  @click="getQuizes(page - 1)" aria-label="Previous" v-if="page > 1">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item" v-for="item in lastPage" :key="item">
                                    <a class="page-link" @click="getQuizes(item)" v-text="item"></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" @click="getQuizes(page + 1)" aria-label="Next" v-if="page < lastPage">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="view" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">{{ title }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <a class="list-group-item list-group-item-action">
                                Titulo: <b> {{ title }} </b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Descripción: <b>{{ description }}</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Aprueba con de : <b>{{ approve_with }} </b> preguntas respondidas correctamente
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Mensaje si aprueba : <b>{{ if_approve }}</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Mensaje si reprueba : <b>{{ if_fail }}</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Url : <b>{{ slug }}</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Tiempo : <b>{{ time }}</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Status : <b v-if="status == 'active'">Activo</b> <b v-else>Inactivo</b>
                            </a>
                            <a class="list-group-item list-group-item-action">
                                Cantidad de preguntas : <b>{{ questions }}</b>
                            </a>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-warning text-white" @click="editQuiz(id)">Editar</a>
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
                id: '',
                title : '',
                description : '',
                approve_with: '',
                if_approve : '',
                if_fail: '',
                slug: '',
                time: '',
                status: '',
                questions: '',
                lastPage: 0,
                page: 0,
                quizes: '',
            }
        },
        methods:{
            getQuizes(index){
                this.page = index
                let url = "/all-quizes-dash?page=" + this.page
                axios.get(url).then(response => {
                    this.quizes = response.data.data
                    this.lastPage = response.data.last_page
                }).catch(e => {
                    console.log(e)
                })
            },
            view(quiz){
                this.id = quiz.id
                this.title = quiz.title
                this.description = quiz.description
                this.approve_with = quiz.approve_with
                this.if_approve = quiz.if_approve
                this.if_fail = quiz.if_fail
                this.slug = quiz.slug
                this.time = quiz.hour + ':' + quiz.min + ':' + quiz.seg
                this.status = quiz.status
                this.questions = quiz.questions.length
            },
            editQuiz(id){
                var host = window.location.protocol + "//" + window.location.hostname
                var href = "/dashboard/edit-quiz/" + id
                window.location=host+href;
                localStorage.setItem('quiz', id);
            },
            deleteQuiz(id, index){
                this.$swal({
                    title: 'Esta acción es permanente',
                    text: "Esta Seguro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    let url = '/delete-quiz/' + id
                    axios.delete(url).then(response => {
                        if (result.value) {
                            this.$swal(
                                'Eliminado!',
                                'El texto se ha eliminado exitosamente.',
                                'success'
                            )
                        }
                        this.quizes.splice(index, 1)
                    }).catch(error => {
                        console.log(error)
                    })
                })
            },
        },
        created(){
            this.getQuizes(1)
        }
    }
</script>