<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Kullanıcı Görüntüle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Kullanıcı Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+avatar" :alt="name">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Ad
                                                Soyad</label>
                                            <input readonly type="text" v-model="name" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı E-Mail</label>
                                            <input readonly type="text" v-model="email" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Yetkisi</label>
                                            <select id="yetki"
                                                    class="form-control yetki">
                                                <option :value="0">- Seçiniz -</option>
                                                <option :selected="(yetki==item.yt_id) ? true : null"
                                                        :value="item.yt_id" v-for="item in yetki_data">{{
                                                        item.yt_baslik
                                                    }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Şifre</label>
                                            <input readonly type="password" placeholder="Boş Bırakırsanız Şifreniz Değişmez" v-model="password" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Şifre
                                                (Tekrar)</label>
                                            <input readonly type="password" placeholder="Boş Bırakırsanız Şifreniz Değişmez" v-model="password_confirmation" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>


                                        <div class="row">
                                            <div class="example-component m-2">
                                                <a :href="geriye_don" class="btn btn-danger btn-md"> Geriye Dön</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminLanguageCreateComponent",
    props: ["geriye_don", 'user_id',"yetkiler"],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            avatar: '',
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            yetki: '',
            yetki_data : '', // TUM YETKILERIN GETIRILMESINI AYARLICAZ
            errors: [],
        }
    },
    mounted() {
        var user_id = this.$props.user_id;
        this.yetki_data = JSON.parse(this.$props.yetkiler);
        this.kullaniciGetir(user_id);
    },
    methods: {
        kullaniciGetir(user_id) {
            var url = "http://127.0.0.1:8000/api/back/kullanicilar/" + user_id + "/show";
            axios.get(url).then((res) => {
                var data = res.data;

                this.name = data.name;
                this.email = data.email;

                $("#yetki").val(data.yetki).trigger('change');  // varsayılan kısmı ayarlanması

                this.avatar = (data.avatar != "") ? data.avatar : "resim-yok.webp";
            });
        }
    }
}
</script>

<style scoped>

</style>
