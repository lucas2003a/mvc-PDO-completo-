<?php

require_once "Conexion.php";

//MODELO = CONTIENE LA LÓGICA
//extends : HERENCIA (POO) en PHP
class Curso extends Conexion{

  //Objeto que almacene la conexión que viene desde el padre(Conexion)
  //y la compartira con todos los metodos (CRUD)
  private $accesoBD;

  //Constructor, INICIALIZAR
  public function __CONSTRUCT(){
    $this->accesoBD = parent::getConexion();
  }

  //Método listar cursos
  public function listarCursos(){
    try{
      // 1. Preparamos la consulta
      $consulta = $this->accesoBD->prepare("CALL spu_cursos_listar()");
      // 2. Ejecutamos la consulta
      $consulta->execute();
      // 3. Devolvemos el resultado (array asociativo)
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registrarCurso(){
    try{

    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }  
  

  public function eliminarCurso(){
    try{

    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function actualizarCurso(){
    try{

    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

}

?>