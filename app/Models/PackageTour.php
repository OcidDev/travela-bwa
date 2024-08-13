<?php

namespace App\Models;

use App\Models\Category;
use App\Models\packagePhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageTour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'categoriesfk',
        'thumbnail',
        'price',
        'location',
        'about',
        'days',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(packagePhoto::class);
    }
}
