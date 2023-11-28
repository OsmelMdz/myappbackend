<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'total',
        'profit',
        'product_id',
    ];

    public function products()
    {
        return $this->belongsTo(product::class);
    }
}
