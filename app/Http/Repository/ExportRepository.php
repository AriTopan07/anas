<?php

namespace App\Http\Repository;

use Milon\Barcode\DNS2D;
use App\Models\Barang;
use App\Models\Goods;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportRepository
{
    public function getStockIn($date_start, $date_end)
    {
        $data = DB::table('goods_receives')
            ->select(
                'goods_receives.*',
                'goods.name AS name',
                'created_by_user.name AS created_by_name',
                'updated_by_user.name AS updated_by_name'
            )
            ->join('goods', 'goods_receives.goods_id', '=', 'goods.id')
            ->join('users AS created_by_user', 'goods_receives.created_by', '=', 'created_by_user.id')
            ->leftJoin('users AS updated_by_user', 'goods_receives.updated_by', '=', 'updated_by_user.id')
            ->orderBy('goods_receives.created_at', 'desc')
            ->where('goods_receives.verified', '=', 1)
            ->whereDate('goods_receives.date', '>=', $date_start)
            ->whereDate('goods_receives.date', '<=', $date_end)
            ->get();

        return $data;
    }

    public function getStockOut($date_start, $date_end)
    {
        $data = DB::table('goods_pickings')
            ->select(
                'goods_pickings.*',
                'goods.name AS name',
                'created_by_user.name AS created_by_name',
                'updated_by_user.name AS updated_by_name'
            )
            ->join('goods', 'goods_pickings.goods_id', '=', 'goods.id')
            ->join('users AS created_by_user', 'goods_pickings.created_by', '=', 'created_by_user.id')
            ->leftJoin('users AS updated_by_user', 'goods_pickings.updated_by', '=', 'updated_by_user.id')
            ->orderBy('goods_pickings.created_at', 'desc')
            ->where('goods_pickings.verified', '=', 1)
            ->whereDate('goods_pickings.date', '>=', $date_start)
            ->whereDate('goods_pickings.date', '<=', $date_end)
            ->get();

        return $data;
    }

    public function getGoods($date_start, $date_end)
    {
        $data = Goods::with('in', 'out')
            ->select(
                'goods.*',
                'categories.categories_name',
                'suppliers.suppliers_name',
                'units.units_name',
                'created_by_user.name as created_by_name',
                'updated_by_user.name as updated_by_name'
            )
            ->join('units', 'goods.units_id', '=', 'units.id')
            ->join('categories', 'goods.category_id', '=', 'categories.id')
            ->join('suppliers', 'goods.supplier_id', '=', 'suppliers.id')
            ->join('users as created_by_user', 'goods.created_by', '=', 'created_by_user.id')
            ->leftJoin('users as updated_by_user', 'goods.updated_by', '=', 'updated_by_user.id')
            ->where('goods.verified', '=', 1)
            ->orderBy('goods.created_at', 'desc')
            ->whereDate('goods.created_at', '>=', $date_start)
            ->whereDate('goods.created_at', '<=', $date_end)
            ->get();

        return $data;
    }
}
