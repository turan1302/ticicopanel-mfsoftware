<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Sosyal Medya Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sosyal Medya Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniSosyalMedyaEkle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya İkon</label>
                                            <input type="text" v-model="service_ikon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Başlık</label>
                                            <input type="text" v-model="service_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Link</label>
                                            <input v-model="service_title" class="form-control"
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
    name: "AdminServiceCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
            service_ikon: '',
            service_baslik: '',
            service_aciklama: '',
            service_title: '',
            service_description: '',
            service_keyword: '',
            service_etiketler: '',
            errors: [],
        }
    },
    methods: {
        yeniSosyalMedyaEkle() {
            this.errors = [];

            if (this.service_baslik == "") {
                this.errors.push("Servis Başlık Kısmı Boş Olamaz");
            }



            /** EĞER HERHANGI BIR HATA YOKSA **/
            // if (this.errors.length == 0) {
            //
            //     var url = "http://127.0.0.1:8000/api/back/service/store";
            //
            //     axios.post(url, {
            //         service_ikon: this.service_ikon,
            //         service_baslik: this.service_baslik,
            //         service_aciklama: aciklama,  // SERVIS KISMI ACIKLAMASI
            //         service_title: this.service_title,
            //         service_description: this.service_description,
            //         service_keyword: this.service_keyword,
            //         service_etiketler: this.service_etiketler,
            //     }).then((res) => {
            //         var data = res.data;
            //         Swal.fire({
            //             icon: data.type,
            //             title: data.title,
            //             text: data.text,
            //             showConfirmButton: false,
            //             timer: 1500
            //         }).then(() => {
            //             location.reload();
            //         })
            //     });
            //
            // }
        }
    }
}
</script>

<style scoped>

</style>
