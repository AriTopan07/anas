<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Http\Repository\ExportRepository;

class GoodsExport implements FromView
{
    use Exportable;

    protected $date_start, $date_end;

    public function __construct($date_start, $date_end)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    public function view(): View
    {
        $report = new ExportRepository();
        $data = $report->getGoods($this->date_start, $this->date_end);
        return view('data.exports.goods', [
            'data' => $data,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end
        ]);
    }
}
