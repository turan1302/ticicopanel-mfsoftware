<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Toplu Mesaj</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Toplu Mesaj</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>

                                <form method="POST" @submit.prevent="topluMesajGonder()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Mail Konu</label>
                                            <input type="text" v-model="mail_konu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Mail Başlık</label>
                                            <input v-model="mail_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Mail İçerik</label>
                                            <textarea type="text" id="mail_icerik" class="editor" v-model="mail_icerik"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button v-show="showSendButton" type="submit" class="btn btn-success btn-md"> Gönder</button>
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
    name: "AdminTopluMesajComponent",
    props: ["geriye_don"],
    data() {
        return {
           mail_konu : '',
            mail_baslik : '',
            mail_icerik : '',
            showSendButton : true,
            errors: [],
        }
    },
    methods: {
        topluMesajGonder() {
            this.errors = [];

            if (this.mail_konu == "") {
                this.errors.push("Mail Konu Kısmı Boş Olamaz");
            }

            if (this.mail_baslik == "") {
                this.errors.push("Mail Başlık Kısmı Boş Olamaz");
            }

            var icerik = tinyMCE.get('mail_icerik').getContent();
            if (icerik == "") {
                this.errors.push("Mail İçerik Kısmı Boş Olamaz");
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {

                this.showSendButton = false;

                var url = "http://127.0.0.1:8000/api/back/ayarlar/toplu-mesaj-gonder";

                axios.post(url, {
                    mail_konu: this.mail_konu,
                    mail_baslik: this.mail_baslik,
                    mail_icerik: icerik,
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
        }
    }
}
</script>

<style scoped>

</style>
