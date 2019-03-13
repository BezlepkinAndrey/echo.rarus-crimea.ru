<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Class StatisticsExport предназначен для экспортирования данных в Excel
 *
 * @package App\Exports
 */

class StatisticsExport implements FromView
{

    protected $data = [];

    /**
     * StatisticsExport constructor.
     *
     * @param [] $data Состоит из массива статистики на период и объекта со статистикой на текущий момент
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     *
     *  Метод возвращает представление статистики для Excel
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $data = [[$this->data['assessmentNow']], $this->data['arrAssessment']];
        return view('exports.statistics', ['data' => $data]);
    }
}