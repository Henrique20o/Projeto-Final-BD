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
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title user" id="offcanvasNavbarLabel"><a href="" class="nav-link active">McLovin</a>
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
                $maisDe2000 = $row["mais_de_2000"];;
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

            $interesseSelecionado = $_POST["interesses"];

            // Inicialize variáveis para contar o número de usuários em cada faixa etária
            $menor18 = 0;
            $entre18e24 = 0;
            $entre25e35 = 0;
            $maior35 = 0;

            // Consulta SQL para obter a quantidade de usuários em cada faixa etária
            $sql = "SELECT 
             idade
        FROM postagens p
        INNER JOIN usuarios u ON p.user_id = u.id
        INNER JOIN interesses i ON p.interesse_id = i.id
        WHERE i.interesse = '$interesseSelecionado'";

            $result = $conexao->query($sql);

            if ($result === false) {
                die("Erro na consulta SQL: " . $conexao->error);
            }

            while ($row = $result->fetch_assoc()) {
                $idade = $row["idade"];

                if ($idade < 18) {
                    $menor18++;
                } elseif ($idade >= 18 && $idade <= 24) {
                    $entre18e24++;
                } elseif ($idade >= 25 && $idade <= 35) {
                    $entre25e35++;
                } else {
                    $maior35++;
                }
            }
            // Verifique se o formulário foi submetido
            {


                // Receba o interesse selecionado a partir do formulário
                $interesseSelecionado = $_POST["interesses"];

                // Consulta SQL para contar publicações por região (Nordeste, Sudeste, etc.)
                $sql = "SELECT
                            SUM(CASE WHEN u.localizacao = 'Nordeste' THEN 1 ELSE 0 END) AS nordeste,
                            SUM(CASE WHEN u.localizacao = 'Sudeste' THEN 1 ELSE 0 END) AS sudeste,
                            SUM(CASE WHEN u.localizacao = 'Sul' THEN 1 ELSE 0 END) AS sul,
                            SUM(CASE WHEN u.localizacao = 'Norte' THEN 1 ELSE 0 END) AS norte,
                            SUM(CASE WHEN u.localizacao = 'Centro-Oeste' THEN 1 ELSE 0 END) AS centroOeste
                        FROM
                            usuarios u
                        INNER JOIN
                            postagens p ON u.id = p.user_id
                        WHERE
                            p.interesse_id = (SELECT id FROM interesses WHERE interesse = '$interesseSelecionado')";

                $result = $conexao->query($sql);

                // Verifique se a consulta foi bem-sucedida
                if ($result === FALSE) {
                    die("Erro na consulta SQL: " . $conexao->error);
                }

                // Obtenha os resultados da consulta
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $nordeste = $row["nordeste"];
                    $sudeste = $row["sudeste"];
                    $sul = $row["sul"];
                    $norte = $row["norte"];
                    $centroOeste = $row["centroOeste"];
                }
                // Feche a conexão com o banco de dados
            }
            // Feche a conexão com o banco de dados
            $conexao->close();
        }
        ?>
        <div class="container mt-5">
            <div class="row" class="container mt-5">
                <div class="col-md-6">
                    <div id="chart_div" style="width: 100%; height: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chart_div2" style="width: 100%; height: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chart_div3" style="width: 100%; height: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chart_div4" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
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
                    width: 600,
                    height: 400
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

                chart.draw(data, options);
            }

            google.charts.load('current', {
                packages: ['corechart', 'bar']
            });

            google.charts.load("current", {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(chartDraw);

            function chartDraw() {
                var data = google.visualization.arrayToDataTable([
                    ["Seleção", "Quantidade", {
                        role: "style"
                    }],
                    ["Menos que 100", <?php echo $menos100; ?>, "blue"],
                    ["Mais que 500", <?php echo $mais500; ?>, "blue"],
                    ["Mais que 1000", <?php echo $mais1000; ?>, "blue"],
                    ["Mais 3000", <?php echo $mais3000; ?>, "blue"]
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2
                ]);

                var options = {
                    title: "Quantidade de postagens com compartilhamentos",
                    width: 600,
                    height: 400,
                    bar: {
                        groupWidth: "95%"
                    },
                    legend: {
                        position: "none"
                    },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("chart_div2"));
                chart.draw(view, options);
            }

            google.charts.load('current', {
                packages: ['corechart', 'bar']
            });

            google.charts.load("current", {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(chartDraw2);

            function chartDraw2() {
                var data = google.visualization.arrayToDataTable([
                    ["Seleção", "Quantidade", {
                        role: "style"
                    }],
                    ["Menores que 18", <?php echo $menor18; ?>, "blue"],
                    ["Maiores que 18", <?php echo $entre18e24; ?>, "blue"],
                    ["Maiores de 24", <?php echo $entre25e35; ?>, "blue"],
                    ["Maiores de 35", <?php echo $maior35; ?>, "blue"]
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2
                ]);

                var options = {
                    title: "Idade dos usuários interessados",
                    width: 600,
                    height: 400,
                    bar: {
                        groupWidth: "95%"
                    },
                    legend: {
                        position: "none"
                    },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("chart_div3"));
                chart.draw(view, options);

                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart2);

                function drawChart2() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Localização');
                    data.addColumn('number', 'Quantidade');
                    data.addRows([
                        ['Nordeste', <?php echo $nordeste; ?>],
                        ['Sudeste', <?php echo $sudeste; ?>],
                        ['Sul', <?php echo $sul; ?>],
                        ['Norte', <?php echo $norte; ?>],
                        ['Centro-Oeste', <?php echo $centroOeste; ?>]
                    ]);

                    var options = {
                        title: 'Estatísticas de Curtidas',
                        width: 500,
                        height: 350
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));

                    chart.draw(data, options);
                }
            }
        </script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>

</body>

</html>