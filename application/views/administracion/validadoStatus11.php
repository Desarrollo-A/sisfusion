<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    
    <style>
        tr th{
            text-align: center;
        }
    </style>



    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Validado estatus 11</h3>
<!--                                <p class="card-title pl-1">(Validación de enganche)</p>-->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover" id="tabla_ingresar_11" name="tabla_ingresar_11">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA ESTATUS 11</th>
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
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var getInfo1 = new Array(7);
    var getInfo3 = new Array(6);


    $("#tabla_ingresar_11").ready( function(){
        let titulos = [];
        $('#tabla_ingresar_11 thead tr:eq(0) th').each( function (i) {

                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (tabla_9.column(i).search() !== this.value ) {
                        tabla_9
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                } );

            titulos.push(title);

        });



        console.log('titulos:', titulos);
        let fecha_title = new Date();
        let year = fecha_title.getFullYear();
        let month = (fecha_title.getMonth()<10) ? '0'+fecha_title.getMonth() : fecha_title.getMonth();
        let day = (fecha_title.getDate()<10) ? '0'+fecha_title.getDate(): fecha_title.getDate();
        let hours = (fecha_title.getHours()<10) ? '0'+fecha_title.getHours(): fecha_title.getHours();
        let minutes = (fecha_title.getMinutes()<10) ? '0'+fecha_title.getMinutes(): fecha_title.getMinutes();
        let seconds = (fecha_title.getSeconds()<10) ? '0'+fecha_title.getSeconds(): fecha_title.getSeconds();
        let fecha_title_ok = year+'-'+month+'-'+day+''+hours+''+minutes+''+seconds;
        tabla_9 = $("#tabla_ingresar_11").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title:'Reporte Validado estatus 11 '+fecha_title_ok,
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' '+titulos[columnIdx] +' ';

                        }
                    }
                }
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
            columns: [
                {
                    "data": function( d ){
                        return '<p class="m-0">'+(d.descripcion).toUpperCase()+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+(d.nombre).toUpperCase()+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';

                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreCliente+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        let dateFormat = new Date(d.fecha_status_11);
                        let year = dateFormat.getFullYear();
                        let month = (dateFormat.getMonth()<10) ? '0'+dateFormat.getMonth() : dateFormat.getMonth();
                        let day = (dateFormat.getDate()<10) ? '0'+dateFormat.getDate(): dateFormat.getDate();
                        let hours = (dateFormat.getHours()<10) ? '0'+dateFormat.getHours(): dateFormat.getHours();
                        let minutes = (dateFormat.getMinutes()<10) ? '0'+dateFormat.getMinutes(): dateFormat.getMinutes();
                        let seconds = (dateFormat.getSeconds()<10) ? '0'+dateFormat.getSeconds(): dateFormat.getSeconds();
                        let fecha_formateada = year+'-'+month+'-'+day+' '+hours+':'+minutes+':'+seconds;
                        return '<p class="m-0">'+fecha_formateada+'</p>';
                    }
                }
                ],
            columnDefs: [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            ajax: {
                "url": '<?=base_url()?>index.php/Administracion/getDateStatus11',
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            },
        });



    });




</script>
</body>