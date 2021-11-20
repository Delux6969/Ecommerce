<?php 

require __DIR__ .  '/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
  
  if(isset($_POST["op"]) && $_POST["op"] == "finalizar_compra"){          

      $id_preference = createPreference($_POST['data']);

      if(!empty($id_preference)){
        $id_pedido = insertPedido(intval($_POST['data']['userId']), null, null, intval($id_preference), null);
        insertItensPedido($id_pedido, $_POST['data']);

        exit(json_encode(['id' => $id_preference ]));
      }else{
        exit(json_encode(['error' => 'erro ao criar preference']));
      }

  }

  
  if(isset($_GET['sucess'])){      

      if(isset($_GET['collection_status']) && $_GET['collection_status'] == 'approved'){
          // Update Pedido          
          updatePedido(intval($_GET['preference_id']), $_GET['payment_type'],  $_GET['payment_id'], $_GET['collection_status']);
      }else if(isset($_GET['collection_status']) && $_GET['collection_status'] == 'pedding'){
          updatePedido(intval($_GET['preference_id']), $_GET['payment_type'],  $_GET['payment_id'], $_GET['collection_status']);
      }

      header("Location: http://localhost/ecommerce/index.php");
  }


  function insertPedido($id_user, $tipo_pagamento = null, $payment_id = null, $preference_id, $status = null){
  
      require __DIR__ .'/config/db.php';

      $pedido = "INSERT INTO pedido(id_user, tipo_pagamento, payment_id, preference_id, status) values(?,?,?,?,?);";

      $stmt = $pdo->prepare($pedido);
      $stmt->bindParam(1,$id_user);      
      $stmt->bindParam(2,$tipo_pagamento);
      $stmt->bindParam(3,$payment_id);
      $stmt->bindParam(4,$preference_id);
      $stmt->bindParam(5,$status);
      $stmt->execute();      

      $id = $pdo->lastInsertId();

      return $id;

  }


  function updatePedido($preference_id, $tipo_pagamento,  $payment_id, $status){
      
      require __DIR__ .'/config/db.php';

      try {

        $pedido_upd = "UPDATE pedido set tipo_pagamento = ?, payment_id = ?, status = ? where preference_id = ?";
        $stmt = $pdo->prepare($pedido_upd);
        $stmt->bindParam(1,$tipo_pagamento);      
        $stmt->bindParam(2,$payment_id);
        $stmt->bindParam(3,$status);
        $stmt->bindParam(4,$preference_id);              
        $stmt->execute();

      } catch (Exception $e) {
         print $e->getMessage();
      }
    
  }

  function insertItensPedido($id_pedido, $dados){
      
    require __DIR__ .'/config/db.php';
    foreach($dados as $data){                  
      if(isset($data['id_prod'])){

        $item_pedido = "INSERT INTO itens_pedido(id_pedido, id_prod, qntd) values(?,?,?);";
        $stmt = $pdo->prepare($item_pedido);
        $stmt->bindParam(1,$id_pedido);
        $stmt->bindParam(2,$data['id_prod']);
        $stmt->bindParam(3,$data['qntd']);
        $stmt->execute();
      }

    }

  }

  function createPreference($dados){

    // Configura credenciais
    MercadoPago\SDK::setAccessToken('TEST-5981270941819947-111623-808db2dfcd435c80a5a49f858c28d34a-183840947');

    // Cria um objeto de preferência
    $preference = new MercadoPago\Preference();    

    // configurando urls de status payment
    $preference->back_urls = array(
      "success" => "http://localhost/ecommerce/carrinho.php?sucess",
      "failure" => "http://localhost/ecommerce/carrinho.php?failure",
      "pending" => "http://localhost/ecommerce/carrinho.php?pending"
    );
    
    $preference->auto_return = "approved";
      
    $arrItens = array();

    foreach($dados as $data){              
      
      if(isset($data['id_prod'])){

        $item = new MercadoPago\Item();
        $item->title     = $data['nome'];
        $item->quantity   = intval($data['qntd']);
        $item->unit_price = floatval($data['preco']);

        array_push($arrItens,$item);
      }

    }

    $preference->items = $arrItens;

    $preference->save();    
    
    return $preference->id;

  }


?>