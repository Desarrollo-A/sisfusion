var url = "<?= base_url() ?>";
var url2 = "<?= base_url() ?>index.php/";
var totaPen = 0;
var tr;
var id_rol = "<?=$this->session->userdata('id_rol')?>";



function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


$('#filtro33').change(function(ruta) {
    directivo = $('#filtro33').val();
    DescuentosxDirectivos(directivo);
});

function opcionSelect(){
    
    $.getJSON( general_base_url + "Comisiones/getDirectivos").done( function( data ){
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');

}

$(document).ready(function () {
    opcionSelect();
   
});

function validarEspacios(e){
    if (e.target.value.trim() == ""){
        alerts.showNotification("top", "right", "Debes ingresar un motivo valido.", "warning");
    }else{
        
    }
}

$("#form_descuentos").on('submit', function(e) {
    e.preventDefault();
    validarEspacios();

    document.getElementById('btn_abonar').disabled = true;
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
    if (i != 7) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
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
                });
                let to1 = 0;
            }
        });
    }
});

$('#aplicar_retiro').on('click', function(){

    $('#miModal').modal('show');
    $('#div_montos, #div_motivo, #div_opcion').addClass('hide');
    $('#opc, #comentario, #monto1').removeAttr('required');


    $('#roles, #usuarioid, #opc,#idmontodisponible, #monto1, #comentario ').val('');
    $('#usuarioid option').remove();

    $('#roles, #usuarioid, #opc').selectpicker("refresh");

    document.getElementById('texto_motivo').innerHTML = 'MÓTIVO DE DESCUENTO';
    document.getElementById('labelmonto1').innerHTML = 'MONTO DISPONIBLE';
    document.getElementById('labelmonto2').innerHTML = 'MONTO A DESCONTAR';
    // $("#users").trigger('change');


});

function DescuentosxDirectivos(user) {
    let resto = 0;
    let total67 = 0;
    $.post('getDisponbleResguardo/' + user, function(data) {

        document.getElementById('totalp3').textContent = '';
        let disponible = formatMoney(data.toFixed(3));
        document.getElementById('totalp3').textContent = "$ " + disponible;
        resto = 0;
        resto = data.toFixed(3);
    }, 'json');

    $.post('getDisponbleResguardoP/' + user, function(data) {

        document.getElementById('totalp').textContent = '';
        console.log('data' + data);
        let disponible = formatMoney(data);
        console.log('disponible' + disponible);
        document.getElementById('totalp').textContent = '$ ' + disponible;
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
        document.getElementById("totalp2").textContent = "$ " + to;

        let extra = 0;
        extra = formatMoney(sumaExtras);
        document.getElementById("totalx").textContent = "$ " + extra;
        
        let to2 = 0;
        to2 = parseFloat(resto) + parseFloat(total);
    });

    tabla_nuevas = $("#tabla_descuentos").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        "buttons": [

            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Retiros',
                title:'Retiros',
                exportOptions: {

                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header: function(d, columnIdx) {
                            if (columnIdx == 0) {
                                return ' ID ';

                            } else if (columnIdx == 1) {
                                return 'USUARIO';
                            } else if (columnIdx == 2) {
                                return 'DESCUENTO';
                            } else if (columnIdx == 3) {
                                return 'MOTIVO';
                            } else if (columnIdx == 4) {
                                return 'ESTATUS';
                            } else if (columnIdx == 5) {
                                return 'CREADO POR';
                            } else if (columnIdx == 6) {
                                return 'FECHA CAPTURA';
                            }
                        }
                    }
                },
            },


        ],
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
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "columns": [
            {
                "width": "5%",
                "data": function(d) {
                    return '<p style="font-size: .8em"><center>' + d.id_rc + '</center></p>';
                }
            },
            {
                "width": "13%",
                "data": function(d) {
                    return '<p style="font-size: .8em"><center><b>' + d.usuario + '</b></center></p>';
                }
            },

            {
                "width": "10%",
                "data": function(d) {
                    return '<p style="font-size: .8em"><center>$' + formatMoney(d.monto) + '</center></p>';
                }
            },

            {
                "width": "13%",
                "data": function(d) {
                    return '<p style="font-size: .8em"><center>' + d.conceptos + '</center></p>';
                }
            },
            {
                "width": "10%",
                "data": function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-warning">ACTIVO</span><center>';
                    } else if (d.estatus == 3) {
                        return '<center><span class="label label-danger">CANCELADO</span><center>';
                    } else if (d.estatus == 2) {
                        return '<center><span class="label label-success">APROBADO</span><center>';
                    } else if (d.estatus == 4) {
                        return '<center><span class="label label-danger">RECHAZADO DIRECTIVO</span><center>';
                    }else if (d.estatus == 67) {
                        return '<center><span class="label label-info">INGRESO EXTRA</span><center>';
                    }

                }
            },
            {
                "width": "10%",
                "data": function(d) {
                    return '<p style="font-size: .7em"><center>' + d.creado_por + '</center></p>';
                }
            },
            {
                "width": "10%",
                "data": function(d) {
                    let fecha = d.fecha_creacion.substring(0, d.fecha_creacion.length - 4);
                    return '<p style="font-size: .8em"><center>' + fecha + '</center></p>';
                }
            },
            {
                "width": "8%",
                "orderable": false,
                "data": function(d) {

                    if(id_rol != 17 ){
                        return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" value="${d.id_rc}" ><i class="fas fa-info"></i></button></div>`;

                    }else{

                    if (d.estatus == 1 || d.estatus == 67) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-warning btn-delete" value="${d.id_rc},${d.monto},${d.usuario}" ><i class="fas fa-trash" ></i></button>
                        <button class="btn-data btn-sky btn-update" value="${d.id_rc},${d.monto},${d.usuario}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn-data btn-details-grey btn-log" value="${d.id_rc}"><i class="fas fa-info"></i></button></div>`;

                        // <button class="btn btn-success btn-round btn-fab btn-fab-mini btn-aut" value="${d.id_rc},${d.monto},${d.usuario}"  style="margin-right: 3px;background-color:#20A117;border-color:#20A117"><i class="material-icons" data-toggle="tooltip" data-placement="right" title="APROBAR RETIRO">check</i></button>

                    } else if (d.estatus == 3 || d.estatus == 4) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" value="${d.id_rc}" ><i class="fas fa-info"></i></button></div>`;
                    } else if (d.estatus == 2) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-details-grey btn-log" value="${d.id_rc}" ><i class="fas fa-info"></i></button></div>`;

                    }
                }

                    // if(d.estatus==0){

                }
            }
        ],
        columnDefs: [{

            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center'
        }],

        "ajax": {
            "url": general_base_url + "Comisiones/getRetiros/" + user + '/' + 1,
            /*registroCliente/getregistrosClientes*/
            "type": "POST",
            cache: false,
            "data": function(d) {

            }
        },
    });


    /**------------------------------------------- */
    $("#tabla_descuentos tbody").on("click", ".abonar", function() {
        bono = $(this).val();
        var dat = bono.split(",");
        //$("#modal_abono").html("");
        $("#modal_abono .modal-body").append(`<div id="inputhidden">
        <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6>
        <input type='hidden' name="id_bono" id="id_bono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}"><input type='hidden' name="id_usuario" id="id_usuario" value="${dat[2]}">
       
       <div class="col-md-3"></div>
       <div class="col-md-3">
        <button type="submit" id="" class="btn btn-primary ">GUARDAR</button>
        </div>
        <div class="col-md-3">
        <button type="button" onclick="closeModalEng()" class=" btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
        <div class="col-md-3"></div>

        </div>`);
        $("#modal_abono .modal-body").append(``);
        $('#modal_abono').modal('show');
        //save(bono);
    });



    // $("#tabla_descuentos tbody").on("click", ".btn-delete", function(){    
    //     id = $(this).val();
    //     $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete">
    //     <h5>¿Estas seguro que deseas eliminar este bono?</h5>
    //     <br>
    //     <input type="hidden" id="id_descuento" name="id_descuento" value="${id}">
    //     <input type="submit" class="btn btn-success" value="Aceptar">
    //     <button class="btn btn-danger" onclick="CloseModalDelete2();">Cerrar</button>
    //     </form></div>`);

    //     $('#modal-delete').modal('show');
    // });


    $("#tabla_descuentos tbody").on("click", ".btn-aut", function() {
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        $("#modal_nuevas .modal-header").append(`<h3>Autorizar</h3>`);
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea autorizar a <b>' + row.data().usuario + '</b> la cantidad de <b style="color:red;">$' + formatMoney(row.data().monto) + '</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="' + row.data().id_rc + '"><input type="hidden" name="opcion" id="opcion" value="Autorizar"><br><div><input type="submit"  class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></p></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_descuentos tbody").on("click", ".btn-delete", function() {
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        // $("#modal_nuevas .modal-header").append(`<h3>Eliminar</h3>`);
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Está seguro que desea borrar el pago de <b>' + row.data().usuario + '</b> por la cantidad de <b style="color:red;">$' + formatMoney(row.data().monto) + '</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="' + row.data().id_rc + '"> <input type="hidden" id="userid" name="userid" value="' + user + '"><input type="hidden" name="opcion" id="opcion" value="Borrar"><br><div class="form-group"><label>Motivo de eliminación</label><textarea class="form-control" id="motivodelete" name="motivodelete"></textarea></div><br><div class="text-right"><input type="submit"  class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></p></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_descuentos tbody").on("click", ".btn-log", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        // var tr = $(this).closest('tr');
        // var row = tabla_nuevas.row( tr );

        id_rc = $(this).val();
        document.getElementsByClassName('modal_body').innerHTML = '';
        $("#modal_log .modal-body").append("");
        $("#modal_log .modal-body").html("");
        $("#modal_log .modal-body").html("");
        $("#modal_log .modal-body").append(`<h3><b>Historial</b></h3><br>`);
        $("#modal_log .modal-body .timeline").html("");
        $.post(general_base_url +"Comisiones/getHistoriRetiros/" + id_rc, function(data) {
            var len = data.length;
            console.log(data);
            let c = 0;
            $("#modal_log .modal-body").append(`
            <div class="row mt-5 mb-5">
            <div class="col-md-12 offset-md-3">
            <ul class="timeline">`);
            for (var i = 0; i < len; i++) {
                if (c > 1) {
                    break;
                }
                let fecha = data[i].fecha_creacion.substring(0, data[i].fecha_creacion.length - 4);
                $("#modal_log .modal-body .timeline").append(`
            <li>
                <em><b>Fecha creación: </b>${fecha}</em><br>
                <em><b>Autor:</b> ${data[i].usuario} </em>
                <p><b>Movimiento: </b>${data[i].comentario}</p>
            </li>`);
                if (i == len) {
                    c = c + 1;
                }

            }
            $("#modal_log .modal-body").append(`</ul>
                </div>
                </div><div class="text-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></p></div></div>
                `);

        }, 'json');


        $("#modal_log").modal();
    });


    $("#tabla_descuentos tbody").on("click", ".btn-update", function() {
        //alert (resto);
        //alert (total);



        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);

        id_pago_i = $(this).val();
        let funcion = '';
        if(row.data().estatus == 1){
            funcion = `verificar2(${resto},${row.data().monto})`;
        }else if(row.data().estatus == 67){
            funcion = `verificar67(${total67},${resto},${row.data().monto})`;
            //funcion = `verificar4()`;
        }

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        $("#modal_nuevas .modal-header").append(`<h3><b>Actualizar Información</b></h3>`);
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12">
<div class="form-group">
<label>Monto</label>
<input type="number" class="form-control" onblur="${funcion}" name="monto" id="monto" value="${row.data().monto}">
<input type="hidden" id="userid" name="userid" value="${user}">
</div>
<div class="form-group">
<input type="hidden" name='estatus' id="estatus" value='${row.data().estatus}'>
<label>Motivo</label>
<textarea class="form-control" id="conceptos" name="conceptos">${row.data().conceptos}</textarea>
</div>
 <input type="hidden" name="id_descuento" id="id_descuento" value="${row.data().id_rc}"><input type="hidden" name="opcion" id="opcion" value="Actualizar"><br><div class="text-right"><input type="submit"  class="btn btn-success" id="btnsub" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></p></div></div>`);
        $("#modal_nuevas").modal();
    });





    //  $("#tabla_descuentos tbody").on("click", ".btn-update", function(){    
    //     id = $(this).val();

    //      bono = $(this).val();
    //     var dat = bono.split(",");

    //      $("#modal_abono .modal-body").append(`<div id="borrarUpdare"><form id="form-update">
    //     <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6><input type='hidden' name="id_descuento" id="id_descuento" value="${dat[0]}">
    //     <br>
    //      <input type="submit" class="btn btn-success" value="Aceptar">
    //     <button class="btn btn-danger" onclick="CloseModalUpdate2();">Cerrar</button>
    //     </form></div>`);

    //     $('#modal_abono').modal('show');
    // });







}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}
function verificar2(resto, monto) {
    let montoingresado = $('#monto').val();
    console.log(montoingresado);
    let resta = parseFloat(montoingresado) - parseFloat(monto);
    console.log('RESTO: '+resto);
    console.log('RESTA: '+ Math.abs(resta));
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

    //let nuevototal = parseFloat(total67)  - parseFloat(montoingresado);

    console.log('Retiros: '+retiros);
    console.log('Monto ingresado: '+montoingresado);

    console.log('Nuevo Total: '+nuevoTotal);

    if(retiros > nuevoTotal){
        alerts.showNotification("top", "right", "Monto excedido.", "warning");
        document.getElementById('btnsub').disabled = true;
    }else{
        document.getElementById('btnsub').disabled = false;

    }

    // console.log(montoingresado);
    // let resta = parseFloat(montoingresado) - parseFloat(monto);
    // console.log('RESTO: '+resto);
    // console.log('RESTA: '+ Math.abs(resta));
    // if (parseFloat(resto) > resta) {
    //     document.getElementById('btnsub').disabled = false;
    // } else {
    //     alerts.showNotification("top", "right", "Monto excedido.", "warning");
    //     document.getElementById('btnsub').disabled = true;
    // }
}



/**-------------------------------------------------------------------------------------------------------------------------------------------------------- */



function closeModalEng() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal_abono").modal('toggle');

}

function CloseModalDelete() {
    // document.getElementById("inputhidden").innerHTML = "";
    a = document.getElementById('borrarBono');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal-delete").modal('toggle');

}

function CloseModalDelete2() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form-delete").reset();
    a = document.getElementById('borrarBono');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal-delete").modal('toggle');

}

function CloseModalUpdate2() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form-update").reset();
    a = document.getElementById('borrarUpdare');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal-abono").modal('toggle');

}
$(document).on('submit', '#form-delete', function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("form-delete"));
    formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Comisiones/BorrarDescuento',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                CloseModalDelete2();
                // $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
                document.getElementById("form_abono").reset();
                $('#filtro33').val('default');
                $("#filtro33").selectpicker("refresh");

            } else if (data == 0) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                CloseModalDelete2();
                //$('#modal-delete').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }
        },
        error: function() {
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});





$("#form_aplicar").submit(function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        let iduser = $('#userid').val();


        var data = new FormData($(form)[0]);
        console.log('idUser:  ' + iduser);
        $.ajax({
            url: general_base_url + 'Comisiones/UpdateRetiro',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
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




// $(document).on('submit','#form-update', function(e){ 
//   e.preventDefault();
// var formData = new FormData(document.getElementById("form-update"));
// formData.append("dato", "valor");
//     $.ajax({
//         method: 'POST',
//         url: url+'Comisiones/UpdateDescuento',
//         data: formData,
//         processData: false,
// contentType: false,
//         success: function(data) {
//             console.log(data);
//             if (data == 1) {
//                 $('#tabla_descuentos').DataTable().ajax.reload(null, false);
//                 CloseModalDelete2();
//                // $('#modal_abono').modal('hide');
//                 alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
//              document.getElementById("form_abono").reset();

//             } else if(data == 0) {
//                 $('#tabla_descuentos').DataTable().ajax.reload(null, false);
//                 CloseModalDelete2();
//                 //$('#modal-delete').modal('hide');
//                 alerts.showNotification("top", "right", "Pago liquidado.", "warning");
//             }
//         },
//         error: function(){
//             closeModalEng();
//             $('#modal_abono').modal('hide');
//             alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//         }
//     });
// });



// FIN TABLA PAGADAS



function mandar_espera(idLote, nombre) {
    idLoteespera = idLote;
    // link_post2 = "Cuentasxp/datos_para_rechazo1/";
    link_espera1 = "Comisiones/generar comisiones/";
    $("#myModalEspera .modal-footer").html("");
    $("#myModalEspera .modal-body").html("");
    $("#myModalEspera ").modal();
    // $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
    $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
}






// FUNCTION MORE

// $(window).resize(function(){
//  tabla_nuevas.columns.adjust();
//  tabla_proceso.columns.adjust();
//  tabla_pagadas.columns.adjust();
//  tabla_otras.columns.adjust();
// });




$("#roles").change(function() {
    var parent = $(this).val();
    $('#monto1, #comentario, #opc ').val('');
    $('#opc').selectpicker('refresh');
    $('#div_montos, #div_motivo, #div_opcion').addClass('hide');
    $('#opc, #comentario, #monto1').removeAttr('required', false);


    document.getElementById('texto_motivo').innerHTML = 'MÓTIVO DE DESCUENTO';
    document.getElementById('labelmonto1').innerHTML = 'MONTO DISPONIBLE';
    document.getElementById('labelmonto2').innerHTML = 'MONTO A DESCONTAR';

    $('#usuarioid, #opc,#idmontodisponible, #monto1, #comentario ').val('');
    $('#usuarioid option').remove();
    $('#usuarioid, #opc').selectpicker("refresh");

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
        // $("#usuariosrol").val(v.id_director);
        $("#usuarioid").selectpicker('refresh');
    }, 'json');
});



$("#usuarioid").change(function() {

    $('#monto1, #comentario, #opc ').val('');
    $('#div_opcion').removeClass('hide');
    $('#div_montos, #div_motivo').addClass('hide');
    $('#opc').attr('required', true);
    $('#comentario, #monto1').removeAttr('required', false);


    $('#opc').selectpicker('refresh');
    document.getElementById('texto_motivo').innerHTML = 'MÓTIVO DE DESCUENTO';
    document.getElementById('labelmonto1').innerHTML = 'MONTO DISPONIBLE';
    document.getElementById('labelmonto2').innerHTML = 'MONTO A DESCONTAR';



    document.getElementById('monto1').value = '';
    document.getElementById('idmontodisponible').value = 'Cargando....';

    var user = $(this).val();
    let montoActual = 0;

    $.post('getDisponbleResguardo/' + user, function(data) {
        // console.log(data);
        let disponible = formatMoney(data.toFixed(3));
        // $('#idmontodisponible').val(disponible);
    }, 'json');
});

$("#opc").change(function() {
    var opc = $(this).val();
    let id_user = $('#usuarioid').val();
    $('#monto1, #comentario ').val('');
    $('#comentario, #monto1').attr('required', true);

    console.log(id_user);

    $('#div_montos, #div_motivo').removeClass('hide');


    if (opc == 1) {
        document.getElementById('labelmonto1').innerHTML = 'MONTO DISPONIBLE';
        document.getElementById('labelmonto2').innerHTML = '';
        document.getElementById('labelmonto2').innerHTML = 'MONTO A DESCONTAR';
        document.getElementById('texto_motivo').innerHTML = 'MÓTIVO DE DESCUENTO';

        $("#monto1").attr("onblur", "verificar();");

        let cantidadDescuento = $("#idmontodisponible").val();
        console.log(cantidadDescuento);
        if(cantidadDescuento != '' && id_user != ''){
       
            document.getElementById('idmontodisponible').value = 'Cargando....';
            $.post('getDisponbleResguardo/' + id_user, function(data) {
                // console.log(data);
                let disponible = formatMoney(data.toFixed(3));
                $('#idmontodisponible').val(disponible);
            }, 'json');
        }else{
            document.getElementById('idmontodisponible').value = 'Cargando....';
            alerts.showNotification("top", "right", "Selcciona un usuario antes de continuar.", "warning");

        }
       

    } else {
        document.getElementById('labelmonto1').innerHTML = '';
        document.getElementById('labelmonto1').innerHTML = '<br>';
        document.getElementById('labelmonto2').innerHTML = 'MONTO A INGRESAR';
        document.getElementById('idmontodisponible').value = '...';
        document.getElementById('texto_motivo').innerHTML = 'MÓTIVO DE INGRESO';
        $("#monto1").attr("onblur", "verificar3();");
    }
});





$("#numeroP").change(function() {

    let monto = parseFloat($('#monto1').val());
    let cantidad = parseFloat($('#numeroP').val());
    let resultado = 0;

    if (isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
        $('#pago').val(resultado);
        document.getElementById('btn_abonar').disabled = true;
    } else {
        //console.log(monto);
        resultado = monto / cantidad;

        if (resultado > 0) {
            document.getElementById('btn_abonar').disabled = false;
            $('#pago').val(formatMoney(resultado));
        } else {
            document.getElementById('btn_abonar').disabled = true;
            $('#pago').val(formatMoney(0));
        }
    }
});



function verificar() {
    let valorDispo = $('#idmontodisponible').val();
    let disponible = replaceAll(valorDispo, ',', '');
    let monto_ingresado = replaceAll($('#monto1').val(), ',', '');
    let monto = parseFloat(monto_ingresado).toFixed(2);
    console.log('disponible: ' + disponible);
    console.log('monto: ' + monto);
    // alert(monto);
    // alert(disponible);
    if (monto < 1 || isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled = true;
    } else {

        if (parseFloat(disponible) < parseFloat(monto)) {
            alerts.showNotification("top", "right", "El monto ingresado es mayor a lo disponible.", "warning");
            document.getElementById('btn_abonar').disabled = true;
        } else {
            document.getElementById('btn_abonar').disabled = false;
            //alert('simon');
        }
    }

}

function verificar3() {
    let monto_ingresado = replaceAll($('#monto1').val(), ',', '');
    let monto = parseFloat(monto_ingresado).toFixed(2);
    //console.log('disponible: '+disponible);
    console.log('monto: ' + monto);
    // alert(monto);
    // alert(disponible);
    if (monto < 1 || isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled = true;
    } else {
        document.getElementById('btn_abonar').disabled = false;
        //alert('simon');
    }
}

function verificar4() {
    let monto_ingresado = replaceAll($('#monto').val(), ',', '');
    let monto = parseFloat(monto_ingresado).toFixed(2);
    //console.log('disponible: '+disponible);
    console.log('monto: ' + monto);
    // alert(monto);
    // alert(disponible);
    if (monto < 1 || isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btnsub').disabled = true;
    } else {
        document.getElementById('btnsub').disabled = false;
        //alert('simon');
    }
}
