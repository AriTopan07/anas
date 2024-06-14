<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_id',
        'date',
        'image',
        'qty',
        'description',
        'created_by',
        'updated_by',
        'verified'
    ];

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }
}
