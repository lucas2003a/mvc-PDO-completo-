<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] == false){
  header('Location:../');
}

?>
<!doctype html>
<html lang="es">

<head>
  <title>USUARIOS</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

</head>

<body>

  <div class="container mt-3">
    <div class="card">
      <div class="card-header bg-primary text-light">
        <div class="row">
          <div class="col-md-6">
            <strong>LISTA DE USUARIOS</strong>
          </div>
          <div class="col-md-6 text-end">
            <button class="btn btn-success btn-sm" id="abrir-modal" data-bs-toggle="modal" data-bs-target="#modal-registro-usuarios"><i class="bi bi-plus-square"> Agregar Usuario</i></button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-striped" id="tabla-usuarios">
          <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="20%">
            <col width="20%">
            <col width="10%">
            <col width="20%">
            <col width="10%">
          </colgroup>
          <thead>
            <tr>
              <th>#</th>
              <th>Usuario</th>
              <th>Apellidos</th>
              <th>Nombres</th>
              <th>Nv.Acceso</th>
              <th>Fecha de Registro</th>
              <th>Operaciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Agregar datos de prueba -->
            <!-- Fin datos de prueba -->
          </tbody>
        </table>
      </div>
      <div class="card-footer text-end">
        <a href="../views/index.php" style="text-decoration: none;" class="btn btn-success btn-sm"><i class="bi bi-arrow-bar-left"></i> Ir a la tabla Cursos</a>
        <a href="../controllers/usuario.controller.php?operacion=finalizar" style="text-decoration: none;" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-left"></i> Cerrar Sesión</a>
    </div>
    </div>
  </div>
  <!-- Fin de container -->


  <!-- Zona de Modales -->
  <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
  <div class="modal fade" id="modal-registro-usuarios" tabindex="-1"  role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary text-light">
          <h5 class="modal-title" id="modal-titulo">Registro de usuarios</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formulario-usuarios" autocomplete="off">
            <div class="mb-3">
              <label for="nombreusuario" class="form-label">Usuario</label>
              <input type="text" class="form-control form-control-sm" id="nombreusuario">
            </div>
            <div class="mb-3">
              <label for="claveacceso" class="form-label">Clave</label>
              <input type="password" class="form-control form-control-sm" id="claveacceso">
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control form-control-sm" id="apellidos">
            </div>
            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres</label>
              <input type="text" class="form-control form-control-sm" id="nombres">
            </div>
            <div class="mb-3">
              <label for="nivelacceso" class="form-label">Nivel de Acceso</label>
              <select id="nivelacceso" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <option value="A">Administrador</option>
                <option value="I">Invitado</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" id="guardar-usuario">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  
  
  <!-- Fin zona de modales -->

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <script>
    $(document).ready(function(){

      // Variables de ámbito general (accesibles)
      let datosNuevos = true;
      let idusuarioactualizar = -1;

      function mostrarusuarios(){
        $.ajax({
          url: '../controllers/usuario.controller.php',
          type: 'POST',
          data: {operacion: 'listar'},
          dataType: 'text',
          success: function(result){
            $("#tabla-usuarios tbody").html(result);
          }
        });
      }

      function registrarusuario(){
        if (confirm("¿Está seguro de salvar los datos?")){
          let datos = {
              operacion     : 'registrar',
              idusuario     : idusuarioactualizar,
              nombreusuario : $("#nombreusuario").val(),
              claveacceso   : $("#claveacceso").val(),
              apellidos     : $("#apellidos").val(),
              nombres       : $("#nombres").val()
            };

          if (!datosNuevos){
            datos["operacion"] = "actualizar";
          }

          $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'POST',
            data: datos,
            success: function(result){
              if (result == ""){
                $("#formulario-usuarios")[0].reset();
                mostrarusuarios();

                $("#modal-registro-usuarios").modal('hide');
              }
            }
          });
        }
      }

      function abrirModal(){
        datosNuevos = true; // Variable de tipo BANDERA
        $("#modal-titulo").html("Registro de usuarios");
        $("#formulario-usuarios")[0].reset();
      }
      // Eventos
      $("#guardar-usuario").click(registrarusuario);
      $("#abrir-modal").click(abrirModal);

      // Al pulsar click sobre el botón ROJO, se elimine el registro
      // Detectaremos eventos de los objetos reados de manera asincrona en...
      $("#tabla-usuarios tbody").on("click", ".eliminar", function (){
        const idusuarioEliminar = $(this).data("idusuario");
        if (confirm("¿Esta seguro de proceder?")){
          $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'POST',
            data: {
              operacion : 'eliminar',
              idusuario   : idusuarioEliminar
            },
            success: function(result){
              if (result == ""){
                mostrarusuarios();
              }
            }
          });
        }
      });

      $("#tabla-usuarios tbody").on("click", ".editar", function(){
        const idusuarioEditar = $(this).data("idusuario");
        $.ajax({
          url: '../controllers/usuario.controller.php',
          type: 'POST',
          data: {
            operacion : 'obtenerusuario',
            idusuario : idusuarioEditar
          },
          dataType: 'JSON',
          success: function(result){
            console.log(result);
            datosNuevos = false;

            // Retornamos los valores a los controles de FORM
            idusuarioactualizar = result['idusuario'];
            $("#nombreusuario").val(result["nombreusuario"]);
            $("#claveacceso").val(result["claveacceso"]);
            $("#apellidos").val(result["apellidos"]);
            $("#nombres").val(result["nombres"]);
            $("#nivelacceso").val(result["nivelacceso"]);

            // Cambiar el titulo del modal
            $("#modal-titulo").html("Actualizar datos de usuario");

            // Ponemos al modal en pantalla
            $("#modal-registro-usuarios").modal("show");
          }
        });

      });

      // Ejecución automatica
      mostrarusuarios();

    });
  </script>

</body>

</html>