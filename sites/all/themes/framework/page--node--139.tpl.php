<?php
foreach($_POST as $nombre_campo => $valor){
  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  eval($asignacion);
}

date_default_timezone_set('Etc/UTC');
require 'sites/all/libraries/PHPMailer-master/PHPMailerAutoload.php';

include("sites/default/settings.php");
$link = mysql_connect($databases['default']['default']['host'], $databases['default']['default']['username'], $databases['default']['default']['password']) or die('No se pudo conectar: ' . mysql_error());      
mysql_select_db($databases['default']['default']['database']) or die('No se pudo seleccionar la base de datos '.$databases['default']['default']['database']);

//$origen="enviar_compra";

switch ($origen) {
  case 'get_valor_bono':
    $query="select b.valor as valor
    from tbl_bonos b
    where b.codigo='".$codigo_bono."'";
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);
    echo $line["valor"];
    mysql_free_result($result);
    mysql_close($link);
  break;

  case 'check_correo'://Aqui se crea la cuenta
    $query="SELECT count(a.pin) as count
    from tbl_clientes a
    where a.correo='".$correo."'";
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);
    if ($line["count"]>0) {
      echo 1;
    } else{
      echo 0;
      $pin=rand(1000, 9999);
      $query="INSERT into tbl_clientes(correo, pin) values
      ('$correo', $pin)";
      $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
      
      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->Username = "ventas.colombianime@gmail.com";
      $mail->Password = "nandito2007";
      $mail->setFrom('ventas.colombianime@gmail.com', 'Colombianime');
      $mail->addReplyTo('ventas.colombianime@gmail.com', 'Elen Colombianime');
      $mail->addAddress($correo, '');
      $mail->Subject = 'Colombianime: Se ha creado tu cuenta!';
      $html = '<html>
      <head>
        <title>¡Se ha creado tu pin! - Colombianime</title>
      </head>
      <body>
        <table>
          <tr>
            <th><img src="http://www.colombianime.com/files/images/logo-colombianime.png" /></th>
          </tr>
          <tr>
            <th>Ya tienes tu pin para realizar compras:</th>
          </tr>
          <tr>
            <td>Hola! '.$correo.' ya tienes tu pin para ingresar a <strong>Colombianime<strong>: '.$pin.'</td>
          </tr>
          <tr>
            <td>Att. Tu amiga Elen ^^</td>
          </tr>
        </table>
      </body>
      </html>';
      $mail->Body=$html;
      $mail->AltBody = 'This is a plain-text message body';
      if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
      }
    }
  break;

  case 'recordar_pass':
    $query="SELECT a.pin
    from tbl_clientes a
    where a.correo='".$correo."'";
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);
    $pin=$line["pin"];
    if ($pin!="") {
      // Enviando correo
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "ventas.colombianime@gmail.com";
        $mail->Password = "nandito2007";
        $mail->setFrom('ventas.colombianime@gmail.com', 'Colombianime');
        $mail->addReplyTo('ventas.colombianime@gmail.com', 'Elen Colombianime');
        $mail->addAddress($correo, '');
        $mail->Subject = 'Colombianime: Aqui esta tu PIN';
        $html = '
        <html>
        <head>
          <title>¡Hemos encontrado tu PIN! - Colombianime</title>
        </head>
        <body>
          <table>
            <tr>
              <th><img src="http://www.colombianime.com/files/images/logo-colombianime.png" /></th>
            </tr>
            <tr>
              <td>Hola! '.$correo.' te enviamos tu PIN para ingresar: <b>'.$pin.'</b></td>
            </tr>
            <tr>
              <td>Att. Tu amiga Elen ^^</td>
            </tr>
            <tr>
              <td><center><a href="http://colombianime.com">http://colombianime.com</a></center></td>
            </tr>
          </table>
        </body>
        </html>';
        $mail->Body=$html;
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
          echo "Se ha enviado el PIN a tu correo electronico.";
        }
    } else{
      echo "No hemos encontrado tu correo electronico en Colombianime.";
    }
  break;

  case 'aplicar_bono':
    $query="SELECT a.id as id, a.valor, a.codigo
    from tbl_bonos a
    where a.codigo='".$bono."' and a.reclamado=0 and a.tienda=$inp_tienda and a.producto='".$productoID."'";
    // echo $query;
    
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);

    if ($line["id"]!=null or $line["id"]!="") {
        $query="UPDATE tbl_bonos
        SET reclamado=1, cliente_cedula='$cedula'
        where id=".$line["id"];
        $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
        $res["id"]=$line["id"];
        $res["valor"]=$line["valor"];
        $res["codigo"]=$line["codigo"];
    } else{
      $res["id"]=0;
    }
    echo json_encode($res);
  break;

  case 'check_cliente':
    $query="SELECT count(a.pin) as count
    from tbl_clientes a
    where a.correo='".$correo. "' and a.pin='".$pin."'";
    
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);
    
    if ($line["count"]>0) {
      echo "get_informacion_cliente";
    } else{
      echo "check_cliente";
    }
    mysql_free_result($result);
    mysql_close($link);
  break;

  case 'enviar_compra':
    // Ingresando compra al sistema/creando el nodo de compra
      //valor
      // link producto
      // recibo $id_producto
      //$id_producto=164;
      $nodeDetails=node_load($id_producto);
      $precio=$nodeDetails->field_precio["und"][0]["value"];
      $precio=number_format($precio);
      $link="http://colombianime.com/".drupal_get_path_alias('node/'.$id_producto);
      //echo "<pre>"; print_r($nodeDetails); echo "</pre>";
      $node = new stdClass();
      $node->title = $nombre." ".$apellidos." - ".$nombre_producto;
      $node->type = "compra";
      $node->field_producto["und"][0]["nid"]=$id_producto;
      $node->field_producto["und"][0]["access"]=1;
      $node->body["und"][0]["value"] = $body;
      $node->field_tipo_entrega["und"][0]["value"] = $field_tipo_entrega;
      $node->field_estado_de_la_compra["und"][0]["value"] = "En proceso";
      $node->field_cliente_cedula["und"][0]["value"] = $cedula;
      $node->field_codigo_bono["und"][0]["value"] = $bonoCODIGO;
      $node->field_valor_bono["und"][0]["value"] = $bonoVAL;
      if ($field_usuario_gestion_compras!="") {
        $node->uid = $field_usuario_gestion_compras;
      }
      $res=node_save($node);
    // Fin

    // Enviando correo al vendedor
      //$field_usuario_gestion_compras=3;
      if ($field_usuario_gestion_compras!="") {
        $user=user_load($field_usuario_gestion_compras);
        $correo_vendedor=$user->mail;
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "ventas.colombianime@gmail.com";
        $mail->Password = "nandito2007";
        // $mail->setFrom($correo_vendedor, 'Colombianime');
        // $mail->addReplyTo('ventas.colombianime@gmail.com', 'Elen Colombianime');
        $mail->addAddress('ventas@colombianime.com', 'Colombianime');
        $mail->addAddress('nandoalvarado022@gmail.com', 'Colombianime');
        $mail->addAddress($correo_vendedor, 'Colombianime');
        $mail->Subject = 'Elen de Colombianime: Felicidades, se ha registrado una venta!';
        $html = '<html>
        <head>
          <title>¡Se ha registrado una compra, por favor revisar! - Colombianime</title>
        </head>
        <body>
          <table>
            <tr>
              <th><img src="http://www.colombianime.com/files/images/logo-colombianime.png" /></th>
            </tr>
            <tr>
              <td>
                '.$nombre." ".$apellidos." esta interesado en: <strong>".$nombre_producto.'<strong>
              </td>
            </tr>
            <tr>
              <th style="text-align: left;">Detalles:</th>
            </tr>
            <tr>
              <td style="width:30%;">Nombre producto:</td><td style="width:30%;">'.$nombre_producto.'</td>  
            </tr>
            <tr>
              <td>Precio:</td><td>$'.$precio.'</td>
            </tr>
            <tr>
              <td>Telefono comprador:</td><td>'.$telefono.'</td>
            </tr>
            <tr>
              <td>Direccion:</td><td>'.$direccion.'</td>
            </tr>
            <tr>
              <td>Att. Tu amiga Elen ^^</td>
            </tr>
          </table>
        </body>
        </html>';
        $mail->Body=$html;
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
          echo "Message sent!";
        }
      } else{
        echo "field_usuario_gestion_compras=0";
      }
    // Fin
  break;

  case 'get_informacion_cliente':
    $query = 'SELECT * FROM tbl_clientes WHERE correo="'.$correo.'"';
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $line = mysql_fetch_array($result, MYSQL_ASSOC);
    echo json_encode($line);
    mysql_free_result($result);
    mysql_close($link);
  break;

  case 'save_info_cliente':
    // Actualizando informacion de la persona
    $query="UPDATE tbl_clientes
    SET nombre='$nombre', apellidos='$apellidos', telefono='$telefono', direccion='$direccion', cedula='$cedula'
    WHERE correo='".$correo."'";
    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    mysql_free_result($result);
    mysql_close($link);
  break;

  case 'testdev':
    
  break;
}?>