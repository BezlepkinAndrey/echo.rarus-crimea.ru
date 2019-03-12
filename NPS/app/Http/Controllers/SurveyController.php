<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Assessment;
use App\SurveyParticipant;

class SurveyController extends Controller
{

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

                            $assessment = new Assessment();
                            $assessment->assessment = $data['assessment'];
                            $assessment->created_at = time();
                            $usr->assessments()->save($assessment);
                            $body['result'] = true;
                            $body['code'] = 1;
                        } else {

                            $body['result'] = false;
                            $body['answer'] = 'assessment error: assessment > 10 or assessment < 1';
                            $body['code'] = 2;
                        }

                    } else {

                        $body['result'] = false;
                        $body['answer'] = 'assessment error: type not int';
                        $body['code'] = 3;
                    }

                } else {
                    $body['result'] = false;
                    $body['answer'] = 'assessment error: not set';
                    $body['code'] = 4;
                }
            } else {
                $body['result'] = false;
                $body['answer'] = 'body type error';
                $body['code'] = 5;
            }

        } else {
            if ($usr === null) {
                $body['result'] = false;
                $body['answer'] = 'usr not found';
                $body['code'] = 6;
            } else {
                if (!$request->isFirstCall) {
                    $body['result'] = false;
                    $body['answer'] = 'auth error';
                    $body['code'] = 7;
                    $body['tip'] = $usr->tip;
                } else {
                    $body['result'] = false;
                    $body['answer'] = 'auth error: wrong key or tip';
                    $body['code'] = 8;
                    $body['tip'] = $usr->tip;
                }
            }
        }
        return response(json_encode($body));
    }

    public function getAssessmentPage(Request $request)
    {
        return view('survey')->with(['request' => $request]);
    }

    public function getStatisticPage(Request $request)
    {
        return view('statistic');
    }

    public function getLinksGeneratorPage(Request $request)
    {
        return view('keyGenerator');
    }

    protected function getStatisticArr($count = 180, $step = 24 * 60 * 60)
    {

        $dateNow = strtotime(date('Y-m-d'));
        $startDate = $dateNow - $step * $count;

        $arrAssessment = [];
        for ($i = $startDate; $i <= $dateNow; $i += $step) {
            $arrAssessment[] = $this->assessmentOfDate($i)['mainData'];
        }


        return [
            'arrAssessment' => $arrAssessment,
            'assessmentNow' => $this->assessmentOfDate(time())
        ];

    }

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


    protected function assessmentFunc($good, $bad, $all)
    {
        $all = ($all === 0) ? 1 : $all;
        return (($good - $bad) / $all) * 100;
    }

    protected function getLastAssessments($date)
    {
        $sql = "SELECT `assessment` FROM `assessments` JOIN (SELECT MAX(`created_at`) as 'created_at', `owner_id` from `assessments` WHERE created_at < ? GROUP BY owner_id ) as dates ON assessments.owner_id = dates.owner_id AND assessments.created_at = dates.created_at ";
        return DB::select($sql, [$date]);
    }

    public function getStatistic()
    {
        return $this->getStatisticArr();
    }

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

    public function getStatisticInExcel()
    {
        $data = $this->assessmentOfDate(time());

        return $data;
    }
}

