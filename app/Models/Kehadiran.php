<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'ID_Kehadiran';
    protected $fillable = ['tarikh', 'status', 'MyKidID', 'direkodOleh'];
    protected $casts = [
        'tarikh' => 'datetime',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'MyKidID', 'MyKidID');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'direkodOleh', 'ID_Guru');
    }
}
