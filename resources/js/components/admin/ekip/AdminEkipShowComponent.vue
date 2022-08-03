<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Ekip Görüntüle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Ekip Bilgileri</h5>
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
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+ekp_resim" :alt="ekp_adsoyad">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input readonly type="text" v-model="ekp_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Unvan</label>
                                            <input readonly type="text" v-model="ekp_unvan" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Facebook</label>
                                            <input readonly type="text" v-model="ekp_facebook" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Twitter</label>
                                            <input readonly type="text" v-model="ekp_twitter" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Instagram</label>
                                            <input readonly type="text" v-model="ekp_instagram" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Telefon</label>
                                            <input readonly type="text" v-model="ekp_telefon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <a :href="geriye_don" class="btn btn-danger btn-md"> Geriye Dön</a>
                                            </div>
                                        </div>
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
    name: "AdminEkipShowComponent",
    props: ["geriye_don", 'ekip_id'],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            ekp_resim: '',
            ekp_adsoyad: '',
            ekp_unvan: '',
            ekp_facebook: '',
            ekp_twitter: '',
            ekp_instagram: '',
            ekp_telefon: '',
            errors: [],
        }
    },
    mounted() {
        var ekip_id = this.$props.ekip_id;
        this.ekipGetir(ekip_id);
    },
    methods: {
        ekipGuncelle() {
            this.errors = [];

            if (this.ekp_adsoyad == "") {
                this.errors.push("Ekip Ad Soyad Alanı Boş Bırakılamaz");
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var id = this.$props.ekip_id;
                var url = "http://127.0.0.1:8000/api/back/ekip/"+id+"/update";

                let formData = new FormData();

                formData.append('ekp_resim', this.ekp_resim);
                formData.append('ekp_adsoyad', this.ekp_adsoyad);
                formData.append('ekp_unvan', this.ekp_unvan);
                formData.append('ekp_facebook', this.ekp_facebook);
                formData.append('ekp_twitter', this.ekp_twitter);
                formData.append('ekp_instagram', this.ekp_instagram);
                formData.append('ekp_telefon', this.ekp_telefon);

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
                });
            }
        },
        ekipGetir(ekip_id) {
            var url = "http://127.0.0.1:8000/api/back/ekip/" + ekip_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.ekp_adsoyad = data.ekp_adsoyad;
                this.ekp_unvan = data.ekp_unvan;
                this.ekp_facebook = data.ekp_facebook;
                this.ekp_twitter = data.ekp_twitter;
                this.ekp_instagram = data.ekp_instagram;
                this.ekp_telefon = data.ekp_telefon;

                this.ekp_resim = (data.ekp_resim != "") ? data.ekp_resim : "resim-yok.webp";
            });
        }
    }
}
</script>

<style scoped>

</style>
