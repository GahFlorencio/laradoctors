<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'disponibility_id',
        'observation'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function disponibility(){
        return $this->belongsTo(Disponibility::class);
    }

}

