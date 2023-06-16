
$(document).ready(function(){ /**FUNCIÓN PARA LLENAR EL SELECT DE PROYECTOS(RESIDENCIALES)*/
    $.post(`${general_base_url}General/getResidencialesList`, function (data) {        
        let len = data.length;
        console.log(data)
        for (let i = 0; i < len; i++) {
            let id = data[i]['idResidencial'];
            let name = data[i]['descripcion'];
            $("#residencial").append($('<option>').val(id).text(name));
        } 
        if (len <= 0) {
            $("#residencial").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#residencial").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json'); 
});

$('#residencial').change(function(){
    var residencial = $(this).val();
    //$('#tableClient').DataTable().clear();
    $("#condominio").empty().selectpicker('refresh');
    $("#lotes").empty().selectpicker('refresh');
    $("#clientes").empty().selectpicker('refresh');
    $.post(`${general_base_url}General/getCondominiosList`,{idResidencial:residencial}, function (data) {  
            data = JSON.parse(data);
            let len = data.length;
            for( let i = 0; i<len; i++)
            {
                let id = data[i]['idCondominio'];
                let name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name));
            }
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
    });
});

$('#condominio').change(function(){
    var condominio = $(this).val();
    //$('#tableClient').DataTable().clear();
    $("#lotes").selectpicker('refresh');
    $("#clientes").empty().selectpicker('refresh');
    $.post(`${general_base_url}General/getLotesList`,{idCondominio:condominio,typeTransaction:0}, function (data) {  
            data = JSON.parse(data);
            let len = data.length;
            for( let i = 0; i<len; i++)
            {
                let id = data[i]['idLote'];
                let name = data[i]['nombreLote'];
                $("#lotes").append($('<option>').val(id).text(name));
            }
            $("#lotes").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
    });
});

var datosTable;

$('#lotes').change(function(){
    datosTable = [];
    var lote = $(this).val();
    $("#clientes").empty().selectpicker('refresh');
    $.ajax({
        url:`${general_base_url}RegistroCliente/getClientByID`,
        type: 'POST',
        data:{idLote:lote,idCliente:''},
        success: function(data) {
                    data = JSON.parse(data);
                    datosTable = data;
                    let datosSelect = data.data;
                    console.log(data)
                    let len = datosSelect.length;
                    for( let i = 0; i<len; i++)
                    {
                        let id = datosSelect[i]['id_cliente'];
                        let name = datosSelect[i]['nombreCliente'];
                        $("#clientes").append($('<option>').val(id).text(name));
                    }
                    $("#clientes").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');  
                 },
        async:   false
   }); 
    construirTableClient('','',datosTable); 
});


let titulos = [];
$('#tableClient thead tr:eq(0) th').each(function (i) {

    if (i != 19) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if ($('#tableClient').DataTable().column(i).search() !== this.value) {
                $('#tableClient').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
    $('[data-toggle="tooltip"]').tooltip();
});

$('#clientes').change(function(){
    datosTable = [];
    var idCliente = $(this).val();
    $.ajax({
        url:`${general_base_url}RegistroCliente/getClientByID`,
        type: 'POST',
        data:{idLote:'',idCliente:idCliente},
        success: function(data) {
                    data = JSON.parse(data);
                    datosTable = data;
                 },
        async:   false
   });
    construirTableClient('',idCliente,datosTable);
});

function construirTableClient(idCliente = '',idLote = '',datos = ''){
    console.log(datos.data)
    let opcionConsulta = 'getClientsByLote'
    tableClient = $("#tableClient").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        data:datos.data,
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'AUTORIZACIONES PLANES DE VENTAS',
            exportOptions: {
                columns: [0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19],
                format: {
                    header:  function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            },
        },{
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: 'Regreso de expediente',
            title: "Regreso de expediente",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19],
                format: {
                    header:  function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            }
        } ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombreCondominio+'</p>';
                }
            },
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.idLote+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombreStatus+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.totalNeto)+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.totalNeto2)+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.totalValidado)+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.bandera8+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.validacionEng+'</p>';
                } 
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.tventa+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.registroComision+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.gerente+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.coordinador+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.asesor+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nomCliente+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fechaApartado+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    let lblStatus='';
                    if(d.estatus_cliente == 1){
                        lblStatus = '<small style="background: rgb(52,199,89); color:white; padding: 5px; width: 40px;border-radius: 10px">ACTIVO</small>';
                    }else{
                        lblStatus = '<small style="background: rgb(255,59,48); color:white; padding: 5px; width: 40px;border-radius: 10px">INACTIVO</small>';
                    }
                    return '<p style="font-size: .8em">'+lblStatus+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em; background-color:'+d.statusLoteColor+'; padding: 2px; color:white; padding: 2px;border-radius: 10px">'+d.estatus_lote+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lp+'</p>';
                }
            },
            {
                "width": "10%",
                data: null,
                render: function ( data, type, row )
                {
                    let button_action='';
                    if(data.estatus_cliente==0){
                        button_action = '<center><a class="backButton btn-data btn-warning" title= "Regresar expediente" style="cursor:pointer;" data-nomLote="'+data.nombreLote+'" data-nombreCliente="'+data.nomCliente+'" data-idCliente="'+data.id_cliente+'"><i class="fas fa-history"></i></a></center>';
                    }else{
                        button_action = 'NA';
                    }
                    return button_action;
                }
            }
        ],
        columnDefs: [{}],
        order: [
            [1, 'asc']
        ]
    });

}


$(document).on('click', '.backButton', function(){
var $itself = $(this);
let nombreLote = $itself.attr('data-nomLote');
let cliente = $itself.attr('data-nombreCliente');
let idCliente = $itself.attr('data-idCliente');
console.log("nombreLote: ", nombreLote);
console.log("cliente: ", cliente);
console.log("idCliente: ", idCliente);
$('#tempIDC').val(idCliente);
$('#loteName').text(nombreLote);
$('#modalConfirmRegExp').modal();
});

$(document).on('click', '.acepta_regreso', function(){
console.log('olv si acepto jejee');
let id_cliente = $('#tempIDC').val();
$.ajax({
    type: "POST",
    url:  `${base_url}Restore/return_status_uno/`,//https://maderascrm.gphsis.com/index.php/Restore/return_status_uno/idCliente
    data: {idCliente: id_cliente},
    dataType: 'json',
    cache: false,
    beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
    },
    success: function(data){
        $('#spiner-loader').addClass('hide');
        console.log(data.data);
        if(data.data==true){
            alerts.showNotification("top", "right", "Se ha regresado el expediente correctamente.", "success");
        }else{
            alerts.showNotification("top", "right", "Ha ocurrido un error intentalo nuevamente.", "danger");
        }
        $('#modalConfirmRegExp').modal('hide');
        $("#tableClient").DataTable().ajax.reload();
    },
    error: function() {
        $('#modalConfirmRegExp').modal('hide');

        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
}); /* */
});

