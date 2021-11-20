<?php 
  session_start();

  if(isset($_SESSION['userId'])) {
      require('./config/db.php');
      $userId = $_SESSION['userId'];
      $stmt = $pdo -> prepare('SELECT * from users WHERE id = ?');
      $stmt->execute([$userId]);
      $user = $stmt->fetch();

      if($user->funcao === 'admin') {

        try{

        $funcao = $_POST['userInfo'];
        $targetUserId = $_POST['targetUserId'];

        if( isset($_POST['superEdit']) ) {
          $stmt = $pdo -> prepare('UPDATE users SET funcao = ? WHERE id = ?');
          $stmt->execute([$funcao, $targetUserId]);
        } elseif( isset($_POST['superDelete']) ) {
          $stmt = $pdo -> prepare('DELETE FROM users WHERE id = ?');
          $stmt->execute([$targetUserId]);
        }
        
        header('Location: http://localhost/ecommerce/index.php');
      }catch(Exception $e){
        echo " <script>
                        alert('Usuario nao pode ser apagado, pois possui uma compra vinculada!');
                        document.location = document.location.origin+'/ecommerce/index.php';
                </script>
        
        ";
    }
      }
  }
?>




