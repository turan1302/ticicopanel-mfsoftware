<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Duyuru Yorumu</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Duyuru Yorum Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="duyuruYorumCevapla()"
                                      enctype="multipart/form-data">
                                    <div class="example-container">


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input readonly type="text" v-model="dy_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">E-Mail</label>
                                            <input readonly type="text" v-model="dy_email" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Website</label>
                                            <input readonly type="text" v-model="dy_website" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Hangi Duyuruya
                                                Geldi</label>
                                            <input readonly type="text" v-model="dy_duyuru" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">IP Adres</label>
                                            <input readonly type="text" v-model="dy_ip" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Gelen Yorum</label>
                                            <textarea readonly rows="3" type="text" class="form-control"
                                                      v-model="dy_yorum"></textarea>
                                        </div>


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Yorumunuz</label>
                                            <textarea type="text" id="yorumumuz" class="editor"
                                                      v-model="yorumumuz"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Cevapla</button>
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
import {ThirdPartyDraggable} from "../../../../../public/back/plugins/fullcalendar/lib/main";

export default {
    name: "AdminDuyuruYorumComponent",
    props: ["geriye_don", "duyuru_yorum_id"],
    data() {
        return {
            dy_adsoyad: '',
            dy_email: '',
            dy_website : '',
            dy_duyuru : '',  // HANGI DUYURUYA GELDI
            dy_ip : '',
            dy_yorum : '',
            yorumumuz: '', // BIZIM YAPACAGIMIZ YORUM BU ARADA
            errors: [],
        }
    },
    mounted() {
        var duyuru_yorum_id = this.$props.duyuru_yorum_id;
        this.duyuruYorumGetir(duyuru_yorum_id);
    },
    methods: {
        duyuruYorumCevapla() {
            this.errors = [];

            var yorumumuz = tinyMCE.get('yorumumuz').getContent();  // DUYURU YORUMUNA BIZIM VERECGIMIZ CEVAP
            if (yorumumuz == "") {
                this.errors.push("Yorumumuz Kısmı Boş Olamaz");
            }


            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.duyuru_yorum_id;
                var url = "http://127.0.0.1:8000/api/back/duyuru-yorumlari/" + id + "/cevapla";

                axios.post(url, {
                   yorumunuz : yorumumuz // YORUM KISMI ALINMASI GERCEKLESTIRILDI
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
        duyuruYorumGetir(duyuru_yorum_id) {
            var url = "http://127.0.0.1:8000/api/back/duyuru-yorumlari/" + duyuru_yorum_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.dy_adsoyad = data.dy_adsoyad;
                this.dy_email = data.dy_email;
                this.dy_website = data.dy_website;
                this.dy_duyuru = data.d_baslik;  // HANGI DUYURUYA GELDİ
                this.dy_ip = data.dy_ip;
                this.dy_yorum = data.dy_yorum;
            });
        },
    }
}
</script>

<style scoped>

</style>
