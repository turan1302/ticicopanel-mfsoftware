<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Menü Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Menü Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="menuGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Menü Başlık</label>
                                            <input type="text" v-model="menu_baslik" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Menü Link</label>
                                            <input type="text" v-model="menu_link" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Üst Menü</label>
                                            <select id="menu_ust_id" class="form-control menu_ust_id">
                                                <option :value="item.menu_id" v-for="(item,index) in menuler">{{
                                                        item.menu_baslik
                                                    }}
                                                </option>
                                            </select>
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
    name: "AdminServiceCreateComponent",
    props: ["geriye_don", "menu_id","menuler"],
    data() {
        return {
            menu_baslik: '',
            menu_link: '',
            errors: [],
        }
    },
    mounted() {
        this.$props.menuler = JSON.parse(this.$props.menuler);
        var menu_id = this.$props.menu_id;
        this.menuGetir(menu_id);
    },
    methods: {
        menuGuncelle() {
            this.errors = [];

            if (this.service_baslik == "") {
                this.errors.push("Servis Başlık Kısmı Boş Olamaz");
            }

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.service_id;
                var url = "http://127.0.0.1:8000/api/back/menuler/" + id + "/update";

                var menu_ust_id = $("#menu_ust_id").val(); // UST KATEGORI ID NUMRASINI ALDIRDIK

                axios.post(url, {
                    menu_baslik: this.menu_baslik,
                    menu_link: this.menu_link,
                    menu_ust_id: menu_ust_id,  // MENU UST ID NUMARASI
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
                }).catch(function (error) {
                    console.log(error.response);
                });
            }
        },
        menuGetir(menu_id) {
            var url = "http://127.0.0.1:8000/api/back/menuler/" + menu_id + "/edit";
            axios.get(url).then((res) => {
                var data = res.data;
                this.menu_baslik = data.menu_baslik;
                this.menu_link = data.menu_link;

                $("#menu_ust_id").val(data.menu_ust_id).trigger('change');  // MENU UST KISMI AYARLANMASI

            });
        },
    }
}
</script>

<style scoped>

</style>
