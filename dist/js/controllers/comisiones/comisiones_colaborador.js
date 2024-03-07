        var userType = "<?php echo $this->session->userdata('id_rol') ?>";
        var userSede = "<?php echo $this->session->userdata('id_sede') ?>";
        var id_usuario = "<?php echo $this->session->userdata('id_usuario') ?>";
        var forma_pago = "<?php echo $this->session->userdata('forma_pago') ?>";

        console.log(forma_pago);

        $("#file-upload-extranjero").on('change', function() {
        $('#archivo-extranjero').val('');

            v2 = document.getElementById("file-upload-extranjero").files[0].name;
            document.getElementById("archivo-extranjero").innerHTML = v2;

            const src = URL.createObjectURL(document.getElementById("file-upload-extranjero").files[0]);
            $('#preview-div').html("");
            $('#preview-div').append(`<embed src="${src}" width="500" height="200">`);
        });

        $(document).on("click", ".subir-archivo", function(e) {
            e.preventDefault();
            $('#archivo-extranjero').val('');

            $.ajax({
                url: 'getTotalComisionAsesor',
                type: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    $('#total-comision').html("");
                    $('#total-comision').append(`Total: $${formatMoney(data.total)}`);
                    $('#addFileExtranjero').modal('show');
                }
            });
        });

        $("#EditarPerfilExtranjeroForm").one('submit', function(e){
            document.getElementById('sendFileExtranjero').disabled =true;
            $("#sendFileExtranjero").prop("disabled", true);
            e.preventDefault();

            const formData = new FormData(document.getElementById("EditarPerfilExtranjeroForm"));
            formData.append("dato", "valor");

            $.ajax({
                type: 'POST',
                url: url+'index.php/Usuarios/SubirPDFExtranjero',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    document.getElementById('sendFileExtranjero').disabled =false;
                    $("#sendFileExtranjero").prop("disabled", false);
                    if (data == 1) {
                        $("#addFileExtranjero").modal('hide');
                        setTimeout('document.location.reload()',100);
                    } else {
                        $("#addFileExtranjero").modal('hide');
                        alerts.showNotification("top", "right", "Error al subir el archivo.", "warning");
                    }
                },
                error: function(){
                    $("#addFileExtranjero").modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $(document).on('click', '.verPDFExtranjero', function () {
            const $itself = $(this);
            Shadowbox.open({
                content: '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/extranjero/'+$itself.attr('data-usuario')+'"></iframe></div>',
                player: "html",
                title: "Visualizando documento fiscal: " + $itself.attr('data-usuario'),
                width: 985,
                height: 660
            });
        });

        var input = document.getElementById('dato_solicitudcp');
        input.addEventListener('input',function(){
        if (this.value.length > 5) 
        this.value = this.value.slice(0,5); 
        })

        // Apartado para la validacion del codigo postal       
        $(document).ready(function () {
            $.ajax({
                url: url2 + 'Comisiones/consulta_codigo_postal',
                cache: false,
                contentType: false,
                processData: false,
                type: 'GET',
                success: function (response) {        
                    const data = JSON.parse(response);
                    if(data.length == 0 && forma_pago == 3){
                        $("#solicitud_cp").modal();  
                    }else if(data[0]['estatus'] == 0 && forma_pago == 3){
                        var b = document.getElementById("dato_solicitudcp");
                        b.setAttribute("value", data[0]['codigo_postal']);
                        $("#solicitud_cp").modal();
                    }else if(data[0]['estatus'] != 0 && data.length != 0 && forma_pago == 3){
                        var b = document.getElementById("dato_solicitudcp");
                        b.setAttribute("value", data[0]['codigo_postal']);
                    }
                }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                 }
            });
        });

        $(document).ready(function(){
            $.ajax({
                url: url2 + 'Comisiones/pagos_codigo_postal',
                cache: false,
                contentType: false,
                processData: false,
                type: 'GET',
                success: function (response) {
                    const data1 = JSON.parse(response);
                    if(data1.length == 0){
                        // $("#solicitud_cp").modal();
                    }else if(data1.length != 0){
                        document.getElementById("dato_solicitudcp").disabled = true;  
                        document.getElementById("codigopostalSubmit").disabled = true;
                        document.getElementById('codigopostalCancel').style.display = 'inline';
                    }
                }
            });
        });


        $(document).on("submit", "#codigoForm", function (e) {  
            e.preventDefault();   
            let dato_solicitudcp = $('#dato_solicitudcp').val();

            if(dato_solicitudcp == ''){
                alerts.showNotification("top", "right", "Llenar la informacion solicitada.", "warning");
                return false;
            }
            let data = new FormData($(this)[0]);
            $.ajax({
                url: url2 + 'Comisiones/insertar_codigo_postal',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                alerts.showNotification("top","right","Se capturo tu codigo postal: "+dato_solicitudcp+"","success");
                $("#solicitud_cp").modal("hide");
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
            });

        });



        function codigo_consulta(){
            $("#solicitud_cp").modal();
        }


        // Termina apartado para la validacion del codigo postal

        $(document).ready(function () {
            $.post(url + "Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#proyecto_wp").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#proyecto_wp").selectpicker('refresh');
            }, 'json');
        });

        $('#proyecto_wp').change(function () {
            index_proyecto = $(this).val();
            index_condominio = 0
            $("#condominio_wp").html("");
            $(document).ready(function () {
                $.post(url + "Contratacion/lista_condominio/" + index_proyecto, function (data) {
                    var len = data.length;
                    $("#condominio_wp").append($('<option disabled selected>Selecciona una opción</option>'));

                    for (var i = 0; i < len; i++) {
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $("#condominio_wp").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#condominio_wp").selectpicker('refresh');
                }, 'json');
            });
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            if (userType != 2 && userType != 3 && userType != 13 && userType != 32 && userType != 17) { // SÓLO MANDA LA PETICIÓN SINO ES SUBDIRECTOR O GERENTE
                fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
            }
        });

        $('#condominio_wp').change(function () {
            index_proyecto = $('#proyecto_wp').val();
            index_condominio = $(this).val();
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
        });

        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totaPen = 0;
        var tr;

        $("#tabla_nuevas_comisiones").ready(function() {

            let titulos = [];
            $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 0){
                    var title = $(this).text();
                    titulos.push(title);    
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_nuevas.column(i).search() !== this.value) {
                            tabla_nuevas
                                .column(i)
                                .search(this.value)
                                .draw();

                            var total = 0;
                            var index = tabla_nuevas.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_nuevas.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.pago_cliente);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_nuevas").textContent = formatMoney(total);
                        }
                    });
                } else {
                    $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
                }
            });

            $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.pago_cliente);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas").textContent = '$' + to;
            });

            tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [
                <?php if($this->session->userdata('forma_pago') != 2 ){?> 
                {
                    text: '<i class="fa fa-paper-plane"></i> SOLICITAR PAGO',
                    action: function() {
                        let actual=13;
                        if(userSede == 8){
                            actual=15;

                        }
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth()+1;
                        var anio = hoy.getFullYear();
                        var hora = hoy.getHours();
                        var minuto = hoy.getMinutes();

                         if ((((mes == 09 && dia == 30) || (mes == 10 && dia == 11 && hora <= 13)) ||
                        ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                        ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)) ||
                        (id_usuario == 7689)) || id_usuario == 10205){

                            if ($('input[name="idT[]"]:checked').length > 0) {
                                $('#spiner-loader').removeClass('hide');
                                var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                    return this.value;
                                }).get();

                                var com2 = new FormData();
                                com2.append("idcomision", idcomision); 

                                $.ajax({
                                    url : url2 + 'Comisiones/acepto_comisiones_user/',
                                    data: com2,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    type: 'POST', 
                                    success: function(data){
                                    response = JSON.parse(data);
                                        if(data == 1) {
                                            $('#spiner-loader').addClass('hide');
                                            $("#totpagarPen").html(formatMoney(0));
                                            $("#all").prop('checked', false);
                                            var fecha = new Date();

                                            alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");

                                            tabla_nuevas.ajax.reload();
                                            tabla_revision.ajax.reload();
                                        }else if(data == 2) {
                                            $('#spiner-loader').addClass('hide');
                                            $("#all").prop('checked', false);
                                            var fecha = new Date();

                                            alerts.showNotification("top", "right", "ESTÁS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES.", "warning");
                                        } else {
                                            $('#spiner-loader').addClass('hide');
                                            alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                        }
                                    },
                                    error: function( data ){
                                            $('#spiner-loader').addClass('hide');
                                            alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                    }
                                });
                            }
                        }
                        else{
                            $('#spiner-loader').addClass('hide');
                            alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al siguiente corte", "warning");      
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                        style: 'position:relative; float:right'
                    }
                }, 
                <?php } ?>
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES NUEVAS',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'ID PAGO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'LOTE';
                                }else if(columnIdx == 4){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 5){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 6){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 7){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 8){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 9){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 10){
                                    return 'DETALLE';
                                }else if(columnIdx == 11){
                                    return 'ESTATUS NUEVAS';
                                }else if(columnIdx != 12 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                },
                <?php if ($this->session->userdata('forma_pago') == 3) { ?> 
                {
                    text: '<i class="fa fa-archive" aria-hidden="true"></i>',
                    className: 'btn btn-azure',
                    titleAttr: 'Clic para consultar codigo postal',
                    action: function (e,dt,button,confing){
                        $('#solicitud_cp').modal('show');
                    }
                },
                <?php } ?>

                <?php if (($this->session->userdata('forma_pago') == 2 ||
                    $this->session->userdata('forma_pago') == 3 ||
                    $this->session->userdata('forma_pago') == 4 ||
                    $this->session->userdata('forma_pago') == 5) &&
                    ($this->session->userdata('id_rol') == 3 ||
                    $this->session->userdata('id_rol') == 7 ||
                    $this->session->userdata('id_rol') == 9)) { ?>
                        {
                            text: '<i class="fa fa-video-camera" aria-hidden="true"></i>',
                            className: 'btn buttons-youtube',
                            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de comisiones podrás visualizarlo en el siguiente tutorial',
                            action: function ( e, dt, button, config ) {
                                <?php if ($this->session->userdata('forma_pago') == 2) { ?>
                                    window.open('https://youtu.be/YuZNsPk8-gY', '_blank');
                                <?php } ?>
                                <?php if ($this->session->userdata('forma_pago') == 3) { ?>
                                    window.open('https://youtu.be/LmmIdipDSEA', '_blank');
                                <?php } ?>
                                <?php if ($this->session->userdata('forma_pago') == 4) { ?>
                                    window.open('https://youtu.be/oRoJev_AZgs', '_blank');
                                <?php } ?>
                                <?php if ($this->session->userdata('forma_pago') == 5) { ?>
                                    window.open('https://youtu.be/4t0MNA8HxZ4', '_blank');
                                <?php } ?>
                            } 
                        } 
                <?php }?>
                        
                ],           
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
                    "width": "5%"
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_i + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        switch (d.forma_pago) {
                            case '1': //SIN DEFINIR
                            case 1: //SIN DEFINIr
                                return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">SIN DEFINIR FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';

                            case '2': //FACTURA
                            case 2: //FACTURA
                                return '<p class="mb-1"><span class="label" style="background:#806AB7;">FACTURA</span></p><p style="font-size: .5em"><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';

                            case '3': //ASIMILADOS
                            case 3: //ASIMILADOS
                                return '<p class="mb-1"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                            case '4': //RD
                            case 4: //RD
                                return '<p class="mb-1"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                            case '5':
                            case 5:
                                return `
                                    <p class="mb-1">
                                        <span class="label" style="background:#0080FF;">FACTURA EXTRANJERO</span>
                                    </p>
                                `;
                            default:
                                return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                        }
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_nuevas" title="Detalles">' +'<i class="fas fa-info"></i></button>';

                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center',
                    render: function(d, type, full, meta) {
                        let actual=13;
                        if(userSede == 8){
                            actual=15;

                        }
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth()+1;
                        var anio = hoy.getFullYear();
                        var hora = hoy.getHours();
                        var minuto = hoy.getMinutes();
    


                        if (((mes == 09 && dia == 30) || (mes == 10 && dia == 11 && hora <= 13)) ||
                        ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                        ((mes == 12 && dia == 24) || (mes == 12 && dia == 24 && hora <= 13)) ||
                        (id_usuario == 7689))
                        {

                            switch (full.forma_pago) {
                                case '1': //SIN DEFINIR
                                case 1: //SIN DEFINIR
                                case '2': //FACTURA
                                case 2: //FACTURA
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                break;

                                case '5':
                                case 5:
                                    if (full.fecha_abono && full.estatus == 1) {
                                        const fechaAbono = new Date(full.fecha_abono);
                                        const fechaOpinion = new Date(full.fecha_opinion);
                                        if (fechaAbono.getTime() > fechaOpinion.getTime()) {
                                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                        }
                                    }
                                    return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';

                                case '3': //ASIMILADOS
                                case 3: //ASIMILADOS
                                case '4': //RD
                                case 4: //RD
                                default:

                                if (full.id_usuario == 5028  || full.id_usuario == 4773 || full.id_usuario == 5381 ){
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';

                                } else {
                                    return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                                }
                                break;
                            }
                        } else {
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        }
                    },
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesor/"+1,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });

            $('#tabla_nuevas_comisiones').on('click', 'input', function() {
                tr = $(this).closest('tr');

                var row = tabla_nuevas.row(tr).data();
                if (row.pa == 0) {
                    row.pa = row.impuesto;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                } 
                else {
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }

                $("#totpagarPen").html(formatMoney(totaPen));
            });

            /**-------------------------------------- */
            $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_nuevas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });

        //FIN TABLA NUEVA

        // INICIO TABLA EN PROCESO
        $("#tabla_revision_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 11){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {

                        if (tabla_revision.column(i).search() !== this.value) {
                            tabla_revision
                                .column(i)
                                .search(this.value)
                                .draw();

                            var total = 0;
                            var index = tabla_revision.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_revision.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.pago_cliente);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_revision").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_revision_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.pago_cliente);
                });

                var to = formatMoney(total);
                document.getElementById("myText_revision").textContent = '$' + to;
            });

            tabla_revision = $("#tabla_revision_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES EN REVISION',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS REVISION';
                                }else if(columnIdx != 11 && columnIdx !=0){
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
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){

                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="mb-1"><span class="label" style="background:#2242CB;">REVISIÓN CONTRALORÍA</span></p>';
                        
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_revision" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesor/"+4,

                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });

            $("#tabla_revision_comisiones tbody").on("click", ".consultar_logs_revision", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#2242CB; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:2242CB;">'+v.comentario+'</i><br><b style="color:#2242CB">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });
        // FIN TABLA PROCESO

        // INICIO TABLA INTERNOMEX
        $("#tabla_pagadas_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 11){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {

                        if (tabla_pagadas.column(i).search() !== this.value) {
                            tabla_pagadas
                                .column(i)
                                .search(this.value)
                                .draw();

                            var total = 0;
                            var index = tabla_pagadas.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_pagadas.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.pago_cliente);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_pagadas").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_pagadas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.pago_cliente);
                });
                var to = formatMoney(total);
                document.getElementById("myText_pagadas").textContent = '$' + to;
            });

            tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES POR PAGAR',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS INTERNOMEX';
                                }else if(columnIdx != 11 && columnIdx !=0){
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
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="mb-1"><span class="label" style="background:#9321B6;">REVISIÓN INTERNOMEX</span></p>';
                        
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pagadas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesAsesor/"+8,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });

            $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_logs_pagadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#9321B6; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');

                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:9321B6;">'+v.comentario+'</i><br><b style="color:#9321B6">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });
        // FIN TABLA internomex

        // INICIO TABLA OTRAS
        $("#tabla_otras_comisiones").ready(function() {

            let titulos = [];
            $('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 11){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {

                        if (tabla_otras.column(i).search() !== this.value) {
                            tabla_otras
                                .column(i)
                                .search(this.value)
                                .draw();

                            var total = 0;
                            var index = tabla_otras.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_otras.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.pago_cliente);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_pausadas").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_otras_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.pago_cliente);
                });

                var to = formatMoney(total);
                document.getElementById("myText_pausadas").textContent = '$' + to;
            });

            tabla_otras = $("#tabla_otras_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE DE COMISIONES PAUSADAS POR CONTRALORÍA',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS PAUSADAS';
                                }else if(columnIdx != 11 && columnIdx !=0){
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
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="m-0"><span class="label" style="background:#CB7922;">EN PAUSA</span></p>';
                        
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pausadas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesAsesor/"+6,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
    
            $("#tabla_otras_comisiones tbody").on("click", ".consultar_logs_pausadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#CB7922; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:CB7922;">'+v.comentario+'</i><br><b style="color:#CB7922">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });

        // FIN TABLA PAGADAS
        $('#tabla_comisiones_sin_pago thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value) {
                    $('#tabla_comisiones_sin_pago').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        function fillCommissionTableWithoutPayment (proyecto, condominio) {
            tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
                dom: "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'><'col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-end p-0'l>rt><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
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
                    data: function(d) {
                        return '<p class="m-0">' + d.idLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCondominio + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCliente + ' </p>';
                    }
                },

                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreAsesor + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCoordinador + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreGerente + '</p>';
                    }
                },
                {
                    data: function(d) {
                        switch (d.reason) {
                            case '0':
                                return '<p class="m-0"><b>En espera de próximo abono en NEODATA </b></p>';
                            break;
                            case '1':
                                return '<p class="m-0"><b>No hay saldo a favor. Esperar próxima aplicación de pago. </b></p>';
                            break;
                            case '2':
                                return '<p class="m-0"><b>No se encontró esta referencia </b></p>';
                            break;
                            case '3':
                                return '<p class="m-0"><b>No tiene vivienda, si hay referencia </b></p>';
                            break;
                            case '4':
                                return '<p class="m-0"><b>No hay pagos aplicados a esta referencia </b></p>';
                            break;
                            case '5':
                                return '<p class="m-0"><b>Referencia duplicada </b></p>';
                            break;
                            default:
                                return '<p class="m-0"><b>Sin localizar </b></p>';
                            break;
                        }
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
        };

        $(window).resize(function() {
            tabla_nuevas.columns.adjust();
            tabla_revision.columns.adjust();
            tabla_pagadas.columns.adjust();
            tabla_otras.columns.adjust();
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

        $(document).on("click", ".subir_factura", function() {
            resear_formulario();
            id_comision = $(this).val();
            total = $(this).attr("data-total");
            link_post = "Comisiones/guardar_solicitud/" + id_comision;
            $("#modal_formulario_solicitud").modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modal_formulario_solicitud .modal-body #frmnewsol").append(`<div id="inputhidden"><input type="hidden" id="comision_xml" name="comision_xml" value="${ id_comision}">
            <input type="hidden" id="pago_cliente" name="pago_cliente" value="${ parseFloat(total).toFixed(2) }"></div>`);
        });

    
        let c = 0;
        function saveX() {
            document.getElementById('btng').disabled=true;
            save2();
        }


        function EnviarDesarrollos() {
            document.getElementById('btn_EnviarM').disabled=true;
            var formData = new FormData(document.getElementById("selectDesa"));
            formData.append("dato", "valor");
            $.ajax({
                url: url + 'Comisiones/EnviarDesarrollos',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data == 1) {
                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente.", "success");
                        document.getElementById('btn_EnviarM').disabled=false;
                        //$('#tabla_nuevas_comisiones').DataTable().ajax.reload(null, false);
                        //$('#tabla_revision_comisiones').DataTable().ajax.reload(null, false);
                        location.reload();
                        $("#ModalEnviar").modal("hide");
                    } else {
                        alerts.showNotification("top", "right", "No se ha podido completar la solicitud.", "warning");
                    }
                },
                error: function() {
                    document.getElementById('btn_EnviarM').disabled=false;
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        $(document).on("click", ".quitar_factura", function() {
            resear_formulario();
            id_comision = $(this).val();
            $("#modalQuitarFactura .modal-body").html('');

            $("#modalQuitarFactura .modal-body").append('<input type="hidden" name="delete_fact" value="' + id_comision + '">');

            $("#modalQuitarFactura .modal-body").append('<div class="row"><div class="col-md-12"><p>¿Estás seguro de eliminar esta factura?</p></div></div>');
            $("#modalQuitarFactura .modal-body").append('<div class="row"><div class="col-md-12"><button type="submit" class="btn btn-success btn-block">ELIMINAR</button> <button type="button" data-dismiss="modal" class="btn btn-danger btn-block close_modal_fact">SALIR</button></div></div>');

            $("#modalQuitarFactura").modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        /** ----------------------------------------*/

        $(document).on("click", ".EnviarMultiple", function() {
            $("#ModalEnviar .modal-body").html("");
            $("#ModalEnviar .modal-header").html("");

            $("#ModalEnviar .modal-header").append(`<div class="row"><div class="col-md-12">
            <form id="selectDesa">
            <b class="">Seleccione un desarrollo</b>
            <select id="desarrolloSelect2" name="desarrolloSelect2" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true">
            </select>
            </div></div>`);

            $.post('getDesarrolloSelect', function(data) {
                c = 0;
                $("#desarrolloSelect2").append($('<option disabled>').val("default").text("Seleccione una opción"))
                var len = data.length;
                let id2 = 1000;
                let name2='TODOS';
                $("#desarrolloSelect2").append($('<option>').val(id2).attr('data-value', id2).text(name2));
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['descripcion'];
                    $("#desarrolloSelect2").append($('<option>').val(id).attr('data-value', id).text(name));
                }

                if (len <= 0) {
                    $("#desarrolloSelect2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#desarrolloSelect2").val(0);
                $("#desarrolloSelect2").selectpicker('refresh');
            }, 'json');

            $("#ModalEnviar .modal-header").append(`<div class="row"><div class="col-md-12">
            <center>
            <button type="submit" id="btn_EnviarM" onclick="EnviarDesarrollos()" class="btn btn-success">ENVIAR</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                        </center>
            </form>
            </div></div>`);

            $("#ModalEnviar").modal();
        });
        /** -------------------------------------------------------------*/

        function todos(){
            if($(".checkdata1:checked").length == 0){
                $(".checkdata1").prop("checked", true);
                sumCheck();

            }else if($(".checkdata1:checked").length < $(".checkdata1").length){
                $(".checkdata1").prop("checked", true);
                sumCheck();
            
            }else if($(".checkdata1:checked").length == $(".checkdata1").length){
                $(".checkdata1").prop("checked", false);
                sumCheck();
            }
        }

        $(document).on("click", ".subir_factura_multiple", function() {
            let actual=13;
            if(userSede == 8){
                actual=15;
            }
            var hoy = new Date();
            var dia = hoy.getDate();
            var mes = hoy.getMonth()+1;
            var anio = hoy.getFullYear();
            var hora = hoy.getHours();
            var minuto = hoy.getMinutes();
    
             if (((mes == 09 && dia == 30) || (mes == 10 && dia == 11 && hora <= 13)) ||
                ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)))
            {

                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .modal-header").html("");

                $("#modal_multiples .modal-header").append(`<div class="row">
                <div class="col-md-12 text-right">
                <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="font-size:40px;">&times;</span>
                </button>
                </div>
                <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);

                $.post('getDesarrolloSelect', function(data) {
                    if(data == 3){
                        $("#desarrolloSelect").append('<option selected="selected" disabled>YA NO ES POSIBLE ENVIAR FACTURAS, ESPERA AL SIGUIENTE CORTE</option>');
                    }
                    else{
                        if(!data){
                            $("#desarrolloSelect").append($('NO TIENES PAGOS.'));
                        }
                        else{
                            c = 0;
                            $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"));
                            var len = data.length;

                            for (var i = 0; i < len; i++) {
                                var id = data[i]['id_usuario'];
                                var name = data[i]['name_user'];
                                $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                            }

                            if (len <= 0) {
                                $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            }

                            $("#desarrolloSelect").val(0);
                            $("#desarrolloSelect").selectpicker('refresh');
                        }
                    }
                }, 'json');

                $('#desarrolloSelect').change(function() {
                    c=0;

                    var valorSeleccionado = $(this).val();
                    $("#modal_multiples .modal-body").html("");
                    $.getJSON(url + "Comisiones/getDatosProyecto/" + valorSeleccionado).done(function(data) {
                        let sumaComision = 0;
                        if (!data) {
                            $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');

                        }
                        else {
                            if(data.length > 0){
                                $("#modal_multiples .modal-body").append(`<div class="row">
                                <div class="col-md-1"><input type="checkbox" class="form-control" onclick="todos();" id="btn_all"></div><div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b></div>`);                    }
                                $.each(data, function(i, v) {
                                    c++;

                                    abono_asesor = (v.abono_neodata);
                                    $("#modal_multiples .modal-body").append('<div class="row">'+
                                    '<div class="col-md-1"><input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult' + i + '" name="comisiones_facura_mult"></div><div class="col-md-4"><input id="data1' + i + '" name="data1' + i + '" value="' + v.nombreLote + '" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%"></div><div class="col-md-4"><input type="hidden" id="idpago-' + i + '" name="idpago-' + i + '" value="' + v.id_pago_i + '"><input id="data2' + i + '" name="data2' + i + '" value="' + "" + parseFloat(abono_asesor).toFixed(2) + '" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%"></div></div>');
                                });

                            $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12 text-left"><b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b></div><div class="col-lg-5"><div class="fileinput fileinput-new text-center" data-provides="fileinput"><div><br><span class="fileinput-new">Selecciona archivo</span><input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml"></div></div></div><div class="col-lg-7"><center><button class="btn btn-warning" type="button" onclick="xml2()" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center></div></div>');

                            $("#modal_multiples .modal-body").append('<p id="cantidadSeleccionada"></p>');
                            $("#modal_multiples .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                            $("#modal_multiples .modal-body").append('<form id="frmnewsol2" method="post">' +
                            '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                            '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                            '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                            '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                            '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                            '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                            '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                            '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                            '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                            ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"><button type="button" id="btng" onclick="saveX();" disabled class="btn btn-primary btn-block">GUARDAR</button></div><div class="col-md-4"></div><div class="col-md-4"> <button type="button" data-dismiss="modal"  class="btn btn-danger btn-block close_modal_xml">CANCELAR</button></div></div></form>');
                        }
                    });
                });

                $("#modal_multiples").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
            else{
                alert("NO PUEDES SUBIR FACTURAS HASTA EL PRÓXIMO CORTE.");
            }
        });

        //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
        function resear_formulario() {
            $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
            $("#modal_formulario_solicitud textarea").html('');
            $("#modal_formulario_solicitud #obse").val('');

            var validator = $("#frmnewsol").validate();
            validator.resetForm();
            $("#frmnewsol div").removeClass("has-error");
        }

        $("#cargar_xml").click(function() {
            subir_xml($("#xmlfile"));
        });

        function xml2() {
            subir_xml2($("#xmlfile2"));
        }

        var justificacion_globla = "";

        function subir_xml(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    } 
                    else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }

        function subir_xml2(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml2",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;

                        cargar_info_xml2(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    } 
                    else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }

        $("#eliminar_factura").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                $.ajax({
                    url: url + "Comisiones/borrar_factura",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (true) {
                            $("#modalQuitarFactura").modal('toggle');
                            tabla_nuevas.ajax.reload();
                            alert("SE ELIMINÓ EL ARCHIVO");
                        } 
                        else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function closeModalEng(){
            document.getElementById("frmnewsol").reset();
            document.getElementById("xmlfile").value = "";
            document.getElementById("totalxml").innerHTML = '';

            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);
            $("#modal_formulario_solicitud").modal('toggle');
        }

        function cargar_info_xml(informacion_factura) {
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let pago_cliente = $('#pago_cliente').val();
            let pago1 = parseFloat(pago_cliente) + .05;
            let pago2 = parseFloat(pago_cliente ) - .05;
            
            if (parseFloat(pago1).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= parseFloat(pago2).toFixed(2)) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btnIndi').disabled = false;
                document.getElementById("totalxml").innerHTML = '';
                disabled();
            }
            else {
                document.getElementById("totalxml").innerHTML = 'Cantidad incorrecta:'+ cantidadXml;
                let elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btnIndi').disabled = true;
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
            }
            
            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }
        
        let pagos = [];

        function cargar_info_xml2(informacion_factura) {
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;
                }
            }

            var myCommentsList = document.getElementById('cantidadSeleccionada');
            myCommentsList.innerHTML = '';
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let cantidadXml2 = Number.parseFloat(informacion_factura.total[0]);
            var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
            myCommentsList.setAttribute('style', 'color:green;');
            myCommentsList.innerHTML = 'Cantidad correcta';

            console.log('suma:'+suma);
            console.log('xml:'+cantidadXml);
            if (((suma + .50).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .50).toFixed(2) ) ||  (cantidadXml.toFixed(2) == (suma).toFixed(2))) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btng').disabled = false;
                console.log("Cantidad correcta");
                disabled();
            } 
            else {
                var elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btng').disabled = true;
                var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
                myCommentsList.setAttribute('style', 'color:red;');
                myCommentsList.innerHTML = 'Cantidad incorrecta';
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
                console.log("cantidad incorrecta");
            }

            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }

        function sumCheck(){
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;

                }
            }
            var myCommentsList = document.getElementById('sumacheck');
            myCommentsList.innerHTML = 'Suma seleccionada: $ ' + formatMoney(suma.toFixed(3));
        } 

        function disabled(){
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
                    document.getElementById("comisiones_facura_mult" + index).disabled = true;
                    document.getElementById("btn_all").disabled = true;
                }
            }
        } 

        function save2() {
            let formData = new FormData(document.getElementById("frmnewsol2"));
            const labelSum = $('#sumacheck').text();
            const total = Number(labelSum.split('$')[1].trim().replace(',', ''));

            formData.append("dato", "valor");
            formData.append("xmlfile", documento_xml);
            formData.append("pagos",pagos);
            formData.append('total', total);

            $.ajax({
                url: url + 'Comisiones/guardar_solicitud2',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    document.getElementById('btng').disabled=false;
                    if (data.resultado) {
                        alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");
                    }else if(data == 3){
                        alert("ESTAS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES");
                        $('#loader').addClass('hidden');
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");

                    } else if (data == 4) {
                        alert("EL TOTAL DE LA FACTURA NO COINCIDE CON EL TOTAL DE COMISIONES SELECCIONADAS");
                        $('#loader').addClass('hidden');
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");
                    } else {
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");
                    }
                },
                error: function() {
                    document.getElementById('btng').disabled=false;
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }

        $("#frmnewsol").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        $("#frmnewsol2").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                alert(data);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } 
                        else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function calcularMontoParcialidad() {
            $precioFinal = parseFloat($('#value_pago_cliente').val());
            $precioNuevo = parseFloat($('#new_value_parcial').val());
            if ($precioNuevo >= $precioFinal) {
                $('#label_estado').append('<label>MONTO NO VALIDO</label>');
            } else if ($precioNuevo < $precioFinal) {
                $('#label_estado').append('<label>MONTO VALIDO</label>');
            }
        }

        function preview_info(archivo) {
            $("#documento_preview .modal-dialog").html("");
            $("#documento_preview").css('z-index', 9999);
            archivo = url + "dist/documentos/" + archivo + "";
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(archivo)[1];
            elemento = "";
            if (ext == 'pdf') {
                elemento += '<iframe src="' + archivo + '" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
                elemento += '</iframe>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'jpg' || ext == 'jpeg') {
                elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
                elemento += '<img src="' + archivo + '" style="overflow:hidden; width: 40%;">';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'xlsx') {
                elemento += '<div class="modal-content">';
                elemento += '<iframe src="' + archivo + '"></iframe>';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
            }
        }


        function cleanComments() {
            var myCommentsList = document.getElementById('comments-list-factura');
            myCommentsList.innerHTML = '';
            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }

    
        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }

        function close_modal_xml() {
            $("#modal_nuevas").modal('toggle');
        }

        function selectAll(e) {
            tota2 = 0;
            $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
                if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    tota2 += parseFloat(tabla_nuevas.row($(this).closest('tr')).data().pago_cliente);
                } else {
                    $(this).prop("checked", false);
                }
                $("#totpagarPen").html(formatMoney(tota2));
            });
        }