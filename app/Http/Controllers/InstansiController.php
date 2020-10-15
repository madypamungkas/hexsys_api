<?php

namespace App\Http\Controllers;

use App\Instansi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DB;
use Auth;
use File;
use Storage;
use Image;
use Carbon\Carbon;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instansi.index');
    }

    public function getData(Request $request)
    {
        $filter_status = $request->filter_status;
        $data = Instansi::with('user')
        ->when($filter_status, function ($query, $filter_status) {
            return $query->whereIn('status', $filter_status);
        })
        ->get()->sortBy('nama');
        return datatables()->of($data)
        ->addColumn('action', function($row){
            $btn ='';
            $btn = $btn.'  <a title="Ubah" href="'.route('instansi.edit',$row->instansi_id).'" class="btn btn-warning btn-icon"><i class="icon-pencil4"></i></a>';
            $btn = $btn.'  <button title="Hapus" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('waktu_operasi', function($row){
            $waktu_operasi = $row->waktu_mulai_operasi .' s/d '. $row->waktu_selesai_operasi;
            return $waktu_operasi;
        })
        ->addColumn('status', function($row){
            if ($row->status == 'STATUS_INSTANSI_1') {
                $btn = '<a title="Klik untuk ubah status instansi" id="btn-status" href="#"> <span class="badge bg-success">'.$row->statusInstansi->code_nm.'</span></a>';
            } elseif ($row->status == 'STATUS_INSTANSI_2'){
                $btn = '<a title="Klik untuk ubah status instansi" id="btn-status" href="#"> <span class="badge bg-danger">'.$row->statusInstansi->code_nm.'</span></a>';
            }
            return $btn;
         })
        ->addIndexColumn()
        ->rawColumns(['action', 'waktu_operasi','status'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instansi.create');
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
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required',

                'nama' => 'required|max:100',
                'latitude' => 'required',
                'longitude' => 'required',
                'waktu_mulai_operasi' => 'required',
                'waktu_selesai_operasi' => 'required',
                'deskripsi' => 'max:255',
                // 'gambar' => '',
        ]
        );

        DB::beginTransaction();
        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();
        $user->roles()->sync(2);

        $data = new Instansi();
        $data->user_id = $user->id;
        $data->nama = $request->nama;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->waktu_mulai_operasi = $request->waktu_mulai_operasi;
        $data->waktu_selesai_operasi = $request->waktu_selesai_operasi;
        $data->deskripsi = $request->deskripsi;
        $data->status = 'STATUS_INSTANSI_1';
        $data->created_by = Auth::id();

        if ($request->gambar) {
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = Carbon::now()->format('ymd').rand(1000,9999) . '.' . $extension;
            Storage::put('public/images/instansi/' . $filename, File::get($file));
    
            $file_server = Storage::get('public/images/instansi/' . $filename);
            $img = Image::make($file_server)->resize(600, 600);
            $img->save(base_path('public/storage/images/instansi/' . $filename));
            $data->gambar = $filename;
        }

        $data->save();
        DB::commit();
        return redirect()->route('instansi.index')->with('alertSuccess','Berhasil menambahkan data!');
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
        $data = Instansi::find($id);
        $user = User::find($data->user_id);
        return view('instansi.edit',compact('data','user'));
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
        $data = Instansi::find($id);
        $this->validate(request(),
        [
                'email' => 'required|unique:users,email,'.$data->user_id,
                'password' => 'nullable|confirmed|min:8',

                'nama' => 'required|max:100',
                'latitude' => 'required',
                'longitude' => 'required',
                'waktu_mulai_operasi' => 'required',
                'waktu_selesai_operasi' => 'required',
                'deskripsi' => 'max:255',
                'gambar' => 'required|max:2000',
        ]
        );

        DB::beginTransaction();
        $data->nama = $request->nama;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->waktu_mulai_operasi = $request->waktu_mulai_operasi;
        $data->waktu_selesai_operasi = $request->waktu_selesai_operasi;
        $data->deskripsi = $request->deskripsi;
        $data->updated_by = Auth::id();

        if ($request->gambar) {
            if (!empty($data->gambar)) {
                Storage::delete('public/images/instansi/'.$data->gambar);
            }
            $file = $request->file('gambar');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = Carbon::now()->format('ymd').rand(1000,9999) . '.' . $extension;
            Storage::put('public/images/instansi/' . $filename, File::get($file));
    
            $file_server = Storage::get('public/images/instansi/' . $filename);
            $img = Image::make($file_server)->resize(600, 600);
            $img->save(base_path('public/storage/images/instansi/' . $filename));
            $data->gambar = $filename;
        }

        $data->save();

        $user = User::find($data->user_id);
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        DB::commit();
        return redirect()->route('instansi.index')->with('alertSuccess','Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Instansi::where('instansi_id',$id)->first();
        $data->delete();
        return response()->json(['status' => 'success', 'data'=>'success delete data']);
    }

    public function updateStatus($id)
    {
        $data= Instansi::find($id);
        if ($data->status == 'STATUS_INSTANSI_1') {
            $data->status = 'STATUS_INSTANSI_2';
        } elseif ($data->status == 'STATUS_INSTANSI_2') {
            $data->status = 'STATUS_INSTANSI_1';
        }
        $data->updated_by = Auth::user()->id;
        $data->save();
        return response()->json(['status' => 'success', 'data'=>'Berhasil mengubah status']);
    }
}
