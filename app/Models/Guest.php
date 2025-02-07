<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public $fillable = ['eng_name', 'arabic_name', 'photo', 'seat_number', 'title_id'];

    public function title()
    {
        return $this->belongsTo(Title::class);
    }
}
