<table>

    @php($i = 0)
    @foreach($data as $arr)


        @if($i === 0)
            <tr>
                <th colspan=6>Данные на текущий момент</th>
            </tr>
        @else

            <tr>
                <th colspan=6></th>
            </tr>

            <tr>
                <th colspan=6>Данные за последние {{count($arr)}} дней</th>
            </tr>
        @endif


        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Количество проголосовавших</th>
            <th scope="col">'ИЭЛ'</th>
            <th scope="col">Процент критиков</th>
            <th scope="col">Процент промоутеров</th>
            <th scope="col">Процент нейтралов</th>
        </tr>

        @foreach($arr as $assessment)
            <tr>
                <th scope="col">{{$assessment['mainData']['date']}}</th>
                <th scope="col">{{$assessment['additionalData']['count']}}</th>
                <th scope="col">{{$assessment['mainData']['value']}}</th>

                @php( $count = ($assessment['additionalData']['count'] === 0)? 1 : $assessment['additionalData']['count'])

                <th scope="col">{{$assessment['additionalData']['bad']/$count*100}}</th>
                <th scope="col">{{$assessment['additionalData']['good']/$count*100}}</th>
                <th scope="col">{{$assessment['additionalData']['neutral']/$count*100}}</th>
            </tr>
        @endforeach
        @php($i++)

    @endforeach


</table>