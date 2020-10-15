@extends('layout.app')
@section('instansi','active')
@section('title')
    <h4><span class="font-weight-semibold">Main</span> - Instansi</h4>
@endsection

@section('breadcrumb')
    <a class="breadcrumb-item"><i class="icon-database mr-2"></i> Main</a>
    <span class="breadcrumb-item active">Instansi</span>
@endsection
@section('content')
<div class="card">
    <div class="col-md-12 row ml-1" style="padding-top:10px">
        <div class="col-md-3">
            <a href="{{route('instansi.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-add"></i></b> Tambah Instansi
            </a>
        </div>
        <div class="offset-6 col-md-3">
            <select data-placeholder="Pilih status" multiple="multiple" class="form-control select" name="filter_status[]" id="filter_status" data-fouc>
                <option value=""></option>
                @foreach (\App\Component::where('code_group','STATUS_INSTANSI')->get()->sortBy('code_nm') as $value)
                    <option value="{{$value->com_cd}}"}}>{{$value->code_nm}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <table class="table" id="table-data">
        <thead>
            <tr>
                <th>ID</th>
                <th style="width:1px">No</th>
                <th>Instansi</th>
                <th>Email</th>
                <th>Waktu Operasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<!-- /basic responsive configuration -->

@endsection @push('after_script')
<script>
    var tableData, id;
    $(document).ready(function () {
        $('#filter_status').change(function() {
            tableData.draw(true);
        });
        tableData = $("#table-data").DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                }
            },
            ajax: {
                url: "{{ url('table/data-instansi') }}",
                type: "GET",
                data: function (d) {
                    d.filter_status    = $('#filter_status').val()
                }
            },

            columns: [
                {data: "instansi_id", name: "instansi_id",visible: false},
                {data: "DT_RowIndex",name: "DT_RowIndex",visible: true},
                {data: "nama",name: "nama",visible: true},
                {data: "user.email",name: "user.email",visible: true},
                {data: "waktu_operasi",name: "waktu_operasi",visible: true},
                {data: "status",name: "status",visible: true},
                {data: "action",name: "action",visible: true},
            ]
        });


        /* delete data */
        $("#table-data tbody").on("click", "#btn-delete", function () {
            var data = tableData.row($(this).parents("tr")).data();
            swal({
                text: "Anda yakin ingin menghapus data?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                url: "{{ url('delete/data-instansi') }}"+"/"+data['instansi_id'],
                method: 'get',
                success: function(result){
                    if (result.status == 'success') {
                    tableData.ajax.reload();
                    swal("Data berhasil dihapus.", {
                        icon: "success",
                    });
                    } else {
                    swal(result.message, {
                        icon: "error",
                    });
                    }
                }
                });
            } else {
                swal("Data anda aman.");
            }
            });
        });

        /* ubah status */
        $("#table-data tbody").on("click", "#btn-status", function () {
            var data = tableData.row($(this).parents("tr")).data();
            swal({
                text: "Anda yakin untuk mengubah status instansi?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                url: "{{ url('table/data-instansi/update-status') }}"+"/"+data['instansi_id'],
                method: 'get',
                success: function(result){
                    if (result.status == 'success') {
                    tableData.ajax.reload();
                    swal("Status berhasil diubah.", {
                        icon: "success",
                    });
                    } else {
                    swal(result.message, {
                        icon: "error",
                    });
                    }
                }
                });
            } 
            });
        });
    });
</script>
@endpush
