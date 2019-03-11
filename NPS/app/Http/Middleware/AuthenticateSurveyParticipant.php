<?php

namespace App\Http\Middleware;

use App\SurveyParticipant;

use Closure;
use Dotenv\Regex\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use SebastianBergmann\Environment\Console;

class AuthenticateSurveyParticipant
{

    public function handle(Request $request, Closure $next)
    {

        $usr = $this->getUsr($request);
        $authData = $this->auth($usr, $request);

        $request->merge($authData);
        $request->merge(['surveyParticipant' => $usr]);

        return $next($request);
    }


    private function auth($usr, $request)
    {

        $isFirstCall = false;
        $isAuth = false;

        if ($usr !== null) {

            $key = null;
            $tip = null;

            $body = json_decode($request->getContent(), true);
            if (is_array($body)) {

                if (array_key_exists('key', $body)) {

                    $key = $body['key'];
                }
                if (array_key_exists('tip', $body)) {

                    $key = $body['tip'];
                }
            }

            if ($key === null) {

                $key = $request->cookie($usr->id);
            }


            if ($usr->secret_key !== null) {
                $isAuth = $usr->secret_key === (string)$key;
            } else {
                $isFirstCall = true;
                if ($key !== null && $tip !== null) {
                    $usr->secret_key = $key;
                    $usr->tip = $tip;
                    $usr->save();
                    $isAuth = true;
                }
            }

            if ($isAuth) {
                Cookie::queue($usr->id, $usr->secret_key);
            } else {
                Cookie::forget($usr->id);
            }
        }

        return ['isAuth' => $isAuth, 'isFirstCall' => $isFirstCall];
    }

    private
    function getUsr(
        $request
    ) {
        $usr = null;
        $id = $request->route('id');
        if ($id !== null) {

            $usr = SurveyParticipant::find($id);
        }
        return $usr;

    }


}
