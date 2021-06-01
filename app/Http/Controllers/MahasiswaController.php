<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $mahasiswas = Mahasiswa::all();
        //$mahasiswas = Mahasiswa::orderBy('Nim', 'asc')
        //->paginate(5);
        $mahasiswas = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('Nim','asc')->paginate(5);
        return view('index', ['Mahasiswas'=>$mahasiswas,'paginate'=>$paginate]);
        //return view('index', compact('mahasiswas'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $kelas = Kelas::all();
        return view('mahasiswas.create',['kelas'=>$kelas]);

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
        $request->validate([
            'Nim' => 'required',
            'Email' => 'required',
            'Nama' => 'required',
            'TglLahir' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // $image_name = time().'.'.$request->image->extension();

        // $image_name = $request->file('image')->getClientOriginalName();
        $image_name='';
        // $request->file('image')->store('images','public');
        if($request->file('image')){
            $image_name= $request->file('image')->store('images','public');
        }
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->tgllahir = $request->get('TglLahir');
        $mahasiswa->jurusan= $request->get('Jurusan');
        $mahasiswa->no_handphone= $request->get('No_Handphone');
        $mahasiswa->foto_profile = $image_name;

        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->Kelas()->associate($kelas);
        $mahasiswa->save();

        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //
        // $Mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();

         return view('mahasiswas.detail', ['Mahasiswa'=> $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa','kelas'));
        // return view('mahasiswas.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //
        $request->validate([
            'Nim' => 'required',
            'Email' => 'required',
            'Nama' => 'required',
            'TglLahir' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->tgllahir = $request->get('TglLahir');
        $mahasiswa->jurusan= $request->get('Jurusan');
        $mahasiswa->no_handphone= $request->get('No_Handphone');

        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->Kelas()->associate($kelas);
        $mahasiswa->save();

        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');

    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $mahasiswas = DB::table('mahasiswas')->where('Nama','like','%'.$search.'%')->paginate(5);
        return view('index', ['mahasiswas'=> $mahasiswas]);
    }

    public function nilai($Nim)
    {
        //
        // $Mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::find($Nim);

         return view('mahasiswas.nilai', compact('mahasiswa'));
    }

    public function cetak_pdf($Nim){
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        $pdf = PDF::loadview('mahasiswas.nilai_pdf', compact('mahasiswa'));
        return $pdf->stream();

        // return view('mahasiswas.nilai_pdf',compact('mhs'));
    }
}

