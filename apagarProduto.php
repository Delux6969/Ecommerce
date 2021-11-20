<?php

ob_start();
include_once './config/db.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
var_dump($id);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #111;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_produto = "SELECT id FROM produtos WHERE id = $id LIMIT 1";
$result_produto = $pdo->prepare($query_produto);
$result_produto->execute();

if (($result_produto) AND ($result_produto->rowCount() != 0)) {

    try{
        $query_del_produto = "DELETE FROM produtos WHERE id = $id";
        $apagar_produto = $pdo->prepare($query_del_produto);
    
        if ($apagar_produto->execute()) {
            $_SESSION['msg'] = "<p style='color: green;'>Produto apagado com sucesso!</p>";
            header("Location: index.php");
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Produto não apagado com sucesso!</p>";
            header("Location: index.php");
        }
    } catch(Exception $e){
        echo " <script>
                        alert('Produto nao pode ser apagado, pois possui uma compra vinculada!');
                        document.location = document.location.origin+'/ecommerce/index.php';
                </script>
        
        ";
    }

} 