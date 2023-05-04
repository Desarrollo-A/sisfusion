
$(document).ready(function(){ /**FUNCIÓN PARA LLENAR EL SELECT DE LOS FILTROS DE ESTATUS */
    $.post('getCatalogo', {
        id_catalogo: 90
    }, function (data) {        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusAut").append($('<option>').val(id).text(name));
                if(i == data.length -1) { //DESPUES DE LA ULTIMA OPCIÓN DE LOS ESTATUS, AGREGAR LA OPCIÓN "TODOS" PARA TRAER TODOS LOS ESTATUS
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

    let titulos = [];
    $('#autorizacionesPVentas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tablaAutorizacion.column(i).search() !== this.value) {
                tablaAutorizacion
                    .column(i)
                    .search(this.value)
                    .draw();
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
            "width": "2%",
            "data": function( d ){
                return '<p class="m-0">'+d.id_autorizacion+'</p>';
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0">${d.sede}</p>`;
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                let residencial = d.nombreResidencial.split(',');
                console.log(residencial)
                let imprimir = '';
                for (let m = 0; m < residencial.length; m++) {
                    imprimir += `<p><span class="label lbl-sky">${residencial[m]}</span></p>`;
                }
                
                return imprimir;
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                let fecha_inicio = moment(d.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY');
                return `<p class="m-0"><b>${fecha_inicio}</b></p>`;
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                let fecha_fin = moment(d.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY');
                return `<p class="m-0"><b>${fecha_fin}</b></p>`;
            }
        },
        {
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0">${d.tipoLote}</p>`;
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                    return `<p class="m-0">${d.tipoSuperficie}</p>`;  
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                    return `<p class="m-0"><span class="label ${d.colorAutorizacion}">${d.estatusAutorizacion}</span></p>`;  
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return `<p class="m-0"><span class="label ${d.colorEstatus}">${d.estatusA}</span></p>`;
        }
        },
        {
            "width": "5%",
            "data": function( d ){
               let fecha_creacion = moment(d.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
                return `<p class="m-0">${fecha_creacion}</p>`;
        }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return `<p class="m-0">${d.creadoPor}</p>`;
             }
        },
        {  
            "width": "5%",
            "data": function( d ){
                $('[data-toggle="tooltip"]').tooltip();
                let botones = '';
                switch(id_rol_general){
                    case 5:
                        if(d.estatus == 1){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 4){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus);
                        }
                    break;
                    case 17:
                        if(d.estatus == 2){
                            botones += botonesPermiso(1,0,1,1,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 4){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                    break;
                }
                botones += `<button data-idAutorizacion="${d.id_autorizacion}" id="btnHistorial" class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Historial"><i class="fas fa-info"></i></button>`; ;
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
}

function botonesPermiso(permisoVista,permisoEditar,permisoAvanzar,permisoRechazar,idAutorizacion,estatus){
        let botones = '';
        /**Permisos
         * 1.- vista
         * 2.- Editar
         * 3.- Avanzar
         * 4.- Rechazar
         * */
            if(permisoVista == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnVer" class="btn-data btn-sky" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></button>`;   }
            if(permisoEditar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnEditar" class="btn-data btn-yellow" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></button>`; }
            if(permisoAvanzar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="1" data-estatus="${estatus}" id="btnAvanzar" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Avanzar"><i class="fas fa-thumbs-up"></i></button>`;  }
            if(permisoRechazar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="2" data-estatus="${estatus}" id="btnAvanzar" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-trash"></i></button>`;  }
        return  botones;
    }

    $(document).on('click', '#btnEditar', function (e) {
        e.preventDefault();
        $('#spiner-loader').removeClass('hide');
       // window.scrollTo(0, 0)

        var data = tablaAutorizacion.row($(this).parents('tr')).data();
        console.log(data);
        //$('#fechainicio').val(moment(data.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY'));
        document.getElementById('fechainicio').value = data.fecha_inicio;// moment(data.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY');
        document.getElementById('fechafin').value = data.fecha_fin;//moment(data.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY');
       // $('#fechafin').val(moment(data.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY'));
       document.getElementById('accion').value = 2;
       document.getElementById('idSolicitudAut').value = data.id_autorizacion;
       document.getElementById('paquetes').value = data.paquetes;
        $('#li-plan').addClass('active');
        $('#li-aut').removeClass('active');
        $('#nuevas-2').addClass('active');
        $('#nuevas-1').removeClass('active');
        //document.getElementById('sede').value = parseInt(data.id_sede);
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
        console.log(radios)
        for (var j = 0; j < radios.length; j++) {
            console.log(radios[j].value)
            if (radios[j].value == data.tipo_lote) {
              radios[j].checked = true;
            break;
             }
         }
         validateAllInForm(data.tipo_lote,1);
         var radios = document.getElementsByName('superficie');
        console.log(radios)
        for (var j = 0; j < radios.length; j++) {
            console.log(radios[j].value)
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
        document.getElementById('titleAvance').innerHTML = tipo == 1 ? 'Avanzar autorización' : 'Rechazar autorización';
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
                if (response == 1) {
                    $("#avanzarAut").modal("hide");
                    tipo == 1  ? $('#modalAutorizacion').removeClass("modal-sm") : $('#modalAutorizacion').removeClass("modal-md") ;
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Estatus actualizado", "success");
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
        let idAutorizacion = $(this).attr('data-idAutorizacion');
        var data = tablaAutorizacion.row($(this).parents('tr')).data();
        let paquetes = data.paquetes;
        let residenciales = data.nombreResidencial.split(',');
        let fecha_inicio = moment(data.fecha_inicio,'YYYY/MM/DD').format('DD/MM/YYYY');
        let fecha_fin = moment(data.fecha_fin,'YYYY/MM/DD').format('DD/MM/YYYY');
        let params = {'paquetes': data.paquetes};
        document.getElementById('contentView').innerHTML = '';  

        $('#contentView').append(`
        <span>Fecha inicio:</span><span class="label lbl-sky">${fecha_inicio}</span> <span>Fecha fin:</span><span class="label lbl-sky">${fecha_fin}</span><br>
        <span>Sede:</span><span class="label lbl-sky">${data.sede}</span>
        <span>Residencial(es):</span>${residenciales.map(function (element) { return `<span class="label lbl-sky">${element}</span>` })}
        <span>Tipo lote:</span><span class="label lbl-sky">${data.tipoLote}</span>
        <span>Superficie:</span><span class="label lbl-sky">${data.tipoSuperficie}</span>
        <div class="row" >
            <div class="col-lg-12" id="cards">
   
            </div>
        </div>
        `);
        
        let tiposDescuentos = descuentosYCondiciones;
        $.post('paquetesView',params, function(data) {
            data = JSON.parse(data);
            let dataPaquetes = data[0].paquetes;
            let dataDescuentosByPlan = data[0].descuentos;
           // tiposDescuentos = JSON.parse(descuentosYCondiciones);
            console.log(data);
            for (let m = 0; m < dataPaquetes.length; m++) {
                console.log(dataPaquetes,tiposDescuentos);
                let idPaquete = dataPaquetes[m].id_paquete;
                console.log(idPaquete)
                let existe = dataDescuentosByPlan.find(elementD => elementD.id_paquete == idPaquete)
                let descuentosByPlan = dataDescuentosByPlan.filter(desc => desc.id_paquete == idPaquete);
                    if(existe != undefined){
                        crearDivs(dataPaquetes[m],tiposDescuentos,descuentosByPlan);
                    }
               /* for (let o = 0; o < tiposDescuentos.length; o++) {   
                    console.log(tiposDescuentos[o]);
                    console.log(tiposDescuentos[o].condicion.id_condicion);
                 
                        
                        
                    }  */
            }


        });

        $("#modalView").modal();
        $('#spiner-loader').addClass('hide');

    });

    function crearDivs(dataPaquete,tiposDescuentos,descuentosPorPlan){
        console.log('--------------')
        console.log(dataPaquete);
        console.log(tiposDescuentos);
        console.log(descuentosPorPlan);
        console.log('--------------')
        $('#cards').append(`
            <div class="col-lg-6">
                <div class="card">
                    <div class="box">  
                        <h2><span class="label lbl-violetChin">${dataPaquete.descripcion}</span></h2>
                        <span>
                            <ul id="descuentosP_${dataPaquete.id_paquete}">
                            </ul>
                        </span>
                    </div>
                </div>
            </div>
        `);

        for (let m = 0; m < tiposDescuentos.length; m++) {
            $(`#descuentosP_${dataPaquete.id_paquete}`).append(`
                <li>${tiposDescuentos[m].condicion.descripcion}</li>
                <div id="tipoDescPaquete_${dataPaquete.id_paquete}_${tiposDescuentos[m].condicion.id_condicion}"></div>
            `);
            let existe = descuentosPorPlan.find(elementD => elementD.id_paquete == dataPaquete.id_paquete &&  elementD.id_condicion == tiposDescuentos[m].condicion.id_condicion);
            console.log(tiposDescuentos[m].condicion);
            if(existe != undefined){
                let descuentosByPlan = descuentosPorPlan.filter(desc => desc.id_paquete == dataPaquete.id_paquete);
                console.log('descuentosByPlan');
console.log(descuentosByPlan);
                for (let o = 0; o < descuentosByPlan.length; o++) {
                    if(descuentosByPlan[o].id_condicion == tiposDescuentos[m].condicion.id_condicion){
                        let porcentaje = descuentosByPlan[o].id_condicion == 4 || descuentosByPlan[o].id_condicion == 12 ? '$'+formatMoney(descuentosByPlan[o].porcentaje) : (descuentosByPlan[o].id_condicion == 13 ? descuentosByPlan[o].porcentaje : descuentosByPlan[o].porcentaje + '%'  )
                        $(`#tipoDescPaquete_${dataPaquete.id_paquete}_${tiposDescuentos[m].condicion.id_condicion}`).append(`
                           <span class="label lbl-green">${porcentaje} ${descuentosByPlan[o].id_condicion == 13 ? '' :(descuentosByPlan[o].msi_descuento != null && descuentosByPlan[o].msi_descuento != 0 ? '+'+descuentosByPlan[o].msi_descuento+'%' : '')}</span>
                `);
                    }
                    
                }

                //llenar(dataPaquete.id_paquete,tiposDescuentos[m].condicion.id_condicion,existe)
                console.log('---SI HAY-----')
                console.log(existe);
                console.log('---SI HAY-----')
                  

             }

                   
        }
    }



    