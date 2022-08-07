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

                                <form method="POST" @submit.prevent="profilAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

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
            name: '',
            email : '',
            password: '',
            password_tekrar : '',
            errors: [],
        }
    },
    mounted() {
      this.genelAyarGetir();
    },
    methods: {
        profilAyarGuncelle() {
            this.errors = [];

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/ayarlar/update";

                axios.post(url, {
                    site_baslik: this.site_baslik,
                    site_desc: this.site_desc,
                    site_keyw: this.site_keyw,
                    site_slogan: this.site_slogan,
                    site_durum: this.site_durum,
                }).then((res) => {
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
        genelAyarGetir() {
            var url = "http://127.0.0.1:8000/api/back/profil";
            axios.get(url).then((res) => {
                var data = res.data;

                this.name = data.name;
                this.email = data.email;
            });
        }
    }
}
</script>

<style scoped>

</style>
