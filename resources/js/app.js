/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
window.events = new Vue();
window.flash = function (message, type) {
    window.events.$emit('flash', message, type);
}

Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', { bubbles: true, cancelable: true });
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});
Vue.filter('money', function (value) {
    return '$ ' + new Intl.NumberFormat().format(value);
})
Vue.filter('number', function (value) {
    return new Intl.NumberFormat().format(value);
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//共用
Vue.component('vue-table', require('./components/common/layout/Table').default);
Vue.component('chart-table', require('./components/common/layout/ChartTable').default);
Vue.component('text-input', require('./components/common/input/TextInput').default);
Vue.component('select-input', require('./components/common/input/SelectInput').default);
Vue.component('select2-input', require('./components/common/input/Select2Input').default);
Vue.component('date-input', require('./components/common/input/DateInput').default);
Vue.component('input-error-message', require('./components/common/input/InputErrorMessage').default);
Vue.component('input-remark-message', require('./components/common/input/InputRemarkMessage').default);
Vue.component('input-row', require('./components/common/layout/FormInputRow').default);
Vue.component('search-input', require('./components/common/layout/SearchInput').default);
Vue.component('submit-row', require('./components/common/layout/FormSubmitRow').default);
Vue.component('flash', require('./components/common/layout/Flash').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('search-condition', require('./components/common/layout/SearchCondition').default);
Vue.component('bar-chart', require('./components/common/chart/BarChart').default);
Vue.component('line-chart', require('./components/common/chart/LineChart').default);
Vue.component('pie-chart', require('./components/common/chart/PieChart').default);
Vue.component('list-page', require('./components/common/page/ListPage').default);
Vue.component('create-page', require('./components/common/page/CreatePage').default);
Vue.component('update-page', require('./components/common/page/UpdatePage').default);
Vue.component('report-page', require('./components/common/page/ReportPage').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
