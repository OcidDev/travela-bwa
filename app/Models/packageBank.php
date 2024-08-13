<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packageBank extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'bankname',
        'bankaccountname',
        'bankaccountnumber',
        'logo'
    ];
}
