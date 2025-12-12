<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktiviti extends Model
{
    protected $fillable = ['month', 'tarikh', 'path'];

    protected $table = 'aktiviti';

    protected $primaryKey = 'id_aktiviti';
}
