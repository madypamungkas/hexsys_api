@extends('layout.app')
@section('component','active')
@section('title')
    <h4><span class="font-weight-semibold">Master</span> - Komponen</h4>
@endsection

@section('breadcrumb')
    <a class="breadcrumb-item"><i class="icon-database mr-2"></i> Master</a>
    <span class="breadcrumb-item active">Komponen</span>
@endsection
@section('content')
<div class="card">
    <div class="col-md-12" style="padding-top:10px">
        <a href="{{route('component.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
            <b><i class="icon-add"></i></b> Tambah Komponen
        </a>
    </div>
    <table class="table" id="table-data">
        <thead>
            <tr>
                <th>ID</th>
                <th>Komponen</th>
                {{-- <th>Nilai</th> --}}
                <th>Group</th>
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
                url: "{{ url('table/data-component') }}",
                type: "GET",
            },

            columns: [
                {
                    data: "com_cd",
                    name: "com_cd",
                    visible: true
                },
                {
                    data: "code_nm",
                    name: "code_nm",
                    visible: true
                },
                // {
                //     data: "code_value",
                //     name: "code_value",
                //     visible: true
                // },
                {
                    data: "code_group",
                    name: "code_group",
                    visible: true
                },
                {
                    data: "action",
                    name: "action",
                    visible: true
                }
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
                url: "{{ url('delete/data-component') }}"+"/"+data['com_cd'],
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

        $('#role').select2({
            dropdownParent: $('#modal-create')
        });

    });
</script>
@endpush
