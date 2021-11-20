<?php



    include_once './config/db.php';
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if (!empty($dados['Cadproduto'])) {
            //var_dump($dados);

            $empty_input = false;

            $dados = array_map('trim', $dados);
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            } 

            if (!$empty_input) {
                $query_produto = "INSERT INTO produtos (nomeProduto, precoProduto, tamanhoProduto) VALUES (:nomeProduto, :precoProduto, :tamanhoProduto ) ";
                $cad_produto = $pdo->prepare($query_produto);
                $cad_produto->bindParam(':nomeProduto', $dados['nomeProduto'], PDO::PARAM_STR);
                $cad_produto->bindParam(':precoProduto', $dados['precoProduto'], PDO::PARAM_STR);
                $cad_produto->bindParam(':tamanhoProduto', $dados['tamanhoProduto'], PDO::PARAM_STR);
                $cad_produto->execute();
                if ($cad_produto->rowCount()) {
                    $produtoCadastrado = "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
                    unset($dados);
                } else {
                    echo "<p style='color: #f00;'>Erro: Produto não cadastrado com sucesso!</p>";
                }
            }
        }
        ?>


<!-----------CADASTRO------------>
<section>        

    <div class="msg">
        <?php if(isset($produtoCadastrado)){ ?> 
            <p><?php echo $produtoCadastrado ?>
        </p> <?php }?>
    </div>

<div class="loginContainer">
    <div class="content">

    <div class="titulo">
        <i class="fas fa-circle" style="color: rgb(224, 61, 61);"></i>
        <i class="fas fa-circle" style="color: rgb(209, 195, 0);"></i>
        <i class="fas fa-circle" style="color: rgb(42, 209, 0);"></i>
    </div>

        <form name="cad-produto" method="POST" action="">

            <div class="login"> <h1>Novo Produto</h1> </div>

            <input type="text" name="nomeProduto" id="nomeProduto" placeholder="Nome Produto" value="<?php
            if (isset($dados['nomeProduto'])) {
                echo $dados['nomeProduto'];
            }
            ?>">

        
            <input type="text" name="precoProduto" id="precoProduto" placeholder="Preco" value="<?php
            if (isset($dados['precoProduto'])) {
                echo $dados['precoProduto'];
            }
            ?>">

            <input type="text" name="tamanhoProduto" id="tamanhoProduto" placeholder="Tamanho" value="<?php
            if (isset($dados['tamanhoProduto'])) {
                echo $dados['tamanhoProduto'];
            }
            ?>">


            <input class="button" type="submit" value="Cadastrar" name="Cadproduto">
        </form>
        
        </div>
    </div>
</section>
<!-----------CADASTRO------------>







     