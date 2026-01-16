<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjek extends Model
{
    protected $table = 'subjek';
    protected $fillable = ['nama_subjek'];

    /**
     * Get the prestasi records for this subject.
     */
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'subject_id', 'id');
    }
}
