<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
  <div class="wrapper">

    <?php
    if($this->session->userdata('id_rol')=="18" || $this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="32" || $this->session->userdata('id_rol')=="31" || $this->session->userdata('id_usuario') == "7310" || $this->session->userdata('id_rol')=="70"){
      $this->load->view('template/sidebar');
    }
    else{
      echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <!-- Modals -->
    <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form method="post" id="form_espera_uno">
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade modal-alertas" id="modal-delete" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" >
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_bonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
              </button>
            </div>
            <div class="modal-body">
              <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                  <div id="nameLote"></div>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="changelogTab">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-plain">
                          <div class="card-content">
                            <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
            </div>
          </div>
      </div>
    </div>
    
    <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
      <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header"></div>
            <form method="post" id="form_abono">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
            </form>
        </div>
      </div>
    </div>
    <!-- END Modals -->
  
    <div class="content boxContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header card-header-icon" data-background-color="goldMaderas">
                <i class="fas fa-gift fa-2x"></i>
              </div>
              <div class="card-content">
                <div class="encabezadoBox">
                  <h3 class="card-title center-align" >Historial de bonos</h3>
                  <p class="card-title pl-1">(Historial de todos los bonos y estatus de pago, para ver bonos activos y/o agregar un abono puedes consultarlos en el panel "Bonos")</p>
                </div>
                <div class="toolbar">
                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group d-flex justify-center align-center">
                          <h4 class="title-tot center-align m-0">Total bonos:</h4>
                          <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="m-0" for="roles">Puesto</label>
                          <select class="selectpicker select-gral" name="roles" id="roles" required>
                            <option value="" disabled="true" selected="selected">Selecciona un rol </option>
                            <?php
                            if($this->session->userdata('id_rol') == 18){
                              echo '  <option value="20">Marketing Digital</option>';
                            } 
                            else{
                              echo '
                              <option value="7">Asesor</option>
                              <option value="9">Coordinador</option>
                              <option value="3">Gerente</option>
                              <option value="2">Sub director</option>   
                              <option value="20">Marketing Digital</option> 
                              ';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="m-0" for="users">Usuario</label>
                          <select class="selectpicker select-gral" id="users" name="users" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UN USUARIO" data-size="7" required></select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="material-datatables">
                  <div class="form-group">
                    <div class="table-responsive">
                      <table class="table-striped table-hover" id="tabla_bonos" name="tabla_bonos">
                        <thead>
                        <tr>
                          <th>ID PAGO</th>
                          <th># BONO</th>
                          <th>USUARIO</th>
                          <th>RFC</th>
                          <th>PUESTO</th>
                          <th>MONTO BONO</th>
                          <th>ABONADO</th>
                          <th>PENDIENTE</th>
                          <th># PAGOS</th>
                          <th>MONTO INDIVIDUAL</th>
                          <th>IMPUESTO</th>
                          <th>TOTAL A PAGAR</th>
                          <th>FECHA CREACIÓN</th>
                          <th>ESTATUS</th>
                          <th>OPCIONES</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>        
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
  </div>
  </div><!--main-panel close-->
  <?php $this->load->view('template/footer');?>
  <!--DATATABLE BUTTONS DATA EXPORT-->
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script>
    $("#tabla_bonos").prop("hidden", true);
    $('#roles').change(function(ruta){
      roles = $('#roles').val();
      param = $('#param').val();
      $("#users").empty().selectpicker('refresh');
      $.ajax({
        url: '<?=base_url()?>Comisiones/getUsuariosRolBonos/'+roles,
        type: 'post',
        dataType: 'json',
        success:function(response){
          var len = response.length;
          for( var i = 0; i<len; i++){
              var id = response[i]['id_usuario'];
              var name = response[i]['name_user'];
              $("#users").append($('<option>').val(id).text(name));
          }

          $("#users").selectpicker('refresh');
        }
      });
    });
  
    $('#roles').change(function(ruta){
      roles = $('#roles').val();
      users = $('#users').val();
      if(users == '' || users == null || users == undefined){
          users = 0;
      }

      getBonusCommissions(roles, users);
    });

    $('#users').change(function(ruta){
      roles = $('#roles').val();
      users = $('#users').val();
      if(users == '' || users == null || users == undefined){
          users = 0;
      }
      else{
        getBonusCommissions(roles, users);
      }
    });

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var tr;
    var tabla_bonos2 ;
    var totaPen = 0;
    
    //INICIO TABLA QUERETARO*********************************************
    let titulos = [];
    $('#tabla_bonos thead tr:eq(0) th').each( function (i) {
      if(i != 0 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_bonos1.column(i).search() !== this.value) {
              tabla_bonos1
                .column(i)
                .search(this.value)
                .draw();

                var total = 0;
                var index = tabla_bonos1.rows({
                selected: true,
                search: 'applied'
            }).indexes();

                var data = tabla_bonos1.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.pago);

                });

                var to1 = formatMoney(total);
                document.getElementById("totalp").textContent = to1;
            }
        });
      }  
    });

    function getBonusCommissions(roles, users){
      $("#tabla_bonos").prop("hidden", false);
      $('#tabla_bonos').on('xhr.dt', function(e, settings, json, xhr) {
          var total = 0;
          $.each(json.data, function(i, v) {
              total += parseFloat(v.pago);
          });
          var to = formatMoney(total);
          document.getElementById("totalp").textContent = '$' + to;
      });
      $("#tabla_bonos").prop("hidden", false);

      tabla_bonos1 = $("#tabla_bonos").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
          extend: 'excelHtml5',
          text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
          className: 'btn buttons-excel',
          titleAttr: 'Descargar archivo de Excel',
          title: 'HISTORIAL BONOS - PAGOS LIQUIDADOS',
          exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
            format: {
              header:  function (d, columnIdx) {
                if(columnIdx == 0){
                  return '';
                }else if(columnIdx == 1){
                  return 'ID PAGO';
                }else if(columnIdx == 2){ 
                  return 'ID BONO';
                }else if(columnIdx == 3){
                  return 'USUARIO';
                }else if(columnIdx == 4){
                  return 'RFC';
                }else if(columnIdx == 5){
                  return 'ROL ';
                }else if(columnIdx == 6){
                  return 'MONTO BONO';
                }else if(columnIdx == 7){
                  return 'ABONDADO';
                }else if(columnIdx == 8){
                  return 'PENDIENTE';
                }else if(columnIdx == 9){
                  return 'NÚMERO PAGO';
                }else if(columnIdx == 10){
                  return 'PAGO INDIVIDUAL';
                }else if(columnIdx == 11){
                  return 'IMPUESTO';
                }else if(columnIdx == 12){
                  return 'TOTAL A PAGAR';
                }else if(columnIdx == 13){
                  return 'FECHA REGISTRO';
                }else if(columnIdx == 14){
                  return 'ESTATUS';
                }else if(columnIdx != 15 && columnIdx !=0){
                  return ' '+titulos[columnIdx-1] +' ';
                }
              }
            }
          },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
          "width": "4%",
          "data": function( d ){
            return '<p class="m-0"><center>'+d.id_pago_bono+'</center></p>';
          }
        },  
        {
          "width": "5%",
          "data": function( d ){
            return '<p class="m-0"><center>'+d.id_bono+'</center></p>';
          }
        },
        {
          "width": "8%",
          "data": function( d ){
            return '<p class="m-0"><b>'+d.nombre+'</b></p>';
          }
        },
         {
          "width": "7%",
          "data": function( d ){
            return '<p class="m-0"><b>'+d.rfc+'</b></p>';
          }
        },
        {
          "width": "7%",
          "data": function( d ){
            return '<p class="m-0">'+d.id_rol+'</p>';
          }
        },
        {
          "width": "7%",
          "data": function( d ){
            if(d.estatus == 2){
              return '<p class="m-0"><center>$'+formatMoney(d.monto)+'</center></p><p style="font-size: .8em"><span class="label" style="background:#5FD482;">LIQUIDADO</span></p>';
            }else{
              return '<p class="m-0"><center>$'+formatMoney(d.monto)+'</center></p>';
            }
          }
        },
        {
          "width": "7%",
          "data": function(d) {
            let abonado = d.n_p*d.pago;
            if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
              abonado = d.monto;
            }else{
              abonado =d.n_p*d.pago;
            }
            return '<p class="m-0"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
          }
        },
        {
          "width": "7%",
          "data": function(d) {
            let pendiente = d.monto - (d.n_p*d.pago);
            if(pendiente < 1){
              pendiente = 0;
            }else{
              pendiente = d.monto - (d.n_p*d.pago);
            }

            if(d.estatus == 2){
              return '<p class="m-0"><center>$ 0.00</center></p>';
            }else{
              return '<p class="m-0"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
            }
          }
        },
        {
          "width": "7%",
          "data": function( d ){
            return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
          }
        },
        {
          "width": "7%",
          "data": function( d ){
            return '<p class="m-0"><center><b>$'+formatMoney(d.pago)+'</b></center></p>';
          }
        },
        {
          "width": "7%",
          "data": function(d) {
            if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
              return '<p class="m-0"><center><b>0%</b></center></p>';
            }else{
              return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
            }
          }
        },
        {
          "width": "7%",
          "data": function(d) {
            if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
              return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
            }else{
              let iva = ((parseFloat(d.impuesto)/100)*d.pago);
              let pagar = parseFloat(d.pago) - iva;
              return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
            }
          }
        },
        {
          "width": "8%",
          "data": function( d ){
            return '<p class="m-0"><center>'+d.fecha_abono+'</center></p>';
          }
        },
        {
          "width": "7%",
          "data": function( d ){
            if(d.estado == 1){
              estatus = d.est;
              color='29A2CC';
            }else if(d.estado == 2){
              estatus=d.est;
              color='9129CC';
            }else if(d.estado == 3){
              estatus=d.est;
              color='05A134';
            }else if(d.estado == 4){
              estatus=d.est;
              color='9129CC';
            }else if(d.estado == 5){
              estatus=d.est;
              color='red';
            }else if(d.estado == 6){
              estatus=d.est;
              color='4D7FA1';
            }
            return '<span class="label label-danger" style="background:#'+color+'">'+estatus+'</span>';
          }
        },
        {
          "width": "5%",
          "orderable": false,
          "data": function( d ){
              return '<button class="btn-data btn-blueMaderas consulta_abonos" value="'+d.id_pago_bono+'" title="Historial"><i class="fas fa-info"></i></button>';
          }
        }],
        columnDefs: [{
          orderable: false,
          className: 'select-checkbox',
          targets: 0,
          searchable:false,
          className: 'dt-body-center'
        }], 
        ajax: {
          url: url2 + "Comisiones/getBonosAllUser/" + roles + "/" + users,
          type: "POST",
          cache: false,
          data: function( d ){
          }
        },
      });
    
      $("#tabla_bonos tbody").on("click", ".consulta_abonos", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#modal_bonos").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE BONO</b></h5></p>');
        $.getJSON("getHistorialAbono2/"+id_pago).done( function( data ){
          $.each( data, function(i, v){
            $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">'+v.comentario+'<br><b style="color:#3982C0;font-size:0.9em;">'+v.date_final+'</b><b style="color:gray;font-size:0.9em;"> - '+v.nombre_usuario+'</b></p></div>');
          });
        });
      });
    }
  
    /**--------------------------------------------------------- */

    $("#form_bonos").on('submit', function(e){ 
      e.preventDefault();
      let formData = new FormData(document.getElementById("form_bonos"));
      formData.append("dato", "valor");
      $.ajax({
        url: 'saveBono',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
          if (data == 1) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            $('#miModalBonos').modal('hide');
            alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
            document.getElementById("form_bonos").reset();
          } else if(data == 2) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            $('#miModalBonos').modal('hide');
            alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
          }else if(data == 3){
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            $('#miModalBonos').modal('hide');
            alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
          }
        },
        error: function(){
          $('#miModalBonos').modal('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
      });
    });

    function filterFloat(evt,input){
      var key = window.Event ? evt.which : evt.keyCode;   
      var chark = String.fromCharCode(key);
      var tempValue = input.value+chark;
      var isNumber = (key >= 48 && key <= 57);
      var isSpecial = (key == 8 || key == 13 || key == 0 ||  key == 46);
      if(isNumber || isSpecial){
        return filter(tempValue);
      }        
      
      return false;    
    }

    function filter(__val__){
      var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
      return (preg.test(__val__) === true);
    }

    function closeModalEng(){
      document.getElementById("form_abono").reset();
      a = document.getElementById('inputhidden');
      padre = a.parentNode;
      padre.removeChild(a);
      $("#modal_abono").modal('toggle');
    }
  
    // FUNCTION MORE
    $(window).resize(function(){
      tabla_bonos1.columns.adjust();
    });

    function formatMoney( n ) {
      var c = isNaN(c = Math.abs(c)) ? 3 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    function cleanCommentsAsimilados() {
      var myCommentsList = document.getElementById('comments-list-asimilados');
      var myCommentsLote = document.getElementById('nameLote');
      myCommentsList.innerHTML = '';
      myCommentsLote.innerHTML = '';
    }
  </script>
</body>