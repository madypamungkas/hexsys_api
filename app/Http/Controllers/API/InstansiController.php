<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Instansi;

class InstansiController extends Controller
{
    use ResponseAPI;

    public function list()
    {
        try {
            $data = Instansi::with('statusInstansi')->get();
            foreach ($data as $key => $value) {
                if ($value->ambulans) {
                    $value->ambulan_aktif = $value->ambulans->where('status','STATUS_AMBULAN_1')->count();
                } else {
                    $value->ambulan_aktif = 0;
                }

                if ($value->gambar) {
                    $value->gambar = url('/').'/storage/images/instansi/'.$value->gambar;
                }
            }
            return $this->success("List instansi.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }

    public function show($id)
    {
        try {
            $data = Instansi::with('statusInstansi','ambulans.statusAmbulan')->find($id);
            if ($data->ambulans) {
                $data->ambulan_aktif = $data->ambulans->where('status','STATUS_AMBULAN_1')->count();
            } else {
                $data->ambulan_aktif = 0;
            }

            if ($data->gambar) {
                $data->gambar = url('/').'/storage/images/instansi/'.$data->gambar;
            }

            if(!$data) return $this->error("Instansi tidak ditemukan.", 404);

            return $this->success("Detail instansi.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }
}
