<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/libs/Semantic-UI-CSS-master/semantic.css">
    <link rel="stylesheet" href="../assets/libs/Semantic-UI-CSS-master/semantic.min.css">
    <link href="../node_modules/bootstrap/compiler/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Hello, world!</title>
</head>
<body>
    <header class="navbar navbar-light">
        <div class="container">
            <a href="#" class="navbar-brand h1 fixed">SEN.AI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title user" id="offcanvasNavbarLabel"><a href=""
                            class="nav-link active">McLovin</a>
                        <img class="userimg" src="../assets/img/User.jpg"></img>
                    </h5><br>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item"></li>
                        <li class="nav-item">
                            <a class="nav-link active" href="interesses.html">Interesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="usuarios.html">Usuários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="postagens.html">Postagens</a>
                        </li><br><br><br><br><br><br>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <p class="sair">Sair</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid form1">
        <h1>Selecione um interesse</h1>
        <form class="form-floating" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <select class="form-select" name="interesses" id="interesses">
                <option value="Esportes">Esportes</option>
                <option value="Musica">Música</option>
                <option value="Viagem">Viagem</option>
                <option value="Culinaria">Culinária</option>
                <option value="Tecnologia">Tecnologia</option>
                <option value="Arte">Arte</option>
                <option value="Leitura">Leitura</option>
                <option value="Moda">Moda</option>
                <option value="Jardinagem">Jardinagem</option>
                <option value="Fotografia">Fotografia</option>
                <option value="AnimaisdeEstimacao">Animais de Estimação</option>
                <option value="Filmes">Filmes</option>
                <option value="Danca">Dança</option>
                <option value="Carros">Carros</option>
                <option value="Politica">Política</option>
            </select>
            <input id="submit" class="ui primary button enviar" type="submit" name="enviar" value="ENVIAR">
        </form>
        
        <?php
        // Verifique se o formulário foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {

            include('conexao.php');

            // Receba o interesse selecionado a partir do formulário
            $interesseSelecionado = $_POST["interesses"];

            // Consulta SQL para contar posts com base nas curtidas e interesse selecionado
            $sql = "SELECT 
                        SUM(CASE WHEN curtidas < 100 THEN 1 ELSE 0 END) AS menos_de_100,
                        SUM(CASE WHEN curtidas > 500 THEN 1 ELSE 0 END) AS mais_de_500,
                        SUM(CASE WHEN curtidas > 1500 THEN 1 ELSE 0 END) AS mais_de_1500,
                        SUM(CASE WHEN curtidas > 2000 THEN 1 ELSE 0 END) AS mais_de_2000
                    FROM postagens p
                    INNER JOIN interesses i ON p.interesse_id = i.ID
                    WHERE i.interesse = '$interesseSelecionado'";
            
            $result = $conexao->query($sql);

            // Verifique se a consulta foi bem-sucedida
            if ($result === FALSE) {
                die("Erro na consulta SQL: " . $conexao->error);
            }

            // Obtenha os resultados da consulta
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $menosDe100 = $row["menos_de_100"];
                $maisDe500 = $row["mais_de_500"];
                $maisDe1500 = $row["mais_de_1500"];
                $maisDe2000 = $row["mais_de_2000"];

;
            }
            $interesseSelecionado = $_POST["interesses"];

            // Consulta SQL para contar posts com base nos compartilhamentos e interesse selecionado
            $sql = "SELECT 
                        SUM(CASE WHEN compartilhamentos < 100 THEN 1 ELSE 0 END) AS menos_de_100,
                        SUM(CASE WHEN compartilhamentos > 500 THEN 1 ELSE 0 END) AS mais_de_500,
                        SUM(CASE WHEN compartilhamentos > 1000 THEN 1 ELSE 0 END) AS mais_de_1000,
                        SUM(CASE WHEN compartilhamentos > 3000 THEN 1 ELSE 0 END) AS mais_de_3000
                    FROM postagens p
                    INNER JOIN interesses i ON p.interesse_id = i.ID
                    WHERE i.interesse = '$interesseSelecionado'";
            
            $result = $conexao->query($sql);

            // Verifique se a consulta foi bem-sucedida
            if ($result === FALSE) {
                die("Erro na consulta SQL: " . $conexao->error);
            }

            // Obtenha os resultados da consulta
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $menos100 = $row["menos_de_100"];
                $mais500 = $row["mais_de_500"];
                $mais1000 = $row["mais_de_1000"];
                $mais3000 = $row["mais_de_3000"];

            } else {
                echo "Nenhuma postagem encontrada para o interesse selecionado.";
            }

            // Feche a conexão com o banco de dados
            $conexao->close();

        }
        ?>
    <div class="container-fluid contn">
        <div id="chart_div" style="width: 450px; height: 250px;"></div>
        <div id="chart_div2" style="width: 500px; height: 250px;"></div>
        <div id="chart_div3" style="width: 450px; height: 250px;"></div>
        <div id="chart_div4" style="width: 450px; height: 250px;"></div>
    </div>

<script type="text/javascript">
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
            width: 500,
            height: 350
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }

    google.charts.load('current', {
  packages: ['corechart', 'bar']
});

google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(chartDraw);

    function chartDraw() {
      var data = google.visualization.arrayToDataTable([
        ["Seleção", "Quantidade", { role: "style" } ],
        ["Menos que 100", <?php echo $menos100; ?>, "blue"],
        ["Mais que 500", <?php echo $mais500; ?>, "blue"],
        ["Mais que 1000", <?php echo $mais1000; ?>, "blue"],
        ["Mais 3000", <?php echo $mais3000; ?>, "blue"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Quantidade de postagens com compartilhamentos",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("chart_div2"));
      chart.draw(view, options);
    }

</script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>

</body>
</html>

