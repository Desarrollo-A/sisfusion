
<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

    <style type="text/css">
    ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: white;
        opacity: 0.4;

        ::-moz-placeholder { /* Firefox 19+ */
            color: white;
            opacity: 0.4;
        }

        :-ms-input-placeholder { /* IE 10+ */
            color: white;
            opacity: 0.4;
        }

        :-moz-placeholder { /* Firefox 18- */
            color: white;
            opacity: 0.4;
        }
    }

    #modal_nuevas{
        z-index: 1041!important;
    }

    #modal_vc{
        z-index: 1041!important;
    }

     .lds-dual-ring.hidden {
        display: none;
    }
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,.8);
    z-index: 9999999;
    opacity: 1;
    transition: all 0.5s;
}


</style>


  <!--<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">-->

            <!-- Modal content-->
            <!--<div class="modal-content">
                <div class="modal-header">
                    <button type="button"class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reporte dispersion</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" name="fecha1" id="fecha1" class="form-control">
                        </div>

                        <div class="col-md-6" id="f2">
                            <input type="date" name="fecha2" id="fecha2" class="form-control"> 
                        </div>
 
                </div>
                    


                </div>
                <div class="modal-body">
                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>-->



<div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_pagadas">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>


<!-- modal  AGREGAR PLAN DE ENGANCHE-->
<!--<div class="modal fade modal-alertas" id="modal_enganche" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
            </div>
            <form method="post" id="form_enganche">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->
<!-- modal -->


<!-- modal -->

<!-- modal verifyNEODATA -->
<div class="modal fade modal-alertas"  id="modal_NEODATA" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->
<!-- modal avisos -->
<div class="modal fade" id="modal_avisos" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" style="font-size: 20px;top:20px;" class="close" data-dismiss="modal">  <i class="large material-icons">close</i></button>

            </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer"></div>
        </div>
    </div>
</div>

 

<!-------FIN----> 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                 <div class="card-content">
                                    <div class="material-datatables">
                                    <div class="tab-pane active" id="factura-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <h4 class="card-title" ><b>AJUSTES COMISIONES</b></h4>
                                                                    <!-- <p class="category">Comisiones solictadas por colaboradores para proceder a pago sin factura.</b></p> -->
                                                                    <!-- <p class="category"><i class="material-icons">info</i> Comisiones con saldo disponible en NEODATA, nuevas sin dispersar y abonadas con saldo a favor.</p> -->

                                                                </div>
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <br>
                                                                </div>

                                                                 <!-- <div class="col xol-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <p class="category"><b>Monto</b> hoy: <i id="monto_label">
                                                                        <?php
                                                                            //  $query = $this->db->query("SELECT SUM(abono_neodata) nuevo_general FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono)");

                                                                            //  foreach ($query->result() as $row)
                                                                            //  {
                                                                            //     $number = $row->nuevo_general;
                                                                            //     echo '<B>$'.number_format($number, 3),'</B>';
                                                                            // }
                                                                        ?></i>
                                                                    </p>
                                                                </div> -->

                                                                <!-- <div class="col xol-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <p class="category"><b>Pagos</b> hoy: <i id="pagos_label">
                                                                        <?php
                                                                             $query = $this->db->query("SELECT count(id_pago_i) nuevo_general FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND abono_neodata>0");

                                                                             foreach ($query->result() as $row)
                                                                             {
                                                                                $number = $row->nuevo_general;
                                                                                echo '<B>'.$number,'</B>';
                                                                            }
                                                                        ?></i></p>
                                                                </div>

                                                                <div class="col xol-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <p class="category"><b>Lotes</b> hoy: <i id="lotes_label">
                                                                        <?php 
                                                                             $query = $this->db->query("SELECT count(distinct(id_lote)) nuevo_general FROM comisiones WHERE id_comision IN (select id_comision from pago_comision_ind WHERE MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND id_comision IN (SELECT id_comision FROM comisiones))");

                                                                             foreach ($query->result() as $row)
                                                                             {
                                                                                $number = $row->nuevo_general;
                                                                                echo '<B>'.$number,'</B>';
                                                                            }
                                                                        ?></i></p>
                                                                </div> -->
 

                                                                <!-- <div class="col xol-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <p class="category"><b><a data-target="#myModal" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#myModal">> MÁS DETALLE</a> </b></p>
                                                                </div> -->

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9">
                                                                                 <thead>
                                                                                 <tr>
                                                                                    <th></th>
                                                                                    <th style="font-size: .9em;">ID LOTE</th>
                                                                                    <th style="font-size: .9em;">PROYECTO</th>
                                                                                    <th style="font-size: .9em;">CONDOMINIO</th>
                                                                                    <th style="font-size: .9em;">LOTE</th>
                                                                                    <th style="font-size: .9em;">CLIENTE</th>
                                                                                    <th style="font-size: .9em;">PRECIO</th>
                                                                                    <!-- <th style="font-size: .9em;">MODALIDAD</th> -->
                                                                                    <th style="font-size: .9em;">EST. CONTRATACIÓN</th>
                                                                                    <th style="font-size: .9em;">ENT. VENTA</th>
                                                                                    <th style="font-size: .9em;">ÚLTIMA ACT.</th>
                                                                                    <th style="font-size: .9em;">MÁS</th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="modalAvisos" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="contenido">

    </div>
  </div>
</div>
</body>
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

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";
let rol  = "<?=$this->session->userdata('id_rol')?>"

$("#modal_avisos").draggable({
    handle: ".modal-header"
}); 
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }

    function Confirmacion(i){
        $('#modal_avisos .modal-body').html(''); 
        $('#modal_avisos .modal-body').append(`<h5>¿Seguro que desea topar esta comisión?</h5>
        <br><div class="row"><div class="col-md-12"><center><input type="button" onclick="ToparComision(${i})" id="btn-save" class="btn btn-success" value="GUARDAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>`);
        $('#modal_avisos').modal('show');
  
    }
    function ToparComision(i){
       // $('#modal_avisos').modal('toggle');

        $('#modal_avisos .modal-body').html('');

        let id_comision = $('#id_comision_'+i).val();
        let abonado = replaceAll($('#abonado_'+i).val(), ',','');

        

        $.ajax({
                url: '<?=base_url()?>Comisiones/ToparComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        $('#comision_total_'+i).val(formatMoney(abonado));
                        let pendiente = parseFloat(abonado - abonado);
                        $('#pendiente_'+i).val(formatMoney(pendiente));
                        $('#modal_avisos .modal-body').append('<b>La comisión total se ajustó con éxito</b>');

                    }else{
let suma = 0;
                        console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>Id pago</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    <th>Comentario</th>
                    </tr></thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>
                        <td>${response[j]['comentario']}</td>

                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                }
            }
            });
            $('#modal_avisos').modal('show');   


    }

function Editar(i,precio){
    $('#modal_avisos .modal-body').html('');
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',',''); 
    let nuevoPorce = replaceAll(nuevoPorce1, '%',''); 
    let  abonado =  replaceAll($('#abonado_'+i).val(), ',','');
    let id_comision = $('#id_comision_'+i).val();
    let id_rol = $('#id_rol_'+i).val();
    let pendiente = replaceAll($('#pendiente_'+i).val(), ',',''); 


    if(id_rol == 1 || id_rol == 2 || id_rol == 3 || id_rol == 9 || id_rol == 38 || id_rol == 45){

        if(parseFloat(nuevoPorce) > 1 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(1);
            nuevoPorce=1;
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';

        }

    }else{
        if(parseFloat(nuevoPorce) > 3 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(3);
            nuevoPorce=3;
            document.getElementById('msj_'+i).innerHTML = '';
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 3';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';
        }
    
    }



    let comisionTotal = precioLote * (nuevoPorce / 100);
    console.log(abonado);
    console.log('Comision total:'+comisionTotal);
    $('#btn_'+i).addClass('btn-success');

    if(parseFloat(abonado) > parseFloat(comisionTotal)){
        $('#comision_total_'+i).val(formatMoney(comisionTotal));

        //document.getElementById('btn_'+i).disabled=true;
        $.ajax({

                url: '<?=base_url()?>Comisiones/getPagosByComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        let nuevoPendient=parseFloat(comisionTotal - abonado);
                    $('#pendiente_'+i).val(formatMoney(nuevoPendient));

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado, No se encontraron pagos disponibles para eliminar. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');

                    }else{
let suma = 0;
                        console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>Id pago</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    <th>Comentario</th>
                    </tr></thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>
                        <td>${response[j]['comentario']}</td>

                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                    let nuevoAbono=parseFloat(abonado-suma);
                    let NuevoPendiente=parseFloat(comisionTotal - nuevoAbono);
                    $('#abonado_'+i).val(formatMoney(nuevoAbono));
                    $('#pendiente_'+i).val(formatMoney(NuevoPendiente));


                    if(nuevoAbono > comisionTotal){

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado <b>$'+formatMoney(nuevoAbono)+'</b> (ya con los pagos eliminados),Se eliminar los pagos mostrados una vez guardado el cambio. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');

                    }else{
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b>, se eliminaran los pagos mostrados una vez guardado el ajuste. El nuevo saldo abonado sera de <b>$'+formatMoney(nuevoAbono)+'</b>. <b>No se requiere aplicar descuentos</b> </p>');

                    }



                    }
                    
                 

                }
            });
        $('#modal_avisos').modal('show');   

console.log('NELSON');
    }else{
        let NuevoPendiente=parseFloat(comisionTotal - abonado);
        $('#pendiente_'+i).val(formatMoney(NuevoPendiente));
        document.getElementById('btn_'+i).disabled=false;
        $('#comision_total_'+i).val(formatMoney(comisionTotal));
        console.log('SIMON');


    }
    
        }

function SaveAjuste(i){
     $('#loader').removeClass('hidden');
     $('#btn_'+i).removeClass('btn-success');
     $('#btn_'+i).addClass('btn-default');

    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = $('#porcentaje_'+i).val();
    let comision_total = $('#comision_total_'+i).val();


    // let datos = {
    //     'id_comision':id_comision,
    //     'id_usuario':id_usuario,
    //     'id_lote':id_lote,
    //     'porcentaje':porcentaje,
    //     'comision_total':comision_total
    // }
    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("comision_total", comision_total);




    $.ajax({
                url: '<?=base_url()?>Comisiones/SaveAjuste',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success:function(response){
                  
                    $('#loader').addClass('hidden');
alerts.showNotification("top", "right", "Modificación almancenada con éxito.", "success");

                }
            });

}



/*$('#filtro33').change(function(ruta){
        residencial = $('#filtro33').val();
        $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }
                    $("#filtro44").selectpicker('refresh');
                    $("#filtro55").selectpicker('refresh');

                }
            });
    });*/

    /*$('#filtro44').change(function(ruta){
        conodominio = $('#filtro44').val();
        $("#filtro55").empty().selectpicker('refresh');
            $.ajax({
                url: '<//?=base_url()?>Comisiones/lista_lote/'+conodominio,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idLote'];
                        var name = response[i]['nombreLote'];
                        var totalneto2 = response[i]['totalNeto2'];
                        $("#filtro55").append($('<option>').val(id+','+totalneto2).text(name));
                    }
                    $("#filtro55").selectpicker('refresh');

                }
            });

    });*/

   

    function verificar(precio){
        let precioAnt = parseFloat(precio);
        let  precioAct =  replaceAll($('#precioL').val(), ',','');

       // let precioAct = $('#precioL').val();
        console.log(precioAnt);
        console.log('-----------');
        console.log(precioAct);

        if(rol == 13){
            if(parseFloat(precioAnt) < parseFloat(precioAct)){
document.getElementById('btn-save').disabled = false;
document.getElementById('msj').innerHTML = '';

        }else{
            document.getElementById('msj').innerHTML = 'El precio ingresado es menor al actual, verificarlo con sistemas';
            //alerts.showNotification("top", "right", "El precio ingresado es menor al actual, verificarlo con sistemas.", "warning");
            document.getElementById('btn-save').disabled = true;
        }
        }else{
            document.getElementById('btn-save').disabled = false;
            document.getElementById('msj').innerHTML = '';

        }
       

    }
    /*$('#filtro55').change(function(ruta){
        infolote = $('#filtro55').val();
        datos = infolote.split(',');
        idLote = datos[0];
        $.post("<//?=base_url()?>index.php/Comisiones/getComisionesLoteSelected/"+idLote, function (data) {
  if( data.length < 1){
    document.getElementById('msj').innerHTML = '';
    document.getElementById('btn-aceptar').disabled  = false;
    var select = document.getElementById("filtro55");
var selected = select.options[select.selectedIndex].text;
       // Lote = $('#filtro55').value;
       let beforelote = $('#natahidden').val();
        
       document.getElementById('nota').innerHTML = 'Se reubicará el lote <b>'+beforelote+'</b> a <b>'+selected+'</b>, una vez aplicado el cambio no se podrá revertir este ajuste';
       $('#comentarioR').val('Se reubicará el lote '+beforelote+' a '+selected+', una vez aplicado el cambio no se podrá revertir este ajuste');
       //alert(selected);
  }else{
      document.getElementById('btn-aceptar').disabled  = true;
      document.getElementById('msj').innerHTML = 'El lote seleccionado tiene comisiones registradas.';
   // alerts.showNotification("top", "right", "El lote seleccionado tiene comisiones registradas.", "warning");

  }
            
        }, 'json');






    });*/

$("#tabla_ingresar_9").ready( function(){

    let titulos = [];
$('#tabla_ingresar_9 thead tr:eq(0) th').each( function (i) {

   if(i != 0 && i != 11){
    var title = $(this).text();
    titulos.push(title);

	$(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
	$( 'input', this ).on('keyup change', function () {
		if (tabla_1.column(i).search() !== this.value ) {
			tabla_1
			.column(i)
			.search(this.value)
			.draw();
		}
	} );
}
});


tabla_1 = $("#tabla_ingresar_9").DataTable({
    dom: 'Brtip',
    width: 'auto',
  "buttons": [
      {
           extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn btn-success',
            titleAttr: 'Excel',
            title: 'REPORTE DISPERSIÓN DE PAGO',
          exportOptions: {
              columns: [1,2,3,4,5,6,7,8,9,10],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }else if(columnIdx == 11){
                            return ' '+d +' ';
                        }
                        else if(columnIdx != 11 && columnIdx !=0){
                            
                            if(columnIdx == 12){
                                return 'TIPO'
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
                        }
                    }
                }
            }
        }
    ],

 
    width: 'auto',
"language":{ url: "../static/spanishLoader.json" },
 
"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"columns": [
{
"width": "3%",
"className": 'details-control',
"orderable": false,
"data" : null,
"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
    "width": "5%",
	"data": function( d ){
        var lblStats;
        lblStats ='<p style="font-size: .8em"><b>'+d.idLote+'</b></p>';
		return lblStats;
	}
},
{
"width": "8%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
}
},
{
"width": "8%",
"data": function( d ){
	return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
}
},
{
"width": "11%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreLote+'</p>';

}
}, 
{
"width": "11%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>'+d.nombre_cliente+'</b></p>';

}
}, 
{
"width": "8%",
"data": function( d ){

    return '<p style="font-size: .8em;color:green;"><b>$'+formatMoney(d.totalNeto2)+'</b></p>';
 
    // var lblType;
	// 		if(d.tipo_venta==1) {
	// 			lblType ='<span class="label label-danger">Venta Particular</span>';
	// 		}
	// 		else if(d.tipo_venta==2) {
	// 			lblType ='<span class="label label-success">Venta normal</span>';
	// 		}
    //     return lblType;
    }
}, 

// {
// "width": "8%",
// "data": function( d ){
//     var lblStats;
//             if(d.compartida==null) {
//                 lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
//             }else {
//                 lblStats ='<span class="label label-warning">Compartida</span>';
//             }
//     return lblStats;
// }
// }, 


{
"width": "8%",
"data": function( d ){
    var lblStats;
    if(d.idStatusContratacion==15) {
        // lblStats ='';
        lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';

    }
    else {
        lblStats ='<p><b>'+d.idStatusContratacion+'</b></p>';

        
    }
    return lblStats;
}
},

{
"width": "8%",
"data": function( d ){
    var lblStats;
 

    if(d.registro_comision == 0){
               // btnCambio = '';
               return  '<span class="label label-info">Nueva</span>';
            }else{
                return  '<span class="label label-success">Dispersada</span>';
 
            }

//     if(d.totalNeto2==null) {
//             lblStats ='<span class="label label-danger">Sin precio lote</span>';
//     }
//     else {
        
//         switch(d.lugar_prospeccion){
//         case '6':
//             lblStats ='<span class="label" style="background:#B4A269;">MARKETING DIGÍTAL</span>';
//         break;
        
//         case '12':
//             lblStats ='<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
//         break;
//         case '25':
//             lblStats ='<span class="label" style="background:#0860BA;">IGNACIO GREENHAM</span>';
//         break;

//         default:
//             lblStats ='';
//         break;
//     }
// }
// return lblStats;
 
}
},


{
"width": "8%",
"data": function( d ){
    var lblStats;

    // LAST_NEODATA = new Date(d.fecha_modificacion);
    // lblStats ='<span class="label label-warning">'+d.fecha_modificacion+'</span>';

    if(d.fecha_modificacion <= '2021-01-01' || d.fecha_modificacion == null ) {
         lblStats ='';
            }else {
                lblStats ='<span class="label label-info">'+d.date_final+'</span>';
            }
    return lblStats;
}
}, 


 { 
"width": "14%",
"orderable": false,


"data": function( data ){
    var BtnStats = '';
   // let btnprecio = '';
    let btnCambio= '';
    // let btnreubicacion= `<button class="btn btn-info btn-round btn-fab btn-fab-mini reubicar" title="Re-ubicación" data-nombre="${data.nombreLote}" value="${data.idLote}" style="color:#fff;background:#B5AD5E;background-color:#B5AD5E;"><i class="large material-icons" style="font-size:30px;left:40%;">edit_location</i></button>`;

    
    if(data.totalNeto2==null) {
        BtnStats = '';
    }else {

        if(data.compartida==null) {
            BtnStats = '<button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">loop</i></button>';
            if(data.registro_comision == 0 || data.registro_comision == 8){
                btnCambio = '';
            }else{
                btnCambio = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-tipo="I" data-precioAnt="'+data.totalNeto2+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
			 'class="btn btn-dark btn-round btn-fab btn-fab-mini verify_neodata" title="Verificar en NEODATA">' +
             '<span class="material-icons">build</span></button>&nbsp;&nbsp;';
            }
           
            }else {
                BtnStats = '<button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">loop</i></button>';
                if(data.registro_comision == 0 || data.registro_comision == 8){
                btnCambio = '';
            }else{
                btnCambio = '<button href="#" value="'+data.idLote+'" data-precioAnt="'+data.totalNeto2+'" data-estatus="'+data.idStatusContratacion+'" data-value="'+data.registro_comision+'"  data-code="'+data.cbbtton+'" ' +
                'class="btn btn-dark btn-round btn-fab btn-fab-mini verify_neodata" data-tipo="C" title="Verificar en NEODATA">' +
                '<span class="material-icons">build</span></button>&nbsp;&nbsp;'; 
            } 
            }
        }
        // return BtnStats+btnreubicacion;
        /*<button class="btn btn-danger btn-round btn-fab btn-fab-mini pausar" title="Rescisión de contrato" value="' + data.idLote +'" color:#fff;"><i class="material-icons">do_not_disturb</i></button>
       <button class="btn btn-danger btn-round btn-fab btn-fab-mini pausar" title="Rescisión de contrato" value="' + data.idLote +'" color:#fff;"><i class="material-icons">do_not_disturb</i></button>*/
        return BtnStats+btnCambio;
    }
}

],

columnDefs: [
{
"searchable": false,
"orderable": false,
"targets": 0
},

],

"ajax": {
 "url": '<?=base_url()?>index.php/Comisiones/getDataDispersionPago/'+1,
"dataSrc": "",
"type": "POST",
cache: false,
"data": function( d ){
}
},
"order": [[ 1, 'asc' ]]

});




/*-----------------------------PROCESO DE REUBICACIÓN----------------------------------*/
/*$("#tabla_ingresar_9 tbody").on("click", ".reubicar", function(){

    $.post("<//?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro33").selectpicker('refresh');
        }, 'json');


  



        idLote = $(this).val();
            // alert(idLote);
            nombreLote = $(this).attr("data-nombre");

//alert(idLote);

            // $("#modal_pagadas .modal-header").html("");
            $("#modal_reubicacion .modal-body #aqui").html("");
            $("#modal_reubicacion .modal-footer").html("");
            $("#modal_reubicacion .modal-body #aqui").append(`
            <div class="row">
            <h5>Reubicar <b>${nombreLote}</b> a:</h5>
            </div>
            `);
            $("#modal_reubicacion .modal-body #aqui2").append(`
            <input type="hidden" name="natahidden" id="natahidden" value="${nombreLote}">
            <input type="hidden" name="idlote1" id="idlote1" readonly="readonly" value="${idLote}">
            <input type="hidden" name="comentarioR" id="comentarioR" readonly="readonly">
            <h5 id="nota"></h5>
            `);
            $("#modal_reubicacion .modal-footer").append(`<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" id="btn-aceptar" value="ACEPTAR"></center></div></div>`);
//            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_reubicacion").modal();
        });*/



    

/**------------------------------------FIN REUBICACIÓN--------------------------------------- */



$('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
		 var tr = $(this).closest('tr');
		 var row = tabla_1.row(tr);

		 if (row.child.isShown()) {
			 row.child.hide();
			 tr.removeClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
		 } else {
			var status;
				
				 var fechaVenc;
				 if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38) {
					 status = 'Status 8 listo (Asistentes de Gerentes)';
				 } else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65 ) {
					 status = 'Status 8 enviado a Revisión (Asistentes de Gerentes)';
				 }
				 else
				 {
					 status='N/A';
				 }

				 if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
					 row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
					 fechaVenc = row.data().fechaVenc;
				 }
				 else
				 {
					 fechaVenc='N/A';
				 }

			 
			 var informacion_adicional = '<table class="table text-justify">' +
				 '<tr><b>INFORMACIÓN COLABORADORES</b>:' +
				 '<td style="font-size: .8em"><strong>SUBDIRECTOR: </strong>' + row.data().subdirector + '</td>' +
 				 '<td style="font-size: .8em"><strong>GERENTE: </strong>' + row.data().gerente + '</td>' +
				 '<td style="font-size: .8em"><strong>COORDINADOR: </strong>'+row.data().coordinador+'</td>' +
				 '<td style="font-size: .8em"><strong>ASESOR: </strong>'+row.data().asesor+'</td>' +
				 '</tr>' +
				 '</table>';


			 row.child(informacion_adicional).show();
			 tr.addClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
		 }


     });


$("#tabla_ingresar_9 tbody").on("click", ".cambiar_precio", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();
            // alert(idLote);
            precioAnt = $(this).attr("data-precioAnt");


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">Cambiar precio del lote <b>'+row.data().nombreLote+'</b></h4><br><em>Precio actual: $<b>'+formatMoney(precioAnt)+'</b></em>');
            $("#modal_pagadas .modal-body").append('<input type="hidden" name="idLote" id="idLote" readonly="true" value="'+idLote+'"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="'+precioAnt+'">');
            $("#modal_pagadas .modal-body").append(`<div class="form-group">
            <label>Nuevo precio</label>
            <input type="text" name="precioL" onblur="verificar(${precioAnt})" required id="precioL" class="form-control">
            <p id="msj" style="color:red;"></p>
            </div>`);

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" disabled id="btn-save" class="btn btn-success" value="GUARDAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });

         $("#tabla_ingresar_9 tbody").on("click", ".pausar", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();
            // alert(idLote);


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Estás seguro de mandar a recisión este lote? <b style="color:red;" >'+row.data().nombreLote+'</b>?</h4>');
            $("#modal_pagadas .modal-body").append(`<div class="form-group"><textarea name="Motivo" id="Motivo" class="form-control" placeholder="Describe brevemente el mótivo y detalles de fecha." cols="70" rows="3" required></textarea></div>
            <input type="hidden" name="ideLotep" id="ideLotep" value="${idLote}"><input type="hidden" name="estatusL" id="estatusL" value="8">`);

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });


 
 

     /*$("#tabla_ingresar_9 tbody").on("click", ".liquidarPago", function(){
        var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();


            
            var parametros = {
              "lote" : idLote
      };

console.log(parametros);
            $.ajax({
        type: 'POST',
        url: url2+'Comisiones/LiquidarLote',
        data: parametros,
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                tabla_1.ajax.reload();
                alerts.showNotification("top", "right", "LIQUIDADO.", "success");
               
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

           
     });*/

    

     

        $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();
let cadena = '';
            registro_status = $(this).attr("data-value");
            id_estatus = $(this).attr("data-estatus");
            precioAnt = $(this).attr("data-precioAnt");
            tipo = $(this).attr('data-tipo');
 

            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            
            $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                console.log('NEO');
                console.log(data[0]);
                if(data.length > 0){

                     console.log("entra 1");
                    switch (data[0].Marca) {
                    case '0':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '1':

                    
                    if(registro_status==0 || registro_status==8){//COMISION NUEVA

                    } else if(registro_status==1){

                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                            
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                               total = total0;
                            }else{
                               total = 0; 
                            }

                             
                            // let total = 100000;
                            var counts=0;
                            // console.log(total);

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div>');
                            if(parseFloat(data[0].Bonificado) > 0){

                cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';


                }else{
                cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';


                }

                            // $("#modal_NEODATA .modal-header").append('<div class="row">'+
                            // '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                            // '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                            // '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                            // $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-6"><h4>Aplicado neodata: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div><div class="col-md-6">'+cadena+'</div></div>');
                            // $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Cliente neodata: <b>$'+formatMoney(data[0].AplicadoCliente)+'</b></h4></div></div>');

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> <i>'+row.data().nombreLote+'</i></b></h3></div></div><br>');
                       

                        $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote+"/"+1).done( function( data ){

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-1"><b>GUARDAR %</b></div><div class="col-md-1">TOPAR</div></div>');
                          //  console.log(total);
                         
                          let contador=0;
                          console.log('gree:'+data.length);

                          for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 4415){
                                        contador +=1;
                                    }
                                    
                                }

                            $.each( data, function( i, v){
                                $('#btn_'+i).tooltip({ boundary: 'window' })
                                let nuevosaldo = 0;
       let nuevoabono=0;
       let evaluar =0;
                                if(tipo == "I"){

                                

console.log(i);
                                /*if( v.rol == "Gerente" && v.id_usuario == 832){

                                }else{*/

                                

                                
     saldo =0;                           
if(v.rol_generado == 7 && v.id_usuario == 4415){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
    contador +=1;
}else if(v.rol_generado == 7 && contador > 0){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
}else if(v.rol_generado == 7 && contador == 0){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
else if(v.rol_generado != 7){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
                                


                                if(v.abono_pagado>0){
                                    console.log("OPCION 1");


                                   evaluar = (v.comision_total-v.abono_pagado);
                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    
                                    resta_1 = saldo-v.abono_pagado;
                                    
                                    if(resta_1<1){
                                        // console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(resta_1 >= 1){
                                        // console.log("entra aqui 2");

                                        if(resta_1 > pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;

                                        }
                                        
                                    }


                                //      if(v.id_usuario == 832){
                                //     saldo = (saldo*2);
                                // }


                                    

                                }
                                else if(v.abono_pagado<=0){

                                        console.log("OPCION 2");

                                        pending = (v.comision_total);

                                    if(saldo > pending){
                                        saldo = pending;
                                    }
                                    
                                    if(pending < 1){
                                        saldo = 0;
                                    }
                                }
                            }else{
                                pending = (v.comision_total-v.abono_pagado);
console.log(v.porcentaje_saldos);
     nuevosaldo = 12.5 * v.porcentaje_decimal;

    //    if( v.rol_generado == 7 && v.porcentaje_decimal == 2){
    //         console.log('ENTRA AQUI AL 2%');
    //         nuevosaldo = (parseFloat(v.porcentaje_saldos) / 3)*2;
    //         // parseFloat(v.porcentaje_saldos) / 2;   
    //     }
    //    else if( v.rol_generado == 7 && v.porcentaje_decimal == 1.5){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /2;
    //     }else  if( v.rol_generado == 7 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }else  if( v.rol_generado == 7 && v.porcentaje_decimal == 0.75){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }
        
    //     else if( v.rol_generado == 9 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
    //     }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.5){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
    //     }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.33333){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.33333000000000002){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }
    //     else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.66666){
    //         nuevosaldo =(parseFloat(v.porcentaje_saldos) /3)*2;   
    //     }
    //     /*else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.33333){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
    //     }*/
    //     else if( v.rol_generado == 3 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos);   
    //     }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.5){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) / 2;   
    //     }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.3333333333333333){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.33333000000000002){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
    //     }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.66666000000000003){
    //         nuevosaldo = (parseFloat(v.porcentaje_saldos) /3)*2;   
    //     }
    //     else if( v.rol_generado == 2 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
    //     }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.5){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
    //     }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.3333333333333333){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
    //     }else if( v.rol_generado == 1 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos);   
    //     }else if( v.rol_generado == 38 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos);   
    //     }else if( v.rol_generado == 42 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos);   
    //     }else if( v.rol_generado == 45 && v.porcentaje_decimal == 1){
    //         nuevosaldo = parseFloat(v.porcentaje_saldos);   
    //     }

        saldo = ((nuevosaldo/100)*(total));

if(v.abono_pagado>0){
                                    console.log("OPCION 1");
                                   evaluar = (v.comision_total-v.abono_pagado);
                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    resta_1 = saldo-v.abono_pagado;
                                    if(resta_1<1){
                                        // console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(resta_1 >= 1){
                                        // console.log("entra aqui 2");
                                        if(resta_1 > pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;
                                        }   
                                    }
                                }
                                else if(v.abono_pagado<=0){

                                        console.log("OPCION 2");

                                        pending = (v.comision_total);

                                    if(saldo > pending){
                                        saldo = pending;
                                    }
                                    
                                    if(pending < 1){
                                        saldo = 0;
                                    }
                                }


        if(saldo > pending){
            saldo = pending;
        }
        
        if(pending < 1){
            saldo = 0;
            pending = 0;
        }


                            }
                                 

                                $("#modal_NEODATA .modal-body").append(`<div class="row">
                                <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}"><input type="hidden" name="id_rol" id="id_rol_${i}" value="${v.rol_generado}"><input type="hidden" name="pending" id="pending" value="${pending}">
                                <input type="hidden" name="idLote" id="idLote" value="${idLote}"><input id="id_comision_${i}" type="hidden" name="id_comision_${i}" value="${v.id_comision}"><input id="id_usuario_${i}" type="hidden" name="id_usuario_${i}" value="${v.id_usuario}">
                                <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;"><b><p style="font-size:12px;">${v.rol}</p></b></div>

                                <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" id="porcentaje_${i}" ${(v.rol_generado == 1 || v.rol_generado == 2 || v.rol_generado == 3 || v.rol_generado == 9 || v.rol_generado == 45 || v.rol_generado == 38) ? 'max="1"' : 'max="3"'}   onblur="Editar(${i},${precioAnt})" value="${v.porcentaje_decimal}"><br>
                                <b id="msj_${i}" style="color:red;"></b>
                                </div>
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required"  readonly="true" id="comision_total_${i}" value="${formatMoney(v.comision_total)}"></div>
                                
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required"  readonly="true" id="abonado_${i}" value="${formatMoney(v.abono_pagado)}"></div>
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" id="pendiente_${i}" value="${formatMoney(pending)}"></div>
                                <div class="col-md-1"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                <button type="button" id="btn_${i}" onclick="SaveAjuste(${i})" data-toggle="tooltip" data-placement="top" title="GUARDAR PORCENTAJE" class="btn btn-dark btn-round btn-fab btn-fab-mini"><span class="material-icons">check</span></button> </div>
                                <div class="col-md-1"><button type="button" id="btnTopar_${i}"  data-toggle="tooltip" data-placement="top" title="TOPAR COMISIÓN" onclick="Confirmacion(${i})" class="btn btn-dark btn-round btn-fab btn-fab-mini"><span class="material-icons">pan_tool</span></button></div>
                                </div>`);
                           // }  
                                counts++
                            });
                        });
                        $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></div>');
                        if(total < 1 ){
                            $('#dispersar').prop('disabled', true);
                        }
                        else{
                            $('#dispersar').prop('disabled', false);
                        }
                    });
                } 
                                       
                    break;
                    case '2':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '3':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '4':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '5':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        
                    break;
                }
            }
            else{
                console.log("entra 2");
                 $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
            });

            $("#modal_NEODATA").modal();

        });

        

        



       

        

});


jQuery.extend(jQuery.validator.messages, {
    required: "This field is required.",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("caca enter no more than {0} characters."),
    minlength: jQuery.validator.format("caca enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Por favor ingrese un valor menor o igual a {0}."),
    min: jQuery.validator.format("Por favor ingrese un valor mayor o igual a {0}.")
});
 



/*jQuery(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();


	jQuery('#editReg').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario').val('');
	jQuery(this).find('#totalNeto').val('');
	jQuery(this).find('#totalNeto2').val('');
	})

	jQuery('#rechReg').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario3').val('');
    })
    


    function myFunctionD2(){
    formatCurrency($('#inputEdit'));
    }

})*/

/*$('.decimals').on('input', function () {
  this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});*/


/*function closeModalEng(){
    $("#modal_enganche").modal('toggle');
}*/

function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
</script>

