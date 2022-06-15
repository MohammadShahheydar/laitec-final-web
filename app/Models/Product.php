<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasEagerLimit;

    protected $guarded = ['id'];

    protected $casts = [
        'size' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSizeAttribute($value)
    {
        return json_decode($value);
    }

    public function associateSize()
    {
        return json_decode($this->size, true);
    }

    public function showSize()
    {
        $size = implode(',', array_map(function ($value, $key) {
            return $key . " => " . $value;
        }, json_decode($this->size, true), array_keys(json_decode($this->size, true))));

        return $size;
    }

    public function banner()
    {
        return $this->hasOne(Banner::class);
    }

    public function productSliders()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
