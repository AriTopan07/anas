<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'units_id',
        'supplier_id',
        'name',
        'brand',
        'description',
        'created_by',
        'updated_by',
        'stock',
        'status',
        'verified'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function in()
    {
        return $this->hasMany(GoodsReceive::class, 'goods_id');
    }

    public function out()
    {
        return $this->hasMany(GoodsPicking::class, 'goods_id');
    }
}
