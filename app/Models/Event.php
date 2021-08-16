<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public function matchType()
    {
        return $this->belongsTo(MatchTypes::class,'match_type_id');
    }
}