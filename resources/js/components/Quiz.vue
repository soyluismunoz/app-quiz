<template>
    <section class="section quiz">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 my-5">
                    <!--Quiz-->
                    <div class="card shadow-lg rounded" v-if="!end">
                        <div class="card-header text-center py-5">
                            <h2 class="font-weight-bold" v-text="quiz.title"></h2>
                            <!--progress-->
                            <div class="mx-auto px-5 py-2">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" :style="'width:' + Math.trunc((questionIndex/quiz.questions.length)*100) + '%;'" 
                                    aria-valuemin="0" aria-valuemax="100">
                                        {{  Math.trunc((questionIndex/quiz.questions.length)*100) + '% Completado'  }}
                                    </div>
                                </div>
                            </div>
                            <!--/progress-->
                        </div>
                        <div class="card-body text-center" v-if="quiz.questions.length > 0 ">
                            <div class="d-flex justify-content-end">
                                <small> 
                                    Tiempo para responder esta pregunta 
                                    <b>
                                       {{ quiz.questions[questionIndex].min}} :
                                       {{ quiz.questions[questionIndex].seg }}
                                    </b> 
                                </small>
                            </div>
                            <h2 class="card-title" v-text="quiz.questions[questionIndex].title"></h2>
                            <div class="row justify-content-center options">
                                <div  class="col-lg-10 option" :key="index" @click="selectAnswer(index)"
                                v-for="(a, index) in quiz.questions[questionIndex].answers"
                                :class="{ 'is-selected': userResponses[questionIndex] == index}"
                                >
                                   {{ a.answer }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary rounded-pill" @click="prev()" :disabled="questionIndex < 1">
                                    Anterior
                                </button>

                                <ul class="pagination m-0">
                                    <li class="page-item" aria-current="page" :id="'act-' + index" 
                                    :class="(index == questionIndex)?'active': ''"
                                    v-for="(r, index) in quiz.questions.length " :key="r.index">
                                        <a class="page-link" @click="goQuestion(index)">
                                            {{ index + 1 }}
                                        </a>
                                    </li>
                                </ul>

                                <button class="btn rounded-pill" @click="next()"
                                :class="(userResponses[questionIndex]==null)?'btn-secondary':'btn-success'" 
                                :disabled="questionIndex>=quiz.questions.length"
                                >
                                    {{ (userResponses[questionIndex]==null)?'Omitir':'Siguiente' }}
                                </button>

                            </div>
                        </div>
                    </div>

                    <!--Result-->
                    <div class="card shadow-lg rounded py-5" v-else>
                        <div class="align-self-center text-center">
                            <i class="fas" :class="score()>3?'fa-check-circle-o is-active':'fa-times-circle'"></i>
                            <hr>
                            <h3>
                                You did {{ score()> 7?'Asombroso': 'Mejor suerte luego' }} {{ score() > 4?'a good':'a poor'}} job!
                            </h3>
                            <p>
                               Puntuacion total : {{ score() }} / {{ quiz.questions.length }}
                            </p>
                            <button class="btn btn-primary" @click="restart()">
                                Reiniciar <i class="fas fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-5">
            <pre>
                {{ $data }}
            </pre>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return {
            questionIndex: 0,
            userResponses: '',
            end: false,
            user: '',
            quizLength : 10,
            quiz: ''
        }
    },
    mounted() {

        var slug = localStorage.getItem('QuizSlug')
        if (slug) {
            try {
                var url = JSON.parse(localStorage.getItem('QuizSlug'))
            }catch(e){
                localStorage.removeItem('QuizSlug')
            }
        }else{
            var host = window.location.protocol + "//" + window.location.hostname
            window.location= host + "/home";
        }
        this.getQuiz(url)
        
        this.userResponses = Array(this.quizLength.length).fill(null);
    },
    methods:{
        // pagination
        next() {
            if (this.questionIndex < this.quiz.questions.length){
                 this.questionIndex++;
            }else{
                this.score()
            }
        },
        prev() {
            if (this.quiz.questions.length > 0) this.questionIndex--;
        },
        goQuestion(index){
            this.questionIndex = index
        },

        restart(){
            this.questionIndex=0;
            this.userResponses=Array(this.quiz.questions.length).fill(null);
            this.end = false
        },

        // select answer
        selectAnswer(index) {
            Vue.set(this.userResponses, this.questionIndex, index);
            console.log(this.userResponses);
        },

        // End and final score
        score() {
            this.end = true
            var score = 0;
            var i = 0;
            for ( i < this.userResponses.length; i++; ) {
                if (
                    typeof this.quiz.questions[i].answers[
                        this.userResponses[i]
                    ] !== "undefined" &&
                    this.quiz.questions[i].answers[this.userResponses[i]].correct
                ) {
                    score = score + 1;
                }
            }
            return score;

            return this.userResponses.filter(function(val) { return val }).length;
        },

        // Get Quiz, Questions, Answer and User
        getQuiz(url){
            axios.get('/show-quiz/' + url).then(response => {
                this.quiz = response.data.quiz
                this.user = response.data.user
                //localStorage.removeItem('QuizSlug')
            }).catch(e => {
                console.log(e)
            })
        }
    }
}
</script>
