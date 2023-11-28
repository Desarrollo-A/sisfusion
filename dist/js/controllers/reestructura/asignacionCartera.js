var arrayValores = [];
$(document).ready(function () {
    $.post(`${general_base_url}Reestructura/getListaUsuariosParaAsignacion`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idAsesor").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombreUsuario']));
        }
        $("#idAsesor").selectpicker('refresh');
    }, 'json');
});

let titulosTabla = [];
$('#tablaAsignacionCartera thead tr:eq(0) th').each(function (i) {
    if(i>=1){
        const title = $(this).text();
        titulosTabla.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tablaAsignacionCartera').DataTable().column(i).search() !== this.value) {
                $('#tablaAsignacionCartera').DataTable().column(i).search(this.value).draw();
            }
        });
    }
    $('[data-toggle="tooltip"]').tooltip();
});

$('#tablaAsignacionCartera').DataTable({
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    },
    {
        text: '<i class="fas fa-exchange-alt" aria-hidden="true"></i>',
        className: 'btn-large btn-sky btn-asignar-ventaML botonEnviar hide',
        titleAttr: 'Asignar venta de lotes seleccionados',
        title:"Asignar venta de lotes seleccionados",
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
            "width": "30%",
            "data": function (d) {
                let lblInput = '';

                if(d.idFusion==null && d.idLotePvOrigen==null ){
                    lblInput = '<center><input type="checkbox" onChange="verificarCheck(this)" data-idAsesorAsignado="'+d.idAsesorAsignado+'"' +
                        'data-nombreLote="'+d.nombreLote+'" data-idCliente="'+d.idCliente+'" ' +
                        'data-totalNeto2="'+d.totalNeto2+'" name="lotesOrigen[]" value="'+d.idLote+'" ></center>';
                }else{
                    lblInput = '<center><input type="checkbox" disabled></center>';
                }


                return lblInput;
            }
        },
        {
            data: function(d){
                let nombreResidencial = d.nombreResidencial;
                let lblFusion = '';
                if(d.idFusion!=null){
                    if(d.idLotePvOrigen==d.idLote){
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN PV '+d.idLotePvOrigen+'</label>';
                    }else{
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN '+d.idLotePvOrigen+'</label>';
                    }
                }
                return nombreResidencial+lblFusion;
            }
            // data: "nombreResidencial"
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
            data: function (d) {
                if(d.idFusion==null && d.idLotePvOrigen==null){
                    btns = `<button class="btn-data btn-sky btn-asignar-venta"
                            data-toggle="tooltip" 
                            data-placement="left"
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
                            title="LOTE PIVOTE ASIGNAR VENTA"
                            data-idCliente="${d.idCliente}"
                            data-LoteFusionado="1"
                            data-idLote="${d.idLote}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}">
                            <i class="fas fa-exchange-alt"></i>
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

$(document).on('click', '.btn-asignar-venta', function () {
    let flagFusionado = $(this).attr("data-lotefusionado");

    if(flagFusionado==1){
        let lotesFusion = '';
        let idLotePV = $(this).attr('data-idLote');
        let lotesFusionados = [];
        $.post('getFusion/', {idLote: idLotePV}, function(respuesta) {

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
    let botonEnviar = document.getElementsByClassName('botonEnviar');
    let arrayInterno = [];

    if (valorActual.checked){
        arrayInterno.push($(valorActual).attr('data-nombreLote'));//[0]
        arrayInterno.push($(valorActual).attr('data-idCliente'));//[1]
        arrayInterno.push($(valorActual).attr('data-idAsesorAsignado'));//[2]
        arrayInterno.push($(valorActual).attr('data-totalNeto2'));//[3]
        arrayInterno.push($(valorActual).val());//[4]
        arrayValores.push(arrayInterno);
    }
    else{
        let indexDelete = buscarValor($(valorActual).val(),arrayValores);
        arrayValores = arrayValores.slice(0, indexDelete).concat(arrayValores.slice(indexDelete + 1));


    }

    if(arrayValores.length>1){
     //se seleccionó más de uno, se habilita el botón para hacer el multiple
        botonEnviar[0].classList.remove('hide');
    }else{
        botonEnviar[0].classList.add('hide');
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