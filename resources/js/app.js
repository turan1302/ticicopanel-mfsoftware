/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/** ADMIN KSIMI AYARLAMASI **/
// ANASAYFA
Vue.component('admin-home-component', require('./components/admin/home/AdminHomeComponent').default);

// DILLER KISMI
Vue.component('admin-language-list-component', require('./components/admin/language/AdminLanguageListComponent').default);
Vue.component('admin-language-create-component', require('./components/admin/language/AdminLanguageCreateComponent').default);
Vue.component('admin-language-edit-component', require('./components/admin/language/AdminLanguageEditComponent').default);
Vue.component('admin-language-show-component', require('./components/admin/language/AdminLanguageShowComponent').default);

// SERVISLER KISMI
Vue.component('admin-service-list-component', require('./components/admin/service/AdminServiceListComponent').default);
Vue.component('admin-service-create-component', require('./components/admin/service/AdminServiceCreateComponent').default);
Vue.component('admin-service-edit-component', require('./components/admin/service/AdminServiceEditComponent').default);
Vue.component('admin-service-show-component', require('./components/admin/service/AdminServiceShowComponent').default);

// DUYURU KATEGORILERI KISMI AYARLANMASI
Vue.component('admin-duyuru-kategori-list-component', require('./components/admin/duyuru_kategoriler/AdminDuyuruKategoriListComponent').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
