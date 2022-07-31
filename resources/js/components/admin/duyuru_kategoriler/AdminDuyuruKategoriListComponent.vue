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

            // DIL AKTIF PASIF KISMI AYARLANMASI
            $(".yajra-datatable").on("change",".isActive",function () {
                var id = $(this).data("id");
                var data = $(this).prop("checked");
                var url = "http://127.0.0.1:8000/api/back/duyuru-kategoriler/"+id+"/is-active";

                axios.post(url,{
                    data : data
                });
            });


            // VARSAYILAN KISMI AYARLANMASINI GERCEKLESTIREELIM
            $(".yajra-datatable").on("change",".isDefault",function () {
                var id = $(this).data("id");
                var data = $(this).prop("checked");
                var url = "http://127.0.0.1:8000/api/back/duyuru-kategoriler/"+id+"/is-default";


                axios.post(url,{
                    data : data
                }).then((res)=>{
                    location.reload();
                });
            });


            // DUYURU SILME KISMI AYARLANMASINI GERCEKLESTIRELIM
            $(".yajra-datatable").on("click", ".isDelete", function () {
                var id = $(this).data("id");
                var url = "http://127.0.0.1:8000/api/back/duyuru-kategoriler/" + id + "/delete";

                Swal.fire({
                    title: 'Dikkat!',
                    text: "Kayıt Silinecektir. Onaylıyor Musunuz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, Kaydı Sil',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get(url).then((res) => {
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
                })
            });

            // SORTABLE JS KISMINI AYARLAYALIM
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function () {
                var data = $(this).sortable("serialize");
                var url = "http://127.0.0.1:8000/api/back/duyuru-kategoriler/rank-setter";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        data: data
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            })

        });
    },
    methods : {

    }
}
</script>

<style scoped>

</style>
