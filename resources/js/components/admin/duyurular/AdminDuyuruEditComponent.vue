<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Duyuru Güncelle</h1>
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


                                <form method="POST" @submit.prevent="duyuruGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+d_resim" :alt="d_baslik">
                                        </div>

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
                                            <select id="d_varsayilan_kategori"
                                                    class="form-control varsayilan">
                                                <option :selected="(d_varsayilan_kategori==item.dkat_id) ? true : null"
                                                        :value="item.dkat_id" v-for="item in duyuru_kategoriler">{{
                                                        item.dkat_ad
                                                    }}
                                                </option>
                                            </select>
                                        </div>


                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru
                                                Kategoriler</label>
                                            <select id="duyuru_kategoriler" v-model="d_varsayilan_kategori"
                                                    class="form-control kategori"
                                                    multiple="multiple">
                                                <option :value="item.dkat_id"
                                                        v-for="(item,index) in duyuru_kategoriler">{{
                                                        item.dkat_ad
                                                    }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Açıklama</label>
                                            <textarea type="text" id="d_aciklama" v-model="d_aciklama"
                                                      class="editor"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Seo Title</label>
                                            <input class="form-control" v-model="d_title" aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Seo
                                                Description</label>
                                            <input type="text" class="form-control" v-model="d_description"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Duyuru Keyword</label>
                                            <input v-model="d_keyword" type="text"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
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
    name: "AdminDuyuruEditComponent",
    props: ["geriye_don", "duyuru_kategoriler", "duyuru_id"],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            d_resim: '',
            d_baslik: '',
            d_aciklama: '',
            d_varsayilan_kategori: '',
            d_title: '',
            d_description: '',
            d_keyword: '',
            d_etiketler: '',
            errors: [],
        }
    },
    mounted() {
        this.$props.duyuru_kategoriler = JSON.parse(this.$props.duyuru_kategoriler);  // JSON VERISINI DUZENLEDIK

        var duyuru_id = this.$props.duyuru_id;
        this.duyuruGetir(duyuru_id);  // DUYURU CEKILME ISLEMINI GETIRLEIM
    },
    methods: {
        duyuruGuncelle() {
            this.errors = [];

            if (this.d_baslik == "") {
                this.errors.push("Duyuru Başlık Alanı Boş Bırakılamaz");
            }

            /** VARSAYILAN KATREGORI KISMININ ALINMASINI GERCEKLESTIERLIM  **/
            var d_varsayilan_kategori = $("#d_varsayilan_kategori").val();  // DUYURU VARSAYILAN KATEGIORI
            if (d_varsayilan_kategori == null || d_varsayilan_kategori == "") {
                this.errors.push("Duyuru Varsayılan Kategori Kısmı Boş Olamaz");
            }

            /** KATEGORI KSIMI AYARLANMASINI GERCEKLESTIERLEIM **/
            var duyuru_kategoriler = $("#duyuru_kategoriler").val();
            if (duyuru_kategoriler == null || duyuru_kategoriler == "") {
                this.errors.push("Duyuru Kategori Kısmı Boş Olamaz");
            }

            /** ACIKLAMA KISMI AYARLANAMSINI GERCEKLESTIELIM **/
            var d_aciklama = tinyMCE.get('d_aciklama').getContent();  // DUYURU KISMI ACIKLAMASI
            if (d_aciklama == "") {
                this.errors.push("Duyuru Açıklama Kısmı Boş Olamaz");
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var id = this.$props.duyuru_id;
                var url = "http://127.0.0.1:8000/api/back/duyurular/"+id+"/update";

                let formData = new FormData();

                formData.append('d_resim', this.d_resim);
                formData.append('d_baslik', this.d_baslik);
                formData.append('d_aciklama', d_aciklama);
                formData.append('d_varsayilan_kategori', d_varsayilan_kategori);
                formData.append('d_title', this.d_title);
                formData.append('d_description', this.d_description);
                formData.append('d_keyword', this.d_keyword);
                formData.append('d_etiketler', this.d_etiketler);
                formData.append('d_kategoriler', duyuru_kategoriler);  // DUYURU KATEGORILERINI ALALIM (COKLU KIISM)

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
                    });
                }).catch(function (error) {
                    if (error.response) {
                        console.log(error.response.data);
                    }
                });
            }
        },
        duyuruGetir(duyuru_id) {
            var url = "http://127.0.0.1:8000/api/back/duyurular/" + duyuru_id + "/edit";
            axios.get(url).then((res) => {

                // DUYURU KISMI AYARLANMASI
                var data = res.data[0];
                this.d_baslik = data.d_baslik;
                this.d_aciklama = data.d_aciklama;
                // this.d_varsayilan_kategori = data.d_varsayilan_kategori;      // bunu kapatalım kısa süreliğine
                this.d_title = data.d_title;
                this.d_description = data.d_description;
                this.d_keyword = data.d_keyword;
                this.d_etiketler = data.d_etiketler;

                $("#d_varsayilan_kategori").val(data.d_varsayilan_kategori).trigger('change');  // varsayılan kısmı ayarlanması

                this.d_resim = (data.d_resim != null && data.d_resim != "") ? data.d_resim : "resim-yok.webp";


                // DUYURU KATEGORI KISMI AYARLANMASI (COKLU KATEGORI)
                var kategori = res.data[1];
                var kategori_uzunluk = kategori.length;
                var kategori_data = "";
                for (var i = 0; i < kategori_uzunluk; i++) {
                    if (kategori[i].pdk_dkat_id != null) {
                        kategori_data += kategori[i].pdk_dkat_id+",";
                    }
                }
                kategori_data = kategori_data.split(",");  // DİZİ OLARKA PARÇALANMASINI ISTEDIK
                $("#duyuru_kategoriler").val(kategori_data).trigger('change');

            });
        },
        duyuruResimSec(e) {
            this.d_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
