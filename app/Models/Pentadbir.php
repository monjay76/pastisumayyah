<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pentadbir extends Model
{
    protected $table = 'pentadbir';
    protected $primaryKey = 'ID_Admin';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['ID_Admin', 'namaAdmin', 'emel', 'kataLaluan', 'noTel'];

    // Hubungan: Pentadbir boleh cipta ramai Guru
    public function guru()
    {
        return $this->hasMany(Guru::class, 'diciptaOleh', 'ID_Admin');
    }

    // Hubungan: Pentadbir boleh cipta ramai Ibu Bapa
    public function ibubapa()
    {
        return $this->hasMany(IbuBapa::class, 'diciptaOleh', 'ID_Admin');
    }
}

