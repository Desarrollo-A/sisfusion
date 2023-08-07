var totaPen = 0;
var tr;
$("#tabla_plaza_1").ready( function(){
    let titulos = [];
    $('#tabla_plaza_1 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" class="textoshead" id="t-'+i+'" title="' + title + '" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (plaza_1.column(i).search() !== this.value ) {
                plaza_1.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_1.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.total);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_nuevas").textContent = formatMoney(total);
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
            total += parseFloat(v.total);
        });
        var to = formatMoney(total);
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
            title: 'LISTADO COMISIONES PLAZA 1',    
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
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
        columns: [{
            "data": function( d ){
                return '<p class="m-0">COMISIÓN - <b>'+d.nombre+' '+d.apellido_paterno+'</b></p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">PLAN <b>'+d.id_plan+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<span class="label lbl-azure">DISPONIBLE</span>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.descripcion+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.total)+'</p>';
            }
        },
        { 
            "orderable": false,
            "data": function( d ){
                return '<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow dispersar_colaboradores" id="btndispersar" data-toggle="tooltip" data-placement="top" title="PARCIALIDAD" value="' + d.id_plan +'" data-residencial="'+d.idResidencial+'" data-empresa="'+d.empresa+'" data-value="' + d.ubicacion_dos +'"><i class="fas fa-chart-pie"></i></button></div>';   
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosNuevasMktd",/*registroCliente/getregistrosClientes*/
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_plaza_1 tbody").on("click", ".dispersar_colaboradores", function(){
        $("#btnplz1").button({ disabled: false });
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        let c=0;
        let ubication = $(this).attr("data-value");
        let empresa = $(this).attr("data-empresa");
        let residencial = $(this).attr("data-residencial");
        let plen = $(this).val();
        $.getJSON( general_base_url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen+"/"+empresa+"/"+residencial).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body ").append(`<div id="encabezado"></div>`);
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="num_plan" value="'+plen+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="empresa" value="'+empresa+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');
            $("#modal_colaboradores .modal-body ").append(`<div id="cuerpo"></div>`);
            $.getJSON( general_base_url + "Comisiones/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                $("#modal_colaboradores .modal-body #cuerpo").html("");
                document.getElementById('cuerpo').innerHTML = '';
                var_sum = 0;
                let fech = data1[0].fecha_plan;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                let fech2 = data1[0].fin_plan;
                let fecha2 = fech2.substr(0, 10);
                let nuevaFecha2 = fecha2.split('-');
                let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-3"><p style="color:gray;font-size:16px;">Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p></div><div class="col-lg-3"><p style="color:blue; font-size:14px;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div></div>');        
                $.each( data1, function( i, v){
                    valor_money = (( parseFloat(v.porcentaje) /100)* parseFloat(suma_01))
                    $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p></div>'
                    +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control input-gral" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-1"><b><p style="text-align:right">$</p></b></div><div class="col-md-4"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control ng-pristine input-gral" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                    +'</div>');
                    var_sum +=  parseFloat(v.porcentaje);
                    c++;
                });
                var_sum2 = parseFloat(var_sum);
                new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                new_valll2 = parseFloat((suma_01/100)*var_sum2);
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
            });
            $("#modal_colaboradores .modal-footer").append('<div class="row"><div class="col-md-10"><input type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"></div><div class="col-md-2"><input type="submit" id="btnplz1" class="btn btn-primary" value="DISPERSAR"></div></div>');
            $("#modal_colaboradores").modal();
        });
    });
});

let titulos = [];
$('#tabla_plaza_2 thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if (plaza_2.column(i).search() !== this.value) {
            plaza_2.column(i).search(this.value).draw();    
            var total = 0;
            var index = plaza_2.rows({ selected: true, search: 'applied' }).indexes();
            var data = plaza_2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.total);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_proceso").textContent = formatMoney(total);
        }
    });
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$("#tabla_plaza_2").ready( function(){
    let c=0;
    $('#tabla_plaza_2').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.total);
        });
        var to = formatMoney(total);
        document.getElementById("myText_proceso").textContent = to;
    });
    plaza_2 = $("#tabla_plaza_2").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'LISTADO COMISIONES PLAZA 2', 
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
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
        columns: [{
            "data": function( d ){
                return '<p class="m-0">COMISIÓN - <b>'+d.nombre+' '+d.apellido_paterno+'</b></p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">PLAN <b>'+d.id_plan+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<span class="label lbl-azure">DISPONIBLE</span>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.descripcion+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.total)+'</p>';
            }
        },
        { 
            "orderable": false,
            "data": function( d ){
                return '<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow dispersar_colaboradores" id="btndispersar" data-toggle="tooltip" data-placement="top" title="PARCIALIDAD" value="' + d.id_plan +'" data-residencial="'+d.idResidencial+'" data-empresa="'+d.empresa+'" data-value="' + d.ubicacion_dos +'"><i class="fas fa-chart-pie"></i></div>';   
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosNuevasMktd2",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $("#tabla_plaza_2 tbody").on("click", ".dispersar_colaboradores", function(){
        $("#btnplz2").button({ disabled: false });
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        let c=0;
        let ubication = $(this).attr("data-value");
        let empresa = $(this).attr("data-empresa");
        let residencial = $(this).attr("data-residencial");
        let plen = $(this).val();
        $.getJSON( general_base_url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen+"/"+empresa+"/"+residencial).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body ").append(`<div id="encabezado"></div>`);
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="num_plan" value="'+plen+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="empresa" value="'+empresa+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');
            $("#modal_colaboradores .modal-body ").append(`<div id="cuerpo"></div>`);
            $.getJSON( general_base_url + "Comisiones/getDatosColabMktd2/"+ubication+"/"+plen).done( function( data1 ){
                $("#modal_colaboradores .modal-body #cuerpo").html("");
                document.getElementById('cuerpo').innerHTML = '';
                var_sum = 0;
                let fech = data1[0].fecha_plan;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                let fech2 = data1[0].fin_plan;
                let fecha2 = fech2.substr(0, 10);
                let nuevaFecha2 = fecha2.split('-');
                let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-3"><p style="color:gray;font-size:16px;">Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p></div><div class="col-lg-3"><p style="color:blue; font-size:14px;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div></div>');
                $.each( data1, function( i, v){
                    valor_money = ((v.porcentaje/100)*suma_01)
                    $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p></div>'
                    +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control input-gral" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-1"><b><p style="text-align:right">$</p></b></div><div class="col-md-4 m-0"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control input-gral" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                    +'</div>');
                    var_sum +=  parseFloat(v.porcentaje);
                    c++;
                });
                var_sum2 = parseFloat(var_sum);
                new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                new_valll2 = parseFloat((suma_01/100)*var_sum2);
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
            });
            $("#modal_colaboradores .modal-footer").append('<div class="row"><div class="col-md-10"><input type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"></div><div class="col-md-2"><input type="submit" id="btnplz2" class="btn btn-primary" value="DISPERSAR"></div></div>');
            $("#modal_colaboradores").modal();
        });
    });
});

$("#tabla_compartidas").ready( function(){
    let titulos = [];
    $('#tabla_compartidas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead" placeholder="'+title+'"/>');
        $( 'input', this ).on('keyup change', function () {
            if (plaza_c.column(i).search() !== this.value ) {
                plaza_c.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_c.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_c.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.total);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_comp").textContent = formatMoney(total);
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    let c=0;
    $('#tabla_compartidas').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.total);
        });
        var to = formatMoney(total);
        document.getElementById("myText_comp").textContent = to;
    });
    plaza_c = $("#tabla_compartidas").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'COMISIONES COMPARTIDAS',
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
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
        columns: [{
            "data": function( d ){
                return '<p class="m-0">COMISIÓN - <b>'+d.nombre+' '+d.apellido_paterno+'</b></p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.s1+' / '+d.s2+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">PLAN <b>'+d.id_plan+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<span class="label lbl-azure">DISPONIBLE</span>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.descripcion+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.total)+'</p>';
            }
        },
        {
            "orderable": false,
            "data": function( d ){
                return '<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow dispersar_colaboradores" data-toggle="tooltip" data-placement="top" title="PARCIALIDAD" data-empresa="'+d.empresa+'" value="' + d.id_plan +','+d.sede1+','+d.sede2+'" data-value="' + d.ubicacion_dos +'"><i class="fas fa-chart-pie"></i></button></div>';   
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosNuevasCompartidas",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_compartidas tbody").on("click", ".dispersar_colaboradores", function(){
        $("#btnplz2").button({ disabled: false });
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        let c=0;
        let ubication = $(this).attr("data-value");
        let empresa  =$(this).attr("data-empresa");
        let d = $(this).val();
        let datos = d.split(',');
        let plen = datos[0];
        let sede1  = datos[1];
        let sede2 = datos[2];
        $.getJSON( general_base_url + "Comisiones/getDatosSumaMktdComp/"+ubication+"/"+plen+"/"+empresa+"/"+sede1+"/"+sede2).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body ").append(`<div id="encabezado"></div>`);
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="num_plan" value="'+plen+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="empresa" value="'+empresa+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
            $("#modal_colaboradores .modal-body #encabezado").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');
            $("#modal_colaboradores .modal-body ").append(`<div id="cuerpo"></div>`);
            $.getJSON( general_base_url + "Comisiones/getDatosColabMktdCompartida/"+ubication+"/"+plen+'/'+sede1+'/'+sede2).done( function( data1 ){
                $("#modal_colaboradores .modal-body #cuerpo").html("");
                document.getElementById('cuerpo').innerHTML = '';  
                var_sum = 0;
                let fech = data1[0].fecha_plan;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                let fech2 = data1[0].fin_plan;
                let fecha2 = fech2.substr(0, 10);
                let nuevaFecha2 = fecha2.split('-');
                let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-3"><p style="color:gray;font-size:16px;">Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p></div><div class="col-lg-3"><p style="color:blue; font-size:14px;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-3"><p style="color:green; font-size:14px;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div></div>');
                let cuantos19=0;
                $.each( data1, function( i, v){
                    let cuantos19 = data1[0]['valor'];
                    let porcentaje = v.porcentaje;
                    if(v.id_opcion == 20){
                        porcentaje = porcentaje/2;
                    }
                    if(v.id_opcion == 19 && cuantos19 == 2){
                        porcentaje = porcentaje/2;
                    }
                    if(v.id_opcion == 28 && v.id_plan == 9){
                        porcentaje = porcentaje/2;
                    }
                    if(v.id_opcion == 28 && v.id_plan == 11){
                        porcentaje = porcentaje/2;
                    }
                    if(v.id_opcion == 28 && v.id_plan == 12){
                        porcentaje = porcentaje/2;
                    }
                    
                    valor_money = ((porcentaje/100)*suma_01)
                    $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p></div>'
                    +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control input-gral" value="'+ porcentaje+'%'+'"></div>'+'<div class="col-md-1"><b><p style="text-align:right">$</p></b></div><div class="col-md-4"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control form-control input-gral" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                    +'</div>');
                    var_sum +=  parseFloat(porcentaje);
                    c++;
                });
                var_sum2 = parseFloat(var_sum);
                new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                new_valll2 = parseFloat((suma_01/100)*var_sum2);
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                $("#modal_colaboradores .modal-body #cuerpo").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
            });
            $("#modal_colaboradores .modal-footer").append('<div class="row"><div class="col-md-10"><input type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"></div><div class="col-md-2"><input type="submit" id="btnplzc" class="btn btn-primary" value="DISPERSAR"></div></div>');
            $("#modal_colaboradores").modal();
        });
    });
});

$("#tabla_planes").ready( function(){
    $('#tabla_planes thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead" placeholder="'+title+'"/>');
        $( 'input', this ).on('keyup change', function () {
            if (tabla_planes.column(i).search() !== this.value ) {
                tabla_planes.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_planes.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_planes.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.pago_cliente);
                });
                var to1 = formatMoney(total);
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    $('#tabla_planes').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
    });
    tabla_planes = $("#tabla_planes").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
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
        columns: [{  
            "data": function( d ){
                return '<p class="m-0">'+d.id_plan+'</p>';
            }
        },
        {
            "orderable": false,
            "data": function( d ){
                fe_crea = (d.fecha_plan).substr(0,10);
                var fecha = new Date(fe_crea);
                var dias = 1;  
                fecha.setDate(fecha.getDate() + dias);
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                return '<p class="m-0">'+(fecha.toLocaleDateString("es-ES", options))+'</p>';
            }
        },
        {
            "orderable": false,
            "data": function( d ){
                if(!d.fin_plan){
                    return '<p class="m-0"><b>ACTUAL</b></p>';
                }
                else{
                    fe_din = (d.fin_plan).substr(0,10);
                    var fecha = new Date(fe_din);
                    var dias = 1;  
                    fecha.setDate(fecha.getDate() + dias);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return '<p class="m-0">'+(fecha.toLocaleDateString("es-ES", options))+'</p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<div class="d-flex justify-center"><button class="btn-data btn-sky ver_plan_details" value="' + d.id_plan +'" title="VER DETALLES DE PLAN"><i class="fas fa-table"></i></button></div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosPlanesMktd",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });
    $("#tabla_planes tbody").on("click", ".ver_plan_details", function(){
        var tr = $(this).closest('tr');
        var row = tabla_planes.row( tr );
        $val_plan =  $(this).val();
        
        $("#modal_users .modal-body").html("");
        $.getJSON( general_base_url + "Comisiones/getDatosUsersMktd/"+$val_plan).done( function( data ){
            $.each( data, function( i, v){
                if(v.porcentaje!=0 && v.id_usuario!=0){
                    est = '<label style="color:green; font-size: 10px;"><i class="fa fa-check"></i><b>ACTIVO</b></label>';
                }
                else{
                    est = '<label style="color:red; font-size: 10px;"><i class="fa fa-close"></i> NO APLICA</label>';
                }
                if(v.plaza!="NA"){
                    plaz = v.plaza;
                }
                else{
                    plaz = '-';
                }
                if(v.sede!=null){
                    sed = '<b>'+v.sede+'</b>';
                }
                else{
                    sed = '-';
                }
                
                $("#modal_users .modal-body").append('<div class="row">'
                +'<div class="col-lg-4"> '+v.usuario+'<br><b>'+v.puesto+'</b></label></div>'
                +'<div class="col-lg-2"><b style="font-size: 12px;">'+v.porcentaje+'%</b></div>'
                +'<div class="col-lg-2" style="font-size: 10px;">'+plaz+'</div>'
                +'<div class="col-lg-2">'+sed+'</div>'
                +'<div class="col-lg-2">'+est+'</div>'
                +'</div>'
                +'</div><hr>');
            });
        });
        $("#modal_users").modal();
    }); 
});

$(document).on( "click", ".nuevo_plan", function(){
    $("#modal_mktd .modal-body").html("");
    $("#modal_mktd .modal-footer").html("");
    $.getJSON( general_base_url + "Comisiones/getDatosNuevo/").done( function( data1 ){
        $("#modal_mktd .modal-body").append('<div class="row mb-2"><div class="col-md-6"><label>Fecha inicio</label><input type="date" class="form-control beginDate" name="fecha_inicio" id="fecha_inicio" required="" style="border-radius: 25px!important; padding-right: 10px"></div></div>');
        $.each( data1, function( i, v){
            $("#modal_mktd .modal-body").append('<div class="row">'
            +'<div class="col-md-3"><br><input class="form-contol ng-invalid ng-invalid-required" style="border: 1px solid white; outline: none;" value="'+v.puesto+'"  readonly><input id="puesto" name="puesto[]" value="'+v.id_rol+'" type="hidden"></div>'
            +'<div class="col-md-3"><select id="userMKTDSelect'+i+'" name="userMKTDSelect[]" class="form-control userMKTDSelect select-gral" required data-live-search="true"></select></div>'
            +'<div class="col-md-2"><input id="porcentajeUserMk'+i+'" name="porcentajeUserMk[]" class="form-control porcentajeUserMk input-gral" required placeholder="%" value="0"></div>'
            +'<div class="col-md-2"><select id="plazaMKTDSelect'+i+'" name="plazaMKTDSelect[]" class="form-control plazaMKTDSelect select-gral" data-live-search="true"></select></div>'
            +'<div class="col-md-2"><select id="sedeMKTDSelect'+i+'" name="sedeMKTDSelect[]" class="form-control sedeMKTDSelect select-gral" data-live-search="true"></select></div></div>');
            $.post('getUserMk', function(data) {
                var len = data.length;
                for( var j = 0; j<len; j++){
                    var id = data[j]['id_usuario'];
                    var name = data[j]['name_user'];
                    $("#userMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if(len<=0){
                    $("#userMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                
                $("#userMKTDSelect"+i+"").val(data1[i].id_usuario);                     
                $("#userMKTDSelect"+i+"").selectpicker('refresh');
            }, 'json');
            $.post('getPlazasMk', function(data) {
                var len = data.length;
                for( var j = 0; j<len; j++){
                    var id = data[j]['id_opcion'];
                    var name = data[j]['nombre'];
                    $("#plazaMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if(len<=0){
                    $("#plazaMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#plazaMKTDSelect"+i+"").val(1); 
                $("#plazaMKTDSelect"+i+"").selectpicker('refresh');
            }, 'json');
            $.post('getSedeMk', function(data) {
                var len = data.length;
                for( var j = 0; j<len; j++){
                    var id = data[j]['id_sede'];
                    var name = data[j]['nombre'];
                    
                    $("#sedeMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if(len<=0){
                    $("#sedeMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                
                if(data1[i].id_rol=='20'){
                    $("#sedeMKTDSelect"+i+"").val(data1[i].id_sede);
                }
                else{
                    $("#sedeMKTDSelect"+i+"").val(2); 
                }
                $("#sedeMKTDSelect"+i+"").selectpicker('refresh');
            }, 'json'); 
        });
    });
    $("#modal_mktd .modal-footer").append('<br><div class="row d-flex align-center"><div class="col-md-9"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button></div><div class="col-md-3"><center><input type="submit" id="btnsubmit" class="btn btn-primary" value="GUARDAR"></center></div></div>');
    $("#modal_mktd").modal();
});

function resear_formulario(){
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');
    var validator = $( "#frmnewsol" ).validate();
    validator.resetForm();
    $( "#frmnewsol div" ).removeClass("has-error");
}

$("#cargar_xml").click( function(){
    subir_xml( $("#xmlfile") );
});

var justificacion_globla = "";
function subir_xml( input ){
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    resear_formulario();
    $.ajax({
        url: general_base_url + "Comisiones/cargaxml",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function(data){
            if( data.respuesta[0] ){
                documento_xml = xml;
                var informacion_factura = data.datos_xml;
                cargar_info_xml( informacion_factura );
                $("#solobs").val( justificacion_globla );
            }
            else{
                input.val('');
                alert( data.respuesta[1] );
            }
        },
        error: function( data ){
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}    

function cargar_info_xml( informacion_factura ){
    $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
    $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);
    $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
    $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);
    $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);
    $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
    $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);
    $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);
    $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);
    $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);
    $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);
    $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
}

$("#form_colaboradores").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        //bloquear boton 
        $("#btnplz1").button({ disabled: true });
        $("#btnplz2").button({ disabled: true });
        $("#btnplzc").button({ disabled: true });
        $('#spiner-loader').removeClass('hide');
        var data = new FormData( $(form)[0] );
        let sumat=0;
        let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
        let valor1 = parseFloat(valor-0.10);
        let valor2 = parseFloat(valor)+0.010;
        for(let i=0;i<$('#cuantos').val();i++){
            sumat += parseFloat($('#abono_mktd_'+i).val());
        }
        let sumat2 =  parseFloat((sumat).toFixed(3));
        document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';
        if(parseFloat(sumat2.toFixed(3)) < valor1){
            alerts.showNotification("top", "right", "Falta dispersar", "warning");
        }
        else if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
            $.ajax({
                url: general_base_url + "Comisiones/nueva_mktd_comision",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#spiner-loader').addClass('hide');
                        $("#modal_colaboradores").modal('toggle');
                        plaza_2.ajax.reload();
                        plaza_1.ajax.reload();
                        plaza_c.ajax.reload();
                        alerts.showNotification("top", "right", "¡Se agregó con éxito!", "success");
                        // alert("");
                    }else{
                        alerts.showNotification("top", "right", "NO SE HA PODIDO COMPLETAR LA SOLICITUD", "danger");
                        $('#spiner-loader').addClass('hide');
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

$("#frmnewsol").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("xmlfile", documento_xml);
        $.ajax({
            url: general_base_url + link_post,
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
                    $("#modal_formulario_solicitud").modal( 'toggle' );
                    tabla_nuevas.ajax.reload();
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });
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
            url: general_base_url + "Comisiones/save_new_mktd",
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

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

$(window).resize(function(){
    plaza_1.columns.adjust();
    plaza_2.columns.adjust();
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