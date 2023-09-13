google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(fetchData); // Mude para chamar fetchData diretamente

function fetchData() {
    // Função para fazer a solicitação AJAX ao arquivo PHP
    var interesse = document.getElementById('interesses').value; // Valor selecionado do interesse

    const select = (document.querySelector('#interesses')).value;

    $.ajax({
        url: 'consulta.php',
        type: 'GET',
        data: {data: select},
        success: function(result){
          
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
    });


    };
         
function Mostrar() {
    $.ajax({
        type: "GET",
        url: "consulta.php", // O URL do seu arquivo PHP
        dataType: "json", // Especifica que esperamos um JSON como resposta
        success: (data)=>{
             // 'data' conterá os dados JSON retornados pelo PHP
            console.log(data); // Você pode exibir os dados no console ou fazer algo mais com eles
        },
        error: function(xhr, status, error) {
            console.error("Erro na solicitação AJAX: " + status + " - " + error);
            }
        });
}
