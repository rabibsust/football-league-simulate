<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>League Simulation</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        #leage tr:nth-child(even) {
            background-color: #dddddd;
        }
        #result tr:nth-child(even) {
            background-color: #dddddd;
        }
        #result td, th {
            border: 0px;
            text-align: left;
            padding: 8px;
        }
        #prediction tr:nth-child(even) {
            background-color: #dddddd;
        }

        .right{
            float:right;
            margin-right: 10px;
            padding: 8px;
        }

        .left{
            float:left;
            margin-left: 10px;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    
                </div>
                <div class="panel-body">
                    <table>
                        <tr>
                            <th>League Table</th>
                            <th>Match Results</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>
                                <table id="leage">
                                    <tr>
                                        <th>Teams</th>
                                        <th>PTS</th>
                                        <th>P</th>
                                        <th>W</th>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>LGD</th>
                                    </tr>
                                    
                                </table>
                            </td>
                            <td>
                                <table id="result">
                                    <tr>
                                        <th><div class="week"></div></th>
                                    </tr>

                                </table>
                            </td>
                            <td>
                                <table id="prediction">
                                    <tr>
                                        <th><div class="week_pred"></div></th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <button id="play_all" class="left">Play All</button>
                    <button id="play" class="right" week="">Next Week</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.4.0.min.js"
  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
  crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        show_league_table();

        $(document).on('click',"button#play_all", function (e) {
            simulate_all();
        });

        $(document).on('click',"button#play", function (e) {
            var week = parseInt($(this).attr('week')) + 1;
            simulate_weekly(week);
        });
        
    });
    function show_league_table()
    {
        $('.items').remove();
        $.ajax({
            type: "GET",
            url:"table",
            dataType: "json",
            beforeSend: function() {
                //$('#response').html("<img src='/images/Preloader_2.gif' />");
            },
            success: function (data) {
                show_result_table(data.week);
                show_prediction(data.week)
                $.each(data.data,function(i,obj)
                {
                    var table1 = "<tr class='items'><td>"+obj.name+"</td>" +
                            "<td>"+obj.points+"</td>" +
                            " <td>"+obj.played+"</td> " +
                            " <td>"+obj.win+"</td> " +
                            " <td>"+obj.draw+"</td> " +
                            " <td></td> " +
                            "<td>"+obj.goal_difference+"</td> </tr>";
                    $("table#leage").append($(table1));
                });
                $(".week_pred").html(data.week + "th Week Prediction of Championship");
                $(".week").html(data.week + "th Week Match Result");
                $("button#play").attr('week',data.week);
                $('#response').hide();
            }
        });
    }

    function show_result_table(week)
    {
        $('.res-item').remove();
        $.ajax({
            type: "GET",
            url:"weekly",
            dataType: "json",
            data: { 
                week: week
            },
            beforeSend: function() {
                //$('#response').html("<img src='/images/Preloader_2.gif' />");
            },
            success: function (data) {
                $.each(data,function(i,obj)
                {
                    var table1 = "<tr class='res-item'><td>"+obj.result+"</td></tr>";
                    $("table#result").append($(table1));
                });
            }
        });
    }

    function simulate_all(){
        $.ajax({
            type: "POST",
            url:"all",
            dataType: "json",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                show_league_table();
            }
        });
    }

    function simulate_weekly(week){
        $.ajax({
            type: "POST",
            url:"weekly",
            dataType: "json",
            data: { 
                _token: "{{ csrf_token() }}",
                week: week
            },
            success: function (data) {
                //show_league_table();
                location.reload();
            }
        });
    }

    function show_prediction(week){
        $.ajax({
            type: "GET",
            url:"prediction",
            dataType: "json",
            data: { 
                week: week
            },
            beforeSend: function() {
                //$('#response').html("<img src='/images/Preloader_2.gif' />");
            },
            success: function (data) {
                $.each(data,function(i,obj)
                {
                    var table1 = "<tr class='res-item'><td>"+ i + " " +parseInt(obj)+"%</td></tr>";
                    $("table#prediction").append($(table1));
                });
            }
        });
    }
</script>
</html>
