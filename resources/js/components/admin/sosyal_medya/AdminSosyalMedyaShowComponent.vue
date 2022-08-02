<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Sosyal Medya Görüntüle</h1>
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


                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya İkon</label>
                                            <input readonly type="text" v-model="sm_ikon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Başlık</label>
                                            <input readonly type="text" v-model="sm_name" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Sosyal Medya Link</label>
                                            <input readonly v-model="sm_link" class="form-control"
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
    name: "AdminSosyalMedyaShowComponent",
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
