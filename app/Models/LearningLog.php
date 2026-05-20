<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningLog extends Model
{
    protected $fillable = [
        'id_user', 'id_sub_material', 'id_material',
        'started_at', 'ended_at', 'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function subMaterial()
    {
        return $this->belongsTo(SubMaterial::class, 'id_sub_material');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material');
    }
}
