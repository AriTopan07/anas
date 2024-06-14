<?php

namespace App\Http\Controllers\Data;

use App\Exports\GoodsExport;
use App\Exports\PickingExport;
use App\Exports\ReceiveExport;
use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsReceive;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Repository\ExportRepository;

class ReportController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/reports');
            return $next($request);
        });
    }

    public function index()
    {
        return view('data.reports.index');
    }

    public function download_excel(Request $request, $type)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        if ($type === "receives") {
            return $this->download_excel_in($date_start, $date_end);
        } elseif ($type === "pickings") {
            return $this->download_excel_out($date_start, $date_end);
        } elseif ($type === "goods") {
            return $this->download_excel_goods($date_start, $date_end);
        }
    }

    public function download_excel_in($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getStockIn($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'There is no data to export');
        }
        return Excel::download(new ReceiveExport($date_start, $date_end), 'goods_receives_report.xlsx');
    }

    public function download_excel_out($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getStockOut($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'There is no data to export');
        }
        return Excel::download(new PickingExport($date_start, $date_end), 'goods_pickings_report.xlsx');
    }

    public function download_excel_goods($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getGoods($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'There is no data to export');
        }
        return Excel::download(new GoodsExport($date_start, $date_end), 'goods_report.xlsx');
    }
}
