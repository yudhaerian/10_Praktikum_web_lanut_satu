<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;
    protected $table='kelas'; //mendefinisikan bahwa model ini terkait dengan table kelas

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
