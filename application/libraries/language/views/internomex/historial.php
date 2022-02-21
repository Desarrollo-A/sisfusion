<body>
<div class="wrapper">

    <?php

    if($this->session->userdata('id_rol')=="31")//contraloria7
    {
        $dato = array(
        'home'=> 0,
        'comisiones_internomex'=> 0,
        'historial_internomex'=> 1,
        'manual'=> 0,
                'aparta'=> 0,


    );
        $this->load->view('template/sidebar', $dato);
    
    }else{
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
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
</style>

<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DETALLES COMISIÓN</h4>
            </div>  
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
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




<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                

                                <div class="tab-content">

                                    <div class="tab-pane active" id="nuevas-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                	<h4 class="card-title">HISTORIAL COMISIONES PAGADAS</h4>
                                                                <p class="category">El pago de comisiones se ha efectuado correctamnete por parte de INTERNOMEX.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                	<label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nuevas" id="myText_nuevas">
                                                                    </label> 

 
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                	<div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                        	<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_historial_comisiones" name="tabla_historial_comisiones">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">PROYECTO</th>
                                                                                        <th style="font-size: .9em;">CONDOMINIO</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN %</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN $</th>
                                                                                        <th style="font-size: .9em;"># COMISIÓN</th>
                                                                                        <th style="font-size: .9em;">FECHA CREACIÓN</th>
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

                                      <!-- ///////////////// -->
 

                                   

                                    <!-- //////////////// -->

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
    var totaPen = 0;
    var tr;

  $("#tabla_historial_comisiones").ready( function(){     

  $('#tabla_historial_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();
 

    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_nuevas.column(i).search() !== this.value ) {
            tabla_nuevas
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_nuevas.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_nuevas").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_historial_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_nuevas").value = to;
});


        tabla_nuevas = $("#tabla_historial_comisiones").DataTable({
            dom: 'Brtip',
            width: 'auto',
            "buttons": [
            {
                text: '<i class="fa fa-check"></i> IMPRIMIR EXCEL',
                action: function(){
 
                },
                attr: {
                    class: 'btn bg-olive',
                }

            },
        ],

            "language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "processing": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": false,
            "searching": true,
            "ordering": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [

            {   
             "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_comision+'</p>';
                }
            },
            {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.proyecto+'</p>';
                }
            },
            {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+(d.condominio).toUpperCase();+'</p>';
                }
            }, 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lote+'</p>';
                }
            }, 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            }, 
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
                }
            }, 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><span class="label label-success">'+d.numero_mensualidad+' / 13</span></p>';
                }
            }, 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            },
            {
                "width": "6%",
                "orderable": false,
                "data": function( data ){
                    opciones = '<div class="btn-group" role="group">';
                    opciones += '<button class="btn btn-just-icon btn-round btn-warning mas_opciones_8"><i class="material-icons">apps</i></button>';
                    return opciones + '</div>';
                } 
            }],
            columnDefs: [
 
{

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center',
 
 select: {
    style:    'os',
    selector: 'td:first-child'
},
}],

 
            
            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesHistorialContraloria",
                /*registroCliente/getregistrosClientes*/
                    "type": "POST",
                	cache: false,
                	"data": function( d ){}},
                	"order": [[ 1, 'asc' ]]
                });

        $("#tabla_historial_comisiones tbody").on("click", ".mas_opciones_8", function(){
        	var tr = $(this).closest('tr');
        	var row = tabla_nuevas.row( tr );

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas").modal();
        });

 


    });

//FIN TABLA NUEVA






 

    // FUNCTION MORE

    $(window).resize(function(){
        tabla_nuevas.columns.adjust();
        tabla_proceso.columns.adjust();
        tabla_pagadas.columns.adjust();
        tabla_otras.columns.adjust();
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


    // function autorizarSeleccionadasPendientes(){        
    //     if(totaPen == 0){
    //         alert('No hay monto autorizado');
    //     }else if(window.confirm('Se pagará el total autorizado.\nEl total es de $ '+ formatMoney(totaPen)+' ¿Estás de acuerdo?')){            
    //         var apagar = [];        
    //         $( tabla_getion_pagosP.$('input[type="checkbox"]:checked')).each(function(){
    //             tr = $(this).closest('tr');
    //             var row = tabla_getion_pagosP.row( tr );
    //             apagar.push([ row.data().ID,  row.data().pa ]);       
    //         });
    //         $.post( url + "DireccionGeneral/PagoDevoluciones", {jsonApagar : JSON.stringify(apagar)} ).done( function( data ){
    //             if( data[0] ){
    //                 totaPen = 0;
    //                 $("#totpagarPen").html(formatMoney(0));
    //                 tabla_getion_pagosP.ajax.reload();
    //             }
    //         }).fail( function(){
    //             alert("HA OCURRIDO UN ERROR, INTENTE MAS TARDE");
    //         });
    //     }
    // }
 
</script>

