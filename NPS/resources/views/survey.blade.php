@extends('main')

@section('content')


    @if($request->surveyParticipant !== null)

        <form class="card-body was-validated text-center" id="data">
            <h2 class="card-title">Добрый день!</h2>
            <p class="card-text">Мы хотели бы узнать</p>

            <hr class="my-4">
            <h2>Какова вероятность того, что Вы посоветуете нас своим знакомым?</h2>

            @for($i=1;$i<11;$i++)
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radio{{$i}}" name="assessment" value="{{$i}}" class="custom-control-input"
                           required>
                    <label class="custom-control-label" for="radio{{$i}}">{{$i}}</label>
                </div>
            @endfor


            <hr class="my-4">


            <p class="card-text">Мы ценим голос каждого нашего клиента и не допустим головования от вашего имени!</p>

            {{$request->firstCall}}
            @if(!$request->isAuth)
                @if($request->isFirstCall)

                    <p class="card-text">Поскольку вы голосуете впервые, мы просим вас ввести свой уникальный ключ,
                        чтобы злоумышленники не смогли голосовать от вашего имени.</p>

                    <small class="form-text text-muted">В качестве ключа вы можите использовать свой Email
                    </small>
                    <div class="input-group mb-3">

                        <input type="text" name="key" id="key" aria-label="Пароль" placeholder="Секретный ключ"
                               class="form-control"
                               required>

                        <input type="text" name="tip" id="tip" aria-label="Введите подсказку..."
                               placeholder="Введите подсказку..."
                               class="form-control" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="submit" name="submit"> Проголосовать
                            </button>
                        </div>
                    </div>


                @else

                    <p> Пожалуйста введите ваш секретный ключ.</p>
                    <small class="form-text text-muted">При регистрации первого ответа, обычно, мы просим ввести ваш
                        Email
                    </small>

                    <div class="input-group mb-3">
                        <input type="text" name="key" id="key" class="form-control" placeholder="Секретный ключ"
                               aria-label="Секретный ключ" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="submit" name="submit">
                                Проголосовать
                            </button>
                        </div>
                    </div>

                @endif
            @else

                <div class="row">
                    <div class="col float-right">

                        <button class="btn btn-primary float-right" id="submit" name="submit">
                            Проголосовать
                        </button>
                    </div>

                </div>
            @endif


        </form>


        <script>

            function getFormData($form) {
                var unindexed_array = $form.serializeArray();
                var indexed_array = {};

                $.map(unindexed_array, function (n, i) {
                    indexed_array[n['name']] = n['value'];
                });

                return indexed_array;
            }

            $(document).ready(() => {

                $("#data").submit(function (event) {


                    event.preventDefault();

                    var data = getFormData($("#data"));
                    data.assessment = data.assessment - 0;

                    var JSONData = JSON.stringify(data);

                    $('input').prop("disabled", true);
                    $('#submit').text(' Загрузка...').prop("disabled", true).prepend('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    $('#answer').remove();

                    console.log(JSONData);

                    $.ajax({
                        type   : 'POST',
                        url    : "{{route('setAssessment',[$request->surveyParticipant->id])}}",
                        data   : JSONData,
                        success: function (result) {

                            result = JSON.parse(result);
                            if (result.code === 1) {
                                $('#submit').text(' Проголосовать').removeClass().addClass('btn btn-success float-right').detach('span').prop("disabled", true);
                                $('form').append('<div id="answer">' +
                                    '<h3> Ваш ответ принят!</h3>' +
                                    '<a href="{{route('assessmentPage',[$request->surveyParticipant->id])}}">Проголосовать еще раз</a>');

                            } else {

                                $('#submit').text(' Проголосовать').removeClass().addClass('btn btn-danger float-right').detach('span').prop("disabled", false);
                                $('input').prop("disabled", false);

                                if (result.code === 7) {
                                    $('form').append('<div id="answer">' +
                                        '<h3> Ответ не принят!!!</h3><p> Вы совершили ошибку при вводе секретного кода.</p> ' +
                                        '<p class="card-text"> Ваша подсказка: ' + result.tip + '</p></div>');
                                    $('#tip').remove();
                                } else {
                                    $('form').append('<div id="answer">' +
                                        '<h3> Упссссс.... Что то пошло не так. Попробуйте проголосовать еще раз.</h3>' +
                                        '<a href="{{route('assessmentPage',[$request->surveyParticipant->id])}}">Перезагрузить</a>');

                                    $('#submit').prop("disabled", true);
                                }


                            }
                        },

                        error: function (result) {

                            console.log(result);
                        }
                    });

                });
            });
        </script>

    @else

        <h1>Похоже, что вы потерялись!</h1>
        <p>Обратитесь к системному администратору для полуение вашей ссылки для голосования</p>
        <img src="https://i.simpalsmedia.com/forum.md/comments/900x900/ecd7efdfee7cd9a8995ea0a8a69acacb.jpg">

    @endif

@endsection
