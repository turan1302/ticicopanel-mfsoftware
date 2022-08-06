<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Genel Ayarlar</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Genel Ayarlar</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="genelAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Başlık</label>
                                            <input type="text" v-model="site_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Anahtar Kelimeler</label>
                                            <input v-model="site_keyw" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Açıklama</label>
                                            <input v-model="site_desc" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Slogan</label>
                                            <input v-model="site_slogan" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Aktiflik</label>
                                            <select v-model="site_durum" class="form-control">
                                                <option :value="1">Aktif</option>
                                                <option :value="0">Pasif</option>
                                            </select>
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
    name: "AdminGenelAyarlarComponent",
    props: ["geriye_don"],
    data() {
        return {
            site_baslik: '',
            site_desc : '',
            site_keyw: '',
            site_slogan : '',
            site_durum : '',
            errors: [],
        }
    },
    mounted() {
      this.genelAyarGetir();
    },
    methods: {
        genelAyarGuncelle() {
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
            var url = "http://127.0.0.1:8000/api/back/ayarlar";
            axios.get(url).then((res) => {
                var data = res.data;

                this.site_baslik = data.site_baslik;
                this.site_desc = data.site_desc;
                this.site_keyw = data.site_keyw;
                this.site_slogan = data.site_slogan;
                this.site_durum = data.site_durum;
            });
        }
    }
}
</script>

<style scoped>

</style>
