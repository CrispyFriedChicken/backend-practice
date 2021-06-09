/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.events = new Vue();
window.flash = function(message,type) {
    window.events.$emit('flash',message,type);
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//共用
Vue.component('vue-table', require('./components/common/Table').default);
Vue.component('text-input', require('./components/common/input/TextInput').default);
Vue.component('select-input', require('./components/common/input/SelectInput').default);
Vue.component('input-error-message', require('./components/common/input/InputErrorMessage').default);
Vue.component('input-row', require('./components/common/layout/FormInputRow').default);
Vue.component('input-search', require('./components/common/layout/SearchInputColumn').default);
Vue.component('submit-row', require('./components/common/layout/FormSubmitRow').default);
Vue.component('flash', require('./components/layout/Flash').default);
Vue.component('pagination', require('laravel-vue-pagination'));
//遊戲維護
Vue.component('create-game', require('./components/game/GameCreate.vue').default);
Vue.component('update-game', require('./components/game/GameUpdate.vue').default);
Vue.component('list-game', require('./components/game/GameList.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
