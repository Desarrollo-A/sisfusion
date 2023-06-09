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
    </style>

    <div class="modal fade modal-alertas" id="modal_estatus_12" role="dialog">
    <div class="modal-dialog">
       <div class="modal-content">
        <div class="modal-header bg-red"  >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ESTATUS 2.0</h4>
        </div>  
        <form method="post" id="form_interes">
            <div class="modal-body"></div>
        </form>
    </div>
</div>
</div>



    <div class="content">
        <div class="container-fluid">
 
            <div class="row">


 



                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Alta clúster</h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables"> 

                                <div class="form-group">

                                    <div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3">

                                       <div class="col-sm-11">

										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-primary btn-round"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
                                       </div>

                                       <div class="col-sm-1">&nbsp;</div>

                                       <div class="col-sm-11">
                                       	<!-- <label for="proyecto">Proyecto: </label> -->
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-primary btn-round"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
                                       </div>

                                       <div class="col-sm-1">&nbsp;</div>


                                       <div class="col-sm-11">

										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-primary btn-round"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA TIPO -</option></select>
                                       </div>

                                       <div class="col-sm-1">&nbsp;</div>


                                       <div class="col-sm-11">

										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-primary btn-round"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA ETAPA -</option></select>
                                       </div>

                                       <div class="col-sm-1">&nbsp;</div>

                                       <div class="col-sm-11">

										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-primary btn-round"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CUENTA BANCARIA -</option></select>
                                       </div>

                                       <div class="col-sm-1">&nbsp;</div>


                                       <div class="col-sm-11"> 
 
                                        <center><button  class="btn btn-primary btn-round" style="background: #0FC693;"><i class="material-icons">done</i> GUARDAR</button></center>
                                        &nbsp;</div>
                                    </div>


                                <div class="col xol-xs-9 col-sm-9 col-md-9 col-lg-9">
                                        <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_alta_cluster" name="tabla_alta_cluster"> 
                                        <thead>
                                            <tr>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">ETAPA</th>
                                                <th style="font-size: .9em;">DATOS BANCARIOS</th>
                                                <th style="font-size: .9em;">TIPO</th>

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

    $("#tabla_alta_cluster").ready( function(){

    $('#tabla_alta_cluster thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_12.column(i).search() !== this.value ) {
                tabla_12
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_12 = $("#tabla_alta_cluster").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
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
// {
//    "width": "3%",
//    "className": 'details-control',
//  "orderable": false,
//  "data" : null,
//  "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
// },

{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
}, 

{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
}, 

 
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},

{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
}, 

{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.primerNombre+" "+d.segundoNombre+" "+d.apellidoMaterno+" "+d.apellidoPaterno+'</p>';
    }
}, 
 
 
 
],

columnDefs: [
{
 "searchable": false,
 "orderable": false,
 "targets": 0
},
 
],

"ajax": {
    "url": url2 + "registroCliente/getregistrosClientes",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 


    $("#tabla_alta_cluster tbody").on("click", ".mas_opciones_8", function(){
    $("#modal_estatus_12 .modal-body").html("");
    $("#modal_estatus_12 .modal-body").append('<div class="row"><div class="col-lg-12 form-group"><input class="form-control" placeholder="Comentario"></div><div class="col-lg-12 form-group"><button class="btn btn-social btn-fill btn-success"> <i class="material-icons">create_</i>ACEPTAR</button></div></div>');
    $("#modal_estatus_12").modal();
});

 
}); 

  $(window).resize(function(){
        tabla_12.columns.adjust();
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

    $(function(){
  setTextareaHeight($('textarea'));
})
 
function setTextareaHeight(textareas) {
    textareas.each(function () {
        var textarea = $(this);
 
        if ( !textarea.hasClass('autoHeightDone') ) {
            textarea.addClass('autoHeightDone');
 
            var extraHeight = parseInt(textarea.css('padding-top')) + parseInt(textarea.css('padding-bottom')), // to set total height - padding size
                h = textarea[0].scrollHeight - extraHeight;
 
            // init height
            textarea.height('auto').height(h);

            textarea.bind('keyup', function() {
 
                textarea.removeAttr('style'); // no funciona el height auto
 
                h = textarea.get(0).scrollHeight - extraHeight;
 
                textarea.height(h+'px'); // set new height
            });
        }
    })
}

</script>

