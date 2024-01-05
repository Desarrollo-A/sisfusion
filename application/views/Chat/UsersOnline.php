<div>
  <div class="wrapper">
    <?php
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
    $this->load->view('template/sidebar', $datos);
    /*--------------------------------------------------------*/

    if ($this->session->userdata('id_rol') == 20 && empty($permiso)) {
      echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    if($this->session->userdata('id_rol') == 20 && $permiso[0]['estado'] != 1){
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

  <style>
    .d-flex{
      display:flex;
    }
    .justify-end{
      justify-content: flex-end;
    }
    .align-end{
      align-items: flex-end;
    }
    .form-control-borderless {
        border: none;
    }
    .form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
        border: none;
        outline: none;
        box-shadow: none;
    }
    .is-empty{
      width: 80%!important;
      padding: 0!important;
    }
    .btn-primary{
      width: 20%!important;
      margin-left: 10px!important;
      padding: 0!important;
    }
    .box-img{
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin: auto;
    }
    .p-3{
      padding: 30px;
    }
    .pl-3{
      padding: 30px;
    }
    .pr-3{
      padding: 30px;
    }
    .m-0{
      margin: 0;
    }
    .text-center{
      text-align: center;
    }
    .btn-back{
      border-radius: 19px;
      color: #fff;
      background-color: #003d82;
      padding: 10px 15px;
      font-weight: 500;
    }
    .btn-back:hover{
      color: #003d82!important;
      background-color: #eee;
    }
    .off-btn:hover{
      background-color: red;
      color: #fff!important;
      border-radius: 50%;
      padding: 5px;
    }
    #btn-b{
      width: 50px;
      height: 50px;
      border: none;
      border-radius: 0 5px 5px 0;
      background-color: #cac9c9;
      color: #fff;
    }
    #btn-b:hover{
      background-color: #003d82;
    }
    .box-search .form-group{
      padding: 0!important;
      width: 80%!important;
    }
  </style>

  <div class="container-fluid" id="box-principal" style="margin-top: 70px;">
    <div class="container-fluid">      
      <div class="row" style="display:flex; align-items: flex-end">      
        <div class="col-md-8">
          <a href="<?=base_url()?>Chat/UserChat " class="btn-back">Regresar</a>
        </div>  
        <div class="col-md-4">
          <div class="box-search d-flex justify-end align-end">
            <input class="form-control form-control-lg form-control-borderless" type="search" id="buscar" placeholder="Nombre del usuario">
            <button class="" id="btn-b" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="container-fluid pl-3 pr-3">
          <div class="row" id="midiv2">
            <?php
              $estatus=0;
              $vista=0;
              for ($i=0; $i < count($usuarios); $i++) { 
                if($usuarios[$i]['estatus'] == 1 && $usuarios[$i]['id_rol'] == 7){
                  $estatus=1;
                }
            ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
              <div class="card" style="margin-bottom:0">
                <div class="container-fluid p-3" style="height: 375px">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-img" style="background-image: url(<?=base_url()?>static/images/perfil/<?=$usuarios[$i]['id_usuario']?>/<?=$usuarios[$i]['foto']?>); background-position: center; background-repeat: no-repeat; background-size: cover;">
                      </div>
                    </div>
                  
                    <div class="col-md-12 text-center">
                      <h3 style="font-size:16px; height: 50px; line-height: 18px"><b><?=$usuarios[$i]['nombre'] . ' ' . $usuarios[$i]['apellido_paterno'] . ' ' . $usuarios[$i]['apellido_materno'] ?></b></h3>
                      <p class="title m-0"><?=$usuarios[$i]['sede']?></p> 
                      <?php
                        if ($usuarios[$i]['estatus'] == 3) {
                          $vista =3;
                          echo '<p><span class="label label-danger">Offline</span></p>';
                        }
                        elseif ($usuarios[$i]['estatus'] == 2) {
                          $vista =2;
                          echo '<p><span class="label label-warning">Consulta</span></p>';  
                        }
                        elseif ($usuarios[$i]['estatus'] == 1) {
                          $vista =1;
                          echo '<p><span class="label label-success">Online</span></p>';
                          if($usuarios[$i]['id_rol'] == 7){
                            echo '<a href="#" data-toggle="modal" data-target="#exampleModal_'.$i.'"  title="Cerrar sesión"><i class="material-icons off-btn" style="color:red; padding:5px;">power_settings_new</i></a>';
                          }
                        }
                      ?>
                    </div>
                    
                    <div class="modal fade" id="exampleModal_<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="display: flex; justify-content: space-between;">
                            <h5 class="modal-title" id="exampleModalLabel">Cerrar sesión</h5>
                            <button type="button" class="close" onclick="cargar();" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>
                          </div>
                          <div class="modal-body">
                            ¿ Seguro que deseas cerrar la sesión de <?=$usuarios[$i]['nombre']?> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                            <button type="submit" class="btn btn-primary" onclick="Cerrarsesion(<?=$usuarios[$i]['id_usuario']?>,<?=$i?>);" style="padding: 12px 30px!important">Aceptar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- END row -->
                </div><!-- END container-fluid -->
              </div>
            </div>
            <?php
              }
            ?>
          </div>
        </div>
      </div><!-- END card -->
    </div><!-- END container -->
  </div><!-- END container-fluid principal-->
      
</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/socket.io.js"></script>

<script>
  let estatus = <?=$estatus?>;
  let vista = <?=$vista?>;
  if(estatus == 1){
    var socket = io('https://chatcomercial.gphsis.com/');
    socket.on("connect", () => {
    });

    function Cerrarsesion(id,i){
      let formData = {
        "estadoE":3,
        "idasesorE":id
      }
      $.ajax({
        type: 'POST',
        url: '<?=base_url()?>index.php/Chat/CerrarSesionChat',
        data: formData,
        success: function(data) {
          setTimeout('document.location.reload()',10);
          socket.emit('getAsesores', { Ase:id});
          $('#exampleModal_'+i).modal('toggle');
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
      });
    }
  }

  $(document).ready(function(){
    $("#btn-b").click(function(){
      let parametros = {
        "buscar":$('#buscar').val(),
        "estatus":vista
      }
      $.ajax({
        data: parametros,
        url: '<?=base_url()?>index.php/Chat/Busqueda',
        type: 'post',
          success:  function (response) { 
              document.getElementById('midiv2').innerHTML = response;
        },
        error:function(){
              alert("error")
          }
      });
    })
  })
</script>