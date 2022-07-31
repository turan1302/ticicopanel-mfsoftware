<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Servis Görüntüle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Servis Bilgileri</h5>
                            </div>
                            <div class="card-body">


                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis İkon</label>
                                            <input readonly type="text" v-model="service_ikon" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Başlık</label>
                                            <input readonly type="text" v-model="service_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Açıklama</label>
                                            <textarea type="text" id="service_aciklama" class="editor"
                                                      v-model="service_aciklama"></textarea>
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Seo Title</label>
                                            <input readonly v-model="service_title" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Seo
                                                Description</label>
                                            <input readonly type="text" v-model="service_description" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Keyword</label>
                                            <input readonly type="text" v-model="service_keyword"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Servis Etiketler</label>
                                            <input readonly type="text" v-model="service_etiketler"
                                                   placeholder="Aralarına Virgül Koyarak Yazınız" class="form-control"
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
    name: "AdminServiceShowComponent",
    props: ["geriye_don", "service_id"],
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
    mounted() {
        var service_id = this.$props.service_id;
      this.servisGetir(service_id);
    },
    methods: {
        servisGetir(service_id) {
            var url = "http://127.0.0.1:8000/api/back/service/" + service_id + "/show";
            axios.get(url).then((res) => {

                var data = res.data;
                this.service_ikon = data.service_ikon;
                this.service_baslik = data.service_baslik;
                this.service_aciklama = data.service_aciklama;
                this.service_title = data.service_title;
                this.service_description = data.service_description;
                this.service_keyword = data.service_keyword;
                this.service_etiketler = data.service_etiketler;
            });
        },
    }
}
</script>

<style scoped>

</style>
