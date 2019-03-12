<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StatisticsExport implements FromView
{

    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = [[$this->data['assessmentNow']], $this->data['arrAssessment']];
        return view('exports.statistics', ['data' => $data]);
    }
}