<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, X-Requested-With');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

include('conexao.php');
    $interesse = $_POST["select"];

        $sql = "SELECT
                    COUNT(CASE WHEN p.curtidas > 100 AND p.curtidas <= 1000 THEN 1 END) AS curtidas_100_1000,
                    COUNT(CASE WHEN p.curtidas > 1000 AND p.curtidas <= 2000 THEN 1 END) AS curtidas_1000_2000,
                    COUNT(CASE WHEN p.curtidas > 2000 AND p.curtidas <= 5000 THEN 1 END) AS curtidas_2000_5000,
                    COUNT(CASE WHEN p.curtidas > 5000 AND p.curtidas <= 10000 THEN 1 END) AS curtidas_5000_10000,
                    COUNT(CASE WHEN p.curtidas > 10000 THEN 1 END) AS curtidas_mais_de_10000
                FROM postagens p
                INNER JOIN interesses i ON p.interesse_id = i.ID
                WHERE i.interesse = :interesse";

    
        $resultado = $conexao->prepare($$sql);
        $resultado->execute();

        if ($resultado) {
            $data2 = [
                'Entre 100 e 1000' => $resultado['curtidas_100_1000'],
                'Entre 1000 e 2000' => $resultado['curtidas_1000_2000'],
                'Entre 2000 e 5000' => $resultado['curtidas_2000_5000'],
                'Entre 5000 e 10000' => $resultado['curtidas_5000_10000'],
                'Mais de 10000' => $resultado['curtidas_mais_de_10000']
            ];

            echo json_encode($data2);
                    
        }
