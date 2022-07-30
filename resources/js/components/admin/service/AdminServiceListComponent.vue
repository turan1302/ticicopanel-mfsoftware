<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Diller</h1>
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
                                <h5 class="card-title">Diller</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered yajra-datatable" id="datatable1" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Sıra</th>
                                        <th>ID</th>
                                        <th>Başlık</th>
                                        <th>İkon</th>
                                        <th>Durum</th>
                                        <th>Dil Kodu</th>
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
    name: "AdminServiceListComponent",
    props: ["yeni_ekle"],
    data() {
        return {}
    },
    mounted() {
        $(document).ready(function () {

            $(".sortable").sortable();

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "http://127.0.0.1:8000/api/back/service",
                    error: function (e) {
                        console.log(e);
                    }
                },
                columns: [
                    {data: 'service_sira', name: 'service_sira', orderable: true},
                    {data: 'service_id', name: 'service_id'},
                    {data: 'service_baslik', name: 'service_baslik'},
                    {data: 'service_ikon', name: 'service_ikon'},
                    {data: 'service_durum', name: 'service_durum'},
                    {data: 'service_dil_kod', name: 'service_dil_kod'},
                    {data: 'actions', name: 'actions'},
                ],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr("id", "item-" + aData.service_id);
                }

            });
        });
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
