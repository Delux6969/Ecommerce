<?php  

    session_start();

//----------TABELA PEDIDO CLIENTE----------//
    if( isset($_SESSION['userId']) ){
        require('./config/db.php');
        require('./inc/header.html');
        
        $pedidos = loadPedido($_SESSION['userId']);

        echo "	<h1 style='text-align: center; color: rgb(74, 152, 255)'>Minhas Compras</h1>
		 <div id='content'>;
		 <div id='tabelaProdutos'>
        		<table class='table-pedido'>";

		
        echo "
        <thead>
        	<tr>
        		<td>Detalhes</td>
    			<td>Código</td>
    			<td>Tipo Pagamento</td>
    			<td>Código Pag.</td>
    			<td>Status</td>
    			<td>Data de Pag.</td>
				<td>Cliente</td>
				<td>Endereco</td>
				<td>Cep</td>
  			</tr>
		</thead>
		<tbody>";

        foreach ($pedidos as $value) {
        	$formatDate = new DateTime($value->dt_created);
        	$formatDate = $formatDate->format('d/m/Y H:i:s');
        	echo "<tr>
        			<td style='text-align: center;'>
        				<img class='show-details' nid='{$value->id}' style='width: 20px; cursor: pointer;' src='img/angle-arrow-down.svg' alt='arrow-down'>
        			</td>
				    <td style='text-align: center;'>{$value->id}</td>
				    <td style='padding: 5px;text-align: center;'>{$value->tipo_pagamento}</td>
				    <td>{$value->payment_id}</td>
				    <td style='text-align: center;'>{$value->status}</td>
				    <td style='text-align: center;'>{$formatDate}</td>
				    <td style='text-align: center;'>{$value->nome_usuario}</td>
				    <td style='text-align: center;'>{$value->endereco}</td>
				    <td style='text-align: center;'>{$value->cep}</td>";


			
			echo "</tr>";
			
			$id = $value->id;
		    $item = loadItensPedido($id);		    
		    
		    foreach($item as $value){
		    	$preco_item = number_format($value->preco,2,',','');
		    	echo "	<tr class='detail-{$id}' style='display: none;'>		    			
						  	  <td colspan='3' style='padding: 2px;'>{$value->produto}</td>
						  	  <td colspan='3' style='padding: 2px;'>{$value->tamanho}</td>
				              <td colspan='2'>R$ {$preco_item}</td>
				              <td colspan='1'  style='text-align: center;'>{$value->qntd}</td>				        
						</tr>";
						

			    				    
		    }		 			
        	
        }

        echo "</tbody>";
        echo "</table></div></div><br>";

        // Regra mostrar detalhes da compra;
        echo "
        <script>
			$(function(){
	        	$('.show-details').click(function() {
					var id 		= $(this).attr('nid');	
					var details = $('.detail-'+id).toggle();	
					console.log('entrou');
				});
			});

        </script>
        ";
//----------TABELA PEDIDO CLIENTE FIM ----------//


//----------TABELA PEDIDO ADMIN ----------//
        $isAdmin = verifyUserIsAdmin($_SESSION['userId']);

        if($isAdmin){

    	    echo "<div id='div-table'>
    	    		<h1 style='text-align: center; color: rgb(74, 152, 255)'>Todas Compras</h1>   
					<div id='content'>;
		 <div id='tabelaProdutos'> 				
    				<table class='table-pedido'>";
	        echo "
	        <thead>
	        	<tr>
	        		<td>Detalhes</td>
	    			<td>Código</td>
	    			<td>Tipo Pagamento</td>
	    			<td>Código Pag.</td>
	    			<td>Status</td>
	    			<td>Data de Pag.</td>
	    			<td>Cliente</td>
					<td>Endereco</td>
					<td>Cep</td>
	  			</tr>
			</thead>
			<tbody>";
        	$pedidosAll = loadAllPedidos();        
        	
        	foreach($pedidosAll as $value){
	        	$formatDate = new DateTime($value->dt_created);
	        	$formatDate = $formatDate->format('d/m/Y H:i:s');
	        	echo "<tr>	        			
	        			<td style='text-align: center;'>
	        				<img class='show-details-all' pid='{$value->id}' style='width: 20px; cursor: pointer;' src='img/angle-arrow-down.svg' alt='arrow-down'>
	        			</td>

					    <td style='text-align: center;'>{$value->id}</td>
					    <td style='padding: 5px;text-align: center;'>{$value->tipo_pagamento}</td>
					    <td>{$value->payment_id}</td>
					    <td style='text-align: center;'>{$value->status}</td>
					    <td style='text-align: center;'>{$formatDate}</td>
						<td style='text-align: center;'>{$value->nome_usuario}</td>
						<td style='text-align: center;'>{$value->endereco}</td>
				    	<td style='text-align: center;'>{$value->cep}</td>";

				
				echo "</tr>";
				
				$id = $value->id;
			    $item = loadItensPedido($id);		    
			    
			    foreach($item as $value){
			    	$preco_item = number_format($value->preco,2,',','');
			    	echo "	<tr class='detail-{$id}-all' style='display: none;'>		    			
							  	  <td colspan='3' style='padding: 2px;'>{$value->produto}</td>
							  	  <td colspan='3' style='padding: 2px;'>{$value->tamanho}</td>
					              <td colspan='2'>R$ {$preco_item}</td>
					              <td colspan='1'  style='text-align: center;'>{$value->qntd}</td>				        
							</tr>";
						

			    				    
		    	}		 			
        	}

        	echo "</tbody>";
	        echo "</table></div></div><br>";

	        // Regra mostrar detalhes da compra;
	        echo "
	        <script>
				$(function(){
		        	$('.show-details-all').click(function() {
						var id 		= $(this).attr('pid');	
						var details = $('.detail-'+id+'-all').toggle();	
						console.log('entrou');
					});
				});

	        </script>";


        }

        require('./inc/footer.html');

    }
//----------TABELA PEDIDO ADMIN FIM ----------//



//----------VERIFICA SE É ADMIN PARA MOSTRAR OS PEDIDOS ----------//
    function verifyUserIsAdmin($id_user){

      require('./config/db.php');

      $pedido = "select funcao from users where id = ? ";

      $stmt = $pdo->prepare($pedido);
      $stmt->bindParam(1,$id_user);
      $stmt->execute();

      $result = $stmt->fetch();      	     

      if($result->funcao == 'admin'){
      	return true;
      }else{
      	return false;
      }
      

    }
//----------VERIFICA SE É ADMIN PARA MOSTRAR OS PEDIDOS ----------//



//----------ALIAS DE TABELA  Eles servem para renomear umA coluna ou uma tabela ----------//
//----------CARREGAR O PEDIDO DO USUARIO COM NOME ENDERECO E CEP----------//
    function loadPedido($id_user){
      require('./config/db.php');

      $pedido = "select t1.*,t2.nome as nome_usuario, t2.endereco, t2.cep from 
	  pedido t1 
	  inner join users t2
	  on t2.id = t1.id_user
	  where t1.id_user = ?";

      $stmt = $pdo->prepare($pedido);
      $stmt->bindParam(1,$id_user);
      $stmt->execute();

      $result = $stmt->fetchAll();      

      return $result;

    }
//----------CARREGAR O PEDIDO DO USUARIO COM NOME ENDERECO E CEP----------//


//----------CARREGAR TODOS OS PEDIDOS E PARA O ADMIN----------//
    function loadAllPedidos(){

      require('./config/db.php');

      $pedido = "select t1.*,t2.nome as nome_usuario, t2.endereco, t2.cep from 
	  pedido t1 
	  inner join users t2
	  on t2.id = t1.id_user ";

      $stmt = $pdo->prepare($pedido);      
      $stmt->execute();

      $result = $stmt->fetchAll();     

      return $result;

    }
//----------CARREGAR TODOS OS PEDIDOS E PARA O ADMIN----------//


//----------CARREGAR TODOS OS ITENS QUE FORAM ESCOLHIDOS----------//
    function loadItensPedido($id_pedido){
		
		require('./config/db.php');
		//Une duas tabelas 
		$itens = "select 
					 t1.id as id_item_pedido,
					 t1.qntd,
					 t1.id_pedido,
					 t1.id_prod,
					 t2.nomeProduto as produto,
					 t2.tamanhoProduto as tamanho,
					 t2.precoProduto as preco,				 
					 t1.dt_created as dt_created_item
				from itens_pedido t1	
				inner join produtos t2
				on t1.id_prod = t2.id
				where id_pedido = ?";
      
      	$stmt = $pdo->prepare($itens);
      	$stmt->bindParam(1,$id_pedido);
      	$stmt->execute();

      	$result = $stmt->fetchAll();      

      	return $result;				


    }
//----------CARREGAR TODOS OS ITENS QUE FORAM ESCOLHIDOS----------//
?>