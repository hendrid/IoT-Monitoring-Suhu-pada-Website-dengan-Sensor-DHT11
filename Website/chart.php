<?php
$koneksi=mysqli_connect("fdb26.awardspace.net","3444711_jastip","keepitsecret","3444711_jastip");
$no = 0;
$menu = array();
$sql = "SELECT * FROM iot ORDER BY logdate ASC";
$qry = mysqli_query($koneksi, $sql);
while ($row = mysqli_fetch_array($qry)) {
    $temp[] = $row['2'];
    $hum[] = $row['3'];
    $date[] = $row['1'];
    $lasttemp = end($temp);
    $lasthum = end($hum);
}

$aray = join(" ,", $hum);
$array = join(" ,", $temp);
$dat = join("', '", $date);
?>
<html lang="en">

<head>
    <meta http-equiv="refresh" content="60" />
    <title>Grafik Pembacaan Suhu Kelompok 3</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
    <link href="jquery-gauge.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    zoomType: 'xy'
                },
                title: {
                    text: 'Grafik Suhu dan Kelembapan'
                },
                subtitle: {
                    text: 'by: Kelompok 3'
                },
                xAxis: [{
                    categories: ['<?php echo $dat; ?>'],
                    labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }],
                yAxis: [{ // Primary yAxis 
                    labels: {
                        formatter: function() {
                            return this.value + '';
                        },
                        style: {
                            color: '#89A54E'
                        }
                    },
                    title: {
                        text: 'Suhu dan Kelembapan',
                        style: {
                            color: '#4572A7'
                        }
                    }
                }, { // Secondary yAxis 
                    title: {
                        text: '',
                        style: {
                            color: '#4572A7'
                        }
                    },
                    labels: {
                        formatter: function() {
                            return this.value + '';
                        },
                        style: {
                            color: '#4572A7'
                        }
                    },
                    opposite: true
                }],
                tooltip: {
                    formatter: function() {
                        return '' + this.x + ' Nilai= ' + this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 100,
                    verticalAlign: 'top',
                    y: 0,
                    floating: true,
                    backgroundColor: '#FFFFFF'
                },
                series: [{
                    name: 'Humidity',
                    color: '#4572A7',
                    type: 'spline',
                    data: [<?php echo $aray; ?>]
                }, {
                    name: 'Temperature',
                    color: '#658475',
                    type: 'spline',
                    data: [<?php echo $array; ?>]
                }]
            });
        });
    </script>
    <style>
        .demo1 {
            width: 40vw;
            height: 40vw;
            box-sizing: border-box;
            float: left;
            margin: 20px;
            margin-bottom: 0px;
        }

        .demo2 {
            width: 40vw;
            height: 40vw;
            box-sizing: border-box;
            float: right;
            margin: 20px;
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <div style="width: 100%; height: 100%;">
        <div class="gauge1 demo1"></div>
        <div class="gauge2 demo2"></div>
        <div style="left:250px;top:0.2vw;position: absolute;">Temperature</div>
        <div style="right:255px;top:0.2vw;position: absolute;">Humidity</div>
    </div>
    <div id="container" style="width: 100%; height: 100%;"></div>
    <script type="text/javascript" src="jquery-gauge.min.js"></script>
    <script>
        // first example
        $('.gauge1').gauge({
            values: {
                0: '0°C',
                10: '5°C',
                20: '10°C',
                30: '15°C',
                40: '20°C',
                50: '25°C',
                60: '30°C',
                70: '35°C',
                80: '40°C',
                90: '45°C',
                100: '50°C'
            },
            colors: {
                0: 'blue',
                20: '#666',
                40: 'green',
                60: 'orange',
                80: 'red',
            },
            angles: [
                90,
                360
            ],
            lineWidth: 10,
            arrowWidth: 20,
            arrowColor: '#666',
            inset: true,
            value: <?= $lasttemp ?> / 50 * 100
        });

        // second example
        $('.gauge2').gauge({
            values: {
                0: '0%',
                10: '10%',
                20: '20%',
                30: '30%',
                40: '40%',
                50: '50%',
                60: '60%',
                70: '70%',
                80: '80%',
                90: '90%',
                100: '100%'
            },
            colors: {
                80: '#666',
                50: '#378618',
                20: '#ffa500',
                0: '#f00'
            },
            angles: [
                180,
                450
            ],
            lineWidth: 10,
            arrowWidth: 20,
            arrowColor: 'blue',
            inset: true,

            value: <?= $lasthum ?>
        });
    </script>

</body>

</html>