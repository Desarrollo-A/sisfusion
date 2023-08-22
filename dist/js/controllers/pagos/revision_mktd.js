var tr;
let meses = [
    {
        id: '01',
        mes:'ENERO'
    },
    {
        id:'02',
        mes:'FEBRERO'
    },
    {
        id:'03',
        mes:'MARZO'
    },
    {
        id:'04',
        mes:'ABRIL'
    },
    {
        id:'05',
        mes:'MAYO'
    },
    {
        id:'06',
        mes:'JUNIO'
    },
    {
        id:'07',
        mes:'JULIO'
    },
    {
        id:'08',
        mes:'AGOSTO'
    },
    {
        id:'09',
        mes:'SEPTIEMBRE'
    },
    {
        id:'10',
        mes:'OCTUBRE'
    },
    {
        id:'11',
        mes:'NOVIEMBRE'
    },
    {
        id:'12',
        mes:'DICIEMBRE'
    }
];
let anios = [2019,2020,2021,2022,2023];
let datos = '';
let datosA = '';

for (let index = 0; index < anios.length; index++) {
    datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
}
$('#anio').html(datosA);
$('#anio').selectpicker('refresh');


$(document).ready(function(){
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    $("#beginDate").val(finalBeginDate);
    $("#endDate").val(finalEndDate);
    $(".beginDateR").val(finalBeginDate);
    $(".endDateR").val(finalEndDate);
    fillTable(1, finalBeginDate, finalEndDate, 0, 0);
    fillTableR(1, finalBeginDate, finalEndDate, 0, 0);
});

sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let estatus =($("#selectEstatus").val() == '') ? 0 : $("#selectEstatus").val();
    fillTable(3, finalBeginDate, finalEndDate, 0, estatus);
});

function fillTable(typeTransaction, beginDate, endDate, where, estatus){
    $("#tabla_total_comisionistas").ready( function(){
        let c=0;
        $('#tabla_total_comisionistas').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            $.each(json.data, function(i, v){
                total += parseFloat(v.total_dispersado);
            });
            var to = formatMoney(numberTwoDecimal(total));
            document.getElementById("myText_nuevas_tc").textContent = to;
        });
        tabla_total_comisionistas = $("#tabla_total_comisionistas").DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                exportOptions: {
                    columns: [0,1,2,3,4,5],
                    format: 
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                },
            }],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [{
                "data": function( d ){
                    return '<p class="m-0"><br>'+d.id_usuario+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><br>'+d.rol+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><b>'+d.nombre_comisionista+'</p>';
                }
            },
            {
                "data": function( d ){
                        return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.total_dispersado))+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.fecha+'<b></b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombre+'<b></b></p>';
                }
            }],
            ajax: {
                url: general_base_url + "Pagos/getCommissionsByMktdUser/",
                type: "POST",
                cache: false,
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where,
                    "estatus": estatus
                }
            },
        });
    });
}

$.post(general_base_url + "Pagos/getEstatusPagosMktd", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#selectEstatus").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#selectEstatus").selectpicker('refresh');
}, 'json');

$.post(general_base_url + "Pagos/getEstatusPagosMktd", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#selectEstatusN").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#selectEstatusN").selectpicker('refresh');
}, 'json');

$.post(general_base_url + "Pagos/getEstatusPagosMktd", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#selectEstatusR").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#selectEstatusR").selectpicker('refresh');
}, 'json');

$('#mes').change(function() {
    anio = $('#anio').val();
    mes = $('#mes').val();
    Estatus = $('#selectEstatusN').val();
    if(Estatus != ''){
        RevisionMKTD(mes,anio,Estatus);
    }
});

$('#anio').change(function() {
    for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        }
    mes = $('#mes').val();
    if(mes == ''){
        mes=0;
    }
    anio = $('#anio').val();
    if (anio == '' || anio == null || anio == undefined) {
        anio = 0;
    }
});

$('#selectEstatusN').change( function(){
    mes = $('#mes').val();
    anio = $('#anio').val();
    Estatus = $('#selectEstatusN').val();
    if(mes != '' || anio != '' ){
        RevisionMKTD(mes,anio,Estatus);
    }else{
        alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
    }
});

let titulos3 = [];
    $('#tabla_plaza_12 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos3.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if (plaza_12.column(i).search() !== this.value ) {
                plaza_12.column(i).search(this.value).draw();
                var total = 0;
                var totalNus=0;
                var totalMktd=0;
                var totalTo=0;
                var index = plaza_12.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_12.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.impuesto);
                    totalNus += parseFloat(v.nus);
                    totalMktd += parseFloat(v.mktd);
                    totalTo += parseFloat(v.impuesto)+ parseFloat(v.nus) + parseFloat(v.mktd);
                });
                document.getElementById("myText_nuevasCo").textContent = formatMoney(numberTwoDecimal(total));
                document.getElementById("myText_nuevasNus").textContent = formatMoney(numberTwoDecimal(totalNus));
                document.getElementById("myText_nuevasMktd").textContent = formatMoney(numberTwoDecimal(totalMktd));
                document.getElementById("myText_nuevasTo").textContent = formatMoney(numberTwoDecimal(totalTo));
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

RevisionMKTD(0,0,0);

function RevisionMKTD(mes,anio,Estatus){
    $("#tabla_plaza_12").ready( function(){
        let c=0;
        $('#tabla_plaza_12').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            var totalNus=0;
            var totalMktd=0;
            var totalTo=0;
            $.each(json.data, function(i, v){
                total += parseFloat(v.impuesto);
                totalNus += parseFloat(v.nus);
                totalMktd += parseFloat(v.mktd);
                totalTo += parseFloat(v.impuesto)+ parseFloat(v.nus) + parseFloat(v.mktd);
            });

            document.getElementById("myText_nuevasCo").textContent = formatMoney(numberTwoDecimal(total));
            document.getElementById("myText_nuevasNus").textContent = formatMoney(numberTwoDecimal(totalNus));
            document.getElementById("myText_nuevasMktd").textContent = formatMoney(numberTwoDecimal(totalMktd));
            document.getElementById("myText_nuevasTo").textContent = formatMoney(numberTwoDecimal(totalTo));
        });
        plaza_12 = $("#tabla_plaza_12").DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MKTD_CONCENTRADO_PAGO_COMISIONES',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: 
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos3[columnIdx] + ' ';
                        }
                    }
                },
            }],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [{
                "data": function( d ){
                    return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.colaborador+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.sede+'</p>';
                }
            },
            
            {
                "data": function( d ){
                    return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.sum_abono_marketing))+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.dcto))+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.nus))+'</b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.mktd))+'</b></p>';
                }
            },
            {
                "data": function( d ){
                    let suma = parseFloat(d.impuesto)+ parseFloat(d.nus)+ parseFloat(d.mktd);
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(suma))+'</b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.forma_pago+'</p>';
                }
            }],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                searchable:false,
                className: 'dt-body-center'
            }],
            ajax: {
                url: general_base_url + "Pagos/getDatosRevisionMktd2/"+mes+"/"+anio+"/"+Estatus,
                type: "POST",
                cache: false,
                data: function( d ){}
            },
        });

        $("#tabla_plaza_12 tbody").on("click", ".dispersar_colaboradores", function(){
            var tr = $(this).closest('tr');
            var row = plaza_1.row( tr );
            let c=0;
            let ubication = $(this).attr("data-value");
            let plen = $(this).val();
            $.getJSON( general_base_url + "Pagos/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
                let suma_01 = parseFloat(data01[0].suma_f01);
                $("#modal_colaboradores .modal-body").html("");
                $("#modal_colaboradores .modal-footer").html("");
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');
                $.getJSON( general_base_url + "Pagos/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                    var_sum = 0;
                    let fech = data1[0].fecha_plan;
                    let fecha = fech.substr(0, 10);
                    let nuevaFecha = fecha.split('-');
                    let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                    let fech2 = data1[0].fin_plan;
                    let fecha2 = fech2.substr(0, 10);
                    let nuevaFecha2 = fecha2.split('-');
                    let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');
                    $.each( data1, function( i, v){
                        valor_money = ((v.porcentaje/100)*suma_01)
                        $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b><p>'+v.colaborador+'</p></b><p>'+v.rol+'</p><br></div>'
                            +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-5"><input type="text" readonly name="abono_marketing[]" id="abono_marketing_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                            +'</div>');
                        var_sum +=  parseFloat(v.porcentaje);
                        c++;
                    });
                    var_sum2 = parseFloat(var_sum);
                    new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                    new_valll2 = parseFloat((suma_01/100)*var_sum2);
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
                });
                $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                $("#modal_colaboradores").modal();
            });
        });
    });
}

$("#tabla_plaza_1").ready( function(){
    let titulosp = [];
    $('#tabla_plaza_1 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulosp.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if (plaza_1.column(i).search() !== this.value ) {
                plaza_1.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_1.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.sum_abono_marketing);
                });
                document.getElementById("myText_nuevas").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    let c=0;
    $('#tabla_plaza_1').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.sum_abono_marketing);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("myText_nuevas").textContent = to;
    });

    plaza_1 = $("#tabla_plaza_1").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'MKTD_CONCENTRADO_PAGO_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulosp[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.colaborador+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.empresa == null || d.empresa == "")
                    return '<p class="m-0">SIN ESPECIFICAR</p>';
                else
                    return '<p class="m-0">'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.sum_abono_marketing))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.dcto))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.forma_pago+'</p>';
            }
        }],
        columnDefs: [{
            defaultContent: "SIN ESPECIFICAR",
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Pagos/getDatosRevisionMktd",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_plaza_1 tbody").on("click", ".dispersar_colaboradores", function(){
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        let c=0;
        let ubication = $(this).attr("data-value");
        let plen = $(this).val();
        $.getJSON( general_base_url + "Pagos/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p> </div></div>');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');
            $.getJSON( general_base_url + "Pagos/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                var_sum = 0;
                let fech = data1[0].fecha_plan;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                let fech2 = data1[0].fin_plan;
                let fecha2 = fech2.substr(0, 10);
                let nuevaFecha2 = fecha2.split('-');
                let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');
                $.each( data1, function( i, v){
                    valor_money = ((v.porcentaje/100)*suma_01)
                    $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b><p>'+v.colaborador+'</p></b><p>'+v.rol+'</p><br></div>'
                        +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-5"><input type="text" readonly name="abono_marketing[]" id="abono_marketing_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                        +'</div>');
                    var_sum +=  parseFloat(v.porcentaje);
                    c++;
                });
                var_sum2 = parseFloat(var_sum);
                new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                new_valll2 = parseFloat((suma_01/100)*var_sum2);
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
            });
            $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
            $("#modal_colaboradores").modal();
        });
    });
});

$("#tabla_plaza_2").ready( function(){
    let titulos = [];
    $('#tabla_plaza_2 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if (plaza_2.column(i).search() !== this.value ) {
                plaza_2.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_2.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_2.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.pago_cliente);
                });
                document.getElementById("myText_proceso").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    let c=0;
    $('#tabla_plaza_2').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("myText_proceso").textContent = to;
    });
    let enviar = [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title: 'MARKETING_SISTEMA_COMISIONES',
        exportOptions: {
            columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
            format: 
            {
                header:  function (d, columnIdx) {
                    return ' ' + titulos[columnIdx] + ' ';
                }
            }
        },
    }];
    if(id_rol_general == 13 || id_rol_general == 17){
        enviar.push({
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function(){
                $.get(general_base_url + "Pagos/acepto_contraloria_MKTD/").done(function () {
                    $("#myModalEnviadas").modal('toggle');
                    plaza_2.ajax.reload();
                    plaza_1.ajax.reload();
                    $("#myModalEnviadas .modal-body").html("");
                    $("#myModalEnviadas").modal();
                    $("#myModalEnviadas .modal-body").append(`<center><img style='width: 75%; height: 75%;' src='${general_base_url}dist/img/send_intmex.gif'><p style='color:#676767;'>Comisiones del área <b>Marketing Dígital</b> fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>`);
                });
            },
            attr: {
                class: 'btn btn-azure',
            }
        });
    }
    plaza_2 = $("#tabla_plaza_2").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: enviar,
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                return '<p>'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+d.proyecto+'</p>';
            }
        },{
            "data": function( d ){
                return '<p>'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p><b>'+d.lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+formatMoney(numberTwoDecimal(d.precio_lote))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p><b>'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+formatMoney(numberTwoDecimal(d.pago_neodata))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p>'+formatMoney(numberTwoDecimal(d.pago_cliente))+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.lugar_prospeccion == 6){
                    return '<p>COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p>COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p><i> '+d.puesto+'</i></p>';
            }
        },
        {
            "data": function( d ){
                var BtnStats1;
                BtnStats1 =  '<p>'+d.fecha_creacion.split('.')[0]+'</p>';
                return BtnStats1;
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<div class="d-flex justify-center">'+
                                '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-sky consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="DETALLE">' 
                                    +'<i class="fas fa-info"></i>'+
                                '</button>'+
                            '</div>';
                return BtnStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + "Pagos/getDatosNuevasmkContraloria",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_plaza_2 tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModal").modal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento.split('.')[0]+'</a></div><div class="col-md-12"><p class="m-0"><small>Modificado por: </small><b> ' +v.nombre_usuario+ '</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
});

$('#tabla_plaza_2').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#fecha1').change( function(){
    fecha1 = $(this).val();
    let fecha2 = $('#fecha2').val();
    let opcion = $('#selectEstatus').val();
    if(fecha2 == ''){
    }
    else{
        totalComisones(fecha1, fecha2, opcion);
    }
});

$('#fecha2').change( function(){
    fecha2 = $(this).val();
    let fecha1 = $('#fecha1').val();
});

$('#selectEstatus').change( function(){
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let estatus =($(this).val() == '') ? 0 : $(this).val();
    fillTable(1, finalBeginDate, finalEndDate, 0, estatus);
});

let titulos = [];
$('#tabla_total_comisionistas thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" id="t-'+i+'" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if (tabla_total_comisionistas.column(i).search() !== this.value ) {
            tabla_total_comisionistas.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_total_comisionistas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_total_comisionistas.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.total_dispersado);
            });
            document.getElementById("myText_nuevas_tc").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

$('#fechaR1').change( function(){
    fecha1 = $(this).val();
    $('#fechaR2').val();
});

$('#fechaR2').change( function(){
    fecha2 = $(this).val();
    $('#fechaR1').val();
});

$('#selectEstatusR').change( function(){
    let finalBeginDate = $(".beginDateR").val();
    let finalEndDate = $(".endDateR").val();
    let estatus =($(this).val() == '') ? 0 : $(this).val();
    fillTableR(1, finalBeginDate, finalEndDate, 0, estatus);
});

let titulos2 = [];
$('#tabla_total_comisionistas2 thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos2.push(title);
    $(this).html('<input type="text" id="t-'+i+'" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if (tabla_total_comisionistas2.column(i).search() !== this.value ) {
            tabla_total_comisionistas2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_total_comisionistas2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_total_comisionistas2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.total);
            });

            document.getElementById("myText_nuevas_tc2").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

function fillTableR(typeTransaction, beginDate, endDate, where, estatus){
    $("#tabla_total_comisionistas2").ready( function(){
        let c=0;
        $('#tabla_total_comisionistas2').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            $.each(json.data, function(i, v){
                total += parseFloat(v.total);
            });
            var to = formatMoney(numberTwoDecimal(total));
            document.getElementById("myText_nuevas_tc2").textContent = to;
        });
        tabla_total_comisionistas2 = $("#tabla_total_comisionistas2").DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: 
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos2[columnIdx] + ' ';
                        }
                    }
                },
            }],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [{
                "data": function( d ){
                    return '<p class="m-0"><center>MKTD COMISIONES</center></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><center>'+d.id_plan+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><center><b>'+d.sede+'</b></center></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0"><center>'+formatMoney(numberTwoDecimal(d.total))+'</center></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em"><center>'+d.nombre+'</center></p>';
                }
            }],
            ajax: {
                url: general_base_url + "Pagos/getCommissionsByMktdUserReport/",
                type: "POST",
                cache: false,
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where,
                    "estatus": estatus
                }
            },
        });
    });
}

$(document).on("click", "#searchByDateRangeR", function () {
    let finalBeginDate = $(".beginDateR").val();
    let finalEndDate = $(".endDateR").val();
    let estatus =($("#selectEstatusR").val() == '') ? 0 : $("#selectEstatusR").val();
    fillTableR(3, finalBeginDate, finalEndDate, 0, estatus);
});

var justificacion_globla = "";

$("#form_colaboradores").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        let sumat=0;
        let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
        let valor1 = parseFloat(valor-0.10);
        let valor2 = parseFloat(valor)+0.010;
        for(let i=0;i<$('#cuantos').val();i++){
            sumat += parseFloat($('#abono_marketing_'+i).val());
        }
        let sumat2 =  parseFloat((sumat).toFixed(3));
        document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';
        if(parseFloat(sumat2.toFixed(3)) < valor1){
            alerts.showNotification("top", "right", "Falta dispersar", "warning");
        }
        else if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
            $.ajax({
                url: general_base_url + "Pagos/nueva_mktd_comision",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#loader').addClass('hidden');
                        $("#modal_colaboradores").modal('toggle');
                        plaza_2.ajax.reload();
                        plaza_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
        else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
            alerts.showNotification("top", "right", "Cantidad excedida", "danger");
        }
    }
});

$("#form_MKTD").submit( function(e) {
    e.preventDefault();
}).validate({
    rules: {
        'porcentajeUserMk[]':{
            required: true,
        }
    },
    messages: {
        'porcentajeUserMk[]':{
            required : "Dato requerido"
        }
    },
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Pagos/save_new_mktd",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_mktd").modal( 'toggle' );
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
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
    }
    else if ($precioNuevo < $precioFinal) {
        $('#label_estado').append('<label>MONTO VALIDO</label>');
    }
}

function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = general_base_url+"dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(window).resize(function(){
    plaza_1.columns.adjust();
    plaza_2.columns.adjust();
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});

$(document).ready( function(){
    $.getJSON( general_base_url + "Comisiones/report_plazas").done( function( data ){
        $(".report_plazas").html();
        $(".report_plazas1").html();
        $(".report_plazas2").html();
        if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
            if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
            }
        }
        if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
            if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
            }
        }
        if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
            if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
            }
        }
    });
});

$(document).ready( function(){
    $.getJSON( general_base_url + "Comisiones/report_plazas").done( function( data ){
        $(".report_plazas").html();
        $(".report_plazas1").html();
        $(".report_plazas2").html();
        if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
            if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
            }
        }
        if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
            if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
            }
        }
        if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
            if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
            }
        }
    });
});

$("#idloteorigen").select2({dropdownParent:$('#miModal')});

$(document).ready(function () {
    $.post(general_base_url + "Pagos/getMktdRol", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre']+' '+data[i]['apellido_paterno']+' '+data[i]['apellido_materno'];
            $("#usuarioid").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#usuarioid").selectpicker('refresh');
    }, 'json');
});

$("#usuarioid").change(function() {
    document.getElementById('monto').value = '';
    document.getElementById('idmontodisponible').value = '';
    var user = $(this).val();
    $('#idloteorigen option').remove();
    $.post(general_base_url + "Pagos/getLotesOrigenmk/"+user, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var name = data[i]['nombreLote'];
            var comision = data[i]['id_pago_i'];
            var pago_neodata = data[i]['pago_neodata'];
            let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
            $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)},${pago_neodata}'> ${ formatMoney(comtotal.toFixed(2))}</option>`);
        }
        if(len<=0)
        {
            $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#idloteorigen").selectpicker('refresh');
    }, 'json');
});

$("#idloteorigen").change(function() {
    let cuantos = $('#idloteorigen').val().length;
    let suma =0;
    if(cuantos > 1){
        var comision = $(this).val();
        for (let index = 0; index < $('#idloteorigen').val().length; index++) {
            datos = comision[index].split(',');
            let id = datos[0];
            let monto = datos[1];
            document.getElementById('monto').value = '';
            $.post(general_base_url + "Pagos/getInformacionDataMK/"+id, function(data) {
                var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                suma = suma + disponible;
                document.getElementById('montodisponible').innerHTML = '';
                $("#idmontodisponible").val(formatMoney(suma));
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma.toFixed(2)+'">');
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                var len = data.length;
                if(len<=0){
                    $("#idmontodisponible").val(formatMoney(0));
                }
                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    }
    else{
        var comision = $(this).val();
        datos = comision[0].split(',');
        let id = datos[0];
        let monto = datos[1];
        document.getElementById('monto').value = '';
        $.post(general_base_url + "Pagos/getInformacionDataMK/"+id, function(data) {
            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
            document.getElementById('montodisponible').innerHTML = '';
            $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
            $("#idmontodisponible").val(formatMoney(disponible));
            $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
            var len = data.length;
            if(len<=0){
                $("#idmontodisponible").val(formatMoney(0));
            }
            $("#montodisponible").selectpicker('refresh');
        }, 'json');
    }
});

function verificar(){
    let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
    let monto = parseFloat($('#monto').val()).toFixed(2);
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled=true;
    }
    else{
        if(parseFloat(monto) <= parseFloat(disponible) ){
            let cantidad = parseFloat($('#numeroP').val());
            resultado = monto /cantidad;
            $('#pago').val(formatMoney(resultado));
            document.getElementById('btn_abonar').disabled=false;
            console.log('OK');
            let cuantos = $('#idloteorigen').val().length;
            let cadena = '';
            var data = $('#idloteorigen').select2('data')
            for (let index = 0; index < cuantos; index++) {
                let datos = data[index].id;
                let montoLote = datos.split(',');
                let abono_neo = montoLote[1];
                if(parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1){
                    document.getElementById('msj2').innerHTML="El monto ingresado se cubre con la comisión "+data[index].text;
                    document.getElementById('btn_abonar').disabled=true;
                    break;
                }
                cadena = cadena+' , '+data[index].text;
                document.getElementById('msj2').innerHTML='';
            }
            $('#comentario').val('PAGOS DESCUENTO: '+cadena+'. Por la cantidad de: '+formatMoney(numberTwoDecimal(monto)));
        }
        else if(parseFloat(monto) > parseFloat(disponible) ){
            alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
            document.getElementById('monto').value = '';
            document.getElementById('btn_abonar').disabled=true;
        }
    }
}

$("#form_descuentos").on('submit', function(e){
    e.preventDefault();
    document.getElementById('btn_abonar').disabled=true;
    let formData = new FormData(document.getElementById("form_descuentos"));
    formData.append("dato", "valor");
    $.ajax({
        url: general_base_url + "Pagos/saveDescuentomk/"+1,
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                document.getElementById('btn_abonar').disabled=false;
                document.getElementById("form_descuentos").reset();
                plaza_1.ajax.reload();
                $('#miModal').modal('hide');
                $('#idloteorigen option').remove();
                $("#roles").val('');
                $("#roles").selectpicker("refresh");
                $('#usuarioid').val('default');
                $("#usuarioid").selectpicker("refresh");
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
            }
            else if(data == 2) {
                document.getElementById('btn_abonar').disabled=false;
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $(".directorSelect2").empty();
            }
            else if(data == 3){
                document.getElementById('btn_abonar').disabled=false;
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                $(".directorSelect2").empty();
            }
        },
        error: function(){
            document.getElementById('btn_abonar').disabled=false;
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});