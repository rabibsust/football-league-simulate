<html>

<head>
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

        tr:nth-child(even) {
            background-color: #dddddd;
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
                                        <th><h5 class="week"></h5>th Week Match Result</th>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table id="prediction">
                                    <tr>
                                        <th><h5 class="week"></h5>th Week Prediction of Championship</th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

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
    function show_league_table()
        {
            $.ajax({
                type: "GET",
                url:"table",
                dataType: "json",
                beforeSend: function() {
                    //$('#response').html("<img src='/images/Preloader_2.gif' />");
                },
                success: function (data) {
                    $.each(data.data,function(i,obj)
                    {
                        var table1 = "<tr><td>"+obj.name+"</td>" +
                                "<td>"+obj.points+"</td>" +
                                " <td>"+obj.played+"</td> " +
                                " <td>"+obj.win+"</td> " +
                                " <td>"+obj.draw+"</td> " +
                                " <td>""</td> " +
                                "<td>"+obj.goal_difference+"</td> </tr>";
                        $("#c_wallpaper_list").append($(table1));
                    });
                    $('#response').hide();
                }
            });
        }
</script>
</html>