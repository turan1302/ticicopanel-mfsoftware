<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Duyuru Kategorisi Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Duyuru Kategori Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <div class="example-container">
                                    <div class="example-content">
                                        <label for="exampleInputEmail1" class="form-label">Duyuru Kategori
                                            Adı</label>
                                        <input type="text" v-model="dkat_ad" class="form-control"
                                               aria-describedby="emailHelp">
                                    </div>

                                    <div class="example-content">
                                        <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO
                                            Title</label>
                                        <input type="text" v-model="dkat_title" class="form-control"
                                               aria-describedby="emailHelp">
                                    </div>

                                    <div class="example-content">
                                        <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO
                                            Description</label>
                                        <input type="text" v-model="dkat_description" class="form-control"
                                               aria-describedby="emailHelp">
                                    </div>

                                    <div class="example-content">
                                        <label for="exampleInputEmail1" class="form-label">Duyuru Kategori SEO
                                            Keywords</label>
                                        <input type="text" v-model="dkat_keyword" class="form-control"
                                               aria-describedby="emailHelp">
                                    </div>

                                    <div class="example-content">
                                        <label for="exampleInputEmail1" class="form-label">Kategori Özelliği</label>
                                        <select v-model="dkat_silinebilir_kategori" class="form-control">
                                            <option value="1">Silinebilir Kategori</option>
                                            <option value="0">Silinemez Kategori</option>
                                        </select>
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
    name: "AdminDuyuruKategoriShowComponent",
    props: ["geriye_don", "dkat_id"],
    data() {
        return {
            dkat_ad: '',
            dkat_title: '',
            dkat_description: '',
            dkat_keyword: '',
            dkat_silinebilir_kategori: 1,
            errors: [],
        }
    },
    mounted() {
        var dkat_id = this.$props.dkat_id;
        this.duyuruKategoriGetir(dkat_id);
    },
    methods: {
        duyuruKategoriGetir(dkat_id) {
            var url = "http://127.0.0.1:8000/api/back/duyuru-kategoriler/" + dkat_id + "/show";
            axios.get(url).then((res) => {
                var data = res.data;
                this.dkat_ad = data.dkat_ad;
                this.dkat_title = data.dkat_title;
                this.dkat_description = data.dkat_description;
                this.dkat_keyword = data.dkat_keyword;
                this.dkat_silinebilir_kategori = data.dkat_silinebilir_kategori;
            });
        }
    }
}
</script>

<style scoped>

</style>
