<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assessment;
use App\SurveyParticipant;

class SurveyController extends Controller
{

    public static function setAssessment($id, Request $request)
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

    public static function getAssessmentPage(Request $request)
    {
        return view('survey')->with(['request' => $request]);
    }
}
