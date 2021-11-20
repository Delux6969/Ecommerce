<!-------Conexao com o login-------->
<?php 
 session_start();  
 //isset serve para ver se existe ou nao
 if( isset($_SESSION['userId']) ){
    require('./config/db.php');

    $userId = $_SESSION['userId'];

    $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
    $stmt -> execute([ $userId ]);

    $user = $stmt -> fetch();

    if($user->funcao === 'cliente') {
      $message = "Bem vindo cliente";
    }elseif( $user->funcao === 'admin' ) {
      $stmt = $pdo -> prepare('SELECT * from users');
      $stmt->execute();
      $users = $stmt->fetchAll();
    } 


 }
 
?>

<!-------Conexao com o login-------->



<!-----------HEADER HTML------------>
<?php require('./inc/header.html') ?>
<!-----------HEADER HTML------------>



<!-----------NOME TOPO DA PAGINA------------>
          <div class="nome">
              <?php if(isset($user)) { ?>
                  <h5>bem vindo <?php echo $user->nome ?></h5>
              <?php } else { ?>
                    <h5>Seja bem vindo</h5>
                    <h5>Realize login para Comprar</5>
              <?php } ?>    
          </div>
<!-----------NOME TOPO DA PAGINA------------>



<!-----------PAINEL ADMIN------------>
<?php if(isset($users)) { ?>
<?php if(isset($user)) { ?>  
    
<!-----------TABELA USUARIOS------------>
<div id="tabelaUsuarios">
            <span class="title">Lista de usuários</span>
                
            <table>
        <thead>
            <tr>
              <td>Nome</td>
              <td>Funcao</td>
              <td>Editar</td>
              <td>Excluir</td>
            </tr>                
        </thead>

        <tbody>          
              <?php 

              foreach($users as $loopUser) {                
                if ($loopUser->email != $user->email) {
                      echo "<tr>

                          <form action='adminUpdate.php' method='POST'> 
          				        <td>$loopUser->nome</td>
                          <td>
                              <select name='userInfo'>";

                                if($loopUser->funcao == 'admin') {
                                  echo '<option value="admin">admin</option>
                                  <option value="cliente">Cliente</option>';
                                } elseif($loopUser->funcao == 'cliente') {
                                  echo '<option value="cliente">Cliente</option>
                                  <option value="admin">admin</option>';
                                }

                      echo "</select>
                          </td>

          				      <input type='hidden' name='targetUserId' value='{$loopUser->id}' />
                        <td><button class='btn btn-primary' type='submit' name='superEdit'>Editar</button></td>
          				      <td><button type='submit' name='superDelete'>Deletar</button></td>
                        </form>
                      </tr> 
                  </tbody>";
                }
            } ?>
        </table>
</div>
<!-----------TABELA USUARIOS------------>



<!-----------CADASTRO PRODUTOS------------>
<?php require('./cadastrarProduto.php') ?>
<!-----------CADASTRO PRODUTOS------------>






<?php } ?>
<?php } ?>
<!-----------PAINEL ADMIN------------>



<!-----------CADASTRO PRODUTOS------------>
<?php require('./listarProduto.php') ?>
<!-----------CADASTRO PRODUTOS------------>


<!-----------CARRINHO------------>
<?php 
//if(isset($_SESSION['funcao']) && $_SESSION['funcao'] == 'cliente'){
  require('./manterCarrinho.php') ;
//}
?>
<!-----------CARRINHO------------>



<?php require('./editarProduto.php') ?>
<?php require('./apagarProduto.php') ?>
<!-----------CADASTRO PRODUTOS------------>



<!-----------FOOTER HTML------------>
<?php require('./inc/footer.html') ?>