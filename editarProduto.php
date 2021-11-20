<?php

ob_start();
include_once './config/db.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    exit();
}

$query_produto = "SELECT id, nomeProduto, precoProduto, tamanhoProduto FROM produtos WHERE id = $id LIMIT 1";
$result_produto = $pdo->prepare($query_produto);
$result_produto->execute();

if (($result_produto) AND ($result_produto->rowCount() != 0)) {
    $row_produto = $result_produto->fetch(PDO::FETCH_ASSOC);
    
} else {
    header("Location: index.php");
    exit();
}
?>

        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if (!empty($dados['Editproduto'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            } elseif (!filter_var($dados['precoProduto'])) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher com e-mail válido!</p>";
            }

            if (!$empty_input) {
                $query_up_produto= "UPDATE produtos SET nomeProduto=:nomeProduto, precoProduto=:precoProduto, tamanhoProduto=:tamanhoProduto WHERE id=:id";
                $edit_produto = $pdo->prepare($query_up_produto);
                $edit_produto->bindParam(':nomeProduto', $dados['nomeProduto'], PDO::PARAM_STR);
                $edit_produto->bindParam(':precoProduto', $dados['precoProduto'], PDO::PARAM_STR);
                $edit_produto->bindParam(':tamanhoProduto', $dados['tamanhoProduto'], PDO::PARAM_STR);
                $edit_produto->bindParam(':id', $id, PDO::PARAM_INT);
                if($edit_produto->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
                }
            }
        }
        ?>

<?php require('./inc/header.html') ?>
<section>        

<div class="loginContainer">
    <div class="content">

    <div class="titulo">
        <i class="fas fa-circle" style="color: rgb(224, 61, 61);"></i>
        <i class="fas fa-circle" style="color: rgb(209, 195, 0);"></i>
        <i class="fas fa-circle" style="color: rgb(42, 209, 0);"></i>
    </div>

        <form id="edit-produto" method="POST" action="">
            <div class="login"> <h1>Editar</h1></div>

            <input type="text" name="nomeProduto" id="nomeProduto" placeholder="Nome Produto" value="<?php
            if (isset($dados['nomeProduto'])) {
                echo $dados['nomeProduto'];
            } elseif (isset($row_produto['nomeProduto'])) {
                echo $row_produto['nomeProduto'];
            }
            ?>">

           
            <input type="text" name="precoProduto" id="precoProduto" placeholder="Preco Produto" value="<?php
            if (isset($dados['precoProduto'])) {
                echo $dados['precoProduto'];
            } elseif (isset($row_produto['precoProduto'])) {
                echo $row_produto['precoProduto'];
            }
            ?>" >

           
            <input type="text" name="tamanhoProduto" id="tamanhoProduto" placeholder="Tamanho" value="<?php
                   if (isset($dados['tamanhoProduto'])) {
                       echo $dados['tamanhoProduto'];
                   } elseif (isset($row_produto['tamanhoProduto'])) {
                       echo $row_produto['tamanhoProduto'];
                   }
                   ?>" >

            <input class="btneditar" type="submit" value="Salvar" name="Editproduto">
        </form>

            </div>
        </div>
</section>
 