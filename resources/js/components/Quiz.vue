<template>
    <section class="section quiz py-5">
        <div class="container-fluid px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 mt-5 order-lg-1">
                    <!--Quiz-->
                    <div class="card shadow-lg rounded" v-if="questionIndex < quiz.questions.length" v-bind:key="questionIndex">
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
                        <div class="card-body text-center" v-if="!load">
                            <div class="d-flex justify-content-end">
                               <p> Tiempo para realizar la prueba <strong v-text="time"></strong></p>
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
                        <div class="card-body text-center" v-else>
                            <div class="row justify-content-center" style="height: 250px;">
                                <div class="col-lg-4 align-self-center">
                                    <i class="fas fa-spinner fa-spin fa-6x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary rounded-pill" @click="prev()" :disabled="questionIndex < 1">
                                    Anterior
                                </button>

                                <button class="btn rounded-pill btn-success" @click="next()" v-if="userResponses[questionIndex]!=null">
                                   Siguiente
                                </button>
                                <button v-else class="btn rounded-pill btn-secondary" @click="skip(questionIndex)">
                                    Omitir
                                </button>

                            </div>
                        </div>
                    </div>

                    <!--Result-->
                    <div class="card shadow-lg rounded py-5" 
                        v-if="questionIndex >= quiz.questions.length" v-bind:key="questionIndex">
                        <div class="align-self-center text-center">
                            <h2 class="card-title text-center" v-text="quizFinished"></h2>
                            <hr>
                            <i class="far fa-5x " 
                            :class=" finalScore > quiz.approve_with?'text-success fa-check-circle is-active':'fa-times-circle text-danger'"></i>
                            <h3>
                                {{ finalScore > quiz.approve_with? quiz.if_approve : quiz.if_fail }}
                            </h3>
                            <p>
                               Puntuacion total : {{ finalScore }} / {{ quiz.questions.length }}
                            </p>
                            <button class="btn btn-primary" @click="restart()">
                                Reiniciar <i class="fas fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!--skipped questions-->
                <div class="col-lg-4 mt-5 skipped order-lg-0" v-if="skippedQues.length > 0">
                    <div class="card shadow rounded">
                        <div class="card-header text-center">
                           <h3 class="card-title m-0">
                               Preguntas Omitidas 
                           </h3>
                        </div>
                       <div class="card-body p-0 overflow-auto" style="max-height:520px">
                            <ul class="list-group list-group-flush">
                                <a class="list-group-item list-group-item-action skipped-item" v-for="sQ in skippedQues" :key="sQ" @click="selectSkipped(sQ)">
                                    {{ quiz.questions[sQ].title }}
                                </a>
                            </ul>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return {
            questionIndex: 0,
            skippedQues:[],
            finalScore: 0,
            userResponses: '',
            load: true,
            time: "",
            hour: "",
            min: "",
            seg: "",
            user: '',
            quizFinished: 'Haz Finalizado el examen de certificacion',
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
    mounted() {
        var self = this
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
        
        setTimeout(function(){
           if(self.quiz){
               localStorage.removeItem('QuizSlug')
               self.load = false
            }
            self.userResponses = Array(self.quiz.questions.length).fill(null)
            console.log(self.userResponses)
            self.takeTime()
        }, 1000)
       
    },
    methods:{
        // pagination
        next() {
            if (this.questionIndex < this.quiz.questions.length){
                 this.questionIndex++;
            }
            if(this.questionIndex >= this.quiz.questions.length){
                this.score()
                this.addResult()
            }
        },
        skip(index){
            this.skippedQues.push(index)
            this.next()
            console.log(index)
        },
        selectSkipped(index){
            this.questionIndex = index
        },
        prev() {
            if (this.quiz.questions.length > 0) this.questionIndex--;
        },
        restart(){
            this.questionIndex=0;
            this.takeTime()
            this.userResponses=Array(this.quiz.questions.length).fill(null);
        },

        // select answer
        selectAnswer(index) {
            Vue.set(this.userResponses, this.questionIndex, index);
            console.log(this.userResponses)
        },

        // End and final score
        score(){
            var score = 0;
            var i = 0;
            for (let i = 0; i < this.userResponses.length; i++) {
                if (typeof this.quiz.questions[i].answers[this.userResponses[i]] !== "undefined" && 
                    this.quiz.questions[i].answers[this.userResponses[i]].correct != 0) 
                {
                    score = score + 1;
                }
            }
            this.skippedQues.length = 0
            this.finalScore = score
            this.userResponses.filter(function(val) { return val }).length;
        },

        // Get Quiz, Questions, Answer and User
        getQuiz(url){
            axios.get('/show-quiz/' + url).then(response => {
                this.quiz = response.data.quiz
                this.user = response.data.user
                this.hour = response.data.quiz.hour
                this.min = response.data.quiz.min
                this.seg = response.data.quiz.seg
                //localStorage.removeItem('QuizSlug')
            }).catch(e => {
                console.log(e)
            })
        },

        addResult(){
            let formData = new FormData()

            formData.append('quizId', this.quiz.id)
            formData.append('userId', this.user.id)
            formData.append('questionsCount', this.quiz.questions.length)
            formData.append('correctAnswers', this.finalScore)

            let url = '/addResult'
            axios.post(url, formData).then(response => {
                console.log(response.status)
            }).catch(error => {
                console.log(error.response.data.message)
            });
        },

        // Temporizador
        takeTime(){
            var timeout;
            var self = this
            var hour = self.hour
            var min = self.min
            var seg = self.seg
            var n = (hour * 3600) + (min * 60) + seg;
            timeout=window.setInterval(function(){
                self.secondsToString(n)
                n--;
                if(n <= 0){
                    clearTimeout(timeout)
                    self.questionIndex = self.quiz.questions.length
                    self.quizFinished = "Se te ha agotado el tiempo"
                }
            },1000);
        },
        secondsToString(seconds) {
            var hour = Math.floor(seconds / 3600);
            hour = (hour < 10)? '0' + hour : hour;
            
            var minute = Math.floor((seconds / 60) % 60);
            minute = (minute < 10)? '0' + minute : minute;
            
            var second = seconds % 60;
            second = (second < 10)? '0' + second : second;
            
            this.time = hour + ':' + minute + ':' + second ;
        }
    }
}
</script>
