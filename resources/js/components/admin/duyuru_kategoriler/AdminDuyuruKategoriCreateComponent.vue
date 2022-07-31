<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni DUyuru Kategorisi Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Duyuru Kategori Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniDilEkle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Kategori Adı</label>
                                            <input type="text" v-model="dkat_ad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO Title</label>
                                            <input type="text" v-model="dkat_title" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO Description</label>
                                            <input type="text" v-model="dkat_description" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO Keywords</label>
                                            <input type="text" v-model="dkat_keyword" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Kategori Özelliği</label>
                                            <select v-model="dkat_silinebilir_kategori" class="form-control">
                                                <option value="1">Silinebilir Kategori</option>
                                                <option value="0">Silinemez Kategori</option>
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
    name: "AdminDuyuruKategoriCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
            dkat_ad: '',
            dkat_title: '',
            dkat_description: '',
            dkat_keyword: '',
            dkat_silinebilir_kategori : 1,
            errors: [],
        }
    },
    methods: {
        yeniDilEkle() {
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
        dilIkonSec(e) {
            this.dil_ikon = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
