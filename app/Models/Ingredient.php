<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'image_id'
    ];

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }
}
