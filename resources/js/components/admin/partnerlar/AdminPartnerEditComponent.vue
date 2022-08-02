<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Partner Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Partner Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="partnerGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+part_resim"
                                                 :alt="part_baslik">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Partner Resim
                                                (196x110)</label>
                                            <input type="file" @change="partnerIkonSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Partner Başlık</label>
                                            <input v-model="part_baslik" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Partner Açıklama</label>
                                            <textarea type="text" id="part_aciklama" v-model="part_aciklama" class="editor"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Link</label>
                                            <input v-model="part_link" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Seo Title</label>
                                            <input v-model="part_title" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Seo Description</label>
                                            <input v-model="part_description" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Seo Keyword</label>
                                            <input v-model="part_keyword" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Etiketler</label>
                                            <input v-model="part_etiketler" type="text" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Partner Güncelle
                                                </button>
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
    props: ["geriye_don", 'partner_id'],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            part_resim: '',
            part_baslik: '',
            part_aciklama: '',
            part_link: '',
            part_title: '',
            part_description: '',
            part_keyword: '',
            part_etiketler: '',
            errors: [],
        }
    },
    mounted() {
        var partner_id = this.$props.partner_id;
        this.partnerGetir(partner_id);
    },
    methods: {
        partnerGuncelle() {
            this.errors = [];

            if (this.part_baslik == "") {
                this.errors.push("Parnet Başlık Alanı Boş Bırakılamaz");
            }


            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var id = this.$props.partner_id;
                var url = "http://127.0.0.1:8000/api/back/partnerlar/" + id + "/update";

                var part_aciklama = tinyMCE.get('part_aciklama').getContent();  // AÇIKLAMA KISMININ ALINMASI

                let formData = new FormData();
                formData.append('part_resim', this.part_resim);
                formData.append('part_baslik', this.part_baslik);
                formData.append('part_aciklama', part_aciklama);
                formData.append('part_link', this.part_link);
                formData.append('part_title', this.part_title);
                formData.append('part_description', this.part_description);
                formData.append('part_keyword', this.part_keyword);
                formData.append('part_etiketler', this.part_etiketler);


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
        partnerGetir(partner_id) {
            var url = "http://127.0.0.1:8000/api/back/partnerlar/" + partner_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.part_baslik = data.part_baslik;
                this.part_aciklama = data.part_aciklama;
                this.part_link = data.part_link;
                this.part_title = data.part_title;
                this.part_description = data.part_description;
                this.part_keyword = data.part_keyword;
                this.part_etiketler = data.part_etiketler;


                this.part_resim = (data.part_resim != "") ? data.part_resim : "resim-yok.webp";
            });
        },
        partnerIkonSec(e) {
            this.part_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
