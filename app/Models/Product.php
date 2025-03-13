<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'del_flag'];

    protected static function booted()
    {
        static::addGlobalScope('active', function(Builder $builder) {
            $builder->where('del_flag', 1);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
