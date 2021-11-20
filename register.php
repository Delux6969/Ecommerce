<?php  
    //verifica quando o botao "cadastrar" for clicado vai executar a funcao
    if(isset($_POST ['cadastrar'])) {
        require('./config/db.php');    
        //filtros para previnir SQLinjection
        $nome     =  filter_var  ($_POST["nome"], FILTER_SANITIZE_STRING);
        $email    =  filter_var  ($_POST["email"], FILTER_SANITIZE_EMAIL);
        $senha    =  filter_var  ($_POST["senha"], FILTER_SANITIZE_STRING);
        $cep      =  filter_var  ($_POST["cep"], FILTER_SANITIZE_STRING);
        $endereco =  filter_var  ($_POST["endereco"], FILTER_SANITIZE_STRING);
        $senhaHashed = password_hash($senha, PASSWORD_DEFAULT);//funcao hash para criptografar a senha do usuario

        if( filter_var ($email, FILTER_VALIDATE_EMAIL) ){

            //$pdo é a variavel que foi declarada na config do banco
            $stmt = $pdo -> prepare('SELECT * from users WHERE email = ?  ');
            $stmt -> execute([$email]);
            $totalUsers = $stmt -> rowCount();

            //se o total de email com esse email é maior que 0, email já registrado
            if($totalUsers > 0){
                $emailRepetido = "Email já registrado!";
            }else{
                $stmt = $pdo -> prepare('INSERT into users( nome, email, senha, cep, endereco ) VALUES( ?, ?, ?, ?, ?)');                                 
                $stmt -> execute( [$nome, $email, $senhaHashed, $cep, $endereco] );
                header('Location: http://localhost/ecommerce/login.php');
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

<form action="register.php" method="POST">
    <div class="login"> <h1>Cadastrar</h1> </div>

    <div class="msg">
        <?php if(isset($emailRepetido)){ ?> <p><?php echo $emailRepetido ?></p> <?php }?>
    </div>

    <input   type="text"      name="nome"      placeholder="Nome"      required/>
    <input   type="email"     name="email"     placeholder="Email"     required/>
    <input   type="password"  name="senha"     placeholder="Senha"     required/>
    <input   type="text"      name="cep"       placeholder="CEP"       required/>
    <input   type="text"      name="endereco"  placeholder="Endereco"  required/>
    <button  name="cadastrar" type="submit"    class="button">Cadastrar</button> 

    <span class="title">Já possui uma conta? <a href="login.php">Entrar</a> </span>  
</form>

    </div>
</div>
</section>
<!-----------CADASTRO------------>


<!-----------FOOTER HTML------------>
<?php require('./inc/footer.html') ?>