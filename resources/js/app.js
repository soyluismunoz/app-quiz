require('./bootstrap');

window.Vue = require('vue');

Vue.component('all-quizes', require('./components/Quizes.vue').default);
Vue.component('show-quiz', require('./components/Quiz.vue').default);

Vue.component('timer', require('./components/Timer.vue').default);

const app = new Vue({
    el: '#app',
});
