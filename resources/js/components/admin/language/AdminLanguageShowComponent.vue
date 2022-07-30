<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Dil Görüntüle</h1>
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

                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Adı</label>
                                            <input readonly type="text" v-model="dil_ad" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Kodu</label>
                                            <input readonly type="text" v-model="dil_kod" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+dil_ikon" :alt="dil_ad">
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
    name: "AdminLanguageShowComponent",
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
        dilGetir(dil_id) {
            var url = "http://127.0.0.1:8000/api/back/language/" + dil_id + "/show";
            axios.get(url).then((res) => {
                var data = res.data;
                this.dil_ad = data.dil_ad;
                this.dil_kod = data.dil_kod;
                this.dil_ikon = (data.dil_ikon != null) ? data.dil_ikon : "resim-yok.webp";

            });
        }
    }
}
</script>

<style scoped>

</style>
