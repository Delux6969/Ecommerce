<?php  

    session_start();

    if( isset($_SESSION['userId']) ){
        require('./config/db.php');

        $userId = $_SESSION['userId'];

        if( isset($_POST['editar']) ){
            $nome     =  filter_var  ($_POST["nome"], FILTER_SANITIZE_STRING);
            $email    =  filter_var  ($_POST["email"], FILTER_SANITIZE_EMAIL);
            $cep      =  filter_var  ($_POST["cep"], FILTER_SANITIZE_STRING);
            $endereco =  filter_var  ($_POST["endereco"], FILTER_SANITIZE_STRING); 

            $stmt = $pdo -> prepare('UPDATE users SET nome=? , email=?, cep=?, endereco=? WHERE id=? ');
            $stmt -> execute( [ $nome, $email, $cep, $endereco, $userId ] );
        }

        $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
        $stmt -> execute([ $userId ]);
        
        $user = $stmt -> fetch();

    }


?>

<!-----------HEADER HTML------------>
<?php require('./inc/header.html') ?>


<!-----------EDITAR------------>
<section>        

<div class="loginContainer">
    <div class="content">

    <div class="titulo">
        <i class="fas fa-circle" style="color: rgb(224, 61, 61);"></i>
        <i class="fas fa-circle" style="color: rgb(209, 195, 0);"></i>
        <i class="fas fa-circle" style="color: rgb(42, 209, 0);"></i>
    </div>

<form action="perfil.php" method="POST">
    <div class="login"> <h1>Perfil</h1> </div>

    <div class="msg">
        <?php if(isset($emailRepetido)){ ?> <p><?php echo $emailRepetido ?></p> <?php }?>
    </div>

    <input   type="text"      name="nome"      placeholder="Nome"     value="<?php echo $user->nome ?>"       required/>
    <input   type="email"     name="email"     placeholder="Email"    value="<?php echo $user->email ?>"      required/>
    <input   type="text"      name="cep"       placeholder="CEP"      value="<?php echo $user->cep ?>"        required/>
    <input   type="text"      name="endereco"  placeholder="Endereco" value="<?php echo $user->endereco ?>"   required/>
    <button  name="editar" type="submit"    class="button">Editar</button> 
 
</form>

    </div>
</div>
</section>
<!-----------EDITAR------------>


<!-----------FOOTER HTML------------>
<?php require('./inc/footer.html') ?>