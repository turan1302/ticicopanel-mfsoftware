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
                                            <input type="text" v-model="d_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Varsayılan URL
                                                Kategori</label>
                                            <select v-model="d_varsayilan_kategori" class="form-control varsayilan">
                                                <option v-for="(item,index) in duyuru_kategoriler">{{
                                                        item.dkat_ad
                                                    }}
                                                </option>
                                            </select>
                                        </div>


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Kategori</label>
                                            <select class="form-control kategori" multiple="multiple">
                                                <option v-for="(item,index) in duyuru_kategoriler">{{
                                                        item.dkat_ad
                                                    }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Açıklama</label>
                                            <textarea type="text" id="d_aciklama"  v-model="d_aciklama" class="editor"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Seo Title</label>
                                            <input class="form-control" v-model="d_title" aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Seo Description</label>
                                            <input type="text" class="form-control" v-model="d_description"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Keyword</label>
                                            <input v-model="d_keyword" type="text" placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Etiketler</label>
                                            <input type="text" v-model="d_etiketler"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
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
    name: "AdminDuyuruCreateComponent",
    props: ["geriye_don", "duyuru_kategoriler"],
    data() {
        return {
            d_baslik: '',
            d_aciklama : '',
            d_varsayilan_kategori : '',
            d_title : '',
            d_description : '',
            d_keyword : '',
            d_etiketler : '',
            errors: [],
        }
    },
    mounted() {
        this.$props.duyuru_kategoriler = JSON.parse(this.$props.duyuru_kategoriler);  // JSON VERISINI DUZENLEDIK
    },
    methods: {
        yeniDuyuruEkle() {


            this.errors = [];

            if (this.d_baslik == "") {
                this.errors.push("Duyuru Başlık Alanı Boş Bırakılamaz");
            }

            var aciklama = tinyMCE.get('d_aciklama').getContent();  // DUYURU KISMI ACIKLAMASI

            if (aciklama == "") {
                this.errors.push("Duyuru Açıklama Kısmı Boş Olamaz");
            }


            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var url = "http://127.0.0.1:8000/api/back/duyurular/store";

                let formData = new FormData();
                formData.append('d_baslik', this.d_baslik);
                formData.append('d_aciklama', aciklama);
                formData.append('d_varsayilan_kategori', this.d_varsayilan_kategori);
                formData.append('d_title', this.d_title);
                formData.append('d_description', this.d_description);
                formData.append('d_keyword', this.d_keyword);
                formData.append('d_etiketler', this.d_etiketler);

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
                    }).catch(function (error) {
                        console.log(error.response);
                    });
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
