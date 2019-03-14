<table>

    @php($i = 0)
    @foreach($data as $arr)


        @if($i === 0)
            <tr>
                <th colspan=19>Данные на текущий момент</th>
            </tr>
        @else

            <tr>
                <th colspan=19></th>
            </tr>

            <tr>
                <th colspan=19>Данные за последние {{count($arr)}} дней</th>
            </tr>
        @endif


        <tr>
            <th rowspan="3">Дата</th>
            <th rowspan="3">Количество проголосовавших</th>
            <th rowspan="3">ИЭЛ</th>
            <th colspan="8">Критики</th>
            <th colspan="4">Нейтралы</th>
            <th colspan="4" class="table-success">Промоутеры</th>
        </tr>
        <tr>
            <td rowspan="2">Абсолютное количество</td>
            <td rowspan="2">Процент</td>
            <td colspan="6">Абсолютное количество по оценкам</td>
            <td rowspan="2">Абсолютное количество</td>
            <td rowspan="2">Процент</td>
            <td colspan="2">Абсолютное количество по оценкам</td>
            <td rowspan="2">Абсолютное количество</td>
            <td rowspan="2">Процент</td>
            <td colspan="2">Абсолютное количество по оценкам</td>
        </tr>
        <tr>
            @for($j = 1; $j < 11;$j++)
                <td>{{$j}}</td>
            @endfor

        </tr>


        @foreach($arr as $assessment)
            <tr>

                <td>{{$assessment['mainData']['date']}}</td>
                <th scope="col">{{$assessment['additionalData']['count']}}</th>
                <th scope="col">{{round($assessment['mainData']['value'],2)}}</th>

                @php( $count = ($assessment['additionalData']['count'] === 0)? 1 : $assessment['additionalData']['count'])


                <th scope="col">{{$assessment['additionalData']['bad']}}</th>
                <th scope="col">{{round($assessment['additionalData']['bad']/$count*100,2)}}</th>
                @for($j = 1; $j < 7; $j++)
                    <th scope="col">{{$assessment['additionalData']['detail'][$j]}}</th>
                @endfor

                <th scope="col">{{$assessment['additionalData']['neutral']}}</th>
                <th scope="col">{{round($assessment['additionalData']['neutral']/$count*100,2)}}</th>
                @for($j = 7; $j < 9; $j++)
                    <th scope="col">{{$assessment['additionalData']['detail'][$j]}}</th>
                @endfor


                <th scope="col">{{$assessment['additionalData']['good']}}</th>
                <th scope="col">{{round($assessment['additionalData']['good']/$count*100,2)}}</th>
                @for($j = 9; $j < 11; $j++)
                    <th scope="col">{{$assessment['additionalData']['detail'][$j]}}</th>
                @endfor

            </tr>

        @endforeach
        @php($i++)

    @endforeach


</table>