<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchTypes extends Model
{
    use HasFactory;
    public function events()
    {
        return $this->hasOne(Event::class,'match_type_id');
    }
   
}