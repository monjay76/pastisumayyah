<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuBapa extends Model
{
    protected $table = 'ibubapa';
    protected $primaryKey = 'ID_Parent';
    protected $fillable = ['ID_Parent', 'namaParent', 'emel', 'noTel', 'kataLaluan', 'diciptaOleh'];

    // Hubungan: Ibu bapa dicipta oleh pentadbir
    public function pentadbir()
    {
        return $this->belongsTo(Pentadbir::class, 'diciptaOleh', 'ID_Admin');
    }

    // Hubungan: Ibu bapa boleh ada ramai murid (melalui jadual parent_murid)
    public function murid()
    {
        return $this->belongsToMany(Murid::class, 'parent_murid', 'ID_Parent', 'MyKidID');
    }
}
