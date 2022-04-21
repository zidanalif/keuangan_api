<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use app\Http\Resources\KeuanganResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Keuangan::get()->sortByDesc('id');
        if (count($data)==0) {
            return response()->json(['Belum ada data']);
        }
        return response()->json([$data, 'berhasil.']);
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

        $validator = Validator::make($request->all(),[
            'categorie' => 'required|string|max:255',
            'description' => 'required',
            'total' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = Keuangan::create([
            'categorie' => $request->categorie,
            'description' => $request->description,
            'total' => $request->total,
            'id_user' => User::get('id')
         ]);

        return response()->json(['Berhasil menambah data.', $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Keuangan::find($id);
        if (is_null($data)) {
            return response()->json('Data tidak ditemukan', 404);
        }
        return response()->json([$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        $validator = Validator::make($request->all(),[
            'categorie' => 'required|string|max:255',
            'description' => 'required',
            'total' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $keuangan->categorie = $request->categorie;
        $keuangan->description = $request->description;
        $keuangan->total = $request->total;

        if ($keuangan->save()) {
            return response()->json(['Data telah diupdate.', $keuangan]);
        }


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
