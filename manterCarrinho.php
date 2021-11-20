<!-----------CARRINHO------------>
<?php							

    echo '<div class="titulocarrinho"> 
            <h1>Carrinho</h1>
          </div>';

		if(empty($_SESSION)){
            echo '<div class="titulocarrinho"> 
			        <p>Carrinho Vazio</p>;
                  </div>';
		}else{
        echo '<div id="content">';
            echo ' <div id="tabelaProdutos">';
                echo "<table>";
                    echo "<thead>
                            <tr>
                                <td>Produto</td>
                                <td>Preço</td>
                                <td>Qntd</td>
                            </tr>
                        </thead>
                    <tbody>";
                    
                //----------PEGA VALOR FLOAT DO PRECO E VALOR INT QUANDIDADE PARA CALCULAR O TOTAL---------//
                    $total_carrinho = 0;
                    foreach($_SESSION as $prod){
                                                   
                    if(isset($prod['id_prod'])){
                    $preco =  number_format($prod['preco'],2,',','');
                        $total_carrinho += 	floatval($prod['preco']) * intval($prod['qntd']);
                            echo "<tr>
                                    <td>{$prod['nome']}</td>
                                    <td>R$ {$preco}</td>
                                    <td style='text-align: center;'>{$prod['qntd']}</td>
                                </tr>";																
                            }
                    }

                    echo "</tbody>";
                    $total_carrinho = number_format($total_carrinho,2,',','');
                //----------PEGA VALOR FLOAT DO PRECO E VALOR INT QUANDIDADE PARA CALCULAR O TOTAL---------// 

                echo "</table>";


         //----------MOSTRA RESULTADO FINAL DA COMPRA---------//
            echo '<div class="price">';
                echo "
                    <p>SubTotal:</p>
                    R$ {$total_carrinho}
                ";
            echo "</div>";
         //----------MOSTRA RESULTADO FINAL DA COMPRA---------//

	}

    //----------CONDICAO PARA APENAS USUARIO LOGADOS VER BOTAO BOMPRAR---------//
        echo '<div class="btncarrinho">';
            if( isset($_SESSION['userId']) ){
                echo "<button class='btncompra' id='bt-finaliza-compra'>Finalizar Compra</button>";	
            }

            if(!empty($_SESSION)){
                echo "<button id='bt-limpa-carrinho'>Limpar Carrinho</button><br>";								
            }
        echo "</div>";
     //----------CONDICAO PARA APENAS USUARIO LOGADOS VER BOTAO BOMPRAR---------//

    echo "</div>";
    echo "</div>";
?>							
<!-----------CARRINHO------------>


<!---------- ADICIONAR E REMOVER ---------->
<?php   

    //----------ADICIONAR PRODUTO---------->        
    if(isset($_GET['add_produto']) && !empty($_GET['add_produto'])){

        $id_prod = (int) $_GET['add_produto'];        

        if(isset($_SESSION["prod_$id_prod"])){
          $_SESSION["prod_$id_prod"]['qntd']++;
          // getProduto($id_prod);
        }else{
          // Pegar os dados do produto
          $query_produtos = "SELECT nomeProduto, precoProduto from produtos where id = ?";
          $stmt = $pdo->prepare($query_produtos);
          $stmt->bindParam(1,$id_prod);
          $stmt->execute();      
          $result = $stmt->fetch();

          $_SESSION["prod_$id_prod"] =  array('id_prod' => $id_prod,'nome' => $result->nomeProduto, 'preco' => $result->precoProduto,'qntd' => 1);
        }


        // limpa url
        echo '<script type="text/javascript">
          
          document.location = document.location.origin+"/ecommerce/index.php";

        </script>';
        
        // var_dump($_SESSION);
        // session_unset();
    }  
    //----------ADICIONAR PRODUTO----------> 



    //----------LIMPAR CARRINHO----------//
    if(isset($_GET['limpa_carrinho']) && $_GET['limpa_carrinho'] == true){

        echo "entrou no limpa";

        foreach ($_SESSION as $key => $value){
          if($key != 'userId'){
            unset($_SESSION[$key]);
          }
        }

        // limpa url
        echo '<script type="text/javascript">
            document.location = document.location.origin+"/ecommerce/index.php";
        </script>';
    }
    //----------LIMPAR CARRINHO----------//


?>
<!---------- ADICIONAR E REMOVER ---------->