<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade"
             id="historial-modal"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true"
             data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Historial del pago</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="historial-prestamo-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon"
                                 data-background-color="goldMaderas">
                                <i class="fas fa-book fa-2x"></i>
                            </div>

                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial de préstamos</h3>
                                    <p class="card-title pl-1">
                                        (Historial de todos los préstamos)
                                    </p>
                                </div>

                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Total pagos:</h4>
                                                    <p class="input-tot pl-1" id="total-pago">$0.00</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="roles">Puesto</label>
                                                    <select class="selectpicker select-gral"
                                                            name="roles"
                                                            id="roles"
                                                            required>
                                                        <option value=""
                                                                disabled
                                                                selected>
                                                            Selecciona un rol
                                                        </option>
                                                        <option value="7">Asesor</option>
                                                        <option value="9">Coordinador</option>
                                                        <option value="3">Gerente</option>
                                                        <option value="2">Sub director</option>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="users">Usuario</label>
                                                    <select class="selectpicker select-gral"
                                                            id="users"
                                                            name="users"
                                                            data-style="btn"
                                                            data-show-subtext="true"
                                                            data-live-search="true"
                                                            title="SELECCIONA UN USUARIO"
                                                            data-size="7"
                                                            required>
                                                    </select>
                                                </div>
                                            </div> -->
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                                            <label for="proyecto">Mes</label>
                                                            <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
                                                                <?php
                                                                    setlocale(LC_ALL, 'es_ES');
                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                    $monthNum  = $i;
                                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                                    $monthName = strftime('%B', $dateObj->getTimestamp());
                                                                    echo '<option value="' . $i . '">' . $monthName . '</option>';
                                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                    <div class="form-group">
                                                                   <label>Año</label>
                                                                   <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                                   <?php
                                                                    setlocale(LC_ALL, 'es_ES');
                                                                     for ($i = 2021; $i <= 2023; $i++) {
                                                                     $yearName  = $i;
                                                                     echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END TOOLBAR -->

                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                   id="prestamos-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID PAGO</th>
                                                        <th>ID PRÉSTAMO</th>
                                                        <th>USUARIO</th>
                                                        <th>PUESTO</th>
                                                        <th>MONTO TOTAL</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>PAGO INDIVUAL</th>
                                                        <th>FECHA</th>
                                                        <th>COMENTARIOS</th>
                                                        <th>ESTATUS</th>
                                                        <th>TIPO DESCUENTO</th>
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
        </div>

        <?php $this->load->view('template/footer_legend');?>
    </div>

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
        const baseUrl = '<?=base_url()?>';
        let prestamosTabla;

        $("#prestamos-table").prop('hidden', true);

        // $('#roles').change(function () {
        //     const rol = $(this).val();
        //     // $("#users").empty().selectpicker('refresh');

        //     $.ajax({
        //         url: `${baseUrl}Comisiones/getUserPrestamoByRol/${rol}`,
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function (data) {
        //             const len = data.length;
        //             for(let i = 0; i < len; i++){
        //                 const id = data[i]['id_usuario'];
        //                 const name = data[i]['name_user'].toUpperCase();
        //                 $("#users").append($('<option>').val(id).text(name));
        //             }

        //             $("#users").selectpicker('refresh');
        //         }
        //     });

        //     // createPrestamosDataTable(rol, user, mes, anio);
        // });

        // $('#users').change(function () {
        //     const rol = $('#roles').val();
        //     let user = $(this).val();
        //     mes = $('#mes').val();
        //     rol = $('#rol').val();

        //     if (user === undefined || user === null || user === '') {
        //         user = 0;
        //     }

        //     // createPrestamosDataTable(rol, user, mes, anio);
        // });

        $('#mes').change(function(ruta){
            anio = $('#anio').val();
            mes = $('#mes').val();
            
            if(mes == '' || anio == ''){
            }else{
               createPrestamosDataTable(mes, anio);
            }
        });

        $('#anio').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            // rol = $('#roles').val();
            // users = $('#users').val();
            console.log(anio);
            if(anio == '' || mes == ''){
            }else{
                createPrestamosDataTable(mes, anio);
            }
            
        });

    //     $('#rol').change( function(){
    //     mes = $('#mes').val();
    //     anio = $('#anio').val();
    //     rol = $('#rol').val();

    //     if(mes == '' || anio == '' ){
    //    //     alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
    //     }else{
    //         createPrestamosDataTable(anio,rol);
    //     }
    // });

        $('#prestamos-table thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();

            if ( i != 10) {
                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (prestamosTabla.column(i).search() !== this.value) {
                        prestamosTabla.column(i).search(this.value).draw();

                        var total = 0;
							var index = prestamosTabla.rows({ selected: true, search: 'applied' }).indexes();
							var data = prestamosTabla.rows( index ).data();
							$.each(data, function(i, v){
								total += parseFloat(v.abono_neodata);
							});
                            document.getElementById('total-pago').textContent = '$' + formatMoney(total);
                    }
                });
            }
        });

        function createPrestamosDataTable(mes, anio) {
            console.log(anio);
            if (prestamosTabla) {
                prestamosTabla.clear();
                prestamosTabla.destroy();
                $('#prestamos-table tbody').empty();
            }

            $("#prestamos-table").prop('hidden', false);

            $('#prestamos-table').on('xhr.dt', function (e, settings, json) {
                let total = 0;

                $.each(json.data, function(i, v) {
                    total += parseFloat(v.abono_neodata);
                });

                document.getElementById('total-pago').textContent = '$' + formatMoney(total);
            });

            prestamosTabla = $('#prestamos-table').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11],
                            format: {
                                header: function (d, columnIndx) {
                                    switch (columnIndx) {
                                        case 0: return 'ID PAGO';
                                        case 1: return 'ID PRÉSTAMO';
                                        case 2: return 'USUARIO';
                                        case 3: return 'PUESTO';
                                        case 4: return 'MONTO TOTAL';
                                        case 5: return 'PAGADO';
                                        case 6: return 'PENDIENTE';
                                        case 7: return 'PAGO INDIVIDUAL';
                                        case 8: return 'FECHA';
                                        case 9: return 'COMENTARIOS';
                                        case 10: return 'TIPO DESCUENTO';
                                        case 11: return 'ESTATUS';
                                        default: return 'NA';
                                    }
                                }
                            }
                        }
                    }
                ],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: `${baseUrl}/static/spanishLoader_v2.json`,
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [
                    {
                        'name': 'ID PAGO',
                        'width': "5%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.id_pago_i+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.id_prestamo+'</p>';
                        }
                    },
                    {
                        'width': "20%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.nombre_completo+'</p>';
                        }
                    },
                    {
                        'width': "10%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.puesto+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">$'+formatMoney(d.monto_prestado)+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">$'+formatMoney(d.abono_neodata)+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">$'+formatMoney(d.pendiente)+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">$'+formatMoney(d.pago_individual)+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.fecha_creacion+'</p>';
                        }
                    },
                    {
                        'width': "8%",
                        'data': function( d ){
                            return '<p class="m-0">'+d.comentario+'</p>';
                        }
                    },
                    {
                        'width': "5%",
                        'data': function(d) {
                            return '<span class="label" style="background: #05A134;">PAGADO</span>';
                        }
                    },
                    {
                        'width': "5%",
                        'data': function(d) {
                            let etiqueta = '';
						color='000';
						if(d.id_opcion == 18){ //PRESTAMO
							color='89C86C';
						} else if(d.id_opcion == 19){ //SCIO
							color='72EDD6';
						}else if(d.id_opcion == 20){ //PLAZA
							color='72CBED';
						}else if(d.id_opcion == 21){ //LINEA TELEFÓNICA
							color='7282ED';
						}else if(d.id_opcion == 22){ //MANTENIMIENTO
							color='CA72ED';
						}else if(d.id_opcion == 23){ //NÓMINA - ANALISTAS DE COMISIONES
							color='CA15ED';
						}else if(d.id_opcion == 24){ //NÓMINA - ASISTENTES CDMX
							color='CA9315';
						}else if(d.id_opcion == 25){ //NÓMINA - IMSS
							color='34A25C';
						}else if(d.id_opcion == 26){ //NÓMINA -LIDER DE PROYECTO E INNOVACIÓN
							color='165879';
						}

						return '<p><span class="label" style="background:#'+color+';">'+d.tipo+'</span></p>';
                        }
                    },
                    {
                        'width': "6%",
                        'orderable': false,
                        'data': function( d ) {
                            return `
                                <button class="btn-data btn-blueMaderas consulta-historial"
                                    value="${d.id_relacion_pp}"
                                    title="Historial">
                                    <i class="fas fa-info"></i>
                                </button>
`                           ;
                        }
                    }
                ],
                columnDefs: [],
                ajax: {
                    url: `${baseUrl}Comisiones/getPrestamosTable/${mes}/${anio}`,
                    type: "GET",
                    cache: false,
                    data: function( d ){}
                },
            });

            $('#prestamos-table tbody').on('click', '.consulta-historial', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                const idRelacion = $(this).val();

                $('#historial-prestamo-content').html('');
                $.getJSON(`${baseUrl}Comisiones/getHistorialPrestamoAut/${idRelacion}`)
                    .done(function (data) {
                        $.each(data, function(i, v) {
                            $("#historial-prestamo-content").append(`
                                <p style="color:gray;font-size:1.1em;">
                                    ${v.comentario}
                                    <br>
                                    <b style="color:#3982C0;font-size:0.9em;">
                                        ${v.fecha}
                                    </b>
                                    <b style="color:gray;font-size:0.9em;">
                                    - ${v.nombre_usuario}
                                    </b>
                                </p>
                            `);
                        });

                        $('#historial-modal').modal();
                    });
            });
        }

        function formatMoney( n ) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d === undefined ? "." : d,
                t = t === undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        }
    </script>
</body>