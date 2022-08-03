<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Ekip Ekle</h1>
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


                                <form method="POST" @submit.prevent="yeniEkipEkle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">EKip İkon (500x800)</label>
                                            <input type="file" @change="ekipIkonSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input type="text" v-model="ekp_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Unvan</label>
                                            <input type="text" v-model="ekp_unvan" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Facebook</label>
                                            <input type="text" v-model="ekp_facebook" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Twitter</label>
                                            <input type="text" v-model="ekp_twitter" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Instagram</label>
                                            <input type="text" v-model="ekp_instagram" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Telefon</label>
                                            <input type="text" v-model="ekp_telefon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Yeni Ekle</button>
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
    name: "AdminEkipCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
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
    methods: {
        yeniEkipEkle() {
            this.errors = [];

            if (this.ekp_adsoyad == "") {
                this.errors.push("Ekip Ad Soyad Alanı Boş Bırakılamaz");
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/ekip/store";

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
        ekipIkonSec(e) {
            this.ekp_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
