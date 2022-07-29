<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Yeni Dil Ekle</h1>
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
                                <form method="POST">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Adı</label>
                                            <input type="text" v-model="dil_adi" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil Kodu</label>
                                            <input type="text"  v-model="dil_kodu" class="form-control"
                                                   aria-describedby="emailHelp">
                                        </div>
                                        <div class="example-content">
                                            <label for="exampleInputEmail1" class="form-label">Dil İkon</label>
                                            <input type="file" class="form-control"
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
    name: "AdminLanguageCreateComponent",
    props : ["geriye_don"],
    data() {
        return {
            dil_adi : '',
            dil_kodu : '',
            dil_ikon : ''
        }
    },
    mounted() {

    },
    methods : {

    }
}
</script>

<style scoped>

</style>
