<template>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Diller</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered yajra-datatable" id="datatable1" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Başlık</th>
                                        <th>Kod</th>
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
    name: "AdminLanguageListComponent",
    data(){
        return {

        }
    },
    mounted(){
        $(document).ready(function () {

            $(".sortable").sortable();

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "http://127.0.0.1:8000/api/back/language",
                    error : function (e){
                        console.log(e);
                    }
                },
                columns: [
                    {data: 'dil_id', name: 'dil_id'},
                    {data: 'dil_ad', name: 'dil_ad'},
                    {data: 'dil_kod', name: 'dil_kod'},
                ],
                "fnCreatedRow" : function (nRow,aData,iDataIndex) {
                    $(nRow).attr("id","item-"+aData.dil_id);
                }

            });


            // SORTABLE JS KISMINI AYARLAYALIM
            $(".sortable").sortable();
            $(".sortable").on("sortupdate",function () {
                var data = $(this).sortable("serialize");
                var url = "http://127.0.0.1:8000/api/back/language/rank-setter";
                $.ajax({
                    type : "POST",
                    url : url,
                    data : {
                        data : data
                    },
                    error : function (e){
                        console.log(e);
                    }
                });
            })
        });
    }
}
</script>

<style scoped>

</style>
