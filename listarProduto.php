
<div class="good">
<?php

include_once './config/db.php';

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

//----------Receber o número da página----------//
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
//----------Receber o número da página----------//

//Setar a quantidade de registros por página
$limite_resultado = 2;

// Calcular o inicio da visualização
$inicio = ($limite_resultado * $pagina) - $limite_resultado;
echo '<div class="produtoleft">';

//----------SELECIONA OS ITENS CADASTRADOS----------//
$query_produtos = "SELECT id, nomeProduto, precoProduto, tamanhoProduto FROM produtos ORDER BY id DESC LIMIT $inicio, $limite_resultado";
$result_produtos = $pdo->prepare($query_produtos);
$result_produtos->execute();

if (($result_produtos) AND ($result_produtos->rowCount() != 0)) {
    while ($row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC)) {
        extract($row_produtos);
        
            echo '<div class="my_class">';
                echo '<img src="produto.png" >';
                echo "Nome: $nomeProduto <br>";
                echo "Preco: $precoProduto R$ <br>";
                echo "tamanho: $tamanhoProduto <br>";
                // Alter aqui
                echo "<a href='?add_produto=$id'>Adicionar ao Carrinho</a>";
                if(isset($users)) {
                if(isset($user)) { 
                    echo "<a href='editarProduto.php?id=$id'>Editar</a>";
                    echo "<a href='apagarProduto.php?id=$id'>Apagar</a>";
                }
                }
            echo '</div>';
        echo '</div>';
    }
echo '</div>';
//----------SELECIONA OS ITENS CADASTRADOS----------//

//----------SELECIONA OS ITENS CADASTRADOS E FAZ A PAGINACAO----------//
echo '<div class="pagina">';

    //Contar a quantidade de registros no BD
    $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM produtos";
    $result_qnt_registros = $pdo->prepare($query_qnt_registros);
    $result_qnt_registros->execute();
    $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

    //Quantidade de página
    $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);

    // Maximo de link
    $maximo_link = 2;

        echo "<a href='index.php?page=1'>Primeira</a> ";

    for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
        if ($pagina_anterior >= 1) {
            echo "<a href='index.php?page=$pagina_anterior'>$pagina_anterior</a> ";
        }
    }

    echo "$pagina ";

    for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
        if ($proxima_pagina <= $qnt_pagina) {
            echo "<a href='index.php?page=$proxima_pagina'>$proxima_pagina</a> ";
        }
    }
 
        echo "<a href='index.php?page=$qnt_pagina'>Última</a> ";
 

} else {
    echo "<p style='color: #f00;'>Erro: Nenhum Produto encontrado!</p>";
}
//----------SELECIONA OS ITENS CADASTRADOS E FAZ A PAGINACAO----------//

?>
<style>
    .pagina a{
        margin: 0 10px;
        font-weight: 600;
        text-decoration: none;
        color: blue;
    }
</style>
</div>
