<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Sertifika Görüntüle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sertifika Bilgileri</h5>
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
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Başlık</label>
                                            <input readonly type="text" v-model="sr_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Açıklama</label>
                                            <textarea readonly class="form-control" v-model="sr_aciklama" rows="5"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Yıl</label>
                                            <input readonly type="date" v-model="sr_yil" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sertifika Derece</label>
                                            <input readonly type="number" min="0" max="100" v-model="sr_derece" class="form-control"
                                                   aria-describedby="emailHelp">
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
    name: "AdminSertifikalarEditComponent",
    props: ["geriye_don", "sr_id"],
    data() {
        return {
            sr_baslik: '',
            sr_aciklama: '',
            sr_yil: '',
            sr_derece: '',
            errors: [],
        }
    },
    mounted() {
        var sr_id = this.$props.sr_id;
      this.sertifikaGetir(sr_id);
    },
    methods: {
        sertifikaGetir(sr_id) {
            var url = "http://127.0.0.1:8000/api/back/sertifikalar/" + sr_id + "/show";
            axios.get(url).then((res) => {

                var data = res.data;
                this.sr_baslik = data.sr_baslik;
                this.sr_aciklama = data.sr_aciklama;
                this.sr_yil = data.sr_yil;
                this.sr_derece = data.sr_derece;
            });
        },
    }
}
</script>

<style scoped>

</style>
