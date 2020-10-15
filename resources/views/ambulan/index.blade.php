@extends('layout.app')
@section('ambulan','active')
@section('title')
    <h4><span class="font-weight-semibold">Main</span> - Ambulan</h4>
@endsection

@section('breadcrumb')
    <a class="breadcrumb-item"><i class="icon-database mr-2"></i> Main</a>
    <span class="breadcrumb-item active">Ambulan</span>
@endsection
@section('content')
<div class="card">
    <div class="col-md-12 row mt-2 ml-1">
        <div class="col-md-3">
            <select data-placeholder="Pilih status" multiple="multiple" class="form-control select" name="filter_status[]" id="filter_status" data-fouc>
                <option value=""></option>
                @foreach (\App\Component::where('code_group','STATUS_AMBULAN')->get()->sortBy('code_nm') as $value)
                    <option value="{{$value->com_cd}}"}}>{{$value->code_nm}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-9">
            <select data-placeholder="Pilih Instansi" multiple="multiple" class="form-control select" name="filter_instansi[]" id="filter_instansi" data-fouc>
                <option value=""></option>
                @foreach (\App\Instansi::get()->sortBy('nama') as $value)
                    <option value="{{$value->instansi_id}}"}}>{{$value->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12 mt-2 ml-2">
        <a href="{{route('ambulan.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
            <b><i class="icon-add"></i></b> Tambah Ambulan
        </a>
    </div>
    <table class="table" id="table-data">
        <thead>
            <tr>
                <th>ID</th>
                <th style="width:1px">No</th>
                <th>Instansi</th>
                <th>Plat Nomor</th>
                <th>Nama Sopir</th>
                {{-- <th>No Telepon</th> --}}
                {{-- <th>Merk</th> --}}
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
        $('#filter_instansi').change(function() {
            tableData.draw(true);
        });
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
                url: "{{ url('table/data-ambulan') }}",
                type: "GET",
                data: function (d) {
                    d.filter_instansi    = $('#filter_instansi').val(),
                    d.filter_status    = $('#filter_status').val()
                }
            },

            columns: [
                {data: "ambulan_id", name: "ambulan_id",visible: false},
                {data: "DT_RowIndex",name: "DT_RowIndex",visible: true},
                {data: "instansi.nama",name: "instansi.nama",visible: true},
                {data: "plat_nomor",name: "plat_nomor",visible: true},
                {data: "nama_sopir",name: "nama_sopir",visible: true},
                // {data: "nomor_telepon",name: "nomor_telepon",visible: true},
                // {data: "merk",name: "merk",visible: true},
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
                url: "{{ url('delete/data-ambulan') }}"+"/"+data['ambulan_id'],
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
                text: "Anda yakin untuk mengubah status ambulan?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                url: "{{ url('table/data-ambulan/update-status') }}"+"/"+data['ambulan_id'],
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
