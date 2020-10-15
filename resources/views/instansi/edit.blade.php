@extends('layout.app')
@section('instansi','active')
@section('title')
    <h4>
        <a href="{{route('instansi.index')}}"><i class="text-default icon-arrow-left52 mr-2"></a></i>
        <span class="font-weight-semibold">Master</span> - Ubah Instansi
    </h4>
@endsection

@section('breadcrumb')
    <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Master</a>
    <span class="breadcrumb-item"><a href="{{route('instansi.index')}}" class="text-default"> Instansi </a></span>
    <span class="breadcrumb-item active">Ubah</span>
@endsection
@section('content')
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" action="{{route('instansi.update',$data->instansi_id)}}" method="post" enctype="multipart/form-data" files=true>
                @csrf
                @method('put')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Instansi</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Nama Instansi <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') ? old('nama') : $data->nama }}">
                            @include('layout.error-single-alert',['name'=>'nama'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2"></label>
                        <div class="col-lg-10">
                            <div id="mapid"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Latitude <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="latitude" class="form-control" value="{{ old('latitude') ? old('latitude') : $data->latitude }}">
                            @include('layout.error-single-alert',['name'=>'latitude'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Longitude <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="longitude" class="form-control" value="{{ old('longitude') ? old('longitude') : $data->longitude }}">
                            @include('layout.error-single-alert',['name'=>'longitude'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Waktu Operasi (Mulai - Selesai) <span class="text-danger">*</span></label>
                        <div class="col-lg-5">
                            <input type="time" name="waktu_mulai_operasi" class="form-control" value="{{ old('waktu_mulai_operasi') ? old('waktu_mulai_operasi') : $data->waktu_mulai_operasi }}">
                            @include('layout.error-single-alert',['name'=>'waktu_mulai_operasi'])
                        </div>
                        <div class="col-lg-5">
                            <input type="time" name="waktu_selesai_operasi" class="form-control" value="{{ old('waktu_selesai_operasi') ? old('waktu_selesai_operasi') : $data->waktu_selesai_operasi }}">
                            @include('layout.error-single-alert',['name'=>'waktu_selesai_operasi'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Deskripsi</label>
                        <div class="col-lg-10">
                            <textarea type="text" rows="3" cols="3" name="deskripsi" class="form-control" placeholder="">{{ old('deskripsi') ? old('deskripsi') : $data->deskripsi }}</textarea>
                            @include('layout.error-single-alert',['name'=>'deskripsi'])
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
                                <img class="mb-1" src='{{asset("storage/images/instansi/$data->gambar")}}' alt="gambar" style="width:170px;height:170px">
                            @endif
                            <input type="file" name="gambar" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
                            @include('layout.error-single-alert',['name'=>'gambar'])
                        </div>
                    </div>

                    <legend class="text-uppercase font-size-sm font-weight-bold">Ubah Password</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" name="password">
                            @include('layout.error-single-alert',['name'=>'password'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Repeat Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" name="password_confirmation">
                            @include('layout.error-single-alert',['name'=>'password_confirmation'])
                        </div>
                    </div>

                </fieldset>

                <div class="text-right">
                    <a href="{{route('instansi.index')}}" class="btn bg-grey-400">Batal</a>
                    <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk position-right"></i></b> Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
@endsection

@push('after_script')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    $(document).ready(function () {
        $('#toko').select2();
        $('#kategori').select2();

        var mymap = L.map('mapid').setView(["{{$data->latitude}}", "{{$data->longitude}}"], 15);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
        }).addTo(mymap);

        var marker = L.marker(["{{$data->latitude}}", "{{$data->longitude}}"]).addTo(mymap);

        L.Control.geocoder({defaultMarkGeocode: true}).addTo(mymap);

        var popup = L.popup();
        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("Latitude : " + e.latlng.lat + ', Longitude : '+ e.latlng.lng)
                .openOn(mymap);

            $("input[name=latitude]").val(e.latlng.lat);
            $("input[name=longitude]").val(e.latlng.lng);
        }

        mymap.on('click', onMapClick);
    });
</script>
@endpush

@push('after_style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<style>
    #mapid { height: 300px; }
</style>
@endpush
