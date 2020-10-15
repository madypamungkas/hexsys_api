@extends('layout.app')
@section('component','active')
@section('title')
    <h4>
        <a href="{{route('component.index')}}"><i class="text-default icon-arrow-left52 mr-2"></a></i>
        <span class="font-weight-semibold">Master</span> - Ubah Komponen
    </h4>
@endsection

@section('breadcrumb')
    <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Master</a>
    <span class="breadcrumb-item"><a href="{{route('component.index')}}" class="text-default"> Komponen </a></span>
    <span class="breadcrumb-item active">Ubah</span>
@endsection
@section('content')
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" action="{{route('component.update',$data->com_cd)}}" method="post" enctype="multipart/form-data" files=true>
                @csrf
                @method('put')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Ubah Komponen</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Kode Komponen <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="kode" class="form-control" value="{{ old('kode') ? old('kode') : $data->com_cd }}" readonly>
                            @include('layout.error-single-alert',['name'=>'kode'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Group Komponen <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="group_komponen" class="form-control" value="{{ old('group_komponen') ? old('group_komponen') : $data->code_group }}">
                            @include('layout.error-single-alert',['name'=>'group_komponen'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Komponen <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="nama_komponen" class="form-control" value="{{ old('nama_komponen') ? old('nama_komponen') : $data->code_nm }}">
                            @include('layout.error-single-alert',['name'=>'nama_komponen'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nilai Komponen</label>
                        <div class="col-lg-10">
                            <input type="text" name="nilai_komponen" class="form-control" value="{{ old('nilai_komponen') ? old('nilai_komponen') : $data->code_value }}">
                            @include('layout.error-single-alert',['name'=>'nilai_komponen'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan 1</label>
                        <div class="col-lg-10">
                            <textarea type="text" rows="3" cols="3" name="keterangan_1" class="form-control" placeholder="">{{ old('keterangan_1') ? old('keterengan_1') : $data->keterangan }}</textarea>
                            @include('layout.error-single-alert',['name'=>'keterangan_1'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Keterangan 2</label>
                        <div class="col-lg-10">
                            <textarea type="text" rows="3" cols="3" name="keterangan_2" class="form-control" placeholder="">{{ old('keterangan_2') ? old('keterangan_2') : $data->keterangan_2 }}</textarea>
                            @include('layout.error-single-alert',['name'=>'keterangan_2'])
                        </div>
                    </div>

                </fieldset>

                <div class="text-right">
                    <a href="{{route('component.index')}}" class="btn bg-grey-400">Batal</a>
                    <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk position-right"></i></b> Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
@endsection 

@push('after_script')
<script>
    $(document).ready(function () {
        $('#toko').select2();
        $('#kategori').select2();
    });
</script>
@endpush
