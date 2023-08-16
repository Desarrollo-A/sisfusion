<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

    <div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h5 class=""></h5>
                </div>
                <form id="my-edit-form" name="my-edit-form" method="post">
                    <div class="modal-body">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_name">
                                            <label class="control-label">NOMBRE</label>
                                            <input id="name" name="name" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="control-label">CORREO</label>
                                            <input id="mail" name="mail" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="control-label">TELÉFONO</label>
                                            <input id="telephone" name="telephone" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <!--<label class="control-label">TELÉFONO</label>-->
                                            <select class="selectpicker select-gral m-0" id="sede" name="sede[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Selecciona sede" data-size="7" required="" multiple="" tabindex="-98">
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align centered">
                                        <div class="form-group label-floating div_last_name">
                                            <button type="button" class="btn btn-primary" id="searchButton">BUSCAR</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="tabla_prospectos" name="tabla_prospectos">
                                            <thead>
                                            <tr>
                                                <!--<th></th>-->
                                                <th>NOMBRE</th>
                                                <th>TELÉFONO</th>
                                                <th>CORREO</th>
                                                <th>LUGAR PROSPECCIÓN</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>FECHA CREACIÓN</th>
                                                <th>ID DRAGON</th>
                                                <th>SEDE</th>
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

    <div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <center><b><h4 class="card-title ">Ventas compartidas</h4></b></center>
                    <div class="material-datatables">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id="verDet" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th>Gerente</th>
                                        <th>Coordinador</th>
                                        <th>Asesor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
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

    $(document).ready(function () {
        $.post(url + "Contraloria/get_sede", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
            }

            $("#sede").selectpicker('refresh');
        }, 'json');
    });

    $('#searchButton').click(()=>{

        let name = $('#name').val();
        let mail = $('#mail').val();
        let telephone = $('#telephone').val();
        let sede = $('#sede').val();

        console.log('sedeII:', JSON.stringify(sede));

        name = (name!='') ? name : '';
        mail = (mail!='') ? mail : '';
        telephone = (telephone!='') ? telephone : '';
        sede = (sede!='') ? sede.toString() : '';

        // console.log('sedeII:', Object.assign({}, sede));
        // var data = new FormData();
        // data.append("idLote", idLote);
        // data.append("name", name);
        // data.append("mail", mail);
        // data.append("telephone", telephone);
        // data.append("sede", sede);

        if(name!='' || mail!='' || telephone!='' || sede!=''){
            let array_data = [];
            array_data['name'] = name;
            array_data['mail'] = mail;
            array_data['telephone'] = telephone;
            array_data['sede'] = sede;
            fillTable(array_data);
        }else{
            alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de busqueda', 'warning')
        }


        // $.ajax({
        //     type: 'POST',
        //    url: '<?//=base_url()?>//index.php/Clientes/searchData',
        //     data: data,
        //     contentType: false,
        //     cache: false,
        //     processData: false,
        //     dataType: "json",
        //     beforeSend: function () {
        //
        //     },
        //     success: function (data) {
        //         if (data == 1) {
        //             $('#preguntaDeleteMktd').modal("hide");
        //             $('#checkEvidencia').DataTable().ajax.reload();
        //             $('#sol_aut').DataTable().ajax.reload();
        //             alerts.showNotification('top', 'right', 'Se ha eliminado MKTD de esta venta de manera exitosa.', 'success');
        //         } else {
        //             alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
        //         }
        //     },
        //     error: function () {
        //         alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
        //     }
        // });


    });


    function fillTable(data_search) {
        // var data = new FormData();
        // data.append("idLote", data_search['idLote']);
        // data.append("name", data_search['name']);
        // data.append("mail", data_search['mail']);
        // data.append("telephone", data_search['telephone']);
        tabla_valores_cliente = $("#tabla_prospectos").DataTable({
            width: 'auto',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro de clientes',
                    title:'Lista de prospectos',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'NOMBRE';
                                        break;
                                    case 1:
                                        return 'TELÉFONO';
                                        break;
                                    case 2:
                                        return 'CORREO';
                                        break;
                                    case 3:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 4:
                                        return 'ASESOR';
                                        break;
                                    case 5:
                                        return 'COORDINADOR';
                                        break;
                                    case 6:
                                        return 'GERENTE';
                                        break;
                                    case 7:
                                        return 'FECHA CREACIÓN';
                                        break;
                                    case 8:
                                        return 'ID DRAGON';
                                        break;
                                    case 9:
                                        return 'SEDE';
                                        break;
                                }
                            }
                        }
                    },

                }
            ],
            pagingType: "full_numbers",
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            processing: true,
            pageLength: 10,
            bAutoWidth: false,
            bLengthChange: false,
            scrollX: true,
            bInfo: true,
            searching: true,
            ordering: false,
            fixedColumns: true,
            destroy: true,
            columns: [
                // {
                //     "width": "3%",
                //     "className": 'details-control',
                //     "orderable": false,
                //     "data" : null,
                //     "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                // },


                {
                    "width": "5%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre_prospecto + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        let tel1 = d.telefono;
                        let tel2 = d.telefono_2;
                        let telefono;
                        if(tel1==null){
                            telefono = tel2;
                        }else if(tel2==null){
                            telefono = tel1;
                        }else if(tel1==null || tel2==null){
                            telefono = '--'
                        }
                        return '<p class="m-0">' + telefono + '</p>';
                    }
                },

                {
                    "width": "12%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.correo + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">'+ d.lugar_prospeccion + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre_asesor + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre_coordinador + '</p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre_gerente+ '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        //myFunctions.convertDateYMDHMS(d.fechaEnganche)
                        return '<p class="m-0">' +  myFunctions.convertDateYMDHMS(d.fecha_creacion)  + '</p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function (d) {
                        let id_dragon = d.id_dragon;
                        let validateData;
                        if(id_dragon==0){
                            validateData = 'No disponible';
                        }
                        return '<p class="m-0">' + validateData + '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {

                        return '<p class="m-0">' +   d.sede_nombre  + '</p>';
                    }
                }
            ],

            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            ajax: {
                type: 'POST',
                url: '<?=base_url()?>index.php/Clientes/searchData',
                data: {
                    "idLote": '',
                    "name" :  data_search['name'],
                    "mail" :  data_search['mail'],
                    "telephone":data_search['telephone'],
                    "sede" : data_search['sede'],
                    "TB": 2
                },
                cache: false
            },
            "order": [[1, 'asc']]
        });
        $('#tabla_prospectos tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_valores_cliente.row(tr);

            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            }
            else {



                var informacion_adicional2 = '<table class="table text-justify">' +
                    '<tr>INFORMACIÓN: <b>' + row.data().nombre + ' ' + row.data().apellido_paterno + ' ' + row.data().apellido_materno + '</b>' +
                    '<td style="font-size: .8em"><strong>CORREO: </strong>' + myFunctions.validateEmptyField(row.data().correo) + '</td>' +
                    '<td style="font-size: .8em"><strong>TELEFONO: </strong>' + myFunctions.validateEmptyField(row.data().telefono1) + '</td>' +
                    '<td style="font-size: .8em"><strong>RFC: </strong>' + myFunctions.validateEmptyField(row.data().rfc) + '</td>' +
                    '<td style="font-size: .8em"><b>FECHA +45:</b> ' + myFunctions.validateEmptyField(row.data().fechaVecimiento) + '</td>' +
                    '<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>' + myFunctions.validateEmptyField(row.data().fechaNacimiento) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="font-size: .8em"><b>DOMICILIO PARTICULAR:</b> ' + myFunctions.validateEmptyField(row.data().domicilio_particular) + '</td>' +
                    '<td style="font-size: .8em"><b>ENTERADO:</b> ' + myFunctions.validateEmptyField(row.data().enterado) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="font-size: .8em"><b>GERENTE TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().gerente) + '</td>' +
                    '<td style="font-size: .8em"><b>ASESOR TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().asesor) + '</td>' +
                    '</tr>' +
                    '</table>';
                var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '       <div class="row">';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '               <label><b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b></label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Correo: </b>'+myFunctions.validateEmptyField(row.data().correo)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Teléfono: </b>'+myFunctions.validateEmptyField(row.data().telefono1)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>RFC: </b>'+myFunctions.validateEmptyField(row.data().rfc)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Fecha +45: </b>'+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Fecha nacimiento: </b>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Domicilio Particular: </b>'+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Enterado: </b>'+myFunctions.validateEmptyField(row.data().enterado)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Gerente: </b>'+myFunctions.validateEmptyField(row.data().gerente) +'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                informacion_adicional += '               <label><b>Asesor Titular: </b>'+myFunctions.validateEmptyField(row.data().asesor)+'</label>';
                informacion_adicional += '           </div>';
                informacion_adicional += '       </div>';
                informacion_adicional += '    </div>';


                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            }
        });
    }

    $("#tabla_prospectos").ready(function () {
        $('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 11) {
                var title = $(this).text();
                $(this).html('<input class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (tabla_valores_cliente.column(i).search() !== this.value) {
                        tabla_valores_cliente
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        let titulos = [];
        $('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 13) {
                var title = $(this).text();

                titulos.push(title);
            }
        });
    });


    var id_cliente_global = 0;

    $(document).on('click', '.cop', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var id_cliente = $itself.attr('data-idcliente');

        id_cliente_global = id_cliente;
        tableHistorial.ajax.reload();
        $('#verDetalles').modal('show');
    });


    // $(document).ready(function () {
    tableHistorial = $('#verDet').DataTable({
        responsive: true,
        "autoWidth": 'true',
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reporte ventas compartidas',
                title:'Reporte ventas compartidas',
            }
        ],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            {"data": "nombreGerente"},
            {"data": "nombreCoordinador"},
            {"data": "nombreAsesor"}
        ],
        "processing": true,
        "bAutoWidth": false,
        "bLengthChange": false,
        "bInfo": true,
        "ordering": false,
        "fixedColumns": true,
        "ajax": {
            "url": "<?=base_url()?>index.php/registroCliente/getcop/",
            "type": "POST",
            cache: false,
            "data": function (d) {
                d.id_cliente = id_cliente_global;
            }
        },
    });


    // });


    $(window).resize(function () {
        tabla_valores_cliente.columns.adjust();
    });



</script>

