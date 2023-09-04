let descuentosYCondiciones;
$('#li-plan').addClass(id_rol_global == 17 ? 'hidden' : '')
llenarTipoDescuentos();

sp = {
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true,
                debug: true
            }
        });
    }
}

$(document).ready(function(){
    $.post('getCatalogo', {
        id_catalogo: 90
    }, function (data) {        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusAut").append($('<option>').val(id).text(name));
                if(i == data.length -1) { 
                    $("#estatusAut").append($('<option>').val(0).text('Todos'));
                }
        } 
        if (len <= 0) {
            $("#estatusAut").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatusAut").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json'); 
});

function verificarEdicion(){
    if($('#idSolicitudAut').val() == ''){
    }else{
        $("#modalConfirm").modal();
    } 
}
$(document).on('click', '#btnCancel', function (e) { 
    $('#li-plan').addClass('active');
    $('#li-aut').removeClass('active');
    $('#nuevas-2').addClass('active');
    $('#nuevas-1').removeClass('active');
    $("#modalConfirm").modal('toggle');
});
$(document).on('click', '#btnLimpiar', function (e) {
        tablaAutorizacion.ajax.reload();
        document.getElementById('form-paquetes').reset();
        $("#sede").selectpicker("refresh");
        $('#residencial option').remove();
        document.getElementById('showPackage').innerHTML = '';
        $('#index').val(0);
        $('#idSolicitudAut').val('');
        $('#paquetes').val('');	
        document.getElementById('accion').value = 1;
        setInitialValues();
        sinPlanesDiv();
        $(".leyendItems").addClass('d-none');
        $("#btn_save").addClass('d-none');
        $("#modalConfirm").modal('toggle');
});

    let titulos = [];
    $('#autorizacionesPVentas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tablaAutorizacion.column(i).search() !== this.value) {
                tablaAutorizacion.column(i).search(this.value).draw();
                var index = tablaAutorizacion.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
            }
        });
    });

    ConsultarTabla();
    function ConsultarTabla(opcion = 1,anio = '',estatus = ''){
    tablaAutorizacion = $("#autorizacionesPVentas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'AUTORIZACIONES PLANES DE VENTAS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header:  function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            },
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
        columns: [{  
            "data": function( d ){
                return '<p class="m-0">'+d.id_autorizacion+'</p>';
            }
        },
        {  
            "data": function( d ){
                return `<p class="m-0">${d.sede}</p>`;
            }
        },
        {  
            "data": function( d ){
                let residencial = d.nombreResidencial.split(',');
                
                let imprimir = '';
                for (let m = 0; m < residencial.length; m++) {
                    imprimir += `<p><span class="label lbl-sky">${residencial[m]}</span></p>`;
                }
                
                return imprimir;
            }
        },
        {  
            "data": function( d ){
                let fecha_inicio = moment(d.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY');
                return `<p class="m-0"><b>${fecha_inicio}</b></p>`;
            }
        },
        {
            "data": function( d ){
                let fecha_fin = moment(d.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY');
                return `<p class="m-0"><b>${fecha_fin}</b></p>`;
            }
        },
        {
            "data": function( d ){
                return `<p class="m-0">${d.tipoLote}</p>`;
            }
        },
        {  
            "data": function( d ){
                    return `<p class="m-0">${d.tipoSuperficie}</p>`;  
            }
        },
        {
            "data": function( d ){
                    return `<p class="m-0"><span class="label ${d.colorEstatus}">${d.estatusA}</span></p>`;  
            }
        },
        {
            "data": function( d ){
                let fecha_creacion = moment(d.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
                return `<p class="m-0">${fecha_creacion}</p>`;
        }
        },
        {  
            "data": function( d ){
                return `<p class="m-0">${d.creadoPor}</p>`;
            }
        },
        {  
            "data": function( d ){
                $('[data-toggle="tooltip"]').tooltip();
                let botones = '';
                switch(id_rol_general){
                    case 5:
                        if(d.estatus_autorizacion == 1){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus_autorizacion);
                        }
                        if(d.estatus_autorizacion == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus_autorizacion);
                        }
                        if(d.estatus_autorizacion == 4){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus_autorizacion);
                        }
                    break;
                    case 17:
                        if(d.estatus_autorizacion == 2){
                            botones += botonesPermiso(1,0,1,1,d.id_autorizacion,d.estatus_autorizacion);
                        }
                        if(d.estatus_autorizacion == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus_autorizacion);
                        }
                        if(d.estatus_autorizacion == 4){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus_autorizacion);
                        }
                    break;
                }
                botones += `<button data-idAutorizacion="${d.id_autorizacion}" id="btnHistorial" class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Historial de movimientos"><i class="fas fa-info"></i></button>`; ;
                return '<div class="d-flex justify-center">' + botones + '<div>';
            }
        }],
        columnDefs: [{}],
        ajax: {
            "url": general_base_url + "PaquetesCorrida/getAutorizaciones",
            "type": "POST",
            cache: false,
            data: {
                "opcion": opcion,
                "anio": anio,
                "estatus":estatus
            }
        },
        order: [
            [1, 'asc']
        ]
    });
    $('#autorizacionesPVentas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

function botonesPermiso(permisoVista,permisoEditar,permisoAvanzar,permisoRechazar,idAutorizacion,estatus_autorizacion){
        let botones = '';
            if(permisoVista == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnVer" class="btn-data btn-sky" data-toggle="tooltip" data-placement="top" title="Ver planes de venta"><i class="fas fa-eye"></i></button>`;   }
            if(permisoEditar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnEditar" class="btn-data btn-yellow" data-toggle="tooltip" data-placement="top" title="Editar planes"><i class="fas fa-edit"></i></button>`; }
            if(permisoAvanzar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="1" data-estatus="${estatus_autorizacion}" id="btnAvanzar" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Avanzar autorización"><i class="fas fa-thumbs-up"></i></button>`;  }
            if(permisoRechazar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="2" data-estatus="${estatus_autorizacion}" id="btnAvanzar" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar autorización"><i class="fas fa-thumbs-down"></i></button>`;  }
        return  botones;
    }

    $(document).on('click', '#btnEditar', function (e) {
        e.preventDefault();
        $('#spiner-loader').removeClass('hide');
        var data = tablaAutorizacion.row($(this).parents('tr')).data();
        document.getElementById('fechainicio').value = data.fecha_inicio;
        document.getElementById('fechafin').value = data.fecha_fin;
        document.getElementById('accion').value = 2;
        document.getElementById('idSolicitudAut').value = data.id_autorizacion;
        document.getElementById('paquetes').value = data.paquetes;
        $('#li-plan').addClass('active');
        $('#li-aut').removeClass('active');
        $('#nuevas-2').addClass('active');
        $('#nuevas-1').removeClass('active');
        $("#sede").selectpicker();
        $('#sede').val(parseInt(data.id_sede)).trigger('change');
        $("#sede").selectpicker('refresh');
        let residencialesSelect = [];
        $("#residencial").selectpicker();
        let residenciales = data.idResidencial.split(',');
        for (let m = 0; m < residenciales.length; m++) {
            residencialesSelect.push(residenciales[m]);
        }
        setTimeout(() => {
            $(`#residencial`).val(residencialesSelect).trigger('change');
        }, 1000);

        $("#residencial").selectpicker('refresh');
        var radios = document.getElementsByName('tipoLote');

        for (var j = 0; j < radios.length; j++) {
            if (radios[j].value == data.tipo_lote) {
            radios[j].checked = true;
                break;
            }
        }
        validateAllInForm(data.tipo_lote,1);
        var radios = document.getElementsByName('superficie');
        
        for (var j = 0; j < radios.length; j++) {
            if (radios[j].value == data.superficie) {
                radios[j].checked = true;
                break;
            }
        }
        selectSuperficie(data.superficie);
        const scroll=document.querySelector(".ps-scrollbar-y-rail");
        scroll.scrollTop=0;
        $('#btn_consultar').prop('disabled', true);
        setTimeout(() => {
            ConsultarPlanes();
        }, 1000);
    });
   
    $(document).on('click', '#btnAvanzar', function () {
        let idAutorizacion = $(this).attr('data-idAutorizacion');
        let estatus = $(this).attr('data-estatus');
        let tipo = $(this).attr('data-tipo');
        tipo == 1  ? $('#modalAutorizacion').addClass("modal-sm") : $('#modalAutorizacion').addClass("modal-md") ;
        document.getElementById('titleAvance').innerHTML = tipo == 1 ? '¿Estás seguro de avanzar está autorización?' : '¿Estás seguro de rechazar está autorización?';
        $('#id_autorizacion').val(idAutorizacion);
        $('#estatus').val(estatus);
        $('#tipo').val(tipo);
        document.getElementById('modal-body').innerHTML = tipo == 2 ? `<textarea class="text-modal scroll-styles" max="255" type="text" name="comentario" id="comentario" autofocus="true" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Escriba aquí su comentario"></textarea>
        <b id="text-observations" class="text-danger"></b>` : ''; 
        $("#avanzarAut").modal();
    });
    
    $(document).on('submit', '#avanceAutorizacion', function (e) {
        e.preventDefault();
        let tipo = $('#tipo').val();
        let data = new FormData($(this)[0]);
        $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: "avanceAutorizacion",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                response = JSON.parse(response);
                if (response.estatus == 1) {
                    $("#avanzarAut").modal("hide");
                    tipo == 1  ? $('#modalAutorizacion').removeClass("modal-sm") : $('#modalAutorizacion').removeClass("modal-md") ;
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", response.respuesta, "success");
                    tablaAutorizacion.ajax.reload(null,false);    
                }
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    });

    $(document).on('click', '#searchByEstatus', function () { 
        if($('#estatusAut').val() == '' || $('#anio').val() == ''){
            alerts.showNotification("top", "right", "Debe seleccionar ambas opciones.", "warning");
        }else{
            let estatus = $('#estatusAut').val();
            let anio = $('#anio').val();
            ConsultarTabla(2,anio,estatus);
        }
    });

    $(document).on('click', '#btnHistorial', function () {
        let idAutorizacion = $(this).attr('data-idAutorizacion');
        document.getElementById('historialAut').innerHTML = '';
            $.post('getHistorialAutorizacion', {
                id_autorizacion: idAutorizacion
            }, function (data) {      
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    let estatus=data[i]['estatus'];
                    let comentario = data[i]['comentario'];
                        $('#historialAut').append(`
                        <div class="d-flex mb-2">
                            <div class="w-10 d-flex justify-center align-center">
                                <span style="width:40px; height:40px; display:flex; justify-content:center; align-items:center; border-radius:27px; background-color: ${estatus == 1 ? '#28B46318' : '#c0131318' }">
                                    <i class="fas ${estatus == 1 ? 'fa-check' : 'fa-close' } fs-2" style="color: ${estatus == 1 ? '#28B463' : '#c01313'} "></i>
                                </span>
                            </div>
                            <div class="w-90">
                                <b>${data[i]['creadoPor']}</b>
                                <p class="m-0" style="font-size:12px">${comentario}</p> 
                                <p class="m-0" style="font-size:10px; line-height:12px; color:#999">${moment(data[i]['fecha_movimiento'].split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')}</p>
                            </div>
                        </div>`)
                }
            }, 'json');
        $("#modalHistorial").modal();
    });



    $(document).on('click', '#btnVer', function () {
        $('#spiner-loader').removeClass('hide');
        var data = tablaAutorizacion.row($(this).parents('tr')).data();
        let residenciales = data.nombreResidencial.split(',');
        let fecha_inicio = moment(data.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY');
        let fecha_fin = moment(data.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY');
        let params = {'paquetes': data.paquetes};
        document.getElementById('contentView').innerHTML = '';  
        $('#contentView').append(`
        <div style="line-height: 15px;padding-bottom: 10px;">
            <p class="m-0"><small style="font-size:10px"><b>Rango de fechas: </b></small>${fecha_inicio} - ${fecha_fin}</p>
            <p class="m-0"><small style="font-size:10px"><b>Sede: </b></small>${data.sede}</p>
            <p class="m-0"><small style="font-size:10px"><b>Residencial(es): </b></small>${residenciales.map(function (element) { return `${element} </p>`})}
            <p class="m-0"><small style="font-size:10px"><b>Tipo lote: </b></small>${data.tipoLote}</p>
            <p class="m-0"><small style="font-size:10px"><b>Superficie: </b></small>${data.tipoSuperficie}</p>
        </div>
        <div class="row scroll-styles" style="height: 420px; overflow: auto">
            <div class="col-lg-12" id="cards" style="padding: 0 40px"></div>
        </div>
        `);
        
        let tiposDescuentos = descuentosYCondiciones;
        $.post('paquetesView',params, function(data) {
            data = JSON.parse(data);
            let dataPaquetes = data[0].paquetes;
            let dataDescuentosByPlan = data[0].descuentos;
            for (let m = 0; m < dataPaquetes.length; m++) {
                let idPaquete = dataPaquetes[m].id_paquete;
                let existe = dataDescuentosByPlan.find(elementD => elementD.id_paquete == idPaquete)
                let descuentosByPlan = dataDescuentosByPlan.filter(desc => desc.id_paquete == idPaquete);
                if(existe != undefined){
                    crearDivs(dataPaquetes[m],tiposDescuentos,descuentosByPlan);
                }
                if(m == dataPaquetes.length -1){
                    $('#spiner-loader').addClass('hide');
                }
            }
        });

        $("#modalView").modal();
        $('#spiner-loader').addClass('hide');
    });

    function crearDivs(dataPaquete,tiposDescuentos,descuentosPorPlan){
        $('#cards').append(`
            <div class="card mb-0" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; border: 1px solid #eaeaea;">
                <div class="box"> 
                    <h6 class="overflow-text" style="color: #4e4e4e; border-bottom: 1px solid #eaeaea; padding: 10px 10px 5px 10px; margin-top: 0; border-radius: 5px 5px 0 0;" data-toggle="tooltip" data-placement="right" title="${dataPaquete.descripcion}"><b>${dataPaquete.descripcion}</b></h6>
                    <span>
                        <div style="padding-bottom: 15px" id="descuentosP_${dataPaquete.id_paquete}">
                        </div>
                    </span>
                </div>
            </div>
        `);

        for (let m = 0; m < tiposDescuentos.length; m++) {
            
            let existe = descuentosPorPlan.find(elementD => elementD.id_paquete == dataPaquete.id_paquete &&  elementD.id_condicion == tiposDescuentos[m].condicion.id_condicion);
            
            if(existe != undefined){
                $(`#descuentosP_${dataPaquete.id_paquete}`).append(`
                <p class="m-0">${tiposDescuentos[m].condicion.descripcion}</p>
                <div id="tipoDescPaquete_${dataPaquete.id_paquete}_${tiposDescuentos[m].condicion.id_condicion}"></div>
            `);
            let existe = descuentosPorPlan.find(elementD => elementD.id_paquete == dataPaquete.id_paquete &&  elementD.id_condicion == tiposDescuentos[m].condicion.id_condicion);
            if(existe != undefined){
                let descuentosByPlan = descuentosPorPlan.filter(desc => desc.id_paquete == dataPaquete.id_paquete);
                for (let o = 0; o < descuentosByPlan.length; o++) {
                    if(descuentosByPlan[o].id_condicion == tiposDescuentos[m].condicion.id_condicion){
                        let porcentaje = descuentosByPlan[o].id_condicion == 4 || descuentosByPlan[o].id_condicion == 12 ? '$'+formatMoney(descuentosByPlan[o].porcentaje) : (descuentosByPlan[o].id_condicion == 13 ? descuentosByPlan[o].porcentaje : descuentosByPlan[o].porcentaje + '%'  )
                        $(`#tipoDescPaquete_${dataPaquete.id_paquete}_${tiposDescuentos[m].condicion.id_condicion}`).append(`
                            <span class="label lbl-green" style="margin: 0 5px">${porcentaje} ${descuentosByPlan[o].id_condicion == 13 ? '' :(descuentosByPlan[o].msi_descuento != null && descuentosByPlan[o].msi_descuento != 0 ? ' +  '+descuentosByPlan[o].msi_descuento+'MSI' : '')}</span>`);
                    }
                }
            }       
        }
        $('[data-toggle="tooltip"]').tooltip()
    }
} 
    $(document).ready(function() {
        $.post(general_base_url+"PaquetesCorrida/lista_sedes", function (data) {
            $('[data-toggle="tooltip"]').tooltip()
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#sede").selectpicker('refresh');
        }, 'json');
    
        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({ locale: 'es' });
        setInitialValues();
        sinPlanesDiv();
    });

    

    async function llenarTipoDescuentos(){
        descuentosYCondiciones = await getDescuentosYCondiciones();
        descuentosYCondiciones = JSON.parse(descuentosYCondiciones);
    }

    $("#sede").change(function() {
        $('#spiner-loader').removeClass('hide');
        $('#residencial option').remove();
        var	id_sede = $(this).val();
    
        $.post('getResidencialesList/'+id_sede,{async: true}, function(data) {
            $('#spiner-loader').addClass('hide');
            $("#residencial").append($('<option disabled>').val("default").text("SELECCIONA UNA OPCIÓN"));
            var len = data.length;
            for( var i = 0; i<len; i++){
                var name = data[i]['nombreResidencial']+' '+data[i]['descripcion'];
                var id = data[i]['idResidencial'];
                $("#residencial").append(`<option value='${id}'>${name}</option>`);
            }   
            if(len<=0){
                $("#residencial").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#residencial").selectpicker('refresh');
        }, 'json'); 
    });
    
    $("#residencial").select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown"});
    
    function addDescuento(id_condicion, descripcion){
        $('#descuento').val('');
        $('#label_descuento').html();
        $('#id_condicion').val(id_condicion);
        $('#nombreCondicion').val(descripcion);
        $('#label_descuento').html('Agregar descuento a "' + descripcion +'"');
        $('#ModalFormAddDescuentos').modal();
    };
    
    $("input[data-type='currency']").on({
        keyup: function() {
            let id_condicion = $('#id_condicion').val();
            if(id_condicion == 12 || id_condicion == 4){
                formatCurrency($(this));
            }
        },
        blur: function() { 
            let id_condicion = $('#id_condicion').val();
            if(id_condicion == 12 || id_condicion == 4){
                formatCurrency($(this), "blur");
            }
        }
    });
    
    function formatCurrency(input, blur) {
        var input_val = input.val();
        if (input_val === "") { return; }
        var original_len = input_val.length;
        var caret_pos = input.prop("selectionStart");
        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            if (blur === "blur") {
                right_side += "00";
            }
            right_side = right_side.substring(0, 2);
            input_val = "$" + left_side + "." + right_side;
        } else {
            input_val = formatNumber(input_val);
            input_val = "$" + input_val;
            if (blur === "blur") {
                input_val += ".00";
            }
        }
    
        input.val(input_val);
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function getDescuentosYCondiciones(){
        $('#spiner-loader').removeClass('hide');
        return new Promise ((resolve, reject) => {   
            $.ajax({
                type: "POST",
                url: `getDescuentosYCondiciones`,
                cache: false,
                success: function(data){
                    primeraCarga = 0;
                    resolve(data);
                    $('#spiner-loader').addClass('hide');
                },
                error: function() {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });
    }
    
    //Fn para construir las tablas según el número de condiciones existente, esto en la modal para ver condiciones
    async function construirTablas(){
        //if(primeraCarga == 1){
        //    descuentosYCondiciones = await getDescuentosYCondiciones(primeraCarga, 0);
        //    descuentosYCondiciones = JSON.parse(descuentosYCondiciones);
        //    primeraCarga = 0;
        //}
        
        descuentosYCondiciones.forEach(element => {
            let descripcion = element['condicion']['descripcion'];
            let id_condicion = element['condicion']['id_condicion'];
            let dataCondicion = element['data'];
            let title = (descripcion.replace(/ /g,'')).replace(/[^a-zA-Z ]/g, "");
            
            $('#table'+title+' thead tr:eq(0) th').each( function (i) {
                var subtitle = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+subtitle+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#table' + title).column(i).search() !== this.value ) {
                        $('#table' + title).column(i).search(this.value).draw();
                    }
                });
            });
            
            $("#table"+title).DataTable({
                dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
                width: "auto",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DESCUENTOS AL '+ descripcion.toUpperCase()
                },
                {
                    text: `<a href="#" onclick="addDescuento(${id_condicion}, '${descripcion}');">Agregar descuento</a>`,
                    className: 'btn-azure',
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
                    data: 'id_descuento'
                },
                {
                    data: function (d) {
                        return d.porcentaje + '%';
                    }
                }
                ],
                data: dataCondicion,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    searchable:false,
                    className: 'dt-body-center'
                }],
                order: [
                    [1, 'desc']
                ]
            });
        });
    
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    //Fn para agregar nuevo descuento
    $("#addNewDesc").on('submit', function(e){
        e.preventDefault();
        $('#spiner-loader').removeClass('hide');
    
        let formData = new FormData(document.getElementById("addNewDesc"));
        let nombreCondicion = (($("#nombreCondicion").val()).replace(/ /g,'')).replace(/[^a-zA-Z ]/g, "");
        $.ajax({
            url: 'SaveNewDescuento',
            data: formData,
            method: 'POST',
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                data =  JSON.parse(data);
                if ( data['status'] = 402 ){
                    descuentosYCondiciones.forEach(element => {
                        if ( element['condicion']['id_condicion'] == data['detalle'][0]['condicion']['id_condicion'] ){
                            element['data'] = [];
                            element['data'] = data['detalle'][0]['data'];
    
                            $("#table"+nombreCondicion).DataTable().clear().rows.add(element['data']).draw();
                        }
                    });
                }
    
                alerts.showNotification("top", "right", ""+data["mensaje"]+"", ""+data["color"]+"");
    
                //Se cierra el modal
                $('#ModalFormAddDescuentos').modal('toggle');
                document.getElementById('addNewDesc').reset();
                $('#spiner-loader').addClass('hide');
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            },
            async: false
        });
    });
    
    //Plantilla para crear tarjeta de los planes de ventas (cascarón principal)
    function templateCard(index, objPlan = ''){
        let value = `${objPlan != '' ? 'value="' + objPlan['descripcion'] + '"' : ''}`
        $('#showPackage').append(`
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="card_${index}">
            <div class="cardPlan dataTables_scrollBody">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="title d-flex justify-center align-center">
                                <h3 class="card-title">Plan</h3>
                                <button type="button" class="btn-trash" data-toggle="tooltip" data-placement="left" title="Eliminar plan" id="btn_delete_${index}" onclick="removeElementCard('card_${index}')"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="text" class="inputPlan" required name="descripcion_${index}" id="descripcion_${index}" placeholder="Descripción del plan (*)" `+value+`>
                            <div class="mt-1" id="checks_${index}">
                                <div class="loadCard w-100">
                                    <img src= '`+general_base_url+`dist/img/loadingMini.gif' alt="Icono gráfica" class="w-30">
                                </div>
                            </div>						
                            <div class="form-group col-md-12" id="tipo_descuento_select_${index}" hidden>
                        </div>
                    </div>
                </div>
            </div>
        </div>`);
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    //Plantilla para crear selects según número de condiciones e insertar en la plantilla del plan
    function templateSelectsByCard(indexNext, indexCondiciones, idCondicion, nombreCondicion){
        $("#tipo_descuento_"+indexNext).append(`<option value='${idCondicion}'>${nombreCondicion}</option>`);
        $("#checks_"+indexNext).append(`
        <div class="row boxAllDiscounts">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="check__item" for="inlineCheckbox1">
                    <label>
                        <input type="checkbox" class="default__check d-none" id="inlineCheckbox1_${indexNext}_${indexCondiciones}" value="${idCondicion}" onclick="PrintSelectDesc(this, '${nombreCondicion}', ${idCondicion}, ${indexCondiciones}, ${indexNext})">
                        ${nombreCondicion}
                        <span class="custom__check"></span>
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="boxDetailDiscount hidden">
                    <div class="w-100 mb-1" id="selectDescuentos_${indexNext}_${indexCondiciones}"></div>
                </div>
            </div>
        </div>`);
    }
    
    async function GenerarCard(){
        if($('#sede').val() != '' && $('#residencial').val() != '' && $('input[name="tipoLote"]').is(':checked') && $('#fechainicio').val() != '' && $('#fechafin').val() != '' && $('input[name="superficie"]').is(':checked') ){
            var indexActual = document.getElementById('index');
            var indexNext = (document.getElementById('index').value - 1) + 2;
            indexActual.value = indexNext;
            
            templateCard(indexNext);
            //if(primeraCarga == 1){
            //    descuentosYCondiciones = await getDescuentosYCondiciones(primeraCarga, 0);
            //    descuentosYCondiciones = JSON.parse(descuentosYCondiciones);
            //    primeraCarga = 0;
            //}
            
            $("#checks_"+indexNext).html('');
            $("#tipo_descuento_"+indexNext).append($('<option>').val("default").text("SELECCIONA UNA OPCIÓN"));
            var len = descuentosYCondiciones.length;
    
            descuentosYCondiciones.forEach(function (element, indexCondiciones) {
                let idCondicion = element['condicion']['id_condicion'];
                let nombreCondicion = element['condicion']['descripcion'];
                templateSelectsByCard(indexNext, indexCondiciones, idCondicion, nombreCondicion);
            });
    
            if(len<=0){
                $("#tipo_descuento_"+indexNext).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
    
            $("#tipo_descuento_"+indexNext).selectpicker('refresh');
            validateNonePlans();
        }
        else{
            alerts.showNotification("top", "right", "Debe llenar todos los campos requeridos.", "warning");
        }
    }
    
    //Guardar nuevo paquetes de planes de venta según attr seleccionados
    function SavePaquete(){
        let formData = new FormData(document.getElementById("form-paquetes"));
        $.ajax({
            url: 'SavePaquete',
            data: formData,
            method: 'POST',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#ModalAlert .btnSave').attr("disabled","disabled");
                $('#ModalAlert .btnSave').css("opacity",".5");
            },
            success: function(data) {
                $('#ModalAlert .btnSave').prop('disabled', false);
                $('#ModalAlert .btnSave').css("opacity","1");
                if(data == 1){
                    tablaAutorizacion.ajax.reload();
                    tablaAutorizacion.columns.adjust();
                    ClearAll();
                    alerts.showNotification("top", "right", "Planes almacenados correctamente.", "success");	
                }else{
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            
            },
            error: function(){
                $('#ModalAlert .btnSave').prop('disabled', false);
                $('#ModalAlert .btnSave').css("opacity","1");
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            },
            async: false
        });
    }
    
    //Fn para consultar los planes de ventas existente según parametros seleccionados
    async function ConsultarPlanes(){
        $('#paquetes').val() == '' ? $('#spiner-loader').removeClass('hide'): '';
        if($('#sede').val() != '' && $('#residencial').val() != '' && $('input[name="tipoLote"]').is(':checked') && $('#fechainicio').val() != '' && $('#fechafin').val() != '' && $('input[name="superficie"]').is(':checked') ){
            let params = {
                'sede':$('#sede').val(),
                'residencial':$('#residencial').val(),
                'superficie':$('#super').val(),
                'fin':$('#fin').val(),
                'tipolote':$('#tipo_l').val(),
                'fechaInicio':$('#fechainicio').val(),
                'fechaFin':$('#fechafin').val(),
                'paquetes':$('#paquetes').val(),
                'accion':$('#accion').val()};
            ClearAll2();
    
          //  if(primeraCarga == 1){
          //      descuentosYCondiciones = await getDescuentosYCondiciones(primeraCarga, 0);
          //      descuentosYCondiciones = JSON.parse(descuentosYCondiciones);
          //      primeraCarga = 0;
          //  }
    
            $.post('getPaquetes',params, function(data) {
                if( data.length >= 1){
                    let dataPaquetes = data[0].paquetes;
                    let dataDescuentosByPlan = data[0].descuentos;
                    
                    
                    dataPaquetes.forEach(function (element, indexPaquetes) {
                        let idPaquete = element.id_paquete;
                        
                        var indexActual = document.getElementById('index');
                        var indexNext = (document.getElementById('index').value - 1) + 2;
                        indexActual.value = indexNext;
    
                        templateCard(indexNext, element);
    
                        $("#checks_"+indexNext).html('');
                        $("#tipo_descuento_"+indexNext).append($('<option>').val("default").text("SELECCIONA UNA OPCIÓN"));
                        let lenDesCon = descuentosYCondiciones.length;
    
                        descuentosYCondiciones.forEach(function (subelement, indexCondicion) {                        
                            let idCondicion = subelement['condicion']['id_condicion'];
                            let nombreCondicion = subelement['condicion']['descripcion'];
                            
                            templateSelectsByCard(indexNext, indexCondicion, idCondicion, nombreCondicion);
                            let existe = dataDescuentosByPlan.find(elementD => elementD.id_paquete == idPaquete &&  elementD.id_condicion == idCondicion);
                            let descuentosByPlan = dataDescuentosByPlan.filter(desc => desc.id_paquete == idPaquete);
                            if(existe != undefined){
                                const check =  document.getElementById(`inlineCheckbox1_${indexNext}_${indexCondicion}`);
                                check.checked = true; 
                                PrintSelectDesc(check, nombreCondicion, idCondicion, indexCondicion, indexNext, descuentosByPlan, lenDesCon, indexPaquetes);
                                if(indexPaquetes == dataPaquetes.length -1){
                                    $('#spiner-loader').addClass('hide');
                                }
                            }                  
                        });
                    
                        if( lenDesCon <= 0 ){
                            $("#tipo_descuento_"+indexNext).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
    
                        $("#tipo_descuento_"+indexNext).selectpicker('refresh');    
                        validateNonePlans();
                    });
                }
                else{
                    alerts.showNotification("top", "right", "No se encontraron planes con los datos proporcionados", "warning");
                }
            }, 'json');
        }
        else{
            alerts.showNotification("top", "right", "Debe llenar todos los campos requeridos.", "warning");
        }        
    }
    
    $("#form-paquetes").on('submit', function(e){ 
        e.preventDefault();
        $("#ModalAlert").modal();
    });
    
    function ClearAll2(){
        document.getElementById('showPackage').innerHTML = '';
        $('#index').val(0);	
        $(".leyendItems").addClass('d-none');
        $("#btn_save").addClass('d-none');
    }
    
    function ClearAll(){
        $("#ModalAlert").modal('toggle');
        document.getElementById('form-paquetes').reset();
        $("#sede").selectpicker("refresh");
        $('#residencial option').remove();
        document.getElementById('showPackage').innerHTML = '';
        $('#index').val(0);	
        $('#idSolicitudAut').val('');
        setInitialValues();
        sinPlanesDiv();
        $(".leyendItems").addClass('d-none');
        $("#btn_save").addClass('d-none');
    }
    
    function ValidarOrden(indexN,i){
        let seleccionado = $(`#orden_${indexN}_${i}`).val();	
        for (let m = 0; m < 4; m++) {
            if(m != i){
                if( $(`#orden_${indexN}_${m}`).val() == seleccionado && seleccionado != ""){
                    $(`#orden_${indexN}_${i}`).val("");
                    alerts.showNotification("top", "right", "Este número ya se ha seleccionado.", "warning");
                }	
            }
        }
    }
    
    function llenar(e, indexGral, indexCondiciones, dataDescuentosByPlan, id_select, idCondicion, lenDesCon, indexPaquetes){
        //var boxDetail = $(e).closest('.boxAllDiscounts' ).find('.boxDetailDiscount');
        //boxDetail.removeClass('hidden');

        
        let tipo = 0;
        if(idCondicion == 4 || idCondicion == 12){
            tipo = 1;
        }
        let descuentosSelected = [];
        dataDescuentosByPlan = dataDescuentosByPlan.filter(desc => desc.id_condicion == idCondicion);
        dataDescuentosByPlan = dataDescuentosByPlan.sort();
        console.log(dataDescuentosByPlan)
        for (let m = 0; m < dataDescuentosByPlan.length; m++) {
            if(idCondicion != 13){                
                descuentosSelected.push(dataDescuentosByPlan[m].id_descuento);
            }
            else{
                descuentosSelected.push(dataDescuentosByPlan[m].id_descuento+','+parseInt(dataDescuentosByPlan[m].porcentaje));
            }
        }
        $(`#${id_select}${indexGral}_${indexCondiciones}`).select2().val(descuentosSelected).trigger('change');

        if( indexPaquetes == lenDesCon -1 ){
            $('#spiner-loader').addClass('hide');
        }
    }

    function selectItem(target, id) { // refactored this a bit, don't pay attention to this being a function
        var option = $(target).children('[value='+id+']');
        option.detach();
        $(target).append(option).change();
      } 
      
      function customPreSelect() {
        let items = $('#selected_items').val().split(',');
        $("select").val('').change();
        initSelect(items);
      }
      
      function initSelect(items) { // pre-select items
        items.forEach(item => { // iterate through array of items that need to be pre-selected
          let value = $('select option[value='+item+']').text(); // get items inner text
          $('select option[value='+item+']').remove(); // remove current item from DOM
          $('select').append(new Option(value, item, true, true)); // append it, making it selected by default
        });
      }
 
    
     //Se introducen todas las opcines para cada uno de los select que pertenecen a un plan
     function PrintSelectDesc(e, nombreCondicion, idCondicion, indexCondiciones, indexGral, dataDescuentosByPlan=[], lenDesCon = 0, indexPaquetes = 0){
        nombreCondicion = (nombreCondicion.replace(/ /g,'')).replace(/[^a-zA-Z ]/g, "");
        var boxDetail = $(e).closest('.boxAllDiscounts' ).find('.boxDetailDiscount');
        boxDetail.removeClass('hidden');
        let descuentosArray = descuentosYCondiciones[indexCondiciones]['data'];

        //Si la condición en el plan ES checkeada
        if($(`#inlineCheckbox1_${indexGral}_${indexCondiciones}`).is(':checked')){
            $(`#orden_${indexGral}_${indexCondiciones}`).prop( "disabled", false );
            
            $(`#selectDescuentos_${indexGral}_${indexCondiciones}`).append(`
            <div class="w-100 d-flex justify-center align-center">
                <select id="ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}" required name="${indexGral}_${indexCondiciones}_ListaDescuentos${nombreCondicion}_[]" multiple class="form-control" data-live-search="true">
            </div>`);



            descuentosArray.forEach(element => {
                let porcentaje = element['porcentaje'];
                let id_descuento = `${idCondicion == 13 ? element['id_descuento'] +','+ element['porcentaje'] : element['id_descuento'] }`;
                
                $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).append(`<option value='${id_descuento}' label="${porcentaje}">${idCondicion == 4 || idCondicion == 12 ? '$'+formatMoney(porcentaje) : (idCondicion == 13 ? porcentaje : porcentaje + '%'  ) }</option>`);
            });


                    
            if( descuentosArray.length <= 0){
                $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
    
            if( dataDescuentosByPlan.length > 0 ){
                                                        
                llenar(e, indexGral, indexCondiciones, dataDescuentosByPlan, `ListaDescuentos${nombreCondicion}_`, idCondicion, lenDesCon, indexPaquetes);

               
            }
            


            //Propiedades que asignaremos a los select
                                                        $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).select2({
                                                            allow_single_deselect: false,
                                                            containerCssClass: "select-gral",
                                                            dropdownCssClass: "custom-dropdown",
                                                            tags: false, 
                                                            tokenSeparators: [',', ' '], 
                                                            closeOnSelect : false,
                                                            placeholder : "SELECCIONA UNA OPCIÓN",
                                                            allowHtml: true, 
                                                            allowClear: true});
                 //Acciones que se ejecutaran cuando SE selecciona un descuento de una condición
            //     $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).select2({allow_single_deselect: false,containerCssClass: "select-gral", dropdownCssClass: "custom-dropdown", tags: true, tokenSeparators: [',', ' '], closeOnSelect : false, placeholder : "Seleccione una opción", allowHtml: true, allowClear: true});

                // $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).off('select2:select');
                 $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).on("select2:select", function (evt){            
                    let element = evt.params.data.element;
                    let $element = $(element);
                    $element.detach(); 
                    $(this).append($element);
                    $(this).trigger("change");
                });




            //Acciones que se ejecutaran cuando DESselecciona un descuento de una condición
            $(`#ListaDescuentos${nombreCondicion}_${indexGral}_${indexCondiciones}`).on("select2:unselecting", function (evt){
                let element = evt.params.args.data.element;
                let $element = $(element);
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");
                /*let classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
                if(classnameExists == true){
                    document.getElementById(`${indexGral}_${$element[0].value}_msi`).outerHTML = "";
                    document.getElementById(`${indexGral}_${$element[0].value}_span`).outerHTML = "";
                }*/
            });
    
        }
        else{
            boxDetail.addClass('hidden');
    
            $(`#orden_${indexGral}_${indexCondiciones}`).val("");
            $(`#orden_${indexGral}_${indexCondiciones}`).prop( "disabled", true );
            document.getElementById(`selectDescuentos_${indexGral}_${indexCondiciones}`).innerHTML = "";
           // document.getElementById(`listamsi_${indexGral}_${indexCondiciones}`).innerHTML = "";
        }
        
    }
    
    function selectSuperficie(tipoSup){
        $('#super').val(tipoSup);
        document.getElementById("printSuperficie").innerHTML ='';
        validateAllInForm();
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    function RemovePackage(){
        let divNum = $('#iddiv').val();
        $('#ModalRemove').modal('toggle');
        $("#" + divNum + "").remove();
        $('#iddiv').val(0);
        validateNonePlans();
        return false;
    }
    
    function removeElementCard(divNum) {
        $('#iddiv').val(divNum);
        $('#ModalRemove').modal('show');
    }
    
    
    function turnOnOff(e){
        let inputMSI = $(e).closest( '.boxOnOff' ).find( '.inputMSI');
        if (e.checked == true) {
            inputMSI.attr("readonly", false); 
            inputMSI.val('');
            inputMSI.focus();
        }
        else{
            inputMSI.attr("readonly", true); 
            inputMSI.val(0);
        }
    }
    
    function numberMask(e) {
        let arr = e.value.replace(/[^\dA-Z]/g, '').replace(/[\s-)(]/g, '').split('');
        e.value = arr.toString().replace(/[,]/g, '');
        if ( e.value > 12 ){
            e.value = '';
            alerts.showNotification("top", "right", "La cantidad ingresada es mayor.", "danger");
        }
    }
    
    function validateAllInForm( tipo_l = 0,origen = 0){
        if(origen == 1){
            $('#tipo_l').val(tipo_l);
        }
        var dinicio = $('#fechainicio').val();
        var dfin = $('#fechafin').val();
        var sede = $('#sede').val();
        var proyecto = $('#residencial').val();
        var containerTipoLote = document.querySelector('.boxTipoLote');
        var containerSup = document.querySelector('.boxSuperficie');
        var checkedTipoLote = containerTipoLote.querySelectorAll('input[type="radio"]:checked').length;
        var checkedSuper = containerSup.querySelectorAll('input[type="radio"]:checked').length;
    
        if(dinicio != '' && dfin != '' && sede != '' && proyecto != '' && checkedTipoLote != 0 && checkedSuper != 0){
            $("#btn_generate").removeClass('d-none');
            $("#btn_consultar").removeClass('d-none');
        }
        else{
            $("#btn_generate").addClass('d-none');
            $("#btn_consultar").addClass('d-none');
            $("#btn_save").addClass('d-none');
        }
    }
    
    function validateNonePlans(){
        var plans = document.getElementsByClassName("cardPlan");
        if (plans.length > 0 ){
            $("#btn_save").removeClass('d-none');
            $(".emptyCards").addClass('d-none');
            $(".emptyCards").removeClass('d-flex');
            $(".leyendItems").removeClass('d-none');
            $(".items").text(plans.length);
        }
        else{
            $("#btn_save").addClass('d-none');
            $(".emptyCards").removeClass('d-none');	
            $(".leyendItems").addClass('d-none');
        }
    }
    
    function sinPlanesDiv(){
        $('#showPackage').append(`
            <div class="emptyCards h-100 d-flex justify-center align-center pt-4">
                <div class="h-100 text-center pt-4">
                    <img src= '`+general_base_url+`dist/img/emptyFile.png' alt="Icono gráfica" class="h-50 w-auto">
                    <h3 class="titleEmpty">Aún no ha agregado ningún plan</h3>
                    <div class="subtitleEmpty">Puede comenzar llenando el formulario de la izquierda <br>para después crear un nuevo plan</div>
                </div>
            </div>`);
    }

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');

    $('#fechainicio').val(finalBeginDate);
    $('#fechafin').val(finalEndDate);
}

$(window).resize(function(){
    tablaAutorizacion.columns.adjust();
});
