<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencapaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'murid_id',
        'subjek',
        'penggal',
        'markah_rata',
        'gred',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'MyKidID');
    }
}