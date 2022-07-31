<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Duyuru Kategorileri</h1>
                            </div>
                            <div class="page-description-actions">
                                <a :href="yeni_ekle" class="btn btn-primary"><i class="material-icons">add</i> Yeni Ekle</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Duyuru Kategorileri</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered yajra-datatable" id="datatable1" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Sıra</th>
                                        <th>ID</th>
                                        <th>Kategori Adı</th>
                                        <th>Kategori Durum</th>
                                        <th>Kategori Varsayılan</th>
                                        <th>Dil</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody class="sortable">
                                    </tbody>
                                </table>
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
    name: "AdminDuyuruKategoriListComponent",
    props: ["yeni_ekle"],
    data() {
        return {

        }
    },
    mounted() {
        $(document).ready(function () {

            $(".sortable").sortable();

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "http://127.0.0.1:8000/api/back/duyuru-kategoriler",
                    error: function (e) {
                        console.log(e);
                    }
                },
                columns: [
                    {data: 'dkat_sira', name: 'dkat_sira', orderable: true},
                    {data: 'dkat_id', name: 'dkat_id'},
                    {data: 'dkat_ad', name: 'dkat_ad'},
                    {data: 'dkat_durum', name: 'dkat_durum'},
                    {data: 'dkat_varsayilan_kategori', name: 'dkat_varsayilan_kategori'},
                    {data: 'dkat_dil_kod', name: 'dkat_dil_kod'},
                    {data: 'actions', name: 'actions'},
                ],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr("id", "item-" + aData.dkat_id);
                }

            });

        });
    },
    methods : {

    }
}
</script>

<style scoped>

</style>
