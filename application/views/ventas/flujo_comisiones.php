<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Flujo comisiones</h3>
                                    <!-- <p class="card-title pl-1">(Pagos dispersados por el área de contraloría, disponibles para revisión)</p> -->
                                </div>
                                <div class="material-datatables">
                                    <div class="container-fluid encabezado-totales">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">TOTAL COMISIÓN</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="inputTotalComision" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">ABONADO</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="inputAbono" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">PENDIENTE</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="inputPendiente" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_flujo_comisiones" name="tabla_flujo_comisiones">
                                                <thead>
                                                    <tr>
                                                    <th>ID LOTE</th>
                                                        <th>NOMBRE LOTE</th>
                                                        <th>ESTATUS CONTRATACIÓN</th>
                                                        <th>FECHA APARTADO</th>
                                                        <th>FECHA PRSPECTO</th>
                                                        <th>TOTAL COM. ($)</th>
                                                        <th>ABONO PAG.</th>
                                                        <th>PENDIENTE</th>
                                                        <th>DISPERSIÓN</th>
                                                        <th>OBSERVACIONES</th>
                                                        <th>ESTATUS COMISIÓN</th>
                                                        <th>ESTATUS GENERAL</th>
                                                        <th>ESTATUS MKTD</th>
                                                        <th>ESTATUS EVI.</th>
                                                        <th>PLAZA</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
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
        var url2 = "<?= base_url() ?>index.php/";


        $("#tabla_flujo_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_flujo_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 2){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {

                        if (tabla_nuevas.column(i).search() != this.value) {
                            tabla_nuevas
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                            var totalComision = 0;
                            var totalAbono = 0;
                            var totalPendiente = 0;
                            
                            var index = tabla_nuevas.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_nuevas.rows(index).data();

                            $.each(data, function(i, v) {
                                v.comision_total == null ? totalComision += 0 : totalComision += parseFloat(v.comision_total);
                                v.abono_pagado == null ? totalAbono += 0 : totalAbono += parseFloat(v.abono_pagado);
                                v.pendiente == null ? totalPendiente += 0 : totalPendiente += parseFloat(v.pendiente);
                            });
                            var to1 = formatMoney(totalComision);

                            document.getElementById("inputTotalComision").value = '$' + formatMoney(totalComision);
                            document.getElementById("inputAbono").value = '$' + formatMoney(totalAbono);
                            document.getElementById("inputPendiente").value = '$' + formatMoney(totalPendiente);

                        
                    });
                }
            });

            $('#tabla_flujo_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var totalComision = 0;
                var totalAbono = 0;
                var totalPendiente = 0;

                $.each(json.data, function(i, v) {
                    v.comision_total == null ? totalComision += 0 : totalComision += parseFloat(v.comision_total);
                    v.abono_pagado == null ? totalAbono += 0 : totalAbono += parseFloat(v.abono_pagado);
                    v.pendiente == null ? totalPendiente += 0 : totalPendiente += parseFloat(v.pendiente);
                });
                
                var toCo = formatMoney(totalComision);
                var toAb = formatMoney(totalAbono);
                var toPe = formatMoney(totalPendiente);

                document.getElementById("inputTotalComision").value = toCo;
                document.getElementById("inputAbono").value = toAb;
                document.getElementById("inputPendiente").value = toPe;
            });

            tabla_nuevas = $("#tabla_flujo_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'FLUJO DE COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID LOTE ';
                                }else if(columnIdx == 1){
                                    return 'NOMBRE LOTE';
                                }
                                else if(columnIdx == 2){
                                    return 'ESTATUS CONTRATACIÓN';
                                }else if(columnIdx == 3){
                                    return 'FECHA APARTADO';
                                }else if(columnIdx == 4){
                                    return 'FECHA PROSPECTO';
                                }else if(columnIdx == 5){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 6){
                                    return 'PAGADO';
                                }else if(columnIdx == 7){
                                    return 'PENDIENTE';
                                }else if(columnIdx == 8){
                                    return 'DISPERSIÓN';
                                }else if(columnIdx == 9){
                                    return 'OBSERVACIONES';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS COMISIÓN';
                                }else if(columnIdx == 11){
                                    return 'ESTATUS LOTE';
                                }else if(columnIdx == 12){
                                    return 'ESTATUS MKTD';
                                }else if(columnIdx == 13){
                                    return 'ESTATUS EVIDENCIA';
                                }else if(columnIdx == 14){
                                    return 'PLAZA';
                                }else if(columnIdx == 15){
                                    return 'SEDE';
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
                columns: [
                    {
                        "width": "5%",
                        "data": function( d ){
                            return '<p class="m-0"><b>'+d.idLote+'</b></p>';
                        }
                    },
                    {
                        "width": "5%",
                        "data": function( d ){
                            return '<p class="m-0"><b>'+d.nombreLote+'</b></p>';
                        }
                    },
                    {
                        "width": "5%",
                        "data": function( d ){
                            if(d.nombreStatus == null){
                                return '<p class="m-0"><b></b></p>';
                            }else{
                                return '<p class="m-0"><b>'+d.nombreStatus+'</b></p>';
                            }

                                                  }
                    },
                    {
                        "width": "9%",
                        "data": function( d ){
                            let fech = d.fechaApartado;
                                                    
                           // let fecha = fech.substr(0, 10);
                          //  let nuevaFecha = fecha.split('-');
                            //return '<p class="m-0">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
                            if(fech == null){
                                return '<p class="m-0"></p>';
                            }else{
                                return '<p class="m-0">'+fech+'</p>';
                            }
                         
                        }
                    },
                    {
                        "width": "9%",
                        "data": function( d ){

                            let fech = d.fechaProspecto;
                            if(fech == null){
                                return '<p class="m-0"></p>';
                            }else{
                                return '<p class="m-0">'+fech+'</p>';
                            }
                          //  let fecha = fech.substr(0, 10);
                           // let nuevaFecha = fecha.split('-');
                           // return '<p class="m-0">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
                          

                            
                         
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            if(d.comision_total == null){
                                return '<p class="m-0">0</p>';
                            }else{
                                return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                            }
                           
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            if(d.abono_pagado == null){
                                return '<p class="m-0">0</p>';
                            }else{
                                return '<p class="m-0"><b>$'+formatMoney(d.abono_pagado)+'</b></p>';
                            }
                            
                        }
                    },
                    
                    {
                        "width": "8%",
                        "data": function( d ){
                            if(d.pendiente == null){
                                return '<p class="m-0">0</p>';
                            }else{
                                return '<p class="m-0">$'+formatMoney(d.pendiente)+' </p>';
                            }
                            
                        }
                    },
                    
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.dispersion+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.observaciones+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.estatus_com+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.estatus_comision_lote+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.ESTATUS_MKTD+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.estatus_evidencia+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.plaza+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.sede+'</p>';
                        }
                    },
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 2,
                    'searchable': false,
                    'className': 'dt-body-center',
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosFlujoComisiones",
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
                order: [
                    [1, 'asc']
                ]
            });
            
        });

        //FIN TABLA NUEVA

        $(window).resize(function() {
        //    tabla_nuevas.columns.adjust();
        });

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        
    </script>
</body>