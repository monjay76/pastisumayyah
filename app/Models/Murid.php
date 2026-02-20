<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';
    protected $primaryKey = 'MyKidID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MyKidID', 'namaMurid', 'kelas', 'tarikhLahir', 'alamat', 'gambar_profil'];
    protected $dates = ['tarikhLahir'];

    // Hubungan: Murid boleh ada ramai ibu bapa
    public function ibubapa()
    {
        return $this->belongsToMany(IbuBapa::class, 'parent_murid', 'MyKidID', 'ID_Parent');
    }

    // Hubungan: Murid boleh ada banyak rekod kehadiran
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'MyKidID', 'MyKidID');
    }

    // Hubungan: Murid boleh ada banyak rekod prestasi
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'murid_id', 'MyKidID');
    }

    // Hubungan: Murid boleh ada banyak laporan
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'MyKidID', 'MyKidID');
    }

    // Fetch parent's phone number
    public function getParentPhoneNumbers()
    {
        return $this->ibubapa->pluck('noTel')->toArray();
    }
}

