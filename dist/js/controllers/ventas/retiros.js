
var totaPen = 0;
var tr;

$(document).ready(function() {
    $("#tabla_descuentos").prop("hidden", true);
    $.post(general_base_url + "Comisiones/getDirectivos", function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');
});

$('#filtro33').change(function(ruta) {
    directivo = $('#filtro33').val();
    DescuentosxDirectivos(directivo);
    $("#spiner-loader").removeClass('hide');
    $("#tabla_descuentos").prop("hidden", false);
});

$("#form_descuentos").on('submit', function(e) {
    e.preventDefault();
    document.getElementById('btn_abonar').disabled = true;
    $("#tabla_descuentos").prop("hidden", false);
    let userid = $('#usuarioid').val();

    let formData = new FormData(document.getElementById("form_descuentos"));
    formData.append("dato", "valor");
    $.ajax({
        url: 'saveRetiro',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            if (data == 1) {
                document.getElementById("form_descuentos").reset();
                $('#miModal').modal('hide');
                document.getElementById('btn_abonar').disabled = false;
                DescuentosxDirectivos(userid);
                $("#roles").val('');
                $("#roles").selectpicker("refresh");
                $('#usuarioid').val('default');
                $("#usuarioid").selectpicker("refresh");
                $('#filtro33').val('default');
                $("#filtro33").selectpicker("refresh");
                alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
            } else if (data == 2) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                document.getElementById('btn_abonar').disabled = false;
            } else if (data == 3) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");document.getElementById('btn_abonar').disabled = false;
            }
        },
        error: function() {
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

let titulos = [];
$('#tabla_descuentos thead tr:eq(0) th').each(function(i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {

        if (tabla_nuevas.column(i).search() !== this.value) {
            tabla_nuevas.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_nuevas.rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = tabla_nuevas.rows(index).data();
            $.each(data, function(i, v) {
            });
            let to1 = 0;
        }
    });
});


function DescuentosxDirectivos(user) {
    let resto = 0;
    let total67 = 0;
    $.post('getDisponbleResguardo/' + user, function(data) {

        document.getElementById('totalp3').textContent = '';
        let disponible = formatMoney(data.toFixed(3));
        document.getElementById('totalp3').textContent = disponible;
        resto = 0;
        resto = data.toFixed(3);
    }, 'json');

    $.post('getDisponbleResguardoP/' + user, function(data) {
        document.getElementById('totalp').textContent = '';
        let disponible = formatMoney(data);
        document.getElementById('totalp').textContent = disponible;
        total67 = data;
    }, 'json');

    $('#tabla_descuentos').on('xhr.dt', function(e, settings, json, xhr) {
        document.getElementById('totalp2').textContent = '';
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
        document.getElementById("totalp2").textContent = to;
        let extra = 0;
        extra = formatMoney(sumaExtras);
        document.getElementById("totalx").textContent = extra;
        let to2 = 0;
        to2 = parseFloat(resto) + parseFloat(total);
    });

    tabla_nuevas = $("#tabla_descuentos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollx: true,
        bAutoWidth: true,
        "buttons": [{
            extend: 'excelHtml5',
            className: 'btn btn-success',
            text: '<i class="fa fa-file-excel-o"></i>',
            titleAttr: 'Retiros',
            title:'Retiros',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        "ordering": false,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "pageLength": 10,
        "bAutoWidth": false,
        "fixedColumns": true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "columns": [{
            "data": function(d) {
                return '<p style="font-size: .8em"><center>' + d.id_rc + '</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p style="font-size: .8em"><center><b>' + d.usuario + '</b></center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p style="font-size: .8em"><center>' + formatMoney(d.monto) + '</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p style="font-size: .8em"><center>' + d.conceptos + '</center></p>';
            }
        },
        {
            "data": function(d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-orange">ACTIVO</span><center>';
                } else if (d.estatus == 3) {
                    return '<center><span class="label lbl-warning">CANCELADO</span><center>';
                } else if (d.estatus == 2) {
                    return '<center><span class="label lbl-green">APROBADO</span><center>';
                } else if (d.estatus == 4) {
                    return '<center><span class="label lbl-warning">RECHAZADO DIRECTIVO</span><center>';
                }else if (d.estatus == 67) {
                    return '<center><span class="label lbl-azure">INGRESO EXTRA</span><center>';
                }
            }
        },
        {
            "data": function(d) {
                return '<p style="font-size: .7em"><center>' + d.creado_por + '</center></p>';
            }
        },
        {
            "data": function(d) {
                let fecha = d.fecha_creacion.substring(0, d.fecha_creacion.length - 4);
                return '<p style="font-size: .8em"><center>' + fecha + '</center></p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                if(id_rol_general != 17 ){
                    return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" data-toggle="tooltip" data-placement="top" title="HISTORIAL" value="${d.id_rc}"><i class="fas fa-info"></i></button></div>`;
                }else{
                    if (d.estatus == 1 || d.estatus == 67) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-warning btn-delete" data-toggle="tooltip" data-placement="top" title="ELIMINAR" value="${d.id_rc},${d.monto},${d.usuario}" ><i class="fas fa-trash" ></i></button>
                        <button class="btn-data btn-sky btn-update" data-toggle="tooltip" data-placement="top" title="ACTUALIZAR INFORMACIÓN" value="${d.id_rc},${d.monto},${d.usuario}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn-data btn-details-grey btn-log" data-toggle="tooltip" data-placement="top" title="HISTORIAL" value="${d.id_rc}"><i class="fas fa-info"></i></button></div>`;
                    } else if (d.estatus == 3 || d.estatus == 4) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" data-toggle="tooltip" data-placement="top" title="HISTORIAL" value="${d.id_rc}" ><i class="fas fa-info"></i></button></div>`;
                    } else if (d.estatus == 2) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" data-toggle="tooltip" data-placement="top" title="HISTORIAL" value="${d.id_rc}" ><i class="fas fa-info"></i></button></div>`;
                    }
                }
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center'
        }],
        "ajax": {
            "url": general_base_url + "Comisiones/getRetiros/" + user + '/' + 1,
            "type": "POST",
            cache: false,
            "data": function(d) {
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });

    $('#tabla_descuentos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_descuentos tbody").on("click", ".btn-delete", function() {
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Está seguro que desea borrar el pago de <b>' + row.data().usuario + '</b> por la cantidad de <b style="color:red;">' + formatMoney(row.data().monto) + '</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="' + row.data().id_rc + '"> <input type="hidden" id="userid" name="userid" value="' + user + '"><input type="hidden" name="opcion" id="opcion" value="Borrar"><br><div class="form-group m-0"><label class="control-label">Motivo de eliminación</label><textarea class="text-modal" id="motivodelete" name="motivodelete"></textarea></div><br><div class="text-right"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button><input type="submit"  class="btn btn-primary" value="Aceptar"></div></p></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_descuentos tbody").on("click", ".btn-log", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_rc = $(this).val();
        document.getElementsByClassName('modal_body').innerHTML = '';
        $("#modal_log .modal-body").append("");
        $("#modal_log .modal-body").html("");
        $("#modal_log .modal-body").html("");
        $("#modal_log .modal-body").append(`<h3><b>Historial</b></h3><br>`);
        $("#modal_log .modal-body .timeline").html("");
        $.post(general_base_url + "Comisiones/getHistoriRetiros/" + id_rc, function(data) {
            var len = data.length;
            let c = 0;
            $("#modal_log .modal-body").append(`
                <div class="row mt-5 mb-5">
                <div class="col-md-12 offset-md-3 card-content scroll-styles" style="height: 350px; overflow: auto">
                <ul class="timeline-3">`);
            for (var i = 0; i < len; i++) {
                if (c > 1) {
                    break;
                }
                let fecha = data[i].fecha_creacion.substring(0, data[i].fecha_creacion.length - 4);
                $("#modal_log .modal-body .timeline-3").append(`
            <li>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <a><b>${data[i].usuario}</b></a><br>
                        </div>
                        <div class="float-end text-right">
                            <a>${fecha}</a>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <p class="m-0"><b>  ${data[i].comentario} </b></p>
                        </div>
                        <h6>
                        </h6>
                    </div>
                </div>
            </li>`);
                if (i == len) {
                    c = c + 1;
                }
            }
            $("#modal_log .modal-body").append(`</ul>
                </div>
            </div><div class="text-right">
            <button type="button" class="btn btn-danger btn-simple" onclick="cerrar();" data-dismiss="modal">Cerrar</button></div></p></div></div>
            `);
        }, 'json');
        $("#modal_log").modal();
    });


    $("#tabla_descuentos tbody").on("click", ".btn-update", function() {
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);
        id_pago_i = $(this).val();
        let funcion = '';
        if(row.data().estatus == 1){
            funcion = `verificar2(${resto},${row.data().monto})`;
        }else if(row.data().estatus == 67){
            funcion = `verificar67(${total67},${resto},${row.data().monto})`;
        }

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        $("#modal_nuevas .modal-header").append(`<h3><b>Actualizar Información</b></h3>`);
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12">
        <div class="form-group">
        <label>Monto</label>
        <input type="number" class="form-control input-gral" onblur="${funcion}" name="monto" id="monto" value="${row.data().monto}">
        <input type="hidden" id="userid" name="userid" value="${user}">
        </div>
        <div class="form-group">
        <input type="hidden" name='estatus' id="estatus" value='${row.data().estatus}'>
        <label>Motivo</label>
        <textarea class="text-modal" id="conceptos" name="conceptos">${row.data().conceptos}</textarea>
        </div>
            <input type="hidden" name="id_descuento" id="id_descuento" value="${row.data().id_rc}"><input type="hidden" name="opcion" id="opcion" value="Actualizar"><br><div class="text-right"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button><input type="submit"  class="btn btn-primary" id="btnsub" value="Aceptar"></div></p></div></div>`);
        $("#modal_nuevas").modal();
    });
}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

function verificar2(resto, monto) {
    let montoingresado = $('#monto').val();
    let resta = parseFloat(montoingresado) - parseFloat(monto);
    if (parseFloat(resto) > resta) {
        document.getElementById('btnsub').disabled = false;
    } else {
        alerts.showNotification("top", "right", "Monto excedido.", "warning");
        document.getElementById('btnsub').disabled = true;
    }
}

function verificar67(total76,disponible, montoselect) {
let  total67 =  replaceAll(total76, ',','');
let  dato =  replaceAll(montoselect, ',','');
let montoseleccionado = replaceAll(dato, '$','');
let montoingresado = $('#monto').val();
let retiros = parseFloat(total67) - parseFloat(disponible);
let restaactual = parseFloat(montoseleccionado) - parseFloat(montoingresado);
let nuevoTotal = parseFloat(total67) - parseFloat(restaactual);

    if(retiros > nuevoTotal){
        alerts.showNotification("top", "right", "Monto excedido.", "warning");
        document.getElementById('btnsub').disabled = true;
    }else{
        document.getElementById('btnsub').disabled = false;
    }
}

$("#form_aplicar").submit(function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        let iduser = $('#userid').val();
        var data = new FormData($(form)[0]);

        $.ajax({
            url: general_base_url + 'Comisiones/UpdateRetiro',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data) {
                if (data = 1) {
                    $("#modal_nuevas").modal('toggle');
                    alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                    setTimeout(function() {
                        tabla_nuevas.ajax.reload();
                        DescuentosxDirectivos(iduser);
                        $('#filtro33').val('default');
                        $("#filtro33").selectpicker("refresh");
                    }, 100);
                } else {
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },
            error: function() {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#roles").change(function() {
    var parent = $(this).val();
    document.getElementById('monto1').value = '';
    document.getElementById('idmontodisponible').value = '';

    $('#usuarioid option').remove();
    $.post('getUsuariosRol/' + parent, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#usuarioid").selectpicker('refresh');
    }, 'json');
});



$("#usuarioid").change(function() {
    document.getElementById('monto1').value = '';
    document.getElementById('idmontodisponible').value = 'Cargando....';
    var user = $(this).val();
    let montoActual = 0;
    $.post('getDisponbleResguardo/' + user, function(data) {
        let disponible = formatMoney(data.toFixed(3));
        $('#idmontodisponible').val(disponible);
    }, 'json');
});

$("#opc").change(function() {
    var opc = $(this).val();
    let id_user = $('#usuarioid').val();
    if (opc == 1) {
        document.getElementById('labelmonto1').innerHTML = 'MONTO DISPONIBLE';
        document.getElementById('labelmonto2').innerHTML = '';
        document.getElementById('labelmonto2').innerHTML = 'MONTO A DESCONTAR';
        $("#monto1").attr("onblur", "verificar();");
            document.getElementById('idmontodisponible').value = 'Cargando....';
            $.post('getDisponbleResguardo/' + id_user, function(data) {
                let disponible = formatMoney(data.toFixed(3));
                $('#idmontodisponible').val(disponible);
            }, 'json');
        
    } else {
        document.getElementById('labelmonto1').innerHTML = '';
        document.getElementById('labelmonto1').innerHTML = '<br>';
        document.getElementById('labelmonto2').innerHTML = 'MONTO A INGRESAR';
        document.getElementById('idmontodisponible').value = '....';
        $("#monto1").attr("onblur", "verificar3();");
    }
});

function verificar() {
    let valorDispo = $('#idmontodisponible').val();
    let disponible = replaceAll(valorDispo, ',', '');
    let monto_ingresado = replaceAll($('#monto1').val(), ',', '');
    let monto = parseFloat(monto_ingresado).toFixed(2);

    if (monto < 1 || isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled = true;
    } else {
        if (parseFloat(disponible) < parseFloat(monto)) {
            alerts.showNotification("top", "right", "El monto ingresado es mayor a lo disponible.", "warning");
            document.getElementById('btn_abonar').disabled = true;
        } else {
            document.getElementById('btn_abonar').disabled = false;
        }
    }

}

function verificar3() {
    let monto_ingresado = replaceAll($('#monto1').val(), ',', '');
    let monto = parseFloat(monto_ingresado).toFixed(2)
    if (monto < 1 || isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled = true;
    } else {
        document.getElementById('btn_abonar').disabled = false;
    }
}
