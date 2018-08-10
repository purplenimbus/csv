
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('list-component', require('./components/ListComponent.vue'));
Vue.component('parser-component', require('./components/ParserComponent.vue'));
Vue.component('upload-component', require('./components/UploadComponent.vue'));
Vue.component('modal-component', require('./components/ModalComponent.vue'));

const app = new Vue({
    el: '#app',
	propsData: ['userId'],
	data(){
		return {
			userId : document.getElementById('app').getAttribute('user-id'),
			notifications : []
		}
	},
	mounted(){

	}
});
