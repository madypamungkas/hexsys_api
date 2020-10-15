<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Component;
use Auth;
use DB;

class ComponentController extends Controller
{
        public function index()
    {
        return view('component.index');
    }

    public function getData(Request $request)
     {
        $data = Component::get()->sortBy('com_cd');
         return datatables()->of($data)
         ->addColumn('action', function($row){
            $btn ='';
            $btn = $btn.'  <a title="Ubah" href="'.route('component.edit',$row->com_cd).'" class="btn btn-warning btn-icon"><i class="icon-pencil4"></i></a>';
            $btn = $btn.'  <button title="Hapus" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
         })
         ->addIndexColumn()
         ->rawColumns(['action'])
         ->make(true);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('component.create');
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
                'kode' => 'required|max:30|unique:component,com_cd',
                'group_komponen' => 'required|max:30',
                'nama_komponen' => 'required|max:255',
        ]
        );

        DB::beginTransaction();
        $data = new Component();
        $data->com_cd = $request->kode;
        $data->code_group = $request->group_komponen;
        $data->code_nm = $request->nama_komponen;
        $data->code_value = $request->nilai_komponen;
        $data->keterangan = $request->keterangan_1;
        $data->keterangan_2 = $request->keterangan_2;
        $data->created_by = Auth::id();
        $data->save();
        DB::commit();
        return redirect()->route('component.index')->with('alertSuccess','Berhasil menambahkan data!');
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
        $data = Component::find($id);
        return view('component.edit',compact('data'));
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
        $this->validate(request(),
        [
                'group_komponen' => 'required|max:30',
                'nama_komponen' => 'required|max:255',
        ]
        );

        DB::beginTransaction();
        $data = Component::find($id);
        $data->com_cd = $request->kode;
        $data->code_group = $request->group_komponen;
        $data->code_nm = $request->nama_komponen;
        $data->code_value = $request->nilai_komponen;
        $data->keterangan = $request->keterangan_1;
        $data->keterangan_2 = $request->keterangan_2;
        $data->updated_by = Auth::id();
        $data->save();
        DB::commit();

        return redirect()->route('component.index')->with('alertSuccess','Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Component::where('com_cd',$id)->first();
        $data->delete();
        return response()->json(['status' => 'success', 'data'=>'success delete data']);
    }
}
