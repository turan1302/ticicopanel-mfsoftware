<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Raporlar</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">approval</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Sertifikalar</span>
                                        <span class="widget-stats-amount">{{ sertifika_sayi }} Adet</span>
                                        <span class="widget-stats-info">Güncel Sayım</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                        <i class="material-icons-outlined">design_services</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Servisler</span>
                                        <span class="widget-stats-amount">{{ servis_sayi }} Adet</span>
                                        <span class="widget-stats-info">Güncel Sayım</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">email</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Mesajlar</span>
                                        <span class="widget-stats-amount">{{ mesaj_sayi }} Adet</span>
                                        <span class="widget-stats-info">Güncel Sayım</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-description">
                    <h1>Son 10 Mesaj</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th scope="col">E-Mail</th>
                                    <th scope="col">Telefon</th>
                                    <th scope="col">Konu</th>
                                    <th scope="col">Okundu Bilgisi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in son_10_mesaj">
                                    <th scope="row">{{ item.im_id }}</th>
                                    <td>{{ item.im_adsoyad }}</td>
                                    <td>{{ item.im_email }}</td>
                                    <td>{{ item.im_tel }}</td>
                                    <td>{{ item.im_konu }}</td>
                                    <td>
                                        <span :class="(item.im_okundu_bilgisi==1) ? okundu : okunmadi">visibility</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props : ["sertifika_sayi","servis_sayi","mesaj_sayi","son_10_mesaj"],
    name: "AdminHomeComponent",
    data(){
      return {
          son_10_mesaj : '',
          okundu : 'material-icons text-success',
          okunmadi : 'material-icons text-danger'
      }
    },
    mounted() {
        var son_10_mesaj = JSON.parse(this.$props.son_10_mesaj);
        this.son_10_mesaj = son_10_mesaj;
    }
}
</script>

<style scoped>

</style>
