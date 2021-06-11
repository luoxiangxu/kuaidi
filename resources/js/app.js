/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import { Form, HasError, AlertError } from 'vform'
import Swal from 'sweetalert2'
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
  })

window.Swal = Swal

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.filter('date',function(created){
    return moment(created).format('YYYY MMMM Do');
});

window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('vue-login', require('./components/Login.vue').default);
Vue.component('vue-topup', require('./components/topup.vue').default);
Vue.component('vue-usercredit', require('./components/userCredit.vue').default);
Vue.component('vue-shopping', require('./components/shopping.vue').default);
Vue.component('vue-userorder', require('./components/userorder.vue').default);
Vue.component('vue-adminorder', require('./components/adminorder.vue').default);
Vue.component('vue-arrivedorder', require('./components/arrivedorder.vue').default);
Vue.component('vue-profile', require('./components/profile.vue').default);
Vue.component('vue-topuprecord', require('./components/topuprecord.vue').default);
Vue.component('vue-orderrecord', require('./components/orderrecord.vue').default);
Vue.component('vue-userpage', require('./components/userpage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
