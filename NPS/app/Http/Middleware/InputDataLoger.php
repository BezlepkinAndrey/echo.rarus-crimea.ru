<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Matrix\Exception;

/**
 *
 *  Middleware логер данных отправляемых в запросе
 *
 * Class InputDataLoger
 *
 * @package App\Http\Middleware
 */
class InputDataLoger
{
    /**
     * Логирует данные формы и продолжает запрос
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $str = "Path: " . $request->path();
            $str .= " Data: " . json_encode($request->all());
            Log::info($str);
        } catch (Exception $e) {

        }


        return $next($request);
    }
}
