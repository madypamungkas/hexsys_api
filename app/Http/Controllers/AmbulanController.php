<?php

namespace App\Http\Controllers;

use App\Ambulan;
use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use Storage;
use Image;
use Carbon\Carbon;

class AmbulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ambulan.index');
    }

    public function getData(Request $request)
    {
        $filter_status = $request->filter_status;
        $filter_instansi = $request->filter_instansi;

        $data = Ambulan::with('instansi')
        ->when($filter_status, function ($query, $filter_status) {
            return $query->whereIn('status', $filter_status);
        })
        ->when($filter_instansi, function ($query, $filter_instansi) {
            return $query->whereIn('instansi_id', $filter_instansi);
        })
        ->get()->sortBy('nama_sopir');
        return datatables()->of($data)
        ->addColumn('action', function($row){
            $btn ='';
            $btn = $btn.'  <a title="Ubah" href="'.route('ambulan.edit',$row->ambulan_id).'" class="btn btn-warning btn-icon"><i class="icon-pencil4"></i></a>';
            $btn = $btn.'  <button title="Hapus" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('status', function($row){
            if ($row->status == 'STATUS_AMBULAN_1') {
                $btn = '<a title="Klik untuk ubah status ambulan" id="btn-status" href="#"> <span class="badge bg-success">'.$row->statusAmbulan->code_nm.'</span></a>';
            } elseif ($row->status == 'STATUS_AMBULAN_2'){
                $btn = '<a title="Klik untuk ubah status ambulan" id="btn-status" href="#"> <span class="badge bg-danger">'.$row->statusAmbulan->code_nm.'</span></a>';
            }
            return $btn;
         })
        ->addIndexColumn()
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ambulan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),
        [
                'instansi' => 'required',
                'plat_nomor' => 'required|max:11',
                'nama_sopir' => 'required|max:50',
                'nomor_telepon' => 'required|max:14',
                'merk' => 'required|max:50',
                'gambar' => 'required|max:2000',
        ]
        );

        DB::beginTransaction();
        $data = new Ambulan();
        $data->instansi_id = $request->instansi;
        $data->plat_nomor = $request->plat_nomor;
        $data->nama_sopir = $request->nama_sopir;
        $data->nomor_telepon = $request->nomor_telepon;
        $data->merk = $request->merk;
        $data->status = 'STATUS_AMBULAN_1';
        $data->created_by = Auth::id();

        if ($request->gambar) {
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = Carbon::now()->format('ymd').rand(1000,9999) . '.' . $extension;
            Storage::put('public/images/ambulan/' . $filename, File::get($file));
    
            $file_server = Storage::get('public/images/ambulan/' . $filename);
            $img = Image::make($file_server)->resize(600, 600);
            $img->save(base_path('public/storage/images/ambulan/' . $filename));
            $data->gambar = $filename;
        }


        $data->save();
        DB::commit();
        return redirect()->route('ambulan.index')->with('alertSuccess','Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Ambulan::find($id);
        return view('ambulan.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Ambulan::find($id);
        $this->validate(request(),
        [
                'instansi' => 'required',
                'plat_nomor' => 'required|max:11',
                'nama_sopir' => 'required|max:50',
                'nomor_telepon' => 'required|max:14',
                'merk' => 'required|max:50',
                'gambar' => 'required|max:2000',
        ]
        );

        DB::beginTransaction();
        $data->instansi_id = $request->instansi;
        $data->plat_nomor = $request->plat_nomor;
        $data->nama_sopir = $request->nama_sopir;
        $data->nomor_telepon = $request->nomor_telepon;
        $data->merk = $request->merk;
        $data->updated_by = Auth::id();

        if ($request->gambar) {
            if (!empty($data->gambar)) {
                Storage::delete('public/images/ambulan/'.$data->gambar);
            }
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = Carbon::now()->format('ymd').rand(1000,9999) . '.' . $extension;
            Storage::put('public/images/ambulan/' . $filename, File::get($file));
    
            $file_server = Storage::get('public/images/ambulan/' . $filename);
            $img = Image::make($file_server)->resize(600, 600);
            $img->save(base_path('public/storage/images/ambulan/' . $filename));
            $data->gambar = $filename;
        }

        $data->save();
        DB::commit();

        return redirect()->route('ambulan.index')->with('alertSuccess','Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Ambulan::where('ambulan_id',$id)->first();
        $data->delete();
        return response()->json(['status' => 'success', 'data'=>'success delete data']);
    }

    public function updateStatus($id)
    {
        $data= Ambulan::find($id);
        if ($data->status == 'STATUS_AMBULAN_1') {
            $data->status = 'STATUS_AMBULAN_2';
        } elseif ($data->status == 'STATUS_AMBULAN_2') {
            $data->status = 'STATUS_AMBULAN_1';
        }
        $data->updated_by = Auth::user()->id;
        $data->save();
        return response()->json(['status' => 'success', 'data'=>'Berhasil mengubah status']);
    }
}
