$(document).ready(function () {
    let titulos_intxt = [];
    let resto = 0;
    
    $.post('getDisponibleResguardo/' + id_usuario_general, function(data) {
        document.getElementById('totalDisponible').textContent = '';
        let disponible = formatMoney(data.toFixed(3));
        document.getElementById('totalDisponible').textContent = disponible;
        resto = 0;
        resto = data.toFixed(3);
    }, 'json');

    $.post('getDisponibleResguardoP/' + id_usuario_general, function(data) {
        document.getElementById('totalResguardo').textContent = '';
        let disponible = formatMoney(data);
        document.getElementById('totalResguardo').textContent = disponible;
        total67 = data;
    }, 'json');

    //TABLA FILTROS
    $('#tabla_retiros_resguardo').on('xhr.dt', function(e, settings, json, xhr) {
        document.getElementById('totalAplicados').textContent = '';
        var total = 0;
        let sumaExtras=0;

        $.each(json.data, function(i, v) {
            if (v.estatus != 3 && v.estatus != 67) {
                total += parseFloat(v.monto);
            }
            if(v.estatus == 67){
                sumaExtras=sumaExtras +parseFloat(v.monto);
            }
        });
        let to = 0;
        to = formatMoney(total);
        document.getElementById("totalAplicados").textContent = to;

        let extra = 0;
        extra = formatMoney(sumaExtras);
        document.getElementById("totalExtras").textContent = extra;
    });

    $('#tabla_retiros_resguardo thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_retiros_resguardo').DataTable().column(i).search() !== this.value ) {
                $('#tabla_retiros_resguardo').DataTable().column(i).search(this.value).draw();
            }
            var index = $('#tabla_retiros_resguardo').DataTable().rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = $('#tabla_retiros_resguardo').DataTable().rows(index).data();
        });
        
    });
    var id_user = id_usuario_general == 1875 ? 2 : id_usuario_general;

    retirosDataTable = $('#tabla_retiros_resguardo').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Reporte Retiros Resguardo',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                            }
                        }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [

            {data: 'id_rc'},
            {data: 'usuario'},
            { data: function (d) {
                return '<b>'+formatMoney(d.monto)+'</b>';
            }},
            {data: 'conceptos'},
            { data: function (d) {
                var labelEstatus;
                if(d.estatus == 1) {
                    labelEstatus ='<span class="label lbl-green">ACTIVO</span>';
                }else if(d.estatus == 3) {
                    labelEstatus ='<span class="label lbl-warning">CANCELADO</span>';
                }else if(d.estatus == 2) {
                    labelEstatus ='<span class="label lbl-violetDeep">APROBADO</span>';
                }else if(d.estatus == 4) {
                    labelEstatus ='<span class="label lbl-warning">RECHAZÓ DIRECTIVO</span>';
                }else if(d.estatus == 67) {
                    labelEstatus ='<span class="label lbl-yellow">INGRESO EXTRA</span>';
                }else {
                    labelEstatus ='<span class="label lbl-gray">Sin Definir</span>';
                }
                return labelEstatus;
            }}, 
            {data: 'creado_por'}, 
            { data: function (d) {
                var fecha = d.fecha_creacion.substring(0, d.fecha_creacion.length - 4);
                return fecha;
            }},
            { data: function (d) {
                var BtnStats = '';
                if(id_user == 1875 ){
                    if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                        BtnStats = `<button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" data-toggle="tooltip"  data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button>`;
                    } 
                } else{
                    if(d.estatus == 1){
                        BtnStats = `<button class="btn-data btn-warning btn-cancelar" value="'+d.id_rc+','+d.monto+','+d.usuario+'" data-toggle="tooltip"  data-placement="top" title="RECHAZAR RETIRO"><i class="fas fa-trash"></i></button><button class="btn-data btn-green btn-autorizar" value="${d.id_rc},${d.monto},${d.usuario}" data-toggle="tooltip"  data-placement="top" title="APROBAR RETIRO"><i class="fas fa-check"></i></button>`;
                    } else if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                        BtnStats = `<button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" data-toggle="tooltip" data-placement="left" title="HISTORIAL RETIRO"><i class="fas fa-info"></i></button>`;
                    } 
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }}   
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getRetiros/'+id_user+'/'+1,   
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    });

    $('#tabla_retiros_resguardo').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_retiros_resguardo').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_retiros_resguardo tbody").on("click", ".btn-log", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_rc = $(this).val();
        $("#seeInformationModalRetiros").modal();
        $.getJSON(general_base_url+"Resguardos/getListaRetiros/"+id_rc, function (data) {
            $.each( data, function(i, v){
                $("#comments-list-retiros").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+v.usuario+' </b></a><br></div><div class="float-end text-right"><a> '+v.fecha_creacion+' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIOS: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
        });
    });

    $("#tabla_retiros_resguardo tbody").on("click", ".btn-autorizar", function(){
        var tr = $(this).closest('tr');
        var row =  $('#tabla_retiros_resguardo').DataTable().row(tr);
        id_pago_i = $(this).val();
        $("#autorizar-modal .modal-body").html("");
        $("#autorizar-modal .modal-header").html("");
        $("#autorizar-modal .modal-header").append('<h4 class="modal-title">Autorizar a <b>'+row.data().usuario+'</b> la cantidad de <b style="color:blue;">'+formatMoney(row.data().monto)+'</b></h4>');
        $("#autorizar-modal .modal-body").append('<input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_rc+'"><input type="hidden" name="opcion" id="opcion" value="Autorizar">');
        $("#autorizar-modal").modal();
    });

    $("#tabla_retiros_resguardo tbody").on("click", ".btn-cancelar", function(){
        var tr = $(this).closest('tr');
        var row =  $('#tabla_retiros_resguardo').DataTable().row(tr);
        id_pago_i = $(this).val();
        $("#autorizar-modal .modal-body").html("");
        $("#autorizar-modal .modal-header").html("");
        $("#autorizar-modal .modal-header").append('<h4 class="modal-title">Rechazar retiro a <b>'+row.data().usuario+'</b> por la cantidad de <b style="color:blue;">'+formatMoney(row.data().monto)+'</b></h4>');
        $("#autorizar-modal .modal-body").append('<input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_rc+'"><input type="hidden" name="opcion" id="opcion" value="Rechazar">');
        $("#autorizar-modal").modal();
    });


    $("#autorizar_form").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );        
            $.ajax({
                url: general_base_url+'Resguardos/actualizarRetiro',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data = 1 ){
                        $("#autorizar-modal").modal('toggle');
                        alerts.showNotification("top", "right", "Ajuste exitoso", "success");
                        setTimeout(function() {
                            $('#tabla_retiros_resguardo').DataTable().ajax.reload(null,false);
                        }, 100);
                    }
                    else{
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });

});

function cleanCommentsRetiros() {
    var myCommentsList = document.getElementById('comments-list-retiros');
    myCommentsList.innerHTML = '';
}