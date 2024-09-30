<body>
<div class="wrapper">

    <?php
        if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17")//contraloria
            $this->load->view('template/sidebar');
        else
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    ?>



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
    th {
        background: #003D82;
        color: white;
    }
</style>
 

<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
    <div class="modal-dialog" style= "margin-top:20px;"></div>
</div>




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


    <div class="modal fade" id="seeInformationModalfactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsfactura()">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                 </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsfactura()"><b>Cerrar</b></button>
                <!-- <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsfactura()"><b>Cerrar</b></button>
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsfactura()"><b>Cerrar</b></button> -->
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

 


<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
        <div class="modal-dialog" style="width:800px; margin-top:20px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>




<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-sm" id="myModalTQro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>

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
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title" >COMISIONES NUEVAS - <b>FACTURA</b></h4>
                                                                    <!-- <p class="category">Comisiones solictadas por colaboradores para proceder a pago sin factura.</b></p> -->
                                                                    <p class="category">Comisiones nuevas, solicitadas para proceder a pago en esquema de factura.</b></p>

                                                                </div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totpagarfactura" id="totpagarfactura"></label>
                                                                    <label style="color: #0a548b;">&nbsp;Autorizar: $
                                                                        <span style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="totpagarPen" name="totpagarPen"></span>
                                                                    </label>
                                                                    <!-- <span id="totpagarLeon"></span> -->
                                                                </div>

                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group">
                                                                            <label for="proyecto">Proyecto:</label>
                                                                            <select name="filtro33" id="filtro33" class="selectpicker" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required> <option value="0">Seleccione todo</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Condominio</label>
                                                                            <select class="selectpicker" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required/></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_factura" name="tabla_factura">
                                                                                 <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .8em;"></th>
                                                                                        <th style="font-size: .8em;" id="th_lote">USUARIO</th>
                                                                                        <th style="font-size: .8em;" id="th_lote">MONTO</th>
                                                                                        <th style="font-size: .8em;" id="th_lote">PROYECTO</th>
                                                                                        <th style="font-size: .8em;" id="th_lote">EMPRESA</th>
                                                                                        <th style="font-size: .8em;" id="th_lote">OPINIÓN CUMPLIMIENTO</th>
                                                                                        <th style="font-size: .8em;" id="th_more">MÁS</th>
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
</body>
<?php $this->load->view('template/footer');?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript"> Shadowbox.init();</script>
    <script type="text/javascript">
    function cleanCommentsfactura() {
        var myCommentsList = document.getElementById('comments-list-factura');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }

    $(document).ready(function() {
        $("#tabla_factura").prop("hidden", true);

        var url = "<?=base_url()?>/index.php/";
        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro3").selectpicker('refresh');
        }, 'json');

        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro33").selectpicker('refresh');
        }, 'json');


        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro333").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro333").selectpicker('refresh');
        }, 'json');
    });

    $('#filtro3').change(function(ruta){
        residencial = $('#filtro3').val();
        $("#filtro4").empty().selectpicker('refresh');
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
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');

                }
            });
    });

        $('#filtro33').change(function(ruta){
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

                }
            });
    });

    $('#filtro3').change(function(ruta){
        proyecto = $('#filtro3').val();
        condominio = $('#filtro4').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getInvoiceCommissions(proyecto, condominio);
    });

    $('#filtro4').change(function(ruta){
        proyecto = $('#filtro3').val();
        condominio = $('#filtro4').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getInvoiceCommissions(proyecto, condominio);
    });


    $('#filtro33').change(function(ruta){
        proyecto = $('#filtro33').val();
        condominio = $('#filtro44').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        console.log(proyecto);
        console.log(condominio);
        getFacturaCommissions(proyecto, condominio);
    });

    $('#filtro44').change(function(ruta){
        proyecto = $('#filtro33').val();
        condominio = $('#filtro44').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getFacturaCommissions(proyecto, condominio);
    });

    $('#filtro333').change(function(ruta){
        proyecto = $('#filtro333').val();
        getHistoryCommissions(proyecto);
    });




    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var totalLeon = 0;
    var totalQro = 0;
    var totalSlp = 0;
    var totalMerida = 0;
    var totalCdmx = 0;
    var totalCancun = 0;
    var tr;
    var tabla_factura2 ;
    var totaPen = 0;
//INICIO TABLA QUERETARO****************************************************************************************
let titulos = [];
        $('#tabla_factura thead tr:eq(0) th').each( function (i) {

            if(i != 15 && i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input class="textoshead" type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_factura2.column(i).search() !== this.value) {
                        tabla_factura2
                            .column(i)
                            .search(this.value)
                            .draw();
                        var total = 0;
                        var index = tabla_factura2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_factura2.rows(index).data();

                        $.each(data, function(i, v) {
                            total += parseFloat(v.total);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("totpagarfactura").value = formatMoney(total);
                    }
                });
            }
        });

  function getFacturaCommissions(proyecto, condominio){
      

      $(".textoshead::placeholder").css( "color", "white" );

      $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function(i, v) {
                total += parseFloat(v.total);
            });
            var to = formatMoney(total);
            document.getElementById("totpagarfactura").value = to;
        });



    $("#tabla_factura").prop("hidden", false);
    tabla_factura2 = $("#tabla_factura").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [

 
    {
        text: '<i class="fa fa-pdf"></i>XMLS',
        action: function(){

 
                 window.location = url+'Kel_XML/descargar_XML';
             
        },
        attr: {
            class: 'btn bg-olive',
            style: 'background: #28B2D9; position: relative; float: right;',
        }
    },




    {
        text: '<i class="fa fa-pdf"></i>OPINIONES CUMPLIMIENTO',
        action: function(){

 
                 window.location = url+'Kel_XML/descargar_PDF';
             
        },
        attr: {
            class: 'btn bg-olive',
            style: 'background: #D94228; position: relative; float: right;',
        }
    },




       {
           extend:    'excelHtml5',
           text:      'Excel',
           titleAttr: 'Excel',
           title: 'CONCENTRADO_FACTURAS',
          exportOptions: {
  
              columns: [1,2,3,4,5],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        
                        }else if(columnIdx == 1){
                            return 'USUARIO';
                        }else if(columnIdx == 2){
                            return 'MONTO ACUMULADO';
                        }else if(columnIdx == 3){
                            return 'PROYECTO';
                        }else if(columnIdx == 4){
                            return 'EMPRESA ';
                        }else if(columnIdx == 5){
                            return 'OPINIÓN CUMPLIMIENTO';
                        }
                        
                        else if(columnIdx != 15 && columnIdx !=0){
                        //     if(columnIdx == 11){
                        //         return 'nose2'
                        //     }
                        //     else{
                                return ' '+titulos[columnIdx-1] +' ';
                        //     }
                        }
                    }
                }
            },

            attr: {
                    class: 'btn btn-success',
                 }
        },


        ],



        width: 'auto',
"language":{ url: "../static/spanishLoader.json" },

"pageLength": 20,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"destroy": true,
"columns": [
    {
"width": "3%",
"className": 'details-control',
"orderable": false,
"data" : null,
"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
            {
                "width": "15%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.usuario+'</p>';
                }
            },
            {
                "width": "15%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b> $'+formatMoney(d.total)+'</b></p>';
                }
            },{
                "width": "15%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.proyecto+'</p>';
                }
            },
            {
                "width": "15%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.empresa+'</b></p>';
                }
            },
            {
                "width": "15%",
                "data": function( d ){

                    if(d.estatus_opinion == 1 || d.estatus_opinion == 2){
                       return '<span class="label label-success" style="background:#F1C40F;">OPINIÓN DE CUMPLIMIENTO</span>';
                    }else{
                        return '<span class="label" style="background:#A6A6A6;">SIN ARCHIVO</span>';
                    }
                }
            },
            {
                "width": "15%",
                "orderable": false,
                "data": function( data ){

                    var BtnStats;

                    // BtnStats = '';

                    
                    if(data.estatus_opinion == 1 || data.estatus_opinion == 2){
                        BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini consultar_documentos"  style="background: #3982C0;" title="Detalle de factura">' +'<span class="material-icons">info</span></button>&nbsp;<a href="#" class="btn btn-info btn-round btn-fab btn-fab-mini verPDF" title= "Ver opinión de cumplimiento" style="margin-top:5px;" data-usuario="'+data.archivo_name+'" ><i class="material-icons">description</i></a>';

                         // <button href="#" value="'+data.id_usuario+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini btn-success enviar_internomex" title="Enviar a Internomex">' +'<span class="material-icons">check</span></button>&nbsp

                       

                    }else{
                        BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini consultar_documentos"  style="background: #3982C0;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;';

                    }

                    
                   
                    return BtnStats;

                }
            }],


            columnDefs: [
{
"searchable": false,
"orderable": false,
"targets": 0
},

],

    "ajax": {
        "url": url2 + "Comisiones/getDatosNuevasXContraloria/" + proyecto + "/" + condominio,
// "dataSrc": "",
"type": "POST",
cache: false,
"data": function( d ){
}
},
"order": [[ 1, 'asc' ]]

});





// $("#tabla_factura tbody").on("click", ".enviar_internomex", function(e){

// e.preventDefault();
// e.stopImmediatePropagation();

//   id_pago = $(this).val();
//   lote = $(this).attr("data-value");

//   $("#myModalEnviadas").modal();
// //   $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
//   $.getJSON("getComments/"+id_pago).done( function( data ){
//       $.each( data, function(i, v){
//         $("#comments-list-factura").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
//       });
//   });
// });


 



    $('#tabla_factura tbody').on('click', 'td.details-control', function () {
		 var tr = $(this).closest('tr');
		 var row = tabla_factura2.row(tr);

         if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
        }
        else {
            if( row.data().solicitudes == null || row.data().solicitudes == "null" ){
                $.post( url + "Comisiones/carga_listado_factura" , { "idResidencial" : row.data().idResidencial, "id_usuario" : row.data().id_usuario } ).done( function( data ){
             
            row.data().solicitudes = JSON.parse( data );

            tabla_factura2.row( tr ).data( row.data() );

            row = tabla_factura2.row( tr );

            row.child( construir_subtablas( row.data().solicitudes ) ).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");

        });
    }else{
        row.child( construir_subtablas( row.data().solicitudes ) ).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    }

}


     });


function construir_subtablas( data ){
            var solicitudes = '<table class="table">';
            $.each( data, function( i, v){ 
               //i es el indice y v son los valores de cada fila
                solicitudes += '<tr>';
                solicitudes += '<td><b>'+(i+1)+'</b></td>';
                solicitudes += '<td>'+'<b>'+'ID: '+'</b> '+v.id_pago_i+'</td>';
                solicitudes += '<td>'+'<b>'+'CONDOMINIO: '+'</b> '+v.condominio+'</td>';
                solicitudes += '<td>'+'<b>'+'LOTE: '+'</b> '+v.lote+'</td>';
                solicitudes += '<td>'+'<b>'+'MONTO: '+'</b> $'+formatMoney(v.pago_cliente)+'</td>';
                solicitudes += '<td>'+'<b>'+'USUARIO: '+'</b> '+v.usuario+'</td>';
                solicitudes += '</tr>';
    
            });          

            return solicitudes += '</table>';
        }



  

        $("#tabla_factura tbody").on("click", ".enviar_internomex", function(){
            id_usuario = $(this).val();
            id_residencial = $(this).attr("data-value");
            user_factura = $(this).attr("data-userfactura");
            
            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de enviar las comisiones de <b>'+user_factura+'</b> a Internomex?</p></div></div>');

            $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_usuario" value="'+id_usuario+'"><input type="hidden" name="id_residencial" value="'+id_residencial+'">');

            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="Enviar"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button></div></div>');
            $("#modal_nuevas").modal();
        });


 


    $("#tabla_factura tbody").on("click", ".consultar_documentos", function(e){
    // id_com = $(this).val();
    // id_pj = $(this).attr("data-personalidad");

    $("#seeInformationModalfactura .modal-body").html("");

    e.preventDefault();
    e.stopImmediatePropagation();

    uuid = $(this).val();
  id_residencial = $(this).attr("data-value");
  user_factura = $(this).attr("data-userfactura");
  

    $("#seeInformationModalfactura").modal();

  

    $.getJSON( url + "Comisiones/getDatosFactura/"+uuid+"/"+id_residencial).done( function( data ){
 
            // alert(data.datos_solicitud['nombre']);

           $("#seeInformationModalfactura .modal-body").append('<div class="row">');
            let uuid,fecha,folio,tot,descripcion;

            if (!data.datos_solicitud['uuid'] == '' && !data.datos_solicitud['uuid'] == '0'){

                $.get(url+"Comisiones/GetDescripcionXML/"+data.datos_solicitud['nombre_archivo']).done(function (dat) {
                   //console.log(data);
                   console.log(JSON.parse(dat));
                   let datos = JSON.parse(dat);
                    uuid = datos[0][0];
                    fecha = datos[1][0];
                    folio = datos[2][0];
                    // if(datos[2][0] == 'S'){
                    //     folio = datos[2];
                    // }else{
                    //   folio =   datos[2][0]
                    // }
                    
                    tot = datos[3][0];
                    descripcion = datos[4];
                   //let desc = data;
           

                $("#seeInformationModalfactura .modal-body").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> PROYECTO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                 $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+tot+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMISIÓN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+fecha+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');


                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');




                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+uuid+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+folio+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

               
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+descripcion+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

            });
               
            }
            else {
                 $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:16px; margin:0; color:black;">NO HAY DATOS A MOSTRAR</label></div>');
             }
             $("#seeInformationModalfactura .modal-body").append('</div>');


        // });
    });

    // $.getJSON( url + "Comisiones/getCambios/"+id_com+"/"+id_pj).done( function( data ){
    //     $.each( data, function( i, v){
    //         fillFields(v, 1);
    //     });
    // });

});





  }


//FIN TABLA  ****************************************************************************************




$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
           $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust();
           //.responsive.recalc();
    });


$(window).resize(function(){
    tabla_factura2.columns.adjust();
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};




function cancela(){
   $("#modal_nuevas").modal('toggle');
}






//Función para pausar la solicitud
$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        console.log(data);
        // data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/enviar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data[0] ){
                        $("#modal_nuevas").modal('toggle' );
                        alerts.showNotification("top", "right", "Se envío a Internomex exitosamente", "success");
                        setTimeout(function() {
                            tabla_factura2.ajax.reload();
                        }, 3000);
                    }else{
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});
 
 
$(document).on("click", ".btn-historial-lo", function(){
    window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
});



    function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = url+"dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}







function cleanComments()
{

    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';


}


// $(document).on('click', '.verPDF', function () {
//         var $itself = $(this);
//         Shadowbox.open({
//             /*verPDF*/
//             content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
//             player:     "html",
//             title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
//             width:      985,
//             height:     660

//         });
//     });


</script>

<script>
     $(document).ready( function()
   {


       $.getJSON( url + "Comisiones/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');

        });
    });

});


$(document).on('click', '.verPDF', function () {
        var $itself = $(this);
        Shadowbox.open({
            /*verPDF*/
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
            width:      985,
            height:     660

        });
    });

</script>

