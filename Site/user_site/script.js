// Função para desenhar o gráfico de pizza (Pie Chart)
function drawPieChart(menosDe100, maisDe500, maisDe1500, maisDe2000) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Curtidas');
    data.addColumn('number', 'Quantidade');
    data.addRows([
        ['Menos de 100', menosDe100],
        ['Mais de 500', maisDe500],
        ['Mais de 1500', maisDe1500],
        ['Mais de 2000', maisDe2000]
    ]);

    var options = {
        title: 'Estatísticas de Curtidas',
        width: 900,
        height: 500
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie'));

    chart.draw(data, options);
}

// Função para desenhar o gráfico de colunas (Column Chart)
function drawColumnChart(menosDe100, maisDe500, maisDe1000, maisDe3000) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Compartilhamentos');
    data.addColumn('number', 'Quantidade');
    data.addRows([
        ['Menos de 100', menosDe100],
        ['Mais de 500', maisDe500],
        ['Mais de 1000', maisDe1000],
        ['Mais de 3000', maisDe3000]
    ]);

    var options = {
        title: 'Estatísticas de Compartilhamentos',
        width: 900,
        height: 500
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_column'));

    chart.draw(data, options);
}
