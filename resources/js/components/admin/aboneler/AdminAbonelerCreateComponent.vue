<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Abone Ekle</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Abone Bilgileri</h5>
                            </div>
                            <div class="card-body">

                                <!-- HATA KISMI AYARLANMASI -->
                                <div v-if="errors.length > 0" class="col-md-12 alert alert-danger text-center">
                                    <ul v-for="item in errors">
                                        <li>{{ item }}</li>
                                    </ul>
                                </div>


                                <form method="POST" @submit.prevent="yeniAboneEkle()" enctype="multipart/form-data">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Abone Mail</label>
                                            <input type="text" v-model="abone_email" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>

                                        <div class="row">
                                            <div class="example-component m-2">
                                                <button type="submit" class="btn btn-success btn-md"> Yeni Ekle</button>
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
    name: "AdminAbonelerCreateComponent",
    props: ["geriye_don"],
    data() {
        return {
            abone_email: '',
            errors: [],
        }
    },
    methods: {
        yeniAboneEkle() {
            this.errors = [];

            if (this.abone_email == "") {
                this.errors.push("Abone Mail Kısmı Boş Olamaz");
            }

            if (this.abone_email != ""){
                if (this.ValidateEmail(this.abone_email)==false){
                    this.errors.push("Lütfen Geçerli Bir Mail Giriniz");
                }
            }


            /** EĞER HERHANGI BIR HATA YOKSA **/
            if (this.errors.length == 0) {

                var url = "http://127.0.0.1:8000/api/back/aboneler/store";

                axios.post(url, {
                    abone_email: this.abone_email,
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
        ValidateEmail(inputText){
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(inputText.match(mailformat))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
</script>

<style scoped>

</style>
