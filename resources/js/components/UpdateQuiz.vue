<template>
    <div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0">Actualizar certificación</h3>
                            <slot></slot>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updateQuiz()">
                            <div class="form-group">
                                <label for="title">Titulo</label>
                                <input type="text" name="title" id="title" class="form-control" v-model="quiz.title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea required class="form-control" name="description" id="description" rows="3" v-model="quiz.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="IfApprove">Si aprueba</label>
                                <input required type="text" name="IfApprove" id="IfApprove" class="form-control" v-model="quiz.if_approve">
                            </div>
                            <div class="form-group">
                                <label for="IfFail">Si Reprueba</label>
                                <input required type="text" name="IfFail" id="IfFail" class="form-control" v-model="quiz.if_fail"> 
                            </div>
                            <div class="form-group">
                                <label for="approve_with">Minima cantidad de preguntas correctas para aprobar</label>
                                <input required type="number" name="approve_with" id="approve_with" class="form-control" v-model="quiz.approve_with"> 
                            </div>
                            <div class="form-group">
                                <label>Tiempo limite</label>
                                <div class="row">
                                    <div class="col">
                                        <input required type="number" class="form-control" placeholder="Horas" v-model="quiz.hour">
                                    </div>
                                    <div class="col">
                                        <input required type="number" class="form-control" placeholder="Minutos" v-model="quiz.min">
                                    </div>
                                    <div class="col">
                                        <input required type="number" class="form-control" placeholder="Segundos" v-model="quiz.seg">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="custom-select" name="status" id="status" v-model="quiz.status">
                                    <option value="inactive">Inactive</option>
                                    <option value="active">Active</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                {{ isCreating? 'Actualizando': 'Actualizar' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0">Preguntas</h3>
                            <button type="button" class="btn btn-sm btn-primary" disabled v-if="!quiz"> Agregar Nueva </button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addQuestion" v-else>
                                 Agregar Nueva
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" v-if="quiz.questions">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Titulo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ques,index) in quiz.questions" :key="ques.id">
                                        <th scope="row" v-text="ques.title"></th>
                                        <td class="text-right">
                                            <button  class="btn btn-sm btn-info" @click="questionIndex = index"
                                            data-toggle="modal" data-target="#viewQues" type="button">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <a type="button" class="btn btn-sm btn-warning text-white" @click="questionIndex = index"
                                            data-toggle="modal" data-target="#updateQues">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a  class="btn btn-sm btn-danger text-white" type="button" @click="delQuestion(ques.id, index)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="align-self-center text-center py-5" v-else>
                            <h2 class="card-title text-center">
                                No hay preguntas para es quiz
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!--View Question-->
            <div class="modal fade" id="viewQues" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border">
                            <h5 class="modal-title" id="staticBackdropLabel">{{quiz.questions[questionIndex].title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3> Titulo: <b> {{ quiz.questions[questionIndex].title }} </b> </h3>
                            <p class="mt-3 mb-1">Respuestas:</p>
                            <ul class="list-group list-group-flush">
                                <a class="list-group-item list-group-item-action" 
                                    v-for="item in quiz.questions[questionIndex].answers" 
                                    :key="item.id" :class="item.correct == 0 ? 'text-success': ''">
                                    {{ item.answer }} 
                                </a>
                            </ul>
                        </div>
                        <div class="modal-footer border-rounded">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Add Question-->
            <div class="modal fade" id="addQuestion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar nueva pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-form-label" >Titulo</label>
                                <input type="text" class="form-control" v-model="newQuestion">
                                <small v-if="warning" class="form-text text-danger">
                                   La pregunta no puede estar vacia
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" @click="addQuestion()" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Update question-->
            <div class="modal fade" id="updateQues" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Actualizar pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-form-label" >Titulo</label>
                                <input type="text" class="form-control" v-model="quiz.questions[questionIndex].title">
                                <small v-if="warning" class="form-text text-danger">
                                   La pregunta no puede estar vacia
                                </small>
                            </div>
                            <ul class="list-group list-group-flush mb-5">
                                <a class="list-group-item list-group-item-action input-group" 
                                    v-for="(item, index) in quiz.questions[questionIndex].answers" 
                                    :key="item.id">
                                    <div class="d-flex justify-content-between">
                                        <span :class="item.correct == 1 ? 'text-success': ''">
                                            {{ item.answer }}
                                        </span>
                                        <a href="#" class="btn btn-sm btn-danger" @click="delAns(item.id, index)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </a>
                            </ul>
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="newAnswer.answer">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <input type="checkbox" v-model="newAnswer.correct">
                                    </span>
                                    <a href="#" class="input-group-text bg-success text-white" @click="addAnswer()">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" @click="updateQuestion(questionIndex)" class="btn btn-primary">Guardar</button>
                        </div>
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
                isCreating: false,
                warning: false,
                questionIndex: 0,
                newQuestion: '',
                newAnswer: {
                    answer: '',
                    correct: false
                },
                quiz: {
                    questions: [
                        {
                            answers: [
                                {
                                    answer: " "
                                },
                            ]
                        },
                    ]
                }
            }
        },
        methods:{
            //questions
            addQuestion(){
                let question = this.newQuestion
                if(question.trim() != ""){
                    this.isCreating = true;
                    let formData = new FormData()

                    formData.append('quiz_id', this.quiz.id)
                    formData.append('title', this.newQuestion)
                    
                    let url = '/add-question'
                    axios.post(url, formData,).then(response => {
                        this.isCreating = false;
                        this.$swal({
                            icon: 'success',
                            title: 'creacion Exitosa',
                        });
                        let newQues = response.data
                        this.quiz.questions.push(newQues)
                        this.newQuestion =  ''
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
                }else{
                    this.warning = true
                }
            },
            updateQuestion(index){
                this.isCreating = true;
                let formData = new FormData()
                
                formData.append('id', this.quiz.questions[index].id)
                formData.append('title', this.quiz.questions[index].title)
                
                let url = "/update-question"
                axios.post(url, formData,).then(response => {
                    this.isCreating = false;
                    this.$swal({
                        icon: 'success',
                        title: 'creacion Exitosa',
                    });
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
            delQuestion(id, index){
                this.$swal({
                    title: 'Se Borraran todas las respuestas vinculadas',
                    text: "Esta Seguro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    let url = '/delete-question/' + id
                    axios.delete(url).then(response => {
                        if (result.value) {
                            this.$swal(
                                'Eliminado!',
                                'El texto se ha eliminado exitosamente.',
                                'success'
                            )
                        }
                        this.quiz.questions.splice(index, 1)
                    }).catch(error => {
                        console.log(error)
                    })
                })
            },

            //answer
            addAnswer(){
                this.isCreating = true;
                var isCorrect;
                if(this.newAnswer.correct){
                    isCorrect = 1
                }else{
                    isCorrect = 0
                }
                console.log(isCorrect)
                let formData = new FormData()

                formData.append('question_id', this.quiz.questions[this.questionIndex].id)
                formData.append('answer', this.newAnswer.answer)
                formData.append('correct', isCorrect)
                
                let url = '/add-answer'
                axios.post(url, formData,).then(response => {
                    this.isCreating = false;
                    this.$swal({
                        icon: 'success',
                        title: 'creacion Exitosa',
                    });
                    let newAnswer = response.data
                    this.quiz.questions[this.questionIndex].answers.push(newAnswer)
                    this.newAnswer.answer = ''
                    this.newAnswer.correct = false
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
            
            delAns(id, index){
                this.$swal({
                    title: 'Esta accion es permanente',
                    text: "Esta Seguro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    let url = '/delete-answer/' + id
                    axios.delete(url).then(response => {
                        if (result.value) {
                            this.$swal(
                                'Eliminado!',
                                'El texto se ha eliminado exitosamente.',
                                'success'
                            )
                        }
                        this.quiz.questions[this.questionIndex].answers.splice(index, 1)
                    }).catch(error => {
                        console.log(error)
                    })
                })
            },

            //quiZ
            updateQuiz(){
                this.isCreating = true;
                let formData = new FormData()
                
                formData.append('id', this.quiz.id)
                formData.append('title', this.quiz.title)
                formData.append('description', this.quiz.description)
                formData.append('approve_with', this.quiz.approve_with)
                formData.append('if_approve', this.quiz.if_approve)
                formData.append('if_fail', this.quiz.if_fail)
                formData.append('hour', this.quiz.hour)
                formData.append('min', this.quiz.min)
                formData.append('seg', this.quiz.seg)
                formData.append('status', this.quiz.status)
                
                let url = '/update-quiz'
                axios.post(url, formData,).then(response => {
                    this.isCreating = false;
                    this.$swal({
                        icon: 'success',
                        title: 'creacion Exitosa',
                    });
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
            getQuiz(id){
                var url = '/edit-quiz/' + id
                axios.get(url).then(response => {
                    this.quiz = response.data
                }).catch(e => {
                    console.log(e.response.data.message)
                })
            }
        },
        created(){
            var quiz = localStorage.getItem('quiz')
            if (quiz) {
                try {
                    var id = JSON.parse(localStorage.getItem('quiz'))
                }catch(e){
                    localStorage.removeItem('QuizSlug')
                }
            }else{
                var host = window.location.protocol + "//" + window.location.hostname
                window.location= host + "/dashboard/all-quizes";
            }
            this.getQuiz(id)

            /*if(this.quiz){
               localStorage.removeItem('quiz')
            }*/
        }
    }
</script>