<template>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="mb-0">Quizes</h3>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addQuiz">
                            Nuevo Quiz
                        </button>
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
        <!--View Quiz-->
        <div class="modal fade" id="view" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">{{ title }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="clear()">&times;</span>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="clear()">Cerrar</button>
                        <a class="btn btn-warning text-white" @click="editQuiz(id)">Editar</a>
                    </div>
                </div>
            </div>
        </div>
        <!--Add Quiz-->
        <div class="modal fade" id="addQuiz" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="clear()">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">Titulo</label>
                                    <input type="text" name="title" id="title" class="form-control" v-model="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea required class="form-control" name="description" id="description" rows="3" v-model="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Tiempo limite</label>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" class="form-control" placeholder="Horas" v-model="hour">
                                        </div>
                                        <div class="col">
                                            <input required type="number" class="form-control" placeholder="Minutos" v-model="min">
                                        </div>
                                        <div class="col">
                                            <input required type="number" class="form-control" placeholder="Segundos" v-model="seg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="IfApprove">Si aprueba</label>
                                    <input required type="text" name="IfApprove" id="IfApprove" class="form-control" v-model="if_approve">
                                </div>
                                <div class="form-group">
                                    <label for="IfFail">Si Reprueba</label>
                                    <input required type="text" name="IfFail" id="IfFail" class="form-control" v-model="if_fail"> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="approve_with">Minimo para aprobar</label>
                                            <a type="button" class="btn-sm" title="Minima cantidad de preguntas correctas para aprobar">
                                                <i class="fas fa-question-circle "></i>
                                            </a>
                                            <input required type="number" id="approve_with" class="form-control" v-model="approve_with"> 
                                        </div>
                                        <div class="col">
                                            <label for="status">Status</label>
                                            <select class="custom-select" id="status" v-model="status">
                                                <option value="inactive" selected>Inactive</option>
                                                <option value="active">Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer border-rounded">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="clear()">Cerrar</button>
                        <button @click="addQuiz()" class="btn btn-success" >
                            {{ isCreating? 'Guardando': 'Guardar' }}
                        </button>
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
                hour: '',
                min: '',
                seg: '',
                slug: '',
                time: '',
                status: 'inactive',
                isCreating: false,
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
            clear(){
                this.id = ''
                this.title = ''
                this.description = ''
                this.approve_with = ''
                this.if_approve = ''
                this.if_fail = ''
                this.slug = ''
                this.time = ''
                this.hour = ''
                this.min = ''
                this.seg = ''
                this.status = 'inactive'
                this.questions = ''.length
            },
            editQuiz(id){
                var host = window.location.protocol + "//" + window.location.hostname
                var href = "/dashboard/edit-quiz/" + id
                window.location=host+href;
                localStorage.setItem('quiz', id);
            },
            deleteQuiz(id, index){
                this.$swal({
                    title: 'Se Borraran todas la preguntas y respuestas vinculadas',
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

            //add quiz
            addQuiz(){
                this.isCreating = true;
                let formData = new FormData()

                formData.append('title', this.title)
                formData.append('description', this.description)
                formData.append('approve_with', this.approve_with)
                formData.append('if_approve', this.if_approve)
                formData.append('if_fail', this.if_fail)
                formData.append('hour', this.hour)
                formData.append('min', this.min)
                formData.append('seg', this.seg)
                formData.append('status', this.status)
                
                let url = '/add-quiz'
                axios.post(url, formData,).then(response => {
                    this.$swal({
                        icon: 'success',
                        title: 'creacion Exitosa',
                    });
                    var quiz = response.data
                    this.quizes.push(quiz)
                    this.isCreating = false;
                    this.clear()
                }).catch(error => {
                    this.$swal({
                        icon: 'error',
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ha ocurrido un error durante el guardado'
                    })
                    this.isCreating = false;
                    console.log(error.response.data.message)
                });
            },
        },
        created(){
            this.getQuizes(1)
        }
    }
</script>