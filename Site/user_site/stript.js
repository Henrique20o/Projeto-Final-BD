google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Curtidas');
        data.addColumn('number', 'Quantidade');
        data.addRows([
            ['Menos de 100', <?php echo $menosDe100; ?>],
            ['Mais de 500', <?php echo $maisDe500; ?>],
            ['Mais de 1500', <?php echo $maisDe1500; ?>],
            ['Mais de 2000', <?php echo $maisDe2000; ?>]
        ]);

        var options = {
            title: 'Estatísticas de Curtidas',
            width: 900,
            height: 500
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }

    