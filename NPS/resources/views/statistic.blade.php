@extends('main')

@section('content')

    <div class="container-fluid spiner-abs">

        <div class="row justify-content-center">
            <div class="col text-center">


                <span class="spinner-border spinner-border" id="load"></span>


            </div>
        </div>


    </div>


    <a href="{{route('linksGenerator')}}">Генерация ссылок</a>
    <hr class="my-4">


    <div>
        <h3 class="float-left">Текущие данные</h3>
        <button id="excel" class="btn btn-success float-right">Выгрузить в Excell</button>
    </div>
    <table class="table">

        <tr>
            <th scope="col">Количество проголосававших</th>
            <th scope="col">ИЭЛ</th>
            <th scope="col">Процент критиков</th>
            <th scope="col">Процент промоутеров</th>
            <th scope="col">Процент нейтралов</th>
        </tr>
        <tr id="data">
        </tr>
    </table>
    <hr class="my-4">
    <script>


        $(document).ready(
            function () {

                var points = [];
                var chart = new CanvasJS.Chart("chartContainer", {
                    zoomEnabled     : true,
                    animationEnabled: true,
                    title           : {
                        text: "Динамика за 180 дней"
                    },
                    axisX           : {
                        valueFormatString: "DD MMM YYYY"
                    },
                    axisY2          : {
                        title : "ИЭЛ",
                        suffix: "%"
                    },
                    toolTip         : {
                        shared: true
                    },
                    legend          : {
                        cursor            : "pointer",
                        verticalAlign     : "top",
                        horizontalAlign   : "center",
                        dockInsidePlotArea: true,
                        itemclick         : toogleDataSeries
                    },
                    data            : [{
                        type      : "line",
                        markerSize: 0,
                        name      : "Значение",

                        dataPoints: points,
                    }]
                });
                chart.render();

                function toogleDataSeries(e) {

                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }

                    chart.render();
                }

                function loadData() {
                    $("#load").show();
                    $('#reload').prop("disabled", true);

                    $.ajax({
                        exportEnabled: true,
                        type         : 'GET',
                        url          : "{{route('getStatistic')}}",
                        success      : function (result) {

                            $("#load").hide();

                            let assessmentNow = result.assessmentNow;
                            let count = assessmentNow.additionalData.count;
                            let good = assessmentNow.additionalData.good;
                            let bad = assessmentNow.additionalData.bad;
                            let neutral = assessmentNow.additionalData.neutral;
                            let lavue = assessmentNow.mainData.value;

                            let tr = "<td>" + count + "</td><td>" + lavue + "</td><td>" + ((bad / count) * 100) + "</td><td>" + ((good / count) * 100) + "</td><td>" + ((neutral / count) * 100) + "</td>"
                            $('#data td').detach();
                            $('#data').append(tr);


                            var newPoints = result.arrAssessment.map((item) => {
                                return {x: new Date(item.date), y: item.value}
                            });

                            points.length = 0;
                            for (let i = 0; i < newPoints.length; i++) {
                                points.push(newPoints[i]);
                            }
                            chart.render();
                            $('#reload').prop("disabled", false);

                        },

                        error: function (result) {

                            console.log(result);

                        }
                    });
                }

                loadData();

                $('#reload').click(function (e) {
                    loadData();
                })

                $("#excel").click(() => {

                    $.ajax({
                        exportEnabled: true,
                        type         : 'GET',
                        url          : "{{route('getStatisticInExcel')}}",
                        success      : function (result) {
                        },

                        error: function (result) {

                            console.log(result);

                        }
                    });

                });

            });
    </script>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <div>
        <button class="btn btn-primary float-right" id="reload">Обновить данные</button>
    </div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endsection
