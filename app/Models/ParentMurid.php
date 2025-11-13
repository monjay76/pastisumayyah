<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentMurid extends Model
{
    protected $table = 'parent_murid';
    protected $primaryKey = 'ID_Relate';
    protected $fillable = ['ID_Parent', 'MyKidID'];

    public function ibubapa()
    {
        return $this->belongsTo(IbuBapa::class, 'ID_Parent', 'ID_Parent');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'MyKidID', 'MyKidID');
    }
}

