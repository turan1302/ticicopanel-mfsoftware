<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Webmaster Ayarlar</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Webmaster Ayarlar</h5>
                            </div>
                            <div class="card-body">

                                <form method="POST" @submit.prevent="webmasterAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Google Doğrulama Kodu</label>
                                            <input v-model="google_dogrulama_kodu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Bing Doğrulama Kodu</label>
                                            <input v-model="bing_dogrulama_kodu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Yandex Doğrulama Kodu</label>
                                            <input v-model="yandex_dogrulama_kodu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Analiytcs Doğrulama Kodu</label>
                                            <input v-model="analiytcs_kodu" class="form-control"
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
    name: "AdminGenelAyarlarComponent",
    props: ["geriye_don"],
    data() {
        return {
            google_dogrulama_kodu : '',
            bing_dogrulama_kodu : '',
            yandex_dogrulama_kodu: '',
            analiytcs_kodu : '',
            errors: [],
        }
    },
    mounted() {
      this.webmasterAyarGetir();
    },
    methods: {
        webmasterAyarGuncelle() {
            this.errors = [];

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/ayarlar/update";

                axios.post(url, {
                    google_dogrulama_kodu: this.google_dogrulama_kodu,
                    bing_dogrulama_kodu: this.bing_dogrulama_kodu,
                    yandex_dogrulama_kodu: this.yandex_dogrulama_kodu,
                    analiytcs_kodu: this.analiytcs_kodu,
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
        webmasterAyarGetir() {
            var url = "http://127.0.0.1:8000/api/back/ayarlar";
            axios.get(url).then((res) => {
                var data = res.data;

                this.google_dogrulama_kodu = data.google_dogrulama_kodu;
                this.bing_dogrulama_kodu = data.bing_dogrulama_kodu;
                this.yandex_dogrulama_kodu = data.yandex_dogrulama_kodu;
                this.analiytcs_kodu = data.analiytcs_kodu;
            });
        }
    }
}
</script>

<style scoped>

</style>
