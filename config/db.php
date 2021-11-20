<?php

    $host = '127.0.0.1';
    $user = 'root';
    $password = '';
    $dbname = 'cadastro';

//Data source name - estrutura para descrever uma conexao a uma fonte de dados
$dsn = 'mysql:host=' . $host .'; dbname=' . $dbname;

try {
    //criando a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conectado com sucesso";

    }catch(PDOException $e) {
    //mostrar o erro de maneira especifica
    echo "Conexao falhou: " . $e->getMessage();
    }