<template>
    <div class="row">
        <!--Ultimos Resultados-->
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="mb-0">Ultimos resultados</h3>
                        <slot name="results"></slot>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="result in lastResult" :key="result.id">
                                <th scope="row" v-text="result.user.name"></th>
                                <td v-text="result.quiz.title"></td>
                                <td v-if="result.correct_answers >= result.quiz.approve_with">
                                    <span class="badge badge-success">Aprobado</span>
                                </td>
                                <td v-else>
                                    <span class="badge badge-dark">Reprobado</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Ultimos Usuarios creados-->
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="mb-0">Ultimos Usuarios</h3>
                        <slot name="users"></slot>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in lastUsers" :key="user.id">
                                <th scope="row" v-text="user.name"></th>
                                <td v-if="user.role == 'user'">
                                    <span class="badge badge-dark" v-text="user.role"></span>
                                </td>
                                <td v-else>
                                    <span class="badge badge-success" v-text="user.role"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                lastResult: '',
                lastUsers: ''
            }
        },
        methods:{
            getData(){
                let url = "/last-user-and-result"

                axios.get(url).then(response => {
                    this.lastResult = response.data.lastResult
                    this.lastUsers = response.data.lastUsers
                }).catch(e => {
                    console.log(e)
                })
            }
        },
        created(){
            this.getData()
        }
    }
</script>