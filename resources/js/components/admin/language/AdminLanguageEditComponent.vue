<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Dİl Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Dil Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="dilGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Adı</label>
                                            <input type="text" v-model="dil_ad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Kodu</label>
                                            <input type="text" v-model="dil_kod" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+dil_ikon" :alt="dil_ad">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil İkon (50x50)</label>
                                            <input type="file" @change="dilIkonSec" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Dil Güncelle</button>
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
    props: ["geriye_don", 'dil_id'],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            dil_ad: '',
            dil_kod: '',
            dil_ikon: '',
            errors: [],
        }
    },
    mounted() {
        var dil_id = this.$props.dil_id;
        this.dilGetir(dil_id);
    },
    methods: {
        dilGuncelle() {
            this.errors = [];

            if (this.dil_ad == "") {
                this.errors.push("Dil Adı Alanı Boş Bırakılamaz");
            }

            if (this.dil_kod == "") {
                this.errors.push("Dil Kodu Alanı Boş Bırakılamaz")
            }

            /** EĞER HATA YOK ISE **/
            if (this.errors.length == 0) {
                var id = this.$props.dil_id;
                var url = "http://127.0.0.1:8000/api/back/language/"+id+"/update";

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
        dilGetir(dil_id) {
            var url = "http://127.0.0.1:8000/api/back/language/" + dil_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;
                this.dil_ad = data.dil_ad;
                this.dil_kod = data.dil_kod;
                this.dil_ikon = (data.dil_ikon != null) ? data.dil_ikon : "resim-yok.webp";

            });
        },
        dilIkonSec(e) {
            this.dil_ikon = e.target.files[0]; //  RESIM EKLETME ISLEMI
        }
    }
}
</script>

<style scoped>

</style>
