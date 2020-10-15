<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Ambulan;

class AmbulanController extends Controller
{
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $instansi_id = $request->instansi_id;
            $data = Ambulan::with('statusAmbulan')
            ->when($instansi_id, function ($query, $instansi_id) {
                return $query->where('instansi_id', $instansi_id);
            })->get();
            foreach ($data as $key => $value) {
                if ($value->gambar) {
                    $value->gambar = url('/').'/storage/images/ambulan/'.$value->gambar;
                }
            }
            return $this->success("List ambulan.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Ambulan::with('statusAmbulan')->find($id);

            if ($data->gambar) {
                $data->gambar = url('/').'/storage/images/ambulan/'.$data->gambar;
            }

            if(!$data) return $this->error("Ambulan tidak ditemukan.", 404);

            return $this->success("Detail ambulan.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
