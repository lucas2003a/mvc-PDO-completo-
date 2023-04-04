<?php

require_once '../models/Curso.php';

if (isset($_POST['operacion'])){

  $curso = new Curso();

  if ($_POST['operacion'] == 'listar'){

    $datosObtenidos = $curso->listarCursos();
    
    // En esta ocacion NO enviaremos un objeto JSON, en su lugar
    // el controlador renderizara las filas que necesita <tbody></tbody>
    // echo json_encode($datosObtenidos);


    //  PASO 1: Verificar que el objeto contenga datos
    if ($datosObtenidos){
      $numeroFila = 1;
      // Paso 2: Recorrer todo el objeto
      foreach($datosObtenidos as $curso){
        // PASO 3: Ahora construiremos las filas
        echo "
          <tr>
            <td>{$numeroFila}</td>
            <td>{$curso['nombrecurso']}</td>
            <td>{$curso['especialidad']}</td>
            <td>{$curso['complejidad']}</td>
            <td>{$curso['fechainicio']}</td>
            <td>{$curso['precio']}</td>
            <td>
              <a href='#' class='btn btn-danger btn-sm'><i class='bi bi-trash3'></i></a>
              <a href='#' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a>
            </td>
         
          </tr>
        ";
        $numeroFila++;
      }
    }
  }

}
