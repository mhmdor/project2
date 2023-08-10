<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transport extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function reservation(){
        return $this->belongsToMany(reservation::class);
    }
}
