@extends('layout.app')
@section('ambulan','active')
@section('title')
    <h4>
        <a href="{{route('ambulan.index')}}"><i class="text-default icon-arrow-left52 mr-2"></a></i>
        <span class="font-weight-semibold">Master</span> - Ubah Ambulan
    </h4>
@endsection

@section('breadcrumb')
    <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Master</a>
    <span class="breadcrumb-item"><a href="{{route('ambulan.index')}}" class="text-default"> Ambulan </a></span>
    <span class="breadcrumb-item active">Ubah</span>
@endsection
@section('content')
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" action="{{route('ambulan.update',$data->ambulan_id)}}" method="post" enctype="multipart/form-data" files=true>
                @csrf
                @method('put')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Ambulan</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Instansi <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="instansi" id="instansi" data-placeholder="Pilih Instansi" class="form-control select" data-fouc>
                                <option value=""></option>
                                @foreach (\App\Instansi::get()->sortBy('nama') as $value)
                                    <option value="{{$value->instansi_id}}" {{ (collect(old('instansi'))->contains($value->instansi_id)) ? 'selected': $data->instansi_id == $value->instansi_id ? 'selected' : '' }}>{{$value->nama}}</option>
                                @endforeach
                            </select>
                            @include('layout.error-single-alert',['name'=>'instansi'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Plat Nomor</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="plat_nomor" value="{{ old('plat_nomor') ? old('plat_nomor') : $data->plat_nomor }}">
                            @include('layout.error-single-alert',['name'=>'plat_nomor'])
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Sopir <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="nama_sopir" class="form-control" value="{{ old('nama_sopir') ? old('nama_sopir') : $data->nama_sopir }}">
                            @include('layout.error-single-alert',['name'=>'nama_sopir'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') ? old('nomor_telepon') : $data->nomor_telepon }}">
                            @include('layout.error-single-alert',['name'=>'nomor_telepon'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Merk </label>
                        <div class="col-lg-10">
                            <input type="text" name="merk" class="form-control" value="{{ old('merk') ? old('merk') : $data->merk }}">
                            @include('layout.error-single-alert',['name'=>'merk'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Gambar</label>
                        <div class="col-lg-10">
                            <div class="alert alert-warning"> 
                            <i class="fa fa-exclamation-triangle"></i> 
                                Maksimal ukuran file 2 MB dan rasio gambar akan otomatis diubah dengan perbandingan 1:1.
                            </div>
                            @if ($data->gambar)
                                @php
                                $gambar = $data->gambar;
                                @endphp
                                <img class="mb-1" src='{{asset("storage/images/ambulan/$data->gambar")}}' alt="gambar" style="width:170px;height:170px">
                            @endif
                            <input type="file" name="gambar" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
                            @include('layout.error-single-alert',['name'=>'gambar'])
                        </div>
                    </div>


                </fieldset>

                <div class="text-right">
                    <a href="{{route('ambulan.index')}}" class="btn bg-grey-400">Batal</a>
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
        $('#instansi').select2(); 
    });
</script>
@endpush
