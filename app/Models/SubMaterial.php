<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMaterial extends Model
{
    protected $fillable = [
        'id_material',
        'title',
        'description',
        'file_material',
    ];
}
