<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\Exports\StatisticsExport;
use App\SurveyParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 *
 * Контроллер работы с NPS
 *
 * Class SurveyController
 *
 * @package App\Http\Controllers
 */
class SurveyController extends Controller
{

    /**
     *
     * Метод сохраняет оценку в БД
     * В теле ответа может содержать result  answer code tip
     * code - код операции (1 успех) (2 оценка вне диапазона) (3 оценка на число) (4 оценка не установлена) (5 ошибка
     * компоновки тела запроса) (6 пользователь не найден) (7 ошибка авторизации) (8 ошибка данных регистрации) (9
     * ошибка базы данных) answer
     * - ошибка tip - подсказка
     *
     * @param string                   $id ИД пользователя
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @api
     *
     */
    public function setAssessment($id, Request $request)
    {


        $body = [];
        $usr = $request->surveyParticipant;

        if ($request->isAuth !== false) {

            $data = json_decode($request->getContent(), true);
            if (is_array($data)) {
                if (array_key_exists('assessment', $data)) {

                    if (is_int($data['assessment'])) {

                        if ($data['assessment'] > 0 && $data['assessment'] < 11) {

                            try {

                                DB::beginTransaction();

                                $assessment = new Assessment();
                                $assessment->assessment = $data['assessment'];
                                $assessment->created_at = time();
                                $usr->assessments()->save($assessment);

                                DB::commit();
                                $body['code'] = 1;

                            } catch (Exception $e) {

                                DB::rollBack();

                                $body['code'] = 9;
                                $body['answer'] = 'DB ERROR:' . $e->getMessage();
                            }

                        } else {

                            $body['answer'] = 'assessment error: assessment > 10 or assessment < 1';
                            $body['code'] = 2;
                        }

                    } else {

                        $body['answer'] = 'assessment error: type not int';
                        $body['code'] = 3;
                    }

                } else {
                    $body['answer'] = 'assessment error: not set';
                    $body['code'] = 4;
                }
            } else {
                $body['answer'] = 'body type error';
                $body['code'] = 5;
            }

        } else {
            if ($usr === null) {
                $body['answer'] = 'usr not found';
                $body['code'] = 6;
            } else {
                if (!$request->isFirstCall) {
                    $body['answer'] = 'auth error';
                    $body['code'] = 7;
                    $body['tip'] = $usr->tip;
                } else {
                    $body['answer'] = 'auth error: wrong key or tip';
                    $body['code'] = 8;
                    $body['tip'] = $usr->tip;
                }
            }
        }
        return response(json_encode($body));
    }


    /**
     *
     * Возвращает страницу голосования
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAssessmentPage(Request $request)
    {
        return view('survey')->with(['request' => $request]);
    }


    /**
     *
     * Возвращает страницу статистики
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStatisticPage(Request $request)
    {
        return view('statistic');
    }

    /**
     *
     * Возвращает страницу генерации ссылок
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLinksGeneratorPage(Request $request)
    {
        return view('keyGenerator');
    }

    /**
     *
     * Производит сбор всей нужной статистики - ИЭЛ за период и на текущий момент
     *
     * @param bool      $min   Выводить минимальную информацию или нет?
     * @param int       $count Соличество шагов
     * @param float|int $step  Шаг выборки
     *
     * @return array Массив данных
     */
    protected function getStatisticArr($min = true, $count = 180, $step = 24 * 60 * 60)
    {

        $dateNow = strtotime(date('Y-m-d'));
        $startDate = $dateNow - $step * ($count - 1);

        $arrAssessment = [];
        for ($i = $startDate; $i <= $dateNow; $i += $step) {
            $arrAssessment[] = $min ? $this->assessmentOfDate($i)['mainData'] : $this->assessmentOfDate($i);
        }


        return [
            'arrAssessment' => $arrAssessment,
            'assessmentNow' => $this->assessmentOfDate(time())
        ];

    }

    /**
     *
     * Возвращает данные по количеству всех типов пользователей в выборке
     *
     * @param $assessments выборка оценок пользователей
     *
     * @return array
     */
    protected function getCountUsrTypes($assessments)
    {
        $good = 0;
        $bad = 0;
        $neutral = 0;
        $count = 0;
        foreach ($assessments as $assessment) {
            if ($assessment->assessment < 7) {
                $bad++;
            } else {
                if ($assessment->assessment < 9) {
                    $neutral++;
                } else {
                    $good++;
                }
            }
            $count++;
        }
        return ['good' => $good, 'bad' => $bad, 'neutral' => $neutral, 'count' => $count];
    }

    /**
     *
     * Производит выборку статистических данных (ИЭЛ + количества всех типов пользователей) на указанную дату
     *
     * @param $date дата, до которой производится сбор статистики
     *
     * @return array
     */
    protected function assessmentOfDate($date)
    {
        $strDate = date('Y-m-d H:i:s', $date);
        $assessments = $this->getLastAssessments($strDate);
        $countArr = $this->getCountUsrTypes($assessments);
        return [
            'mainData'       => [
                'date'  => $strDate,
                'value' => $this->assessmentFunc($countArr['good'], $countArr['bad'],
                    $countArr['count'])
            ],
            'additionalData' => $countArr
        ];
    }

    /**
     *
     * Расчет оценки ИЭЛ
     *
     * @param $good Промоутеры
     * @param $bad  Критики
     * @param $all  Нейтральные пользователи
     *
     * @return float|int
     */
    protected function assessmentFunc($good, $bad, $all)
    {
        $all = ($all === 0) ? 1 : $all;
        return (($good - $bad) / $all) * 100;
    }

    /**
     *
     * Срез последних оценок пользователей на указанную дату
     *
     * @param $date дата на которую производится срез
     *
     * @return array
     */
    protected function getLastAssessments($date)
    {
        $sql = "SELECT `assessment` FROM `assessments` JOIN (SELECT MAX(`created_at`) as 'created_at', `owner_id` from `assessments` WHERE created_at < ? GROUP BY owner_id ) as dates ON assessments.owner_id = dates.owner_id AND assessments.created_at = dates.created_at ";
        return DB::select($sql, [$date]);
    }

    /**
     *
     * Возвращает минимальную статистику на 180 дней
     *
     * @return array
     * @api
     *
     */
    public function getStatistic()
    {
        return $this->getStatisticArr();
    }

    /**
     *
     * Производит генерецию учетных записей пользователей
     * Может вернуть код операции ссылки или сообщние об ошибке
     * code - (1 все хорошо) (2 запос количества < 1) (3 ошибка БД)
     *
     * @param                          $count количество нужных записей
     * @param \Illuminate\Http\Request $request
     *
     * @return false|string
     * @api
     *
     */
    public function getNewLinks($count, Request $request)
    {
        $count = (int)$count;

        if ($count > 0) {
            try {
                $result = [];
                DB::beginTransaction();
                while ($count > 0) {

                    $obj = new SurveyParticipant();
                    $obj->save();
                    $result[] = route('assessmentPage', $obj->id);
                    $count--;
                }
                DB::commit();

                $body['code'] = 1;
                $body['links'] = $result;
            } catch (Exception $e) {

                DB::rollBack();

                $body['code'] = 3;
                $body['answer'] = 'DB ERROR:' . $e->getMessage();
            }


        } else {

            $body['code'] = 2;
            $body['answer'] = 'count error: count < 1';

        }


        return json_encode($body);
    }


    /**
     *
     * Возвращает расширенную статистику в файле типа xlsx
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @api
     *
     */
    public function getStatisticInExcel()
    {
        $data = $this->getStatisticArr(false);
        return Excel::download(new StatisticsExport($data), 'export.xlsx');

    }
}

