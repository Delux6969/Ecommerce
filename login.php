<?php  
     session_start();  
    //verifica quando o botao "ENTRAR" for clicado vai executar a funcao
    if(isset($_POST ['entrar'])) {
        require('./config/db.php');   

        //filtros para previnir SQLinjection
        $email  =  filter_var  ($_POST["email"], FILTER_SANITIZE_EMAIL);
        $senha  =  filter_var  ($_POST["senha"], FILTER_SANITIZE_STRING);

        $stmt = $pdo -> prepare('SELECT * from users WHERE email = ?');
        $stmt -> execute([$email]);
        $user = $stmt -> fetch();

        if( isset($user) ) {
            if(password_verify($senha, $user -> senha) ){
                $_SESSION['userId'] = $user -> id;
                $_SESSION['funcao'] = $user -> funcao;
                header('Location: http://localhost/ecommerce/index.php');
            }else{
                $loginErrado = "Email e/ou senha incorreto(s)";
            }
        }

    }
?>

<!-----------HEADER HTML------------>
<?php require('./inc/header.html') ?>


<!-----------CADASTRO------------>
<section>        

<div class="loginContainer">
    <div class="content">

    <div class="titulo">
        <i class="fas fa-circle" style="color: rgb(224, 61, 61);"></i>
        <i class="fas fa-circle" style="color: rgb(209, 195, 0);"></i>
        <i class="fas fa-circle" style="color: rgb(42, 209, 0);"></i>
    </div>

<form action="login.php" method="POST">
    <div class="login"> <h1>Login</h1> </div>

    <div class="msg2">
        <?php if(isset($loginErrado)){ ?> <p><?php echo $loginErrado ?></p> <?php }?>
    </div>

    <input   type="email"     name="email"     placeholder="Email"     required/>
    <input   type="password"  name="senha"     placeholder="Senha"     required/>
   
    <button  name="entrar"    type="submit"    class="button">Entrar</button> 

    <span class="title">Não possui uma conta? <a href="register.php">Cadastrar</a> </span>  
</form>

    </div>
</div>
</section>
<!-----------CADASTRO------------>


<!-----------FOOTER HTML------------>
<?php require('./inc/footer.html') ?>