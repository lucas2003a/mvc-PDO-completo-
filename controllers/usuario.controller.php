<?php
session_start();
require_once '../models/Usuario.php';

if (isset($_POST['operacion'])){

  $usuario = new Usuario();

  // Identificando la operación
  if ($_POST['operacion'] == 'login'){

    $registro = $usuario->iniciarSesion($_POST['nombreusuario']);

    $_SESSION["login"] = false;

    // Objeto para contener el resultado
    $resultado = [
      "status"    => false,
      "mensaje"   => ""
    ];

    if ($registro){
      // El usuario si existe
      $claveEncriptada = $registro["claveacceso"];
      
      // Validar contraseña
      if (password_verify($_POST['claveIngresada'], $claveEncriptada)){
        $resultado["status"] = true;
        $resultado["mensaje"] = "Bienvenido al sistema";
        $_SESSION["login"] = true;
      }else{
        $resultado["mensaje"] = "Error en la contraseña";
      }

    }else{
      // El usuario no existe
      $resultado["mensaje"] = "No encontramos al usuario";
    }

    // Enviamos el objeto resultado a la vista
    echo json_encode($resultado);

  }

  // CRUD DE USUARIOS
  if ($_POST['operacion'] == 'listar'){
    $datosObtenidos = $usuario->listarUsuarios();
    if ($datosObtenidos){
      $numeroFila = 1;
      foreach($datosObtenidos as $usuario){
        echo "
          <tr>
            <td>{$numeroFila}</td>
            <td>{$usuario['nombreusuario']}</td>
            <td>{$usuario['apellidos']}</td>
            <td>{$usuario['nombres']}</td>
            <td>{$usuario['nivelacceso']}</td>
            <td>{$usuario['fecharegistro']}</td>
            <td>
              <a href='#' data-idusuario='{$usuario['idusuario']}' class='btn btn-danger btn-sm eliminar'><i class='bi bi-trash3'></i></a>
              <a href='#' data-idusuario='{$usuario['idusuario']}' class='btn btn-warning btn-sm editar'><i class='bi bi-pencil-square'></i></a>
            </td>
         
          </tr>
        ";
        $numeroFila++;
      }
    }
  }
  
  if ($_POST['operacion']  == 'registrar'){

    $datosForm = [
      "nombreusuario"   => $_POST['nombreusuario'],
      "claveacceso"     => $_POST['claveacceso'],
      "apellidos"       => $_POST['apellidos'],
      "nombres"         => $_POST['nombres']
    ];

    $usuario->registrarUsuario($datosForm);

  }

  if ($_POST['operacion'] == 'eliminar'){
    $usuario->eliminarUsuario($_POST['idusuario']);
  }

  if ($_POST['operacion'] == 'obtenerusuario'){
    $registro = $usuario->getUsuario($_POST['idusuario']);
    echo json_encode($registro);
  }

  if ($_POST['operacion'] == 'actualizar'){
        $datosForm = [
          "idusuario"       => $_POST['idusuario'],
          "nombreusuario"   => $_POST['nombreusuario'],
          "claveacceso"     => $_POST['claveacceso'],
          "apellidos"       => $_POST['apellidos'],
          "nombres"         => $_POST['nombres'],
          "nivelacceso"     => $_POST['nivelacceso']
        ];
    
        $usuario->actualizarUsuario($datosForm);
    
  }

}


if (isset($_GET['operacion'])){

  if ($_GET['operacion'] == 'finalizar'){
    session_destroy();
    session_unset();
    header('Location:../index.php');
  }
}
