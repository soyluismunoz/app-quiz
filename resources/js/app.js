require('./bootstrap');
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Vue = require('vue');
Vue.use(VueSweetalert2);

Vue.component('all-quizes-act', require('./components/Quizes.vue').default);
Vue.component('show-quiz', require('./components/Quiz.vue').default);

//dashboard
Vue.component('counters', require('./components/Counters.vue').default);
Vue.component('main-tables', require('./components/MainTables.vue').default);

Vue.component('all-results', require('./components/Results.vue').default);
Vue.component('all-quizes', require('./components/AllQuizes.vue').default);

const app = new Vue({
    el: '#app',
});
