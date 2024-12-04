<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_title',
        'material_image',
        'description',
        'id_teacher',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'material_users')
            ->withTimestamps()
                ->withPivot('joined_at');
    }
    
}
