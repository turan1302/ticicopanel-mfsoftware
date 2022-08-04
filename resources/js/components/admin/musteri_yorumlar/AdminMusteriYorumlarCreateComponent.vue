<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Müşteri Yorumu Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Müşteri Yorum Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniMusteriYorumuEkle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Müşteri İkon (350x350)</label>
                                            <input type="file" @change="musteriIkonSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input type="text" v-model="my_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ünvan</label>
                                            <input type="text" v-model="my_unvan" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Müşteri Yorum</label>
                                            <textarea type="text" id="my_aciklama" class="editor" v-model="my_aciklama"></textarea>
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
    name: "AdminMusteriYorumlarCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
            my_resim: '',
            my_adsoyad: '',
            my_unvan: '',
            my_aciklama: '',
            errors: [],
        }
    },
    methods: {
        yeniMusteriYorumuEkle() {
            this.errors = [];

            if (this.my_adsoyad == "") {
                this.errors.push("Dil Adı Alanı Boş Bırakılamaz");
            }

            var my_aciklama = tinyMCE.get('my_aciklama').getContent();  // SERVİS KISMI ACIKLAMASI
            if (my_aciklama == "") {
                this.errors.push("Müşteri Yorum Kısmı Boş Olamaz");
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/musteri-yorumlar/store";

                let formData = new FormData();

                formData.append('my_resim', this.my_resim);
                formData.append('my_adsoyad', this.my_adsoyad);
                formData.append('my_unvan', this.my_unvan);
                formData.append('my_aciklama', my_aciklama);

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
        musteriIkonSec(e) {
            this.my_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
