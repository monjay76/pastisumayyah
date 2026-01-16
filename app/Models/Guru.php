<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'ID_Guru';
    // Primary key will be a string (non auto-incrementing)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['ID_Guru', 'namaGuru', 'emel', 'noTel', 'jawatan', 'kataLaluan', 'diciptaOleh'];

    // Hubungan: Guru direkod oleh Pentadbir
    public function pentadbir()
    {
        return $this->belongsTo(Pentadbir::class, 'diciptaOleh', 'ID_Admin');
    }

    // Hubungan: Guru boleh rekod banyak kehadiran
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'direkodOleh', 'ID_Guru');
    }

    // Hubungan: Guru boleh rekod banyak prestasi murid
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'ID_Guru', 'ID_Guru');
    }
}

