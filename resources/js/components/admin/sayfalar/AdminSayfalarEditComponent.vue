<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Sayfa Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sayfa Güncelle</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="sayfaGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+sayfa_resim" :alt="sayfa_baslik">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Resim
                                                (570x669)</label>
                                            <input type="file" @change="sayfaResimSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Başlık</label>
                                            <input type="text" v-model="sayfa_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Kısa
                                                Açıklama</label>
                                            <textarea id="sayfa_kisa_aciklama" class="editor"
                                                      v-model="sayfa_kisa_aciklama"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Açıklama</label>
                                            <textarea type="text" id="sayfa_aciklama" class="editor"
                                                      v-model="sayfa_aciklama"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Seo Title</label>
                                            <input v-model="sayfa_title" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Seo
                                                Description</label>
                                            <input type="text" v-model="sayfa_description" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Keyword</label>
                                            <input type="text" v-model="sayfa_keyword"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sayfa Etiketler</label>
                                            <input type="text" v-model="sayfa_etiketler"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Güncelle</button>
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
    name: "AdminSayfalarEditComponent",
    props: ["geriye_don", "sayfa_id"],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            sayfa_resim: '',
            sayfa_baslik: '',
            sayfa_kisa_aciklama: '',
            sayfa_aciklama: '',
            sayfa_title: '',
            sayfa_description: '',
            sayfa_keyword: '',
            sayfa_etiketler: '',
            errors: [],
        }
    },
    mounted() {
        var sayfa_id = this.$props.sayfa_id;
        this.sayfaGetir(sayfa_id);  // DUYURU CEKILME ISLEMINI GETIRLEIM
    },
    methods: {
        sayfaGuncelle() {
            this.errors = [];

            if (this.sayfa_baslik == "") {
                this.errors.push("Sayfa Başlık Kısmı Boş Olamaz");
            }

            var kisa_aciklama = tinyMCE.get('sayfa_kisa_aciklama').getContent();  // SERVİS KISMI ACIKLAMASI
            if (kisa_aciklama == "") {
                this.errors.push("Sayfa Kısa Açıklama Kısmı Boş Olamaz");
            }

            var aciklama = tinyMCE.get('sayfa_aciklama').getContent();  // SERVİS KISMI ACIKLAMASI
            if (aciklama == "") {
                this.errors.push("Sayfa Açıklama Kısmı Boş Olamaz");
            }


            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {

                var id = this.$props.sayfa_id;
                var url = "http://127.0.0.1:8000/api/back/sayfalar/"+id+"/update";


                let formData = new FormData();

                var kisa_aciklama = tinyMCE.get('sayfa_kisa_aciklama').getContent();  // KISA ACIKLAMA
                var aciklama = tinyMCE.get('sayfa_aciklama').getContent();  // ACIKLAMA


                formData.append('sayfa_resim', this.sayfa_resim);
                formData.append('sayfa_baslik', this.sayfa_baslik);
                formData.append('sayfa_kisa_aciklama', kisa_aciklama);
                formData.append('sayfa_aciklama', aciklama);
                formData.append('sayfa_title', this.sayfa_title);
                formData.append('sayfa_description', this.sayfa_description);
                formData.append('sayfa_keyword', this.sayfa_keyword);
                formData.append('sayfa_etiketler', this.sayfa_etiketler);

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
        sayfaGetir(sayfa_id) {
            var url = "http://127.0.0.1:8000/api/back/sayfalar/" + sayfa_id + "/edit";
            axios.get(url).then((res) => {

                // DUYURU KISMI AYARLANMASI
                var data = res.data;
                this.sayfa_baslik = data.sayfa_baslik;
                this.sayfa_kisa_aciklama = data.sayfa_kisa_aciklama;
                this.sayfa_aciklama = data.sayfa_aciklama;
                this.sayfa_title = data.sayfa_title;
                this.sayfa_description = data.sayfa_description;
                this.sayfa_keyword = data.sayfa_keyword;
                this.sayfa_etiketler = data.sayfa_etiketler;

                this.sayfa_resim = (data.sayfa_resim != null && data.sayfa_resim != "") ? data.sayfa_resim : "resim-yok.webp";

            });
        },
        sayfaResimSec(e) {
            this.sayfa_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
