@extends('main')

@section('content')
    <div class="card col-lg-6 main-card">


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
            <a href="{{route('getStatisticInExcel')}}" id="excelA" class="btn btn-success float-right">Выгрузить в
                Excel</a>
        </div>


        <table class="table table-bordered table-striped" style="width: 100% !important;">

            <tr>
                <th rowspan="2"><span style="font-weight:700">Количество голосов</span></th>
                <th rowspan="2">ИЭЛ</th>
                <th colspan="10">Абсолютное количество голосов по оценкам</th>
            </tr>
            <tr>
                @for($j = 1; $j < 11;$j++)
                    <td>{{$j}}</td>
                @endfor

            </tr>
            <tr id="mainData">
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="6">Критики</td>
                <td colspan="2">Нейтралы</td>
                <td colspan="2">Промоутеры</td>
            </tr>
            <tr id="percentData">

            </tr>
            <tr id="absoluteData">

            </tr>

        </table>


        <hr class="my-4">
        <script>


            $(document).ready(
                function () {

                    CanvasJS.addCultureInfo("ru",
                        {

                            days       : ["понедельник", "вторник", "среда", "четверг", "пятница", "суббота", "воскресенье"],
                            months     : ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"],
                            shortMonths: ["янв", "фев", "мар", "апр", "май", "июн", "июл", "авг", "сен", "окт", "ноя", "дек"]
                        });

                    var chartGroupData = [];
                    var chartGroup = new CanvasJS.Chart("chartContainerGroup", {
                        animationEnabled: true,
                        title           : {
                            text: "Процентное соотношение групп на текущий момент"
                        },
                        data            : [{
                            type              : "pie",
                            yValueFormatString: "0.00",
                            tooltipContent    : "<d>{label}</b>: {y}%",
                            showInLegend      : "true",
                            legendText        : "{label}",
                            indexLabel        : "{label}: Абсолютное значение - {abs} ; Процент - {y}%",
                            dataPoints        : chartGroupData,
                        }]
                    });

                    var chartDetailData = [];
                    var chartDetail = new CanvasJS.Chart("chartContainerDetail", {
                        animationEnabled: true,
                        title           : {
                            text: "Процентное соотношение по каждой оценке"
                        },
                        data            : [{
                            type              : "pie",
                            yValueFormatString: "0.00",
                            tooltipContent    : "<d>{label}</b>: {y}%",
                            showInLegend      : "true",
                            legendText        : "{label}",
                            indexLabel        : "{label}: Абсолютное значение - {abs} ; Процент - {y}%",
                            dataPoints        : chartDetailData,
                        }]
                    });

                    var points = [];
                    var chart = new CanvasJS.Chart("chartContainer", {
                        zoomEnabled     : true,
                        animationEnabled: true,
                        culture         : "ru",
                        title           : {
                            text: "Динамика за 180 дней"
                        },
                        axisX           : {
                            valueFormatString: "DD MMMM YYYY"
                        },
                        axisY2          : {
                            title            : "ИЭЛ",
                            suffix           : "%",
                            valueFormatString: "0.00",
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
                            type              : "line",
                            markerSize        : 0,
                            yValueFormatString: "0.00",
                            name              : "Значение",

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
                                let value = assessmentNow.mainData.value;
                                let detail = assessmentNow.additionalData.detail;

                                let tr = "<td>" + count + "</td>";

                                count = (count === 0) ? 1 : count;
                                tr += "<td>" + value.toFixed(2) + "</td>";
                                for (let i = 1; i < 11; i++) {
                                    tr += "<td>" + detail[i] + "</td>";
                                }

                                $('#mainData td').detach();
                                $('#mainData').append(tr);


                                tr = "<td colspan='2'>Процент от общего количества</td>";
                                tr += "<td colspan='6'>" + (((bad / count) * 100).toFixed(2)) + "</td>";
                                tr += "<td colspan='2'>" + (((neutral / count) * 100).toFixed(2)) + "</td>";
                                tr += "<td colspan='2'>" + (((neutral / good) * 100).toFixed(2)) + "</td>";

                                $('#percentData td').detach();
                                $('#percentData').append(tr);

                                tr = "<td colspan=2>Абсолютное количество</td>";
                                tr += "<td colspan=6>" + bad + "</td>";
                                tr += "<td colspan=2>" + neutral + "</td>";
                                tr += "<td colspan=2>" + good + "</td>";

                                $('#absoluteData td').detach();
                                $('#absoluteData').append(tr);


                                var newPoints = result.arrAssessment.map((item) => {
                                    return {x: new Date(item.date), y: item.value}
                                });

                                points.length = 0;
                                for (let i = 0; i < newPoints.length; i++) {
                                    points.push(newPoints[i]);
                                }
                                chart.render();

                                chartGroupData.length = 0;
                                chartGroupData.push({label: 'Нейтралы', y: (neutral / count) * 100, abs: neutral});
                                chartGroupData.push({label: 'Критики', y: (bad / count) * 100, abs: bad});
                                chartGroupData.push({label: 'Промоутеры', y: (good / count) * 100, abs: good});

                                chartGroup.render();

                                chartDetailData.length = 0;
                                for (let i = 1; i < 11; i++) {
                                    chartDetailData.push({label: i, y: (detail[i] / count) * 100, abs: detail[i]});
                                }
                                chartDetail.render();


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


                });
        </script>


        <div id="chartContainerGroup" style="height: 370px; width: 100%;"></div>
        <div id="chartContainerDetail" style="height: 370px; width: 100%;"></div>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

        <div>
            <button class="btn btn-primary float-right" id="reload">Обновить данные</button>
        </div>

        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </div>

@endsection
