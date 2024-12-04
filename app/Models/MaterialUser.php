<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialUser extends Model
{
        protected $fillable = [
            'id_user',
            'id_material',
            'joined_at',
        ];
}
