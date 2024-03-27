var arrayValores = [];
const ROLES_SIN_ACCIONES = [4, 6];

$(document).ready(function () {
    if (!ROLES_SIN_ACCIONES.includes(id_rol_general)) {
        $.post(`${general_base_url}Reestructura/getListaUsuariosParaAsignacion`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idAsesor").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombreUsuario']));
            }
            $("#idAsesor").selectpicker('refresh');
        }, 'json');
    }
});

let titulosTabla = [];
$('#tablaAsignacionCartera thead tr:eq(0) th').each(function (i) {
    if(i >= 1){
        const title = $(this).text();
        titulosTabla.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tablaAsignacionCartera').DataTable().column(i).search() !== this.value)
                $('#tablaAsignacionCartera').DataTable().column(i).search(this.value).draw();
        });
    }
    $('[data-toggle="tooltip"]').tooltip();
});

tablaAsignacion = $('#tablaAsignacionCartera').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx - 1] + ' ';
                }
            }
        }
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: 'btn buttons-pdf',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx - 1] + ' ';
                }
            }
        }
    },
    {
        text: '<i class="fas fa-random"></i>',
        className: 'btn-large btn-sky btn-asignar-ventaML botonEnviar hide',
        titleAttr: 'Fusionar lotes',
        title:"Fusionar lotes",
    }],
    columnDefs: [{
        searchable: false,
        visible: false
    }],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: false,
    language: {
        url: general_base_url+"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        {
            visible: (ROLES_SIN_ACCIONES.includes(id_rol_general)) ? false : true,
            width: "30%",
            data: function (d) {
                let lblInput = '';
                console.log('d.idFusion: ', d.idFusion, ' d.idLotePvOrigen: ', d.idLotePvOrigen, ' d.id_estatus_preproceso: ', d.id_estatus_preproceso);
                
                if(d.idFusion == null && d.idLotePvOrigen == null && d.id_estatus_preproceso == 0){
                    lblInput = `<center><input type="checkbox" onChange="verificarCheck(this)" required data-idAsesorAsignado="${d.idAsesorAsignado}"
                         data-nombreLote="${d.nombreLote}" data-idCliente="${d.idCliente}"
                         data-totalNeto2="${d.totalNeto2}" data-sup="${d.sup}" name="lotesOrigen[]" value="${d.idLote}" ></center>`;
                }else
                    lblInput = '<center><input type="checkbox" disabled></center>';
                return lblInput;
            }
        },
        {
            data: function(d){
                let nombreResidencial = d.nombreResidencial;
                let lblFusion = '';
                if(d.idFusion!=null){
                    if(d.idLotePvOrigen == d.idLote)
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN PV '+d.idLotePvOrigen+'</label>';
                    else
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN '+d.idLotePvOrigen+'</label>';
                }
                return nombreResidencial+lblFusion;
            }
        },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "cliente" },
        { data: "nombreAsesor" },
        { data: "nombreCoordinador" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        { data: "nombreRegional" },
        { data: "nombreRegional2" },
        { data: "fechaApartado" },
        { data: "sup"},
        {
            data: function (d) {
                if( d.costom2f == 'SIN ESPECIFICAR')
                    return d.costom2f;
                else
                    return `$${formatMoney(d.costom2f)}`;
            }
        },
        {
            data: function (d) {
                return `$${formatMoney(d.total)}`;
            }
        },
        { data: "nombreAsesorAsignado"},
        {
            visible: (ROLES_SIN_ACCIONES.includes(id_rol_general)) ? false : true,
            data: function (d) {
                if(d.idFusion==null && d.idLotePvOrigen==null){
                    btns = `<button class="btn-data btn-sky btn-asignar-venta"
                            data-toggle="tooltip" 
                            data-placement="left"
                            id="btn_${d.idLote}"
                            title="ASIGNAR VENTA"
                            data-idCliente="${d.idCliente}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}"
                            data-LoteFusionado="0">
                            <i class="fas fa-exchange-alt"></i>
                    </button>`;
                }
                if(d.idFusion!=null && d.idLotePvOrigen!=null){
                    if(d.idLotePvOrigen==d.idLote){
                        btns = `<button class="btn-data btn-sky btn-asignar-venta"
                            data-toggle="tooltip" 
                            data-placement="left"
                            id="btn_${d.idLote}"
                            title="LOTE PIVOTE ASIGNAR VENTA"
                            data-idCliente="${d.idCliente}"
                            data-LoteFusionado="1"
                            data-idLote="${d.idLote}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}">
                            <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button class="btn-data btn-warning btn-quitarFusion"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="REMOVER LOTES DE LA FUSIÓN"
                            data-idCliente="${d.idCliente}"
                            data-LoteFusionado="1"
                            data-idLote="${d.idLote}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}">
                            <i class="fas fa-user-slash"></i>
                    </button>
                    <button class="btn-data btn-warning btn-desFusionar"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="DESHACER FUSIÓN"
                            data-idCliente="${d.idCliente}"
                            data-LoteFusionado="1"
                            data-idLote="${d.idLote}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}">
                            <i class="fas fa-reply"></i>
                    </button>`;
                    }else{
                        btns = `<button class="btn-data btn-sky btn-asignar-venta"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="LOTE FUSIONADO" disabled>
                            <i class="fas fa-exchange-alt"></i></button>`;
                    }

                }
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}reestructura/getListaAsignacionCartera`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});

$(document).on('click', '.btn-quitarFusion', function () {
    let idLotePV = $(this).attr('data-idLote');
    document.getElementById('lotesFusiones2').innerHTML = '';
    $.post('getFusion/', {idLote: idLotePV, tipoOrigenDestino: 1}, function(respuesta) {
        respuesta.data.map((elemento, index)=>{
            $('#lotesFusiones2').append(`
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="" id="checkDS">
                    <div class="container boxChecks p-0">
                        <label class="m-0 checkstyleDS">
                            <input type="checkbox" class="select-checkbox" id="idFusion_${index}" name="idFusion_${index}" value="${elemento.idFusion}" />
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Lote <b>${elemento.nombreLoteDO}</b></p>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            </div><br>
            `);
            if(index == (respuesta.data.length - 1)){
                $('#lotesFusiones2').append(`
                    <div>
                        <input type="hidden" id="index" name="index" value="${respuesta.data.length}" />
                    </div>
                    `);
            }
        });
        $("#modalQuitarFusion").modal("show");
    }, 'json');
});
$(document).on("submit", "#formQuitarFusion", function(e){
    e.preventDefault();
    let data = new FormData($(this)[0]);
    let index = document.getElementById('index').value;
    let contador = 0;
    for (let m = 0; m < index; m++) {
        if($("input[name='idFusion_"+m+"']").is(':checked') === true){
            contador = contador + 1;
        }
    }
    if(contador == 0){
        alerts.showNotification("top", "right", "Debe seleccionar al menos un lote para continuar", "warning");
        return false;
    }
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/quitarLoteFusion',
        data: data,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data) {
            $('#tablaAsignacionCartera').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            $('#modalQuitarFusion').modal('hide');
            alerts.showNotification("top", "right", "Lote(s) removidos correctamente de la fusión.", "success");
            document.getElementById('lotesFusiones2').innerHTML = '';
            }else{
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        },
        error: function(){
            $('#modalQuitarFusion').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.btn-desFusionar', function () {
    let idLotePV = $(this).attr('data-idLote');
    document.getElementById("pvLote").value = idLotePV;
    document.getElementById('lotesFusiones').innerHTML = '';
    $.post('getFusion/', {idLote: idLotePV, tipoOrigenDestino: 1}, function(respuesta) {
        respuesta.data.map((elemento, index)=>{
            $('#lotesFusiones').append(`
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="" id="checkDS">
                    <div class="container boxChecks p-0">
                        <label class="m-0 checkstyleDS">
                            <input type="checkbox" class="select-checkbox" id="idFusion_${index}" name="idFusion_${index}" value="${elemento.idFusion}" disabled/>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Lote <b>${elemento.nombreLoteDO}</b></p>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            </div><br>
            `);
            if(index == (respuesta.data.length - 1)){
                $('#lotesFusiones').append(`
                    <div>
                        <input type="hidden" id="index" name="index" value="${respuesta.data.length}" />
                    </div>
                    `);
            }
        });
        $("#modalDropFusion").modal("show");
    }, 'json');
});

$(document).on("submit", "#formDesFusion", function(e){
    e.preventDefault();
    let data = new FormData($(this)[0]);
    let index = document.getElementById('index').value;
    let contador = 0;
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/removeLoteFusion',
        data: data,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.result) {
            $('#tablaAsignacionCartera').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            $('#modalDropFusion').modal('hide');
            alerts.showNotification("top", "right", "Lote(s) removidos correctamente de la fusión.", "success");
            document.getElementById('lotesFusiones').innerHTML = '';
            }else{
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        },
        error: function(){
            $('#modalDropFusion').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
$(document).on('click', '.btn-asignar-venta', function () {
    let flagFusionado = $(this).attr("data-lotefusionado");

    if(flagFusionado==1){
        let lotesFusion = '';
        let idLotePV = $(this).attr('data-idLote');
        let lotesFusionados = [];
        $.post('getFusion/', {idLote: idLotePV, tipoOrigenDestino: 1}, function(respuesta) {

            respuesta.data.map((elemento, index)=>{
                lotesFusion += elemento.nombreLotes+ ' ';
                lotesFusionados.push(elemento.idLote);
            });
            $("#idLote").val(lotesFusionados);
            $('#fusionLote').val(1);
            document.getElementById("mainLabelText").innerHTML = `Asigna un asesor para el seguimiento de la venta <b>${lotesFusion}</b>`;
            $("#asignacionModal").modal("show");
        }, 'json');
        const idAsesorAsignado = $(this).attr("data-idAsesorAsignado");
        $("#idAsesor").val(idAsesorAsignado == 0 ? '' : idAsesorAsignado).selectpicker('refresh');
    }else{
        const tr = $(this).closest('tr');
        const row = $('#tablaAsignacionCartera').DataTable().row(tr);
        const idAsesorAsignado = $(this).attr("data-idAsesorAsignado");
        const idLote = row.data().idLote;
        const nombreLote = row.data().nombreLote;
        $("#idAsesor").val(idAsesorAsignado == 0 ? '' : idAsesorAsignado).selectpicker('refresh');
        $("#nombreLote").val(nombreLote);
        //$('#payment_method').selectpicker('refresh');
        $("#idLote").val(idLote);
        $('#fusionLote').val(0);
        document.getElementById("mainLabelText").innerHTML = `Asigna un asesor para el seguimiento de la venta <b>${nombreLote}</b>`;
        $("#asignacionModal").modal("show");
    }

});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const idLote = $("#idLote").val();
    const idAsesor = $("#idAsesor").val();
    const nombreLote = $("#nombreLote").val();
    const idFusion = $("#fusionLote").val();
    const select = document.getElementById("idAsesor");
    const textNombreAsesor = select.options[select.selectedIndex].innerText;
    let data = new FormData();
    data.append("idLote", idLote);
    data.append("idAsesor", idAsesor);
    data.append("idFusion", idFusion);
    if (idAsesor == '')
        alerts.showNotification("top", "right", `Asegúrate de asignar un asesor para continuar con este proceso.`, "warning");
    else {
        $.ajax({
            url: `${general_base_url}Reestructura/setAsesor`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                response = JSON.parse(response);
                $("#sendRequestButton").prop("disabled", false);
                if(response.status == 200){
                        alerts.showNotification("top", "right", `El asignación del lote <b>${nombreLote}</b> a <b>${textNombreAsesor}</b> ha sido exitosa.`, "success");
                        $('#tablaAsignacionCartera').DataTable().ajax.reload(null, false);
                        $("#asignacionModal").modal("hide");
                }
                else
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "warning");
            },
            error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
  });


function verificarCheck(valorActual){
const tr = $(this).closest('tr');
    const row = $('#tablaAsignacionCartera').DataTable().row(tr);
    let botonEnviar = document.getElementsByClassName('botonEnviar');
    let arrayInterno = [];

    if (valorActual.checked){
        arrayInterno.push($(valorActual).attr('data-nombreLote'));//[0]
        arrayInterno.push($(valorActual).attr('data-idCliente'));//[1]
        arrayInterno.push($(valorActual).attr('data-idAsesorAsignado'));//[2]
        arrayInterno.push($(valorActual).attr('data-totalNeto2'));//[3]
        arrayInterno.push($(valorActual).val());//[4]
        arrayInterno.push($(valorActual).attr('data-sup'));//[5]

        arrayValores.push(arrayInterno);
    }
    else{
        let indexDelete = buscarValor($(valorActual).val(),arrayValores);
        arrayValores = arrayValores.slice(0, indexDelete).concat(arrayValores.slice(indexDelete + 1));
    }
    if(arrayValores.length>1 || (arrayValores.length == 1 && parseFloat(arrayValores[0][5]))){
     //se seleccionó más de uno, se habilita el botón para hacer el multiple
        botonEnviar[0].classList.remove('hide');
        $('#btn_'+$(valorActual).val()).prop("disabled", true);        
    }else if((arrayValores.length == 1 && parseFloat(arrayValores[0][5]))){
        $('#btn_'+$(valorActual).val()).prop("disabled", true);        
    }else{
        botonEnviar[0].classList.add('hide');
        $('#btn_'+$(valorActual).val()).prop("disabled", false);        
    }
}

$(document).on('click', '.btn-asignar-ventaML', ()=>{
   document.getElementById('txtLotes').innerHTML = '';

   let nombresLot = '';
   let separador = '';
   arrayValores.map((elemento, index)=>{
       if(arrayValores.length == (index+1))
           separador = '';
       else
           separador = '<br>';
       nombresLot += elemento[0]+separador;
   });
    document.getElementById('txtLotes').innerHTML += '<b>'+nombresLot+'</b>';
    $('#preguntaConfirmacion').modal();
});

function buscarValor(valor, array) {
    for (let i = 0; i < array.length; i++) {
        const subArray = array[i];
        if (subArray.includes(valor)) {
            return i;
        }
    }
    return null;
}
$(document).on('click', '#fusionarLotes', ()=>{
    let dataFS = new FormData();
    dataFS.append("data", JSON.stringify(arrayValores));
    $.ajax({
        url: `${general_base_url}Reestructura/setFusionLotes`,
        data: dataFS,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (response) {
            response = JSON.parse(response);
            $("#fusionarLotes").prop("disabled", false);
            if (response.status==200) {
                alerts.showNotification("top", "right", response.message, "success");
                $('#tablaAsignacionCartera').DataTable().ajax.reload(null, false);
                $('#preguntaConfirmacion').modal('toggle');
                document.getElementsByClassName('btn-asignar-ventaML')[0].classList.add('hide');
                arrayValores=[]; //resetea el array que guarda los lotes que se fusionaron
            }
            else
                alerts.showNotification("top", "right", response.status, "warning");/**/
        },
        error: function () {
            $("#fusionarLotes").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});