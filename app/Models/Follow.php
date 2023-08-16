<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $table = 'follow';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
