<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yetki Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Yetki Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yetkiGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Yetki Başlık</label>
                                            <input type="text" v-model="yt_baslik" class="form-control"
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
    name: "AdminYetkilerEditComponent",
    props: ["geriye_don", "yt_id"],
    data() {
        return {
            yt_baslik : '',
            errors: [],
        }
    },
    mounted() {
        var yt_id = this.$props.yt_id;
      this.yetkiGetir(yt_id);
    },
    methods: {
        yetkiGuncelle() {
            this.errors = [];

            if (this.yt_baslik == "") {
                this.errors.push("Yetki Başlık Kısmı Boş Olamaz");
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.yt_id;
                var url = "http://127.0.0.1:8000/api/back/yetkiler/"+id+"/update";

                axios.post(url, {
                   yt_baslik : this.yt_baslik,
                }).then((res) => {
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
        yetkiGetir(yt_id) {
            var url = "http://127.0.0.1:8000/api/back/yetkiler/" + yt_id + "/edit";
            axios.get(url).then((res) => {

                var data = res.data;
                this.yt_baslik = data.yt_baslik;
            });
        },
    }
}
</script>

<style scoped>

</style>
