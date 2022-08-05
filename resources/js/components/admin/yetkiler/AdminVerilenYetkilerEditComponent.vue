<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Verilen Yetkileri Güncelle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Verilen Yetki Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yetkiAyarGuncelle()" enctype="multipart/form-data">
                                    <div class="example-container">

                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Yetki Adı</th>
                                                <th scope="col">Aktiflik</th>
                                                <th scope="col">Listeleme</th>
                                                <th scope="col">Ekleme</th>
                                                <th scope="col">Güncelleme</th>
                                                <th scope="col">Görüntüleme</th>
                                                <th scope="col">Silme</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(index,item) in yetkiler">
                                                <th scope="row">{{ index }}</th>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][aktiflik]'" :checked="yetkiKontrol(item,'aktiflik')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][listeleme]'" :checked="yetkiKontrol(item,'listeleme')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][ekleme]'" :checked="yetkiKontrol(item,'ekleme')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][guncelleme]'" :checked="yetkiKontrol(item,'guncelleme')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][goruntuleme]'" :checked="yetkiKontrol(item,'goruntuleme')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input :name="'yetkiler[' + item + '][silme]'" :checked="yetkiKontrol(item,'silme')" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

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
    name: "AdminVerilenYetkilerEditComponent",
    props: ["geriye_don", "yt_id", "yetkiler"],
    data() {
        return {
            yt_baslik: '',
            yt_yetkiler : '',
            yetkiler: '',
            errors: [],
        }
    },
    mounted() {
        this.yetkiler = JSON.parse(this.$props.yetkiler);
        var yt_id = this.$props.yt_id;
        this.yetkiGetir(yt_id);

    },
    methods: {
        yetkiAyarGuncelle() {
            this.errors = [];

            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {
                var id = this.$props.yt_id;
                var url = "http://127.0.0.1:8000/api/back/yetkiler/" + id + "/verilen-yetki-guncelle";

                axios.post(url, {
                    yt_baslik: this.yt_baslik,
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
                this.yt_yetkiler = data.yt_yetkiler;
            });
        },
        yetkiKontrol(modul,yetki) {
            var yetki_data = JSON.parse(this.yt_yetkiler);
            if (yetki_data[modul]){
                if (yetki_data[modul][yetki]){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        }
    }
}
</script>

<style scoped>

</style>
