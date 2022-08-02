<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Slider Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Slider Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniSliderEkle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Resim Sec (690x690)</label>
                                            <input type="file" @change="sliderResimSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Üst Başlık</label>
                                            <input type="text" v-model="sld_ustbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Orta Başlık</label>
                                            <input type="text" v-model="sld_ortabaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Alt Başlık</label>
                                            <input type="text" v-model="sld_altbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Buton Başlık</label>
                                            <input type="text" v-model="sld_butonbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Buton Link</label>
                                            <input type="text" v-model="sld_butonlink" class="form-control"
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
    name: "AdminLanguageCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
            sld_resim : '',
            sld_ustbaslik : '',
            sld_ortabaslik : '',
            sld_altbaslik : '',
            sld_butonbaslik : '',
            sld_butonlink : '',
            dil_kod: '',
            dil_ikon: '',
            errors: [],
        }
    },
    methods: {
        yeniSliderEkle() {
            this.errors = [];

            if (this.sld_ustbaslik == "") {
                this.errors.push("Üst Başlık Alanı Boş Bırakılamaz");
            }

            if (this.sld_ortabaslik == "") {
                this.errors.push("Dil Kodu Alanı Boş Bırakılamaz")
            }

            if (this.sld_altbaslik == "") {
                this.errors.push("Dil Kodu Alanı Boş Bırakılamaz")
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/sliderlar/store";

                let formData = new FormData();
                formData.append('sld_resim', this.sld_resim);
                formData.append('sld_ustbaslik', this.sld_ustbaslik);
                formData.append('sld_ortabaslik', this.sld_ortabaslik);
                formData.append('sld_altbaslik', this.sld_altbaslik);
                formData.append('sld_butonbaslik', this.sld_altbaslik);
                formData.append('sld_butonlink', this.sld_altbaslik);

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
        sliderResimSec(e) {
            this.sld_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
