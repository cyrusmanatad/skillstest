<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'sku_code', 'price', 'price_adjustment', 'user_id', 'del_flag', 'image'];

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
    
    public function fromUser($userId)
    {
        return $this->where('user_id', $userId)->get();
    }
}
