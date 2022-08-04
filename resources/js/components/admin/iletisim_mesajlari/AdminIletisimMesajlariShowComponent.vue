<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>İletişim Mesajı Görüntüle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">İletişim Mesajı Bilgileri</h5>
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
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input readonly type="text" v-model="im_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">E-Mail</label>
                                            <input readonly type="text" v-model="im_email" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Telefon</label>
                                            <input readonly type="text" v-model="im_tel" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Konu</label>
                                            <input readonly type="text" v-model="im_konu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">IP Adresi</label>
                                            <input readonly type="text" v-model="im_ip_adres" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Mesaj</label>
                                            <textarea type="text" class="editor"
                                                      v-model="im_mesaj"></textarea>
                                        </div>

                                        <form @submit.prevent="mesajCevapla()" method="POST">
                                            <div class="example-content">
                                                <label for="exampleInputEmail1" class="form-label">Cevabınız</label>
                                                <textarea type="text" id="im_cevap" class="editor"
                                                          v-model="im_cevap"></textarea>
                                            </div>



                                            <div class="row">
                                                <div class="example-component m-2">
                                                    <button type="submit" class="btn btn-success btn-md"> Cevapla</button>
                                                    <a :href="geriye_don" class="btn btn-danger btn-md"> Geriye Dön</a>
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
    </div>
</template>

<script>
export default {
    name: "AdminServiceShowComponent",
    props: ["geriye_don", "im_id"],
    data() {
        return {
            im_adsoyad: '',
            im_email: '',
            im_tel: '',
            im_konu: '',
            im_mesaj: '',
            im_ip_adres: '',
            im_cevap : '',
            errors: [],
        }
    },
    mounted() {
        var im_id = this.$props.im_id;
      this.iletisimMesajGetir(im_id);
    },
    methods: {
        mesajCevapla() {
            this.errors = [];

            var im_cevap = tinyMCE.get('im_cevap').getContent();  // SERVİS KISMI ACIKLAMASI
            if (im_cevap == "") {
                this.errors.push("Mesaj Cevap Kısmı Boş Olamaz");
            }


            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {

                var id = this.$props.im_id;
                var url = "http://127.0.0.1:8000/api/back/iletisim-mesajlari/"+id+"/reply";

                axios.post(url, {
                    im_cevap: im_cevap,
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
                    if (error.response){
                        console.log(error.response.data);
                    }
                });

            }
        },
        iletisimMesajGetir(im_id) {
            var url = "http://127.0.0.1:8000/api/back/iletisim-mesajlari/" + im_id + "/show";
            axios.get(url).then((res) => {

                var data = res.data;
                this.im_adsoyad = data.im_adsoyad;
                this.im_email = data.im_email;
                this.im_tel = data.im_tel;
                this.im_konu = data.im_konu;
                this.im_mesaj = data.im_mesaj;
                this.im_ip_adres = data.im_ip_adres;
            });
        },
    }
}
</script>

<style scoped>

</style>
