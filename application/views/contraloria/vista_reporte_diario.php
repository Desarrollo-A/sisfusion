<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php  $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Registro diario </h3>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <input type="date" name="fecha" id="fecha" class="form-control input-gral pr-2" data-style="btn btn" data-show-subtext="true" data-live-search="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="table-responsive">
                                        <table  id="tabla_ingresar_6" name="tabla_ingresar_6" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>GERENTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>F.MOD</th>
                                                    <th>F.VENC</th>
                                                    <th>UC</th>
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


        <div class="content hide">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title center-align">Registro diario</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables"> 

                                    <div class="form-group">
                                        <div class="table-responsive">
									        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_6" name="tabla_ingresar_6" style="text-align:center;">
                                                <thead>
                                                    <tr>
												        <th style="font-size: .9em;">PROYECTO</th>
												        <th style="font-size: .9em;">CONDOMINIO</th>
                                                        <th style="font-size: .9em;">LOTE</th>
                                                        <th style="font-size: .9em;">GERENTE</th>
                                                        <th style="font-size: .9em;">CLIENTE</th>
                                                        <th style="font-size: .9em;">F.MOD</th>
                                                        <th style="font-size: .9em;">F.VENC</th>
												        <th style="font-size: .9em;">UC</th>
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

    var getInfo1 = new Array(6);
    var getInfo2 = new Array(6);
    var getInfo3 = new Array(6);

    var getInfo6 = new Array(1);
    var rol;

    $('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {
        if(i!=0 && i!=1 && i!=10){
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_ingresar_6').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_ingresar_6').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });

    $("#fecha").change( function (){
        //console.log("prueba");
        let sistema = $(this).val();
        let fecha_inicio = $("#fecha").val();
        let fecha_fin = $("#fecha").val();

        $("#tabla_ingresar_6").ready( function(){
        let titulos = [];

            $('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {
                if( i!=0 && i!=13){
                    var title = $(this).text();
                    titulos.push(title);
                }
            });
            tabla_6 = $("#tabla_ingresar_6").DataTable({
                    
                    "ajax": {
                        "url": url2 + "contraloria/getRegistroDiarioPorFecha/"+fecha_inicio,
                        "dataSrc": "",
                        "type": "POST",
                        cache: false,
                        "data": function( d ){
                        }
                    },
                    destroy: true,
                    dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                    width: 'auto',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                            className: 'btn buttons-excel',
                            titleAttr: 'Registro diario',
                            title: "Registro diario",
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                                format: {
                                    header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                            case 1:
                                                return 'PROYECTO';
                                                break;
                                            case 2:
                                                return 'CONDOMINIO';
                                                break;
                                            case 3:
                                                return 'LOTE';
                                                break;
                                            case 4:
                                                return 'GERENTE';
                                                break;
                                            case 5:
                                                return 'CLIENTE';
                                                break;
                                            case 6:
                                                return 'F. MOD';
                                                break;
                                            case 7:
                                                return 'F. VENC';
                                                break;
                                            case 8:
                                                return 'UC';
                                                break;
                                        } 
                                    }
                                }
                            }
                        }
                    ],
                    language: {
                        url: "<?=base_url()?>/static/spanishLoader_v2.json",
                        paginate: {
                            previous: "<i class='fa fa-angle-left'>",
                            next: "<i class='fa fa-angle-right'>"
                        }
                    },
                    "pageLength": 10,
                    "bAutoWidth": false,
                    "fixedColumns": true,
                    "ordering": false,
                    "columns": [
                        {
                            "width": "7%",
                            "data": function( d ){
                                return '<p class="m-0">'+d.nombreResidencial+'</p>';
                            }
                        },
                        {
                            "width": "8%",
                            "data": function( d ){
                                return '<p class="m-0">'+(d.nombreCondominio)+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p class="m-0">'+d.nombreLote+'</p>';
                            }
                        },  
                        {
                            "width": "16%",
                            "data": function( d ){
                                return '<p class="m-0">'+d.gerente+'</p>';
                            }
                        },
                        {   
                            "width": "16%",
                            "data": function( d ){
                                return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                            }
                        },
                        {
                            "width": "8%",
                            "data": function( d ){
                            return '<p class="m-0">'+d.modificado+'</p>';
                            }
                        },
                        {   
                            "width": "8%",
                            "data": function( d ){
                                var fechaVenc;
                                
                                if(d.idStatusContratacion == 5 && d.idMovimiento == 22 || d.idStatusContratacion == 5 && d.idMovimiento == 75 || d.idStatusContratacion == 5 && d.idMovimiento == 94) {
                                    fechaVenc = 'Vencido';
                                } else if (d.idStatusContratacion == 5 && d.idMovimiento == 35 || d.idStatusContratacion == 2 && d.idMovimiento == 62) {
                                    fechaVenc = d.fechaVenc;
                                }

                                return '<p class="m-0">'+fechaVenc+'</p>';
                            }
                        },
                        {
                            "width": "12%",
                            "data": function( d ){
                                var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;

                                return '<p class="m-0">'+lastUc+'</p>';
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
                    "order": [[ 1, 'asc' ]]
                });
                $('#tabla_ingresar_6 tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_6.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } else {
				var status;
				if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35) {
					status = 'Status 5 listo (Contraloría) ';
				} else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
					status = 'Status 2 enviado a Revisión (Asesor)';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22) {
					status = 'Status 6 Rechazado (Juridico) ';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
					status = 'Status enviado a revisión (Contraloria)';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 94) {
					status = 'Status 6 Rechazado (Juridico)';
				}

                var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '  <div class="row">';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '          <label><b>Información adicional</b></label>';
                informacion_adicional += '      </div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>'+ status +'</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
                informacion_adicional += '  </div>';
                informacion_adicional += '</div>';

    			row.child(informacion_adicional).show();
				tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");

            }
		});

        $("#tabla_ingresar_6 tbody").on("click", ".regRevCorr", function(e){
            e.preventDefault();

            getInfo1[0] = $(this).attr("data-idCliente");
            getInfo1[1] = $(this).attr("data-nombreResidencial");
            getInfo1[2] = $(this).attr("data-nombreCondominio");
            getInfo1[3] = $(this).attr("data-idcond");
            getInfo1[4] = $(this).attr("data-nomlote");
            getInfo1[5] = $(this).attr("data-idLote");
            getInfo1[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevCorrElab').modal('show');

        });

		$("#tabla_ingresar_6 tbody").on("click", ".revStaCE", function(e){
            e.preventDefault();

            getInfo2[0] = $(this).attr("data-idCliente");
            getInfo2[1] = $(this).attr("data-nombreResidencial");
            getInfo2[2] = $(this).attr("data-nombreCondominio");
            getInfo2[3] = $(this).attr("data-idcond");
            getInfo2[4] = $(this).attr("data-nomlote");
            getInfo2[5] = $(this).attr("data-idLote");
            getInfo2[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevA7').modal('show');

        });


		$("#tabla_ingresar_6 tbody").on("click", ".return1", function(e){
            e.preventDefault();

            getInfo3[0] = $(this).attr("data-idCliente");
            getInfo3[1] = $(this).attr("data-nombreResidencial");
            getInfo3[2] = $(this).attr("data-nombreCondominio");
            getInfo3[3] = $(this).attr("data-idcond");
            getInfo3[4] = $(this).attr("data-nomlote");
            getInfo3[5] = $(this).attr("data-idLote");
            getInfo3[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal_return1').modal('show');

        });
			
			
        $("#tabla_ingresar_6 tbody").on("click", ".change_sede", function(e){
            e.preventDefault();

            getInfo6[0] = $(this).attr("data-lote");
            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);
            $('#change_s').modal('show');

        });
        });

    });

    $(document).ready(function(){
        rol = <?php echo $this->session->userdata('id_rol'); ?>
	
        $.post(url + "Contraloria/get_sede", function(data) {
            var len = data.length;
            for(var i = 0; i<len; i++) {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#ubicacion").selectpicker('refresh');
        }, 'json');
    });

    $("#tabla_ingresar_6").ready( function(){
        let titulos = [];

        $('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {
            if( i!=0 && i!=13){
                var title = $(this).text();
                titulos.push(title);
            }
        });

        tabla_6 = $("#tabla_ingresar_6").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro diario',
                    title:"Registro diario",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'PROYECTO';
                                        break;
                                    case 2:
                                        return 'CONDOMINIO';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'GERENTE';
                                        break;
                                    case 5:
                                        return 'CLIENTE';
                                        break;
                                    case 6:
                                        return 'F. MOD';
                                        break;
                                    case 7:
                                        return 'F. VENC';
                                        break;
                                    case 8:
                                        return 'UC';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreResidencial+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
		                return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
	                }
                }, 
                {
	                "width": "16%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.gerente+'</p>';
                    }
                }, 
                {
                    "width": "16%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                    }
                }, 
                {
	                "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.modificado+'</p>';
                    }
                }, 
                {
	                "width": "8%",
                    "data": function( d ){
                        var fechaVenc;

		                if (d.idStatusContratacion == 5 && d.idMovimiento == 22 || d.idStatusContratacion == 5 && d.idMovimiento == 75 || d.idStatusContratacion == 5 && d.idMovimiento == 94) {
				            fechaVenc = 'Vencido';
		                } else if (d.idStatusContratacion == 5 && d.idMovimiento == 35 || d.idStatusContratacion == 2 && d.idMovimiento == 62) {
				            fechaVenc = d.fechaVenc;
		                }

                		return '<p class="m-0">'+fechaVenc+'</p>';
                    }
                }, 
                {
	                "width": "12%",
                    "data": function( d ){
		                var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;
                        
                        return '<p class="m-0">'+lastUc+'</p>';
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
                "url": url2 + "contraloria/getRegistroDiario",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]

        });

        $('#tabla_ingresar_6 tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_6.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } else {
				var status;
				if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35) {
					status = 'Status 5 listo (Contraloría) ';
				} else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
					status = 'Status 2 enviado a Revisión (Asesor)';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22) {
					status = 'Status 6 Rechazado (Juridico) ';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
					status = 'Status enviado a revisión (Contraloria)';
				} else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 94) {
					status = 'Status 6 Rechazado (Juridico)';
				}

                var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '  <div class="row">';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '          <label><b>Información adicional</b></label>';
                informacion_adicional += '      </div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>'+ status +'</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
                informacion_adicional += '  </div>';
                informacion_adicional += '</div>';

    			row.child(informacion_adicional).show();
				tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");

            }
		});

        $("#tabla_ingresar_6 tbody").on("click", ".regRevCorr", function(e){
            e.preventDefault();

            getInfo1[0] = $(this).attr("data-idCliente");
            getInfo1[1] = $(this).attr("data-nombreResidencial");
            getInfo1[2] = $(this).attr("data-nombreCondominio");
            getInfo1[3] = $(this).attr("data-idcond");
            getInfo1[4] = $(this).attr("data-nomlote");
            getInfo1[5] = $(this).attr("data-idLote");
            getInfo1[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevCorrElab').modal('show');

        });

		$("#tabla_ingresar_6 tbody").on("click", ".revStaCE", function(e){
            e.preventDefault();

            getInfo2[0] = $(this).attr("data-idCliente");
            getInfo2[1] = $(this).attr("data-nombreResidencial");
            getInfo2[2] = $(this).attr("data-nombreCondominio");
            getInfo2[3] = $(this).attr("data-idcond");
            getInfo2[4] = $(this).attr("data-nomlote");
            getInfo2[5] = $(this).attr("data-idLote");
            getInfo2[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevA7').modal('show');

        });


		$("#tabla_ingresar_6 tbody").on("click", ".return1", function(e){
            e.preventDefault();

            getInfo3[0] = $(this).attr("data-idCliente");
            getInfo3[1] = $(this).attr("data-nombreResidencial");
            getInfo3[2] = $(this).attr("data-nombreCondominio");
            getInfo3[3] = $(this).attr("data-idcond");
            getInfo3[4] = $(this).attr("data-nomlote");
            getInfo3[5] = $(this).attr("data-idLote");
            getInfo3[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal_return1').modal('show');

        });
			
			
        $("#tabla_ingresar_6 tbody").on("click", ".change_sede", function(e){
            e.preventDefault();

            getInfo6[0] = $(this).attr("data-lote");
            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);
            $('#change_s').modal('show');

        });
    });

	function getFileExtension(filename) {		
		validaFile =  filename == null ? 0:
		filename.split('.').pop();
		  
		return validaFile;
	}

	$(document).on('click', '.regCorrElab', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");

		$('#nombreLoteregCor').val($(this).attr('data-nomLote'));
		$('#idLoteregCor').val($(this).attr('data-idLote'));
		$('#idCondominioregCor').val($(this).attr('data-idCond'));
		$('#idClienteregCor').val($(this).attr('data-idCliente'));
		$('#fechaVencregCor').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeEregCor').val($(this).attr('data-nomLote'));

		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		$('#regCorrElab').modal();

	});

	function preguntaRegCorr() {

		var idLote = $("#idLoteregCor").val();
		var idCondominio = $("#idCondominioregCor").val();
		var nombreLote = $("#nombreLoteregCor").val();
		var idStatusContratacion = $("#idStatusContratacionregCor").val();
		var idCliente = $("#idClienteregCor").val();
		var fechaVenc = $("#fechaVencregCor").val();
		var comentario = $("#comentarioregCor").val();


		var parametros = {
			"idLote": idLote,
			"idCondominio": idCondominio,
			"nombreLote": nombreLote,
			"idStatusContratacion": idStatusContratacion,
			"idCliente": idCliente,
			"fechaVenc": fechaVenc,
			"comentario": comentario
		};


		if (comentario.length <= 0 ) {

			alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');

		} else if (comentario.length > 0) {

		     	$('#enviarAContraloriaGuardar').prop('disabled', true);
				$.ajax({
					data: parametros,
					url: '<?=base_url()?>index.php/Contraloria/editar_registro_lote_contraloria_proceceso6/',
					type: 'POST',
					success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
			    	$('#enviarAContraloriaGuardar').prop('disabled', false);
		 			$('#rechazregCorrElabarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
			  }
			  
			});

		}

	}

	$(document).on('click', '.rechazoCorrida', function (e) {
		idLote = $(this).data("idlote");
		nombreLote = $(this).data("nomlote");
		$('#idClienterechCor').val($(this).attr('data-idCond'));
		$('#idCondominiorechCor').val($(this).attr('data-idCliente'));
		$(".lote").html(nombreLote);


		$('#rechazarStatus').modal();
		e.preventDefault();
	});

	$("#guardar").click(function () {

		var motivoRechazo = $("#motivoRechazo").val();
		var idCondominioR = $("#idClienterechCor").val();
		var idClienteR = $("#idCondominiorechCor").val();


		parametros = {
			"idLote": idLote,
			"nombreLote": nombreLote,
			"motivoRechazo": motivoRechazo,
			"idCliente" : idClienteR,
			"idCondominio" : idCondominioR
		};


		if (motivoRechazo.length <= 0 ) {

		alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');

		} else if (motivoRechazo.length > 0) {

		$('#guardar').prop('disabled', true);
		$.ajax({
			url: '<?=base_url()?>index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso6/',
			type: 'POST',
			data: parametros,
			success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		});
	  }
	});

	$(document).on('click', '.noCorrida', function(e){
		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		$('#infoNoCorrida').modal();
		e.preventDefault();
	});

    $(document).on('click', '#save1', function(e) {
        e.preventDefault();

        var comentario = $("#comentario1").val();

        var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;

        var dataExp1 = new FormData();

        dataExp1.append("idCliente", getInfo1[0]);
        dataExp1.append("nombreResidencial", getInfo1[1]);
        dataExp1.append("nombreCondominio", getInfo1[2]);
        dataExp1.append("idCondominio", getInfo1[3]);
        dataExp1.append("nombreLote", getInfo1[4]);
        dataExp1.append("idLote", getInfo1[5]);
        dataExp1.append("comentario", comentario);
        dataExp1.append("fechaVenc", getInfo1[6]);

        if (validaComent == 0) {
			alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
	    }
	  
        if (validaComent == 1) {

            $('#save1').prop('disabled', true);   
            $.ajax({
                url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRevision_contraloria_proceceso6/',
                data: dataExp1,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST', 
                success: function(data){
                    response = JSON.parse(data);

                    if(response.message == 'OK') {
                        $('#save1').prop('disabled', false);
                        $('#regRevCorrElab').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save1').prop('disabled', false);
                        $('#regRevCorrElab').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save1').prop('disabled', false);
                        $('#regRevCorrElab').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
		    });
        }
    });

    $(document).on('click', '#save2', function(e) {
        e.preventDefault();

        var comentario = $("#comentario2").val();

        var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;

        var dataExp2 = new FormData();

        dataExp2.append("idCliente", getInfo2[0]);
        dataExp2.append("nombreResidencial", getInfo2[1]);
        dataExp2.append("nombreCondominio", getInfo2[2]);
        dataExp2.append("idCondominio", getInfo2[3]);
        dataExp2.append("nombreLote", getInfo2[4]);
        dataExp2.append("idLote", getInfo2[5]);
        dataExp2.append("comentario", comentario);
        dataExp2.append("fechaVenc", getInfo2[6]);

        if (validaComent == 0) {
		    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
	    }
	  
        if (validaComent == 1) {
            $('#save2').prop('disabled', true);   
            $.ajax({
                url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRevision_contraloria6_AJuridico7/',
                data: dataExp2,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST', 
                success: function(data){
                    response = JSON.parse(data);

                    if(response.message == 'OK') {
                        $('#save2').prop('disabled', false);
                        $('#regRevA7').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save2').prop('disabled', false);
                        $('#regRevA7').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save2').prop('disabled', false);
                        $('#regRevA7').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
		    });
	    }
    });

    $(document).on('click', '#b_return1', function(e) {
        e.preventDefault();

        var comentario = $("#comentario3").val();

        var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;

        var dataExp3 = new FormData();

        dataExp3.append("idCliente", getInfo3[0]);
        dataExp3.append("nombreResidencial", getInfo3[1]);
        dataExp3.append("nombreCondominio", getInfo3[2]);
        dataExp3.append("idCondominio", getInfo3[3]);
        dataExp3.append("nombreLote", getInfo3[4]);
        dataExp3.append("idLote", getInfo3[5]);
        dataExp3.append("comentario", comentario);
        dataExp3.append("fechaVenc", getInfo3[6]);

        if (validaComent == 0) {
		    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
	    }
	  
        if (validaComent == 1) {

            $('#save1').prop('disabled', true);   
                $.ajax({
                    url : '<?=base_url()?>index.php/Contraloria/return1/',
                    data: dataExp3,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);

                        if(response.message == 'OK') {
                            $('#b_return1').prop('disabled', false);
                            $('#modal_return1').modal('hide');
                            $('#tabla_ingresar_6').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#b_return1').prop('disabled', false);
                            $('#modal_return1').modal('hide');
                            $('#tabla_ingresar_6').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#b_return1').prop('disabled', false);
                            $('#modal_return1').modal('hide');
                            $('#tabla_ingresar_6').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#b_return1').prop('disabled', false);
                        $('#modal_return1').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
		        });
            }

        });

        $(document).on('click', '#savecs', function(e) {
            e.preventDefault();
            
            var ubicacion = $("#ubicacion").val();
            var validaUbicacion = ($("#ubicacion").val().trim() == '') ? 0 : 1;

            var dataChange = new FormData();

            dataChange.append("idLote", getInfo6[0]);
            dataChange.append("ubicacion", ubicacion);

            if (validaUbicacion == 0) {
				alerts.showNotification("top", "right", "Selecciona una sede.", "danger");
	        }
	  
            if (validaUbicacion == 1) {

                $('#savecs').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Contraloria/changeUb/',
                    data: dataChange,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);

                        if(response.message == 'OK') {
                            $('#savecs').prop('disabled', false);
                            $('#change_s').modal('hide');
                            $('#tabla_ingresar_6').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Sede modificada.", "success");
                        } else if(response.message == 'ERROR'){
                            $('#savecs').prop('disabled', false);
                            $('#change_s').modal('hide');
                            $('#tabla_ingresar_6').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#savecs').prop('disabled', false);
                        $('#change_s').modal('hide');
                        $('#tabla_ingresar_6').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
		        });
		    }
        });


        jQuery(document).ready(function(){

	        jQuery('#regCorrElab').on('hidden.bs.modal', function (e) {
	            jQuery(this).removeData('bs.modal');    
	            jQuery(this).find('#comentarioregCor').val('');
	        })

	        jQuery('#rechazarStatus').on('hidden.bs.modal', function (e) {
	            jQuery(this).removeData('bs.modal');    
	            jQuery(this).find('#motivoRechazo').val('');
	        })

	        jQuery('#envARevCE').on('hidden.bs.modal', function (e) {
	            jQuery(this).removeData('bs.modal');    
	            jQuery(this).find('#comentarioenvARevCE').val('');
	            jQuery(this).find('#tipo_ventaenvARevCE').val(null).trigger('change');
	            jQuery(this).find('#ubicacion').val(null).trigger('change');
	        })

        	jQuery('#regRevA7').on('hidden.bs.modal', function (e) {
	            jQuery(this).removeData('bs.modal');    
	            jQuery(this).find('#comentario2').val('');
	        })

        	jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
	            jQuery(this).removeData('bs.modal');    
	            jQuery(this).find('#comentario3').val('');
	        })
	
            jQuery('#change_s').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');    
        	jQuery(this).find('#ubicacion').val(null).trigger('change');
	        })
	
        });

    </script>
