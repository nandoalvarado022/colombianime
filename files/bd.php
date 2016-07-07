<?php
modu_clear_cache();
db_set_active();
  
  // Definimos la base de datos externa...
  $bd_modu = array(
    'database' => 'descubrebarranquilla',       // nombre de la BD externa
    'username' => 'descubrebarranquilla',         // usuario para acceder a la BD externa
    'password' => 'BXxRtu7t7Uez',             // password del usuario
    'host' => 'localhost',        // host donde se encuentra la BD
    'driver' => 'mysql',          // tipo de BD
  );
 
  try
  {
    Database::addConnectionInfo('drupal', 'default', $bd_modu);
    db_set_active('drupal');
  }
  catch (Exception $e)
  {
     db_set_active();
     return "se produjo un error en la conexion de la base de datos: ".$e;  
  }
?>