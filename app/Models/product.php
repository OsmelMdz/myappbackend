<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'price_sale',
        'stock',
        'expired',
        'image',
        'state',
        'category_id',
    ];

    public function categories(){
        return $this->belongsTo(category::class);
    }
    public function sales(){
        return $this->hasMany(sale::class);
    }
}
