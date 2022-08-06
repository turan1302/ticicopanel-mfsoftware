<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Favicon Ayarlar</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Favicon Ayarlar</h5>
                            </div>
                            <div class="card-body">

                                <form method="POST" @submit.prevent="faviconAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Faavicon Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+site_favicon" :alt="site_baslik">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Favicon (100x100)</label>
                                            <input type="file" @change="siteFaviconSec" class="form-control"
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
    name: "AdminFaviconAyarlarComponent",
    props: ["geriye_don"],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            site_baslik : '',
            site_favicon : '',
            errors: [],
        }
    },
    mounted() {
      this.faviconAyarGetir();
    },
    methods: {
        faviconAyarGuncelle() {
            this.errors = [];

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/ayarlar/favicon-update";

                let formData = new FormData();
                formData.append('site_favicon', this.site_favicon);

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
        faviconAyarGetir() {
            var url = "http://127.0.0.1:8000/api/back/ayarlar";
            axios.get(url).then((res) => {
                var data = res.data;

                this.site_baslik = data.site_baslik;
                this.site_favicon = (data.site_favicon != null && data.site_favicon != "") ? data.site_favicon : "resim-yok.webp";

            });
        },
        siteFaviconSec(e) {
            this.site_favicon = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
