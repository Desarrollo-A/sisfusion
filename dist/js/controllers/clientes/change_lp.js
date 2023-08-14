$('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
            $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function () {
    $.post(general_base_url + 'index.php/Clientes/getSedes/', function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#sede").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#sede").append('<option selected="selected" disabled>SELECCIONA UNA SEDE</option>');
        }
        $("#sede").selectpicker('refresh');
    }, 'json');
});

$('#sede').on('change', function () {
    var sede = $("#sede").val();
    $("#asesor").empty().selectpicker('refresh');
    $.post(general_base_url + 'index.php/Clientes/getAdvisers/'+sede, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            $("#asesor").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#asesor").append('<option selected="selected" disabled>NINGUN ASESOR</option>');
        }
        $("#asesor").selectpicker('refresh');
    }, 'json');
});

$('#asesor').on('change', function () {				
    var asesor = $("#asesor").val();
    var url = general_base_url + "index.php/Clientes/getProspectsListByAsesor/"+asesor;
    updateTable(url, 0, 0, 0, 0);
    $("#prospects-datatable_dir").removeClass('hide');
});

function updateTable(url, typeTransaction, beginDate, endDate, where){
    var prospectsTable = $('#prospects-datatable_dir').dataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        columns: [{ 
            data: function (d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-green">Vigente</span><center>';
                } else {
                    return '<center><span class="label lbl-melon">Sin vigencia</span><center>';
                }
            }
        },
        { 
            data: function (d) {
                let b='';
                if(d.estatus_particular == 1) { // DESCARTADO
                    b = '<center><span class="label lbl-melon">Descartado</span><center>';
                } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                    b = '<center><span class="label lbl-orangeYellow">Interesado sin cita</span><center>';
                } else if (d.estatus_particular == 3){ // CON CITA
                    b = '<center><span class="label ">Con cita</span><center>';
                } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                    b = '<center><span class="label lbl-azure">Sin especificar</span><center>';
                } else if (d.estatus_particular == 5){ // PAUSADO
                    b = '<center><span class="label lbl-blueMaderas">Pausado</span><center>';
                } else if (d.estatus_particular == 6){ // PREVENTA
                    b = '<center><span class="label lbl-pink">Preventa</span><center>';
                }
                return b;
            }
        },
        { 
            data: function (d) {
                return d.nombre;
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
                return d.nombre_lp;
            }
        },
        { 
            data: function (d) {
                return d.otro_lugar;
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
        },
        {
            data: function( data ){
                return '<div class="d-flex justify-center"><button title= "Cambio de lp" data-pros="'+data.id_prospecto+'" class="btn-data btn-gray change_lp"><i class="fas fa-map-marker-alt"></i></button></div>';
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
            "url": url,
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data":{
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    })
}

var id_pros = 0;
$("#prospects-datatable_dir tbody").on("click", ".change_lp", function(e){
    e.preventDefault();
    id_pros = $(this).attr("data-pros");
    $('#change_u').modal('show');
});

$(document).on('click', '#btn_change_lp', function(e){
    e.preventDefault();
    var lugar = $('#lp').val();
    $('#btn_change_lp').prop('disabled', true);
    $.ajax({
        url : general_base_url + 'index.php/Clientes/change_lp/',
        data: {id: id_pros, lugar_p: lugar},
        dataType: 'json',
        type: 'POST', 
        success: function(data){
            alerts.showNotification("top", "right", "Solicitud enviada.", "success");
            $('#prospects-datatable_dir').DataTable().ajax.reload();
            $('#change_u').modal('hide');
            $('#btn_change_lp').prop('disabled', false);
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#btn_change_lp').prop('disabled', false);
        }
    });
});

jQuery(document).ready(function(){
    jQuery('#change_u').on('hidden.bs.modal', function (e){
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#lp').val(null).trigger('change');
    })
});