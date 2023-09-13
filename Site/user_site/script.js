google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(fetchData); // Mude para chamar fetchData diretamente

function fetchData() {
    // Função para fazer a solicitação AJAX ao arquivo PHP
    var interesse = document.getElementById('interesses').value; // Valor selecionado do interesse

    
    
    $.ajax(
        url: 'consulta.php',
        type: 'POST',
        data: {data: dados},
        success: function(result){
          // Retorno se tudo ocorreu normalmente
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Retorno caso algum erro ocorra
        }
    });

    $.ajax({
        method: "GET",
        url: "consulta.php?interesses=" + interesse, // Inclua o interesse na URL
        dataType: 'json',
        success: function (jsonData) { // Corrija aqui para receber jsonData como argumento
            // Processar os dados JSON recebidos e criar o gráfico
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Intervalo de Curtidas');
            data.addColumn('number', 'Número de Postagens');

            for (var intervalo in jsonData) {
                data.addRow([intervalo, jsonData[intervalo]]);
            }

            var options = {
                title: 'Distribuição de Curtidas',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        },
        error: function (xhr, status, error) {
            console.error('Erro na solicitação AJAX: ' + status + ' - ' + error);
        }
    });
}
