<?php
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

$obj = new Usuario();

$headers = 'From: '.$correo."\r\n".
'Reply-To: '.$correo."\r\n" .
'Cc: '.$email_cc."\r\n".
'X-Mailer: PHP/' . phpversion();

$html="
Nombre: ".$nombre."
Correo: ".$correo."
Telefono: ".$telefono."
Mensaje: ".$mensaje."
Link: ".$link_proyecto;

$obj->insertLeads($correo, $nombre, $proyecto, $empresa, $html);

@mail("$email_to, $email_to1", "elheraldo.co - Área Caribe", $html, $headers);
echo "¡El formulario se ha enviado con éxito!, pronto estaremos en contacto con usted.";


class Usuario{
	function __construct(){
		//Database configuration
		$dbServer = '10.61.212.93'; //Define database server host
		$dbUsername = 'ehconcursos'; //Define database username
		$dbPassword = '3KKiH8DSaN'; //Define database password
		$dbName = 'concursos'; //Define database name
		//Connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}

	function insertLeads($remitente, $nombre, $proyecto, $empresa, $mensaje){
		$insert = mysqli_query($this->connect,"INSERT INTO fcorreos SET remitente = '".$remitente."', nombre = '".$nombre."', proyecto = '".$proyecto."', empresa = '".$empresa."', mensaje = '".$mensaje."', fecha = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
		$result = true;
		return $result;
	}
}
?>