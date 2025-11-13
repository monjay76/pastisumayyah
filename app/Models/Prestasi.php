<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'ID_Prestasi';
    protected $fillable = ['ID_Guru', 'MyKidID', 'subjek', 'markah', 'gred', 'tarikhRekod'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'ID_Guru', 'ID_Guru');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'MyKidID', 'MyKidID');
    }
}
