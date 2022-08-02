<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Slider Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Slider Bilgileri</h5>
                            </div>
                            <div class="card-body">


                                 <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Aktif Resim</label>
                                            <br>
                                            <img width="100" height="100" :src="site_url+''+sld_resim"
                                                 :alt="sld_ustbaslik">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Üst Başlık</label>
                                            <input readonly type="text" v-model="sld_ustbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Orta
                                                Başlık</label>
                                            <input readonly type="text" v-model="sld_ortabaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Alt Başlık</label>
                                            <input readonly type="text" v-model="sld_altbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Buton
                                                Başlık</label>
                                            <input readonly type="text" v-model="sld_butonbaslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Slider Buton Link</label>
                                            <input readonly type="text" v-model="sld_butonlink" class="form-control"
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
    name: "AdminSliderShowComponent",
    props: ["geriye_don", 'slider_id'],
    data() {
        return {
            site_url: 'http://127.0.0.1:8000/storage/',
            sld_resim: '',
            sld_ustbaslik: '',
            sld_ortabaslik: '',
            sld_altbaslik: '',
            sld_butonbaslik: '',
            sld_butonlink: '',
            errors: [],
        }
    },
    mounted() {
        var slider_id = this.$props.slider_id;
        this.sliderGetir(slider_id);
    },
    methods: {
        sliderGetir(slider_id) {
            var url = "http://127.0.0.1:8000/api/back/sliderlar/" + slider_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;

                this.sld_ustbaslik = data.sld_ustbaslik;
                this.sld_ortabaslik = data.sld_ortabaslik;
                this.sld_altbaslik = data.sld_altbaslik;
                this.sld_butonbaslik = data.sld_butonbaslik;
                this.sld_butonlink = data.sld_butonlink;


                this.sld_resim = (data.sld_resim != "") ? data.sld_resim : "resim-yok.webp";
            });
        }
    }
}
</script>

<style scoped>

</style>
