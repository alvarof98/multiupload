<?php 
/*                                 
                                Estructura de datos del archivo $_FILES, trabajar con esta estructura de datos
array (
  'archivo' => 
  array (
    'name' => 
    array (
      0 => 'AORUS.DAT',
      1 => 'BSL430.dll',
    ),
    'type' => 
    array (
      0 => 'application/octet-stream',
      1 => 'application/x-msdownload',
    ),
    'tmp_name' => 
    array (
      0 => '/tmp/phpjgC3gc',
      1 => '/tmp/phpdZzFuq',
    ),
    'error' => 
    array (
      0 => 0,
      1 => 0,
    ),
    'size' => 
    array (
      0 => 55802,
      1 => 25088,
    ),
  ),
)

*/

class Multiupload{
    
    private 
    $archivo,
    $target = './',
    $nombre;
    
    //Al iniciar el constructor, recorrer archivo por archivo y subirlo
    function __construct(){
        foreach($_FILES["archivo"]['tmp_name'] as $atributo => $valor){
          if($_FILES["archivo"]['name'][$atributo] != ''){
            $archivo = $_FILES["archivo"]['tmp_name'][$atributo];
            $nombre = $_FILES["archivo"]['name'][$atributo];
            $targetFinal = $target . $nombre;
            if (move_uploaded_file($archivo, $targetFinal)) {
              echo 'Se ha subido correctamente el archivo '.$nombre . '<br></br>';
            }else{
                echo 'El archivo '.$nombre.' no se ha subido correctamente' . '<br></br>';
            }
          }else{
            echo 'Error al subir el archivo, no existe';
          }
        }
    }
  }
