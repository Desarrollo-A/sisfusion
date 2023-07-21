let titulosEvidence=[];
$('#prospects-datatable_dir').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulosEvidence.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $( 'input', this ).on('keyup change', function () {
            if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
                $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
            }
        });
});

$(document).ready(function () {
    var url='';
    $(document).on('click', '#buscarBtn', function () {
        var nombreField = $('#nombre').val();
        var correoField = $('#correo').val();
        var telefonoField = $('#telefono').val();
        var ap_paterno = $('#ap_paterno').val();
        var ap_materno = $('#ap_materno').val();

        //correo y telefono vacío    ---- NOMBRE
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {nombre: nombreField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre y telefono vacio  --- CORREO
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {correo: correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre y correo vacio  ---- TELEFONO
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {telefono: telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre, ap_materno, telefono y correo vacio  ---- AP PATERNO
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length<=0){
            let busquedaParams = {ap_paterno: ap_paterno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre, ap_paterno, telefono y correo vacio  ---- AP MATERNO
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length > 0){
            let busquedaParams = {ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        //telefono, ap_paterno, ap_materno vacío   ----- NOMBRE + CORREO
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {nombre: nombreField, correo: correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //correo, ap_paterno, ap_materno vacío     ------ NOMBRE + TELEFONO
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {nombre: nombreField, telefono: telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //correo, telefono, ap_materno vacío     ------ NOMBRE + AP_PATERNO
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length<=0){
            let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //correo, telefono, ap_paterno vacío     ------ NOMBRE + AP_MATERNO
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {nombre: nombreField, ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //correo, telefono, nombre vacío     ------ AP_PATERNO + AP_MATERNO
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {ap_paterno: ap_paterno, ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //AP_MATERNO, telefono, nombre vacío     ------ AP_PATERNO + correo
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {ap_paterno: ap_paterno, ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //AP_MATERNO, correo, nombre vacío     ------ AP_PATERNO +  telefono
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {ap_paterno: ap_paterno, telefonoField: telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //AP_PATERNO, telefono, nombre vacío     ------  AP_MATERNO +  correo
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {correo: correoField, ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //AP_PATERNO, correo, nombre vacío     ------  AP_MATERNO + telefono
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {telefono: telefonoField, ap_materno: ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        /*************************/
        //nombre, ap_paterno, ap_materno vacío     ------- CORREO + TELEFONO
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
            let busquedaParams = {correo: correoField, telefono: telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //all ingresados    ----- NOMBRE + CORREO + TELEFONO + AP_PATERNO + AP_MATERNO
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {nombre:nombreField, correo: correoField, telefono: telefonoField, ap_paterno:ap_paterno, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        // CORREO + TELEFONO vacío     -------  nombre, ap_paterno, ap_maternov
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
            let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        // CORREO + TELEFONO vacío     -------  nombre, ap_paterno, ap_maternov
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
            let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        // TELEFONO vacío     -------  nombre, ap_paterno, ap_materno, CORREO
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
            let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno, correo:correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        /**combs de telefono**/
        //nombre, ap_paterno vacío     ------- TELEFONO + CORREO  + ap_materno
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length > 0){
            let busquedaParams = {correo: correoField, telefono: telefonoField, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre, ap_materno  vacío     ------- TELEFONO + CORREO  +  ap_paterno
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {correo: correoField, telefono: telefonoField, ap_paterno:ap_paterno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //ap_paterno, ap_materno  vacío     ------- TELEFONO + CORREO  +   nombre
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length <= 0){
            let busquedaParams = {correo: correoField, telefono: telefonoField, nombre:nombreField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre vacío     ------- TELEFONO + CORREO  + ap_materno + ap_paterno
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {correo: correoField, telefono: telefonoField, ap_materno:ap_materno, ap_paterno:ap_paterno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        // CORREO vacío     ------- TELEFONO +  nombre + ap_materno + ap_paterno
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {correo: correoField, nombre: nombreField, ap_materno:ap_materno, ap_paterno:ap_paterno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        //ap_paterno, telefono  vacío     ------- nombre + ap_materno + correo
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {correo: correoField, nombre: nombreField, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //ap_paterno,  correo vacío     ------- nombre + ap_materno + telefono
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_materno:ap_materno};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //ap_paterno, vacío     ------- nombre + ap_materno + telefono + correo
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
            let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_materno:ap_materno, correo:correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        //ap_materno, vacío     ------- nombre +  ap_paterno + telefono + correo
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_paterno:ap_paterno, correo:correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //ap_materno, telefono vacío     ------- nombre +  ap_paterno  + correo
        if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {nombre: nombreField, ap_paterno:ap_paterno, correo:correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //ap_materno, correo vacío     ------- nombre +  ap_paterno  +  telefono
        if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
            let busquedaParams = {nombre: nombreField, ap_paterno:ap_paterno, telefono:telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }
        //nombre, telefono  vacío     -------  ap_materno +  ap_paterno  +   correo
        if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {ap_materno: ap_materno, ap_paterno:ap_paterno, correo:correoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        //nombre, correo   vacío     -------  ap_materno +  ap_paterno  +   telefono
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
            let busquedaParams = {ap_materno: ap_materno, ap_paterno:ap_paterno, telefono:telefonoField};
            var urlBusqueda = general_base_url + 'index.php/clientes/getResultsProspectsSerch';
            updateTable(typeTransaction, busquedaParams, urlBusqueda);
        }

        //all vacío
        if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <=0 && ap_paterno.length<=0 && ap_materno.length<=0){
            alerts.showNotification('top', 'right', 'Ups, asegurate de colocar al menos un criterío de búsqueda', 'warning');
            $('#nombre').focus();
        }
        $("#prospects-datatable_dir").removeClass('hide');
    });
});

function updateTable(typeTransaction, busquedaParams, urlBusqueda){
    $('#prospects-datatable_dir').dataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        columns: [{ 
            data: function (d) {
                return d.id_prospecto;
            }
        },
        { 
            data: function (d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-green">VIGENTE</span><center>';
                } else {
                    return '<center><span class="label lbl-warinig">NO VIGENTE</span><center>';
                }
            }
        },
        { 
            data: function (d) {
                if( d.lugar_prospeccion == 'MKT digital (especificar)'){
                    if(d.otro_lugar != '0'){
                        return '<center><span class="label lbl-azure">'+d.lugar_prospeccion+'</span><br><br><span class="label label-danger" style="background:#494e54">'+d.otro_lugar+'</span><center>';
                    }
                    else{
                        return '<center><span class="label lbl-azure">'+d.lugar_prospeccion+'</span><center>';
                    }
                }
                else{
                    return '<center><span class="label lbl-azure">'+d.lugar_prospeccion+'</span><center>';
                }
            }
        },
        { 
            data: function (d) {
                return d.nombre;
            }
        },
        { 
            data: function (d) {
                return d.apellido_paterno;
            }
        },
        { 
            data: function (d) {
                return d.apellido_materno;
            }
        },
        { 
            data: function (d) {
                return d.asesor;
            }
        },
        { 
            data: function (d) {
                return d.coordinador;
            }
        },
        { 
            data: function (d) {
                return d.gerente;
            }
        },
        { 
            data: function (d) {
                return d.fecha_creacion;
            }
        },
        { 
            data: function (d) {
                return d.fecha_vencimiento;
            }
        }
        ,
        { 
            data: function (d) {
                return '<div class="d-flex justify-center"><button  data-toggle="tooltip"  data-placement="top" title="VER INFORMACIÓN" class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '"><i class="material-icons">remove_red_eye</i></button></div>';
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        ajax: {
            "url": urlBusqueda,
            "method": 'POST',
            data:busquedaParams
        }	
    })
}

$(document).on('click', '.see-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $("#prospecto_lbl").val(id_prospecto);

    $.getJSON("getInformationToPrint/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillFields(v, 1);
        });
    });

    $.getJSON("getComments/" + id_prospecto).done(function(data) {
        counter = 0;
        $.each(data, function(i, v) {
            counter++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillChangelog(v);
        });
    });

});

$(document).on('click', "#ResetForm", function() {
    $('#nombre').val('');
    $('#correo').val('');
    $('#telefono').val('');
    $('#ap_paterno').val('');
    $('#ap_materno').val('');
});

function fillFields(v, type) {

    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        $("#name").val(v.nombre);
        $("#last_name").val(v.apellido_paterno);
        $("#mothers_last_name").val(v.apellido_materno);
        $("#date_birth").val(v.fecha_nacimiento);
        $("#email").val(v.correo);
        $("#phone_number").val(v.telefono);
        $("#phone_number2").val(v.telefono_2);
        $("#civil_status").val(v.estado_civil);
        $("#matrimonial_regime").val(v.regimen_matrimonial);
        $("#spouce").val(v.conyuge);
        $("#from").val(v.originario_de);
        $("#home_address").val(v.domicilio_particular);
        $("#occupation").val(v.ocupacion);
        $("#company").val(v.empresa);
        $("#position").val(v.posicion);
        $("#antiquity").val(v.antiguedad);
        $("#company_antiquity").val(v.edadFirma);
        $("#company_residence").val(v.direccion);
        $("#prospecting_place").val(v.lugar_prospeccion);
        $("#advertising").val(v.medio_publicitario);
        $("#sales_plaza").val(v.plaza_venta);
        //document.getElementById("observations").innerHTML = v.observaciones;
        $("#observation").val(v.observaciones);
        if (v.tipo_vivienda == 1) {
            document.getElementById('own').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 2) {
            document.getElementById('rented').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 3) {
            document.getElementById('paying').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 4) {
            document.getElementById('family').setAttribute("checked", "true");
        } else {
            document.getElementById('other').setAttribute("checked", "true");
        }

        pp = v.lugar_prospeccion;
        if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
            $("#specify").val(v.otro_lugar);
        } else if (pp == 6) { // SPECIFY MKTD OPTION
            document.getElementById('specify_mkt').value = v.otro_lugar;
        } else if (pp == 21) { // RECOMMENDED SPECIFICATION
            document.getElementById('specify_recommends').value = v.otro_lugar;
        } else { // WITHOUT SPECIFICATION
            $("#specify").val("");
        }

    } 
    else if (type == 1) {
        $("#nationality-lbl").val(v.nacionalidad);
        $("#legal-personality-lbl").val(v.personalidad_juridica);
        $("#curp-lbl").val(v.curp);
        $("#rfc-lbl").val(v.rfc);
        $("#name-lbl").val(v.nombre);
        $("#last-name-lbl").val(v.apellido_paterno);
        $("#mothers-last-name-lbl").val(v.apellido_materno);
        $("#email-lbl").val(v.correo);
        $("#phone-number-lbl").val(v.telefono);
        $("#phone-number2-lbl").val(v.telefono_2);
        $("#prospecting-place-lbl").val(v.lugar_prospeccion);
        $("#specify-lbl").html(v.otro_lugar);
        $("#sales-plaza-lbl").val(v.plaza_venta);
        $("#comments-lbl").val(v.observaciones);
        $("#asesor-lbl").val(v.asesor);
        $("#coordinador-lbl").val(v.coordinador);
        $("#gerente-lbl").val(v.gerente);
        $("#phone-asesor-lbl").val(v.tel_asesor);
        $("#phone-coordinador-lbl").val(v.tel_coordinador);
        $("#phone-gerente-lbl").val(v.tel_gerente);
    } 
    else if (type == 2) {
        $("#prospecto_ed").val(v.id_prospecto).trigger('change');
        $("#prospecto_ed").selectpicker('refresh');
        $("#kinship_ed").val(v.parentesco).trigger('change');
        $("#kinship_ed").selectpicker('refresh');
        $("#name_ed").val(v.nombre);
        $("#phone_number_ed").val(v.telefono);
    }
}

function fillTimeline(v) {
    $("#comments-list").append('<li>\n' +
        '    <div class="container-fluid">\n' +
        '       <div class="row">\n' +
        '           <div class="col-md-6">\n' +
        '               <a><small>Usuario: </small><b>' + v.creador + '</b></a><br>\n' +
        '           </div>\n' +
        '           <div class="float-end text-right">\n' +
        '               <a>' + v.fecha_creacion + '</a>\n' +
        '           </div>\n' +
        '           <div class="col-md-12">\n' +
        '               <p class="m-0"><small>Obseravación: </small><b> ' + v.observacion + '</b></p>\n'+
        '           </div>\n' +
        '        <h6>\n' +
        '        </h6>\n' +
        '       </div>\n' +
        '    </div>\n' +
        '</li>');
}

function fillChangelog(v) {
    $("#changelog").append('<li>\n' +
    '    <div class="container-fluid">\n' +
    '       <div class="row">\n' +
    '           <div class="col-md-6">\n' +
    '               <a><small>Campo: </small><b>' + v.parametro_modificado + '</b></a><br>\n' +
    '           </div>\n' +
    '           <div class="float-end text-right">\n' +
    '               <a>' + v.fecha_creacion + '</a>\n' +
    '           </div>\n' +
    '           <div class="col-md-12">\n' +
    '               <p class="m-0"><small>USUARIO: </small><b> ' + v.creador + '</b></p>\n'+
    '               <p class="m-0"><small>VALOR ANTERIOR: </small><b> ' + v.anterior + '</b></p>\n' +
    '               <p class="m-0"><small>VALOR NUEVO: </small><b> ' + v.nuevo + '</b></p>\n' +
    '           </div>\n' +
    '        <h6>\n' +
    '        </h6>\n' +
    '       </div>\n' +
    '    </div>\n' +
    '</li>');
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    myCommentsList.innerHTML = '';
    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

function printProspectInfo() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfo/" + id_prospecto, "_blank")
}

function printProspectInfoMktd() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfoMktd/" + id_prospecto, "_blank")
}