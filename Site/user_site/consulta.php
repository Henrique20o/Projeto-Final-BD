<?php 
    include("conexao.php");

    try {
        $interesse = $_GET["interesses"];
    
        $sql = "SELECT SUM(p.curtidas) AS total_curtidas,
                COUNT(CASE WHEN p.curtidas > 100 THEN 1 END) AS curtidas_mais_de_100,
                COUNT(CASE WHEN p.curtidas > 1000 THEN 1 END) AS curtidas_mais_de_1000,
                COUNT(CASE WHEN p.curtidas > 5000 THEN 1 END) AS curtidas_mais_de_5000,
                COUNT(CASE WHEN p.curtidas > 10000 THEN 1 END) AS curtidas_mais_de_10000
                FROM postagens p
                INNER JOIN interesses i ON p.interesse_id = i.ID
                WHERE i.interesse = :interesse";
    
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':interesse', $interesse, PDO::PARAM_STR);
        $stmt->execute();
    
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            $totalCurtidas = $resultado['total_curtidas'];
            $curtidasMaisDe100 = $resultado['curtidas_mais_de_100'];
            $curtidasMaisDe1000 = $resultado['curtidas_mais_de_1000'];
            $curtidasMaisDe5000 = $resultado['curtidas_mais_de_5000'];
            $curtidasMaisDe10000 = $resultado['curtidas_mais_de_10000'];
   
        } else {
            echo "Nenhum resultado encontrado para o interesse '$interesse'.";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }

?>