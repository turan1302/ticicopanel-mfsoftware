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
Vue.component('admin-duyuru-kategori-create-component', require('./components/admin/duyuru_kategoriler/AdminDuyuruKategoriCreateComponent').default);
Vue.component('admin-duyuru-kategori-edit-component', require('./components/admin/duyuru_kategoriler/AdminDuyuruKategoriEditComponent').default);
Vue.component('admin-duyuru-kategori-show-component', require('./components/admin/duyuru_kategoriler/AdminDuyuruKategoriShowComponent').default);

// DUYURULAR KISMI AYARLANMASINA BAKALIM
Vue.component('admin-duyuru-list-component', require('./components/admin/duyurular/AdminDuyuruListComponent').default);
Vue.component('admin-duyuru-create-component', require('./components/admin/duyurular/AdminDuyuruCreateComponent').default);
Vue.component('admin-duyuru-edit-component', require('./components/admin/duyurular/AdminDuyuruEditComponent').default);
Vue.component('admin-duyuru-show-component', require('./components/admin/duyurular/AdminDuyuruShowComponent').default);

// DUYURU YORUMLARI KISMI AYARLANAMSI
Vue.component('admin-duyuru-yorum-list-component', require('./components/admin/duyuru_yorumlari/AdminDuyuruYorumListComponent').default);
Vue.component('admin-duyuru-yorum-edit-component', require('./components/admin/duyuru_yorumlari/AdminDuyuruYorumEditComponent').default);

// SOSYAL MEDYA KISMI AYARLANAMSI
Vue.component('admin-sosyal-medya-list-component', require('./components/admin/sosyal_medya/AdminSosyalMedyaListComponent').default);
Vue.component('admin-sosyal-medya-create-component', require('./components/admin/sosyal_medya/AdminSosyalMedyaCreateComponent').default);
Vue.component('admin-sosyal-medya-edit-component', require('./components/admin/sosyal_medya/AdminSosyalMedyaEditComponent').default);
Vue.component('admin-sosyal-medya-show-component', require('./components/admin/sosyal_medya/AdminSosyalMedyaShowComponent').default);

// SLIDER KISMI AYARLANMASI
Vue.component('admin-slider-list-component', require('./components/admin/sliderlar/AdminSliderListComponent').default);
Vue.component('admin-slider-create-component', require('./components/admin/sliderlar/AdminSliderCreateComponent').default);
Vue.component('admin-slider-edit-component', require('./components/admin/sliderlar/AdminSliderEditComponent').default);
Vue.component('admin-slider-show-component', require('./components/admin/sliderlar/AdminSliderShowComponent').default);

// PARTNER KISMI AYARLANMASI
Vue.component('admin-partner-list-component', require('./components/admin/partnerlar/AdminPartnerListComponent').default);
Vue.component('admin-partner-create-component', require('./components/admin/partnerlar/AdminPartnerCreateComponent').default);
Vue.component('admin-partner-edit-component', require('./components/admin/partnerlar/AdminPartnerEditComponent').default);
Vue.component('admin-partner-show-component', require('./components/admin/partnerlar/AdminPartnerShowComponent').default);

// EKIP KISMI AYARLAMASI
Vue.component('admin-ekip-list-component', require('./components/admin/ekip/AdminEkipListComponent').default);
Vue.component('admin-ekip-create-component', require('./components/admin/ekip/AdminEkipCreateComponent').default);
Vue.component('admin-ekip-edit-component', require('./components/admin/ekip/AdminEkipEditComponent').default);
Vue.component('admin-ekip-show-component', require('./components/admin/ekip/AdminEkipShowComponent').default);

// MENULER KISMI AYARLANMASI
Vue.component('admin-menuler-list-component', require('./components/admin/menuler/AdminMenulerListComponent').default);
Vue.component('admin-menuler-create-component', require('./components/admin/menuler/AdminMenulerCreateComponent').default);
Vue.component('admin-menuler-edit-component', require('./components/admin/menuler/AdminMenulerEditComponent').default);
Vue.component('admin-menuler-show-component', require('./components/admin/menuler/AdminMenulerShowComponent').default);

// SAYFALAR KISMI AYARLANMASI
Vue.component('admin-sayfalar-list-component', require('./components/admin/sayfalar/AdminSayfalarListComponent').default);
Vue.component('admin-sayfalar-create-component', require('./components/admin/sayfalar/AdminSayfalarCreateComponent').default);
Vue.component('admin-sayfalar-edit-component', require('./components/admin/sayfalar/AdminSayfalarEditComponent').default);
Vue.component('admin-sayfalar-show-component', require('./components/admin/sayfalar/AdminSayfalarShowComponent').default);

// MUSTERI YORUMLAR KISMI AYARLANMASI
Vue.component('admin-musteri-yorumlar-list-component', require('./components/admin/musteri_yorumlar/AdminMusteriYorumlarListComponent').default);
Vue.component('admin-musteri-yorumlar-create-component', require('./components/admin/musteri_yorumlar/AdminMusteriYorumlarCreateComponent').default);
Vue.component('admin-musteri-yorumlar-edit-component', require('./components/admin/musteri_yorumlar/AdminMusteriYorumlarEditComponent').default);
Vue.component('admin-musteri-yorumlar-show-component', require('./components/admin/musteri_yorumlar/AdminMusteriYorumlarShowComponent').default);

// ILETISIM MESAJLARI KISMI AYARLANAMSI
Vue.component('admin-iletisim-mesajlari-list-component', require('./components/admin/iletisim_mesajlari/AdminIletisimMesajlariListComponent').default);
Vue.component('admin-iletisim-mesajlari-show-component', require('./components/admin/iletisim_mesajlari/AdminIletisimMesajlariShowComponent').default);

// ABONELER KISMI AYARLANAMSI
Vue.component('admin-aboneler-list-component', require('./components/admin/aboneler/AdminAbonelerListComponent').default);
Vue.component('admin-aboneler-create-component', require('./components/admin/aboneler/AdminAbonelerCreateComponent').default);

// SERTIFIKALAR KISMI AYARLANMASI
Vue.component('admin-sertifikalar-list-component', require('./components/admin/sertifikalar/AdminSertifikalarListComponent').default);
Vue.component('admin-sertifikalar-create-component', require('./components/admin/sertifikalar/AdminSertifikalarCreateComponent').default);
Vue.component('admin-sertifikalar-edit-component', require('./components/admin/sertifikalar/AdminSertifikalarEditComponent').default);
Vue.component('admin-sertifikalar-show-component', require('./components/admin/sertifikalar/AdminSertifikalarShowComponent').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
