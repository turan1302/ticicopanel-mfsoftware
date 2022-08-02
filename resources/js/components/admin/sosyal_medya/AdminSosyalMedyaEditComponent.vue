<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Sosyal Medya Güncelle</h1>
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


                                <form method="POST" @submit.prevent="servisGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya İkon</label>
                                            <input type="text" v-model="sm_ikon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Başlık</label>
                                            <input type="text" v-model="sm_name" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Link</label>
                                            <input v-model="sm_link" class="form-control"
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
    name: "AdminSosyalMedyaEditComponent",
    props: ["geriye_don", "sosyal_medya_id"],
    data() {
        return {
            sm_ikon: '',
            sm_name: '',
            sm_link: '',
            errors: [],
        }
    },
    mounted() {
        var sosyal_medya_id = this.$props.sosyal_medya_id;
      this.sosyalMedyaGetir(sosyal_medya_id);
    },
    methods: {
        servisGuncelle() {
            this.errors = [];

            if (this.service_baslik == "") {
                this.errors.push("Servis Başlık Kısmı Boş Olamaz");
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.sosyal_medya_id;
                var url = "http://127.0.0.1:8000/api/back/sosyal-medya/"+id+"/update";
                axios.post(url, {
                    sm_ikon: this.sm_ikon,
                    sm_name: this.sm_name,
                    sm_link: this.sm_link,
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
        sosyalMedyaGetir(sosyal_medya_id) {
            var url = "http://127.0.0.1:8000/api/back/sosyal-medya/" + sosyal_medya_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.sm_ikon = data.sm_ikon;
                this.sm_name = data.sm_name;
                this.sm_link = data.sm_link;
            });
        },
    }
}
</script>

<style scoped>

</style>
