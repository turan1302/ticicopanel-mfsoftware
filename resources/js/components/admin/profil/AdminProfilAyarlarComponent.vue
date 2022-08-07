<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Profil Ayarlar</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Profil Ayarlar</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>

                                <form method="POST" @submit.prevent="profilAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+avatar" :alt="name">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Avatar (80x80)</label>
                                            <input type="file" @change="kullaniciAvatarSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input type="text" v-model="name" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">E-Mail</label>
                                            <input type="text" v-model="email" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Şifreniz</label>
                                            <input type="password" v-model="password" placeholder="Boş Bırakırsanız Şifreniz Değişmez" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Şifre
                                                (Tekrar)</label>
                                            <input type="password" v-model="password_confirmation" placeholder="Boş Bırakırsanız Şifreniz Değişmez" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Güncelle</button>
                                                <a :href="geriye_don" class="btn btn-danger btn-md"> Geriye Dön</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    name: "AdminProfilAyarlarComponent",
    props: ["geriye_don"],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            avatar  : '',
            name: '',
            email : '',
            password: '',
            password_confirmation : '',
            errors: [],
        }
    },
    mounted() {
      this.genelProfilGetir();
    },
    methods: {
        profilAyarGuncelle() {
            this.errors = [];

            if (this.name == "") {
                this.errors.push("Ad Soyad Kısmı Boş Olamaz");
            }

            if (this.email == "") {
                this.errors.push("E-Mail Kısmı Boş Olamaz");
            }

            if (this.email != "") {
                if (this.ValidateEmail(this.email)==false){
                    this.errors.push("Lütfen Geçerli Bir E-Mail Adresi Giriniz");
                }
            }

            if (this.password != ""){
                if (this.password.length < 8){
                    this.errors.push("Şifre Kısmı 8 Karakterden Küçük Olamaz");
                }

                if (this.password_confirmation == ""){
                    this.errors.push("Şifre Tekrar Kısmını Boş Bırakmayınız");
                }

                if (this.password_confirmation != ""){
                    if (this.password_confirmation != this.password){
                        this.errors.push("Şifreler Eşleşmiyor");
                    }
                }
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/profil/update";

                let formData = new FormData();
                formData.append('avatar', this.avatar);
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);

                axios.post(url, formData).then((res) => {
                    var data = res.data;
                    Swal.fire({
                        icon: data.type,
                        title: data.title,
                        text: data.text,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    })
                }).catch(function (error) {
                    console.log(error.response);
                });
            }
        },
        genelProfilGetir() {
            var url = "http://127.0.0.1:8000/api/back/profil";
            axios.get(url).then((res) => {
                var data = res.data;

                this.name = data.name;
                this.email = data.email;

                this.avatar = (data.avatar != "") ? data.avatar : "resim-yok.webp";

            });
        },
        kullaniciAvatarSec(e) {
            this.avatar = e.target.files[0]; //  RESIM EKLETME ISLEMI
        },
        ValidateEmail(inputText) {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (inputText.match(mailformat)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
</script>

<style scoped>

</style>
