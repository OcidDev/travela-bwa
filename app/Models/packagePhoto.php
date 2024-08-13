<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packagePhoto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'packagetoursfk',
        'photo',
    ];
}
