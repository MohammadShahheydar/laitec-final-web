<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Category extends Model
{
    use HasFactory , SoftDeletes , HasEagerLimit;

    protected $guarded = ['id'];

    public function products () {
        return $this->hasMany(Product::class);
    }
}
