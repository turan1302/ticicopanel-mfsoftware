<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>İletişim Ayarlar</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">İletişim Ayarlar</h5>
                            </div>
                            <div class="card-body">

                                <form method="POST" @submit.prevent="iletisimAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Mail</label>
                                            <input v-model="site_mail" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Telefon</label>
                                            <input v-model="site_tel" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Adres</label>
                                            <textarea v-model="site_adres" class="form-control" rows="5"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Harita</label>
                                            <input v-model="site_harita" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Site Harita Durum</label>
                                            <select v-model="site_harita_durum" class="form-control">
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
    name: "AdminIletisimAyarlarComponent",
    props: ["geriye_don"],
    data() {
        return {
            site_mail : '',
            site_tel : '',
            site_adres : '',
            site_harita : '',
            site_harita_durum : '',
            errors: [],
        }
    },
    mounted() {
      this.iletisimAyarGetir();
    },
    methods: {
        iletisimAyarGuncelle() {
            this.errors = [];

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/ayarlar/update";

                axios.post(url, {

                    site_mail: this.site_mail,
                    site_tel: this.site_tel,
                    site_adres: this.site_adres,
                    site_harita: this.site_harita,
                    site_harita_durum: this.site_harita_durum

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
        iletisimAyarGetir() {
            var url = "http://127.0.0.1:8000/api/back/ayarlar";
            axios.get(url).then((res) => {
                var data = res.data;

                this.site_mail = data.site_mail;
                this.site_tel = data.site_tel;
                this.site_adres = data.site_adres;
                this.site_harita = data.site_harita;
                this.site_harita_durum = data.site_harita_durum;
            });
        }
    }
}
</script>

<style scoped>

</style>
