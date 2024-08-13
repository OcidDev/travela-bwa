<?php

namespace App\Models;

use App\Models\User;
use App\Models\packageBank;
use App\Models\PackageTour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class packageBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'proof',
        'usersfk',
        'packagetooursfk',
        'packagebanksfk',
        'quantity',
        'totalamount',
        'insurance',
        'tax',
        'subtotal',
        'ispaid',
        'startdate',
        'enddate',
    ];

    protected $casts = [
        'startdate' => 'datetime',
        'enddate' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(PackageTour::class);
    }

    public function bank()
    {
        return $this->belongsTo(packageBank::class);
    }
}
