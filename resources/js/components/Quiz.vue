<template>
    <section class="section quiz">
        <div class="container-fluid px-5">
            <div class="row justify-content-center">
                <div class="col-lg-4 mt-5 skipped" v-if="skippedQues.length > 0">
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
                <div class="col-lg-8 mt-5">
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

                                <ul class="pagination m-0">
                                    <li class="page-item" aria-current="page" :id="'act-' + index" 
                                    :class="(index == questionIndex)?'active': ''"
                                    v-for="(r, index) in quiz.questions.length " :key="r.index">
                                        <a class="page-link" @click="goQuestion(index)">
                                            {{ index + 1 }}
                                        </a>
                                    </li>
                                </ul>

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
            skippedQues:[],
            end: false,
            userResponses: '',
            load: true,
            time: "",
            hour: "",
            min: "",
            seg: "",
            user: '',
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
               //localStorage.removeItem('QuizSlug')
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
        goQuestion(index){
            this.questionIndex = index
        },
        restart(){
            this.questionIndex=0;
            this.userResponses=Array(this.quiz.questions.length).fill(null);
        },

        // select answer
        selectAnswer(index) {
            Vue.set(this.userResponses, this.questionIndex, index);
            console.log(this.userResponses)
        },

        // End and final score
        score() {
            this.skippedQues = []
            var score = 0;
            var i = 0;
            for (let i = 0; i < this.userResponses.length; i++) {
                if (typeof this.quiz.questions[i].answers[this.userResponses[i]] !== "undefined" && 
                    this.quiz.questions[i].answers[this.userResponses[i]].correct != 0) 
                {
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
                this.hour = response.data.quiz.hour
                this.min = response.data.quiz.min
                this.seg = response.data.quiz.seg
                //localStorage.removeItem('QuizSlug')
            }).catch(e => {
                console.log(e)
            })
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
                if(n == 0){
                    clearTimeout(timeout)
                    self.questionIndex = self.quiz.questions.length
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
