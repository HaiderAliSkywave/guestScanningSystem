<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public $fillable = ['name'];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
