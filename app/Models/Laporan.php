<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'ID_Laporan';
    protected $fillable = ['MyKidID', 'jenisLaporan', 'bulan', 'tahun', 'prestasiKeseluruhan', 'prestasiKehadiran', 'tarikhJana'];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'MyKidID', 'MyKidID');
    }
}
