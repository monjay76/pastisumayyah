<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'ID_Prestasi';
    protected $fillable = [
<<<<<<< HEAD
        'ID_Guru',
        'MyKidID',
=======
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
        'subject_id',
        'murid_id',
        'guru_id',
        'subjek',
        'tarikhRekod',
        'kriteria_nama',
        'penggal',
        'tahap_pencapaian'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'ID_Guru');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'MyKidID');
    }

    public function subject()
    {
        return $this->belongsTo(Subjek::class, 'subject_id', 'id');
    }
}
