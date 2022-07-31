<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Duyuru Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Duyuru Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniDuyuruEkle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Resim
                                                (1170x1012)</label>
                                            <input type="file" @change="duyuruResimSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Başlık</label>
                                            <input type="text" v-model="dil_ad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Varsayılan URL
                                                Kategori</label>
                                            <select class="form-control">
                                                <option v-for="(item,index) in duyuru_kategoriler">{{
                                                        item.dkat_ad
                                                    }}
                                                </option>
                                            </select>
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
    props: ["geriye_don", "duyuru_kategoriler"],
    data() {
        return {
            dil_ad: '',
            dil_kod: '',
            dil_ikon: '',
            errors: [],
        }
    },
    mounted() {
        this.$props.duyuru_kategoriler = JSON.parse(this.$props.duyuru_kategoriler);  // JSON VERISINI DUZENLEDIK
    },
    methods: {
        yeniDuyuruEkle() {
            this.errors = [];

            if (this.dil_ad == "") {
                this.errors.push("Dil Adı Alanı Boş Bırakılamaz");
            }

            if (this.dil_kod == "") {
                this.errors.push("Dil Kodu Alanı Boş Bırakılamaz")
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/language/store";

                let formData = new FormData();
                formData.append('dil_ad', this.dil_ad);
                formData.append('dil_kod', this.dil_kod);
                formData.append('dil_ikon', this.dil_ikon);

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
        duyuruResimSec(e) {
            this.dil_ikon = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
