<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Müşteri Yorumları</h1>
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
                                        <th>Ad Soyad</th>
                                        <th>Unvan</th>
                                        <th>Resim</th>
                                        <th>Durum</th>
                                        <th>Dil Kod</th>
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
    name: "AdminMusteriYorumlarListComponent",
    props: ["yeni_ekle"],
    data() {
        return {}
    },
    mounted() {
        $(document).ready(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "http://127.0.0.1:8000/api/back/musteri-yorumlar",
                    error : function (error) {
                        console.log(error);
                    }
                },
                columns: [
                    {data: 'my_sira', name: 'my_sira', orderable: true},
                    {data: 'my_id', name: 'my_id'},
                    {data: 'my_adsoyad', name: 'my_adsoyad'},
                    {data: 'my_unvan', name: 'my_unvan'},
                    {data: 'my_resim', name: 'my_resim'},
                    {data: 'my_durum', name: 'my_durum'},
                    {data: 'my_dil_kod', name: 'my_dil_kod'},
                    {data: 'actions', name: 'actions'},
                ],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr("id", "item-" + aData.my_id);
                }

            });

            // DIL AKTIF PASIF KISMI AYARLANMASI
            $(".yajra-datatable").on("change",".isActive",function () {
                var id = $(this).data("id");
                var data = $(this).prop("checked");
                var url = "http://127.0.0.1:8000/api/back/musteri-yorumlar/"+id+"/is-active";

                axios.post(url,{
                    data : data
                });
            });

            // DIL SILME KISMI AYARLANMASINI GERCEKLESTIRELIM
            $(".yajra-datatable").on("click", ".isDelete", function () {
                var id = $(this).data("id");
                var url = "http://127.0.0.1:8000/api/back/language/" + id + "/delete";

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
                var url = "http://127.0.0.1:8000/api/back/musteri-yorumlar/rank-setter";

                axios.post(url,{
                    data : data
                });
            })
        });
    }
}
</script>

<style scoped>

</style>
