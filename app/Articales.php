<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Articales extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y H:i:s');
    }
}
