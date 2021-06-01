@extends('mahasiswas.layout')

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h2 class="m-3">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        <h3 class="m-3"><strong>KARTU HASIL STUDI (KHS)</strong></h3>
    </div>
    <div class="col-12">
        <p class="m-1"><strong>Nama:</strong> {{ $mahasiswa->Nama }}</p>
        <p class="m-1"><strong>NIM:</strong> {{ $mahasiswa->Nim }}</p>
        <p class="m-1"><strong>Kelas:</strong> {{ $mahasiswa->kelas->nama_kelas }}</p>
    </div>

    <div class="col-12">
        <table class="table table-bordered">
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai</th>
            </tr>
            @foreach ($mahasiswa->matakuliah as $matakuliah)
                <tr>
                    <td>{{ $matakuliah->nama_matkul }}</td>
                    <td>{{ $matakuliah->sks }}</td>
                    <td>{{ $matakuliah->semester }}</td>
                    <td>{{ $matakuliah->pivot->nilai }}</td>
                </tr>
            @endforeach
        </table>
         <a class="btn btn-danger" href="{{ route('mahasiswa.cetak_pdf', $mahasiswa->Nim) }}">CETAK PDF</a>
    </div>
</div>
   @endsection
