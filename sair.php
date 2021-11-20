<?php 
    //DESTRUIR A SESSAO DO LOGIN E MANDAR DE VOLTA PARA O INDEX PRINCIPAL
    session_start();
    if(isset($_SESSION['userId'])){
        session_destroy();
        header('Location: http://localhost/ecommerce/index.php');
    }

?>