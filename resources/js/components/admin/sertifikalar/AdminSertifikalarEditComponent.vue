<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Sertifika Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sertifika Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="sertifikaGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Başlık</label>
                                            <input type="text" v-model="sr_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Açıklama</label>
                                            <textarea class="form-control" v-model="sr_aciklama" rows="5"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Yıl</label>
                                            <input type="date" v-model="sr_yil" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Derece</label>
                                            <input type="number" min="0" max="100" v-model="sr_derece" class="form-control"
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
    name: "AdminSertifikalarEditComponent",
    props: ["geriye_don", "sr_id"],
    data() {
        return {
            sr_baslik: '',
            sr_aciklama: '',
            sr_yil: '',
            sr_derece: '',
            errors: [],
        }
    },
    mounted() {
        var sr_id = this.$props.sr_id;
      this.sertifikaGetir(sr_id);
    },
    methods: {
        sertifikaGuncelle() {
            this.errors = [];

            if (this.sr_baslik == "") {
                this.errors.push("Sertifika Başlık Kısmı Boş Olamaz");
            }

            if (this.sr_aciklama == "") {
                this.errors.push("Sertifika Açıklama Kısmı Boş Olamaz");
            }

            if (this.sr_yil == "") {
                this.errors.push("Sertifika Yıl Kısmı Boş Olamaz");
            }

            if (this.sr_derece == "") {
                this.errors.push("Sertifika Derece Kısmı Boş Olamaz");
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.sr_id;
                var url = "http://127.0.0.1:8000/api/back/sertifikalar/"+id+"/update";


                axios.post(url, {
                    sr_baslik: this.sr_baslik,
                    sr_aciklama: this.sr_aciklama,
                    sr_yil: this.sr_yil,
                    sr_derece: this.sr_derece,
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
        sertifikaGetir(sr_id) {
            var url = "http://127.0.0.1:8000/api/back/sertifikalar/" + sr_id + "/edit";
            axios.get(url).then((res) => {

                var data = res.data;
                this.sr_baslik = data.sr_baslik;
                this.sr_aciklama = data.sr_aciklama;
                this.sr_yil = data.sr_yil;
                this.sr_derece = data.sr_derece;
            });
        },
    }
}
</script>

<style scoped>

</style>
