<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kode_plant',
        'growth',
        'type',
        'additional',
    ];

    protected $casts = [
        "growth" => "array"
    ];
}
