<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Müşteri Yorum Görüntüle</h1>
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


                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+my_resim" :alt="my_adsoyad">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
                                            <input readonly type="text" v-model="my_adsoyad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Ünvan</label>
                                            <input readonly type="text" v-model="my_unvan" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Müşteri Yorum</label>
                                            <textarea type="text" id="my_aciklama" class="editor" v-model="my_aciklama"></textarea>
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
    name: "AdminMusteriYorumlarShowComponent",
    props: ["geriye_don", 'my_id'],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            my_resim: '',
            my_adsoyad: '',
            my_unvan: '',
            my_aciklama: '',
            errors: [],
        }
    },
    mounted() {
        var my_id = this.$props.my_id;
        this.musteriYorumGetir(my_id);
    },
    methods: {
        musteriYorumGetir(my_id) {
            var url = "http://127.0.0.1:8000/api/back/musteri-yorumlar/" + my_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.my_adsoyad = data.my_adsoyad;
                this.my_unvan = data.my_unvan;
                this.my_aciklama = data.my_aciklama;

                this.my_resim = (data.my_resim != "") ? data.my_resim : "resim-yok.webp";

            });
        },
        musteriYorumIkonSec(e) {
            this.my_resim = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
