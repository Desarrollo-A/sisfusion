var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);

let titulos = [];
$(document).ready(function () {
  $("#Jtabla thead tr:eq(0) th").each(function (i) {
    if (i != 0) {
      var title = $(this).text();
      titulos.push(title);
      $(this).html(
        '<input class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="' +
          title +
          '" placeholder="' +
          title +
          '"/>'
      );
      $("input", this).on("keyup change", function () {
        if (tabla_6.column(i).search() !== this.value) {
          tabla_6.column(i).search(this.value).draw();
        }
      });
    }
  });

  tabla_6 = $("#Jtabla").DataTable({
    dom:
      "Brt" +
      "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: "btn buttons-excel",
        filename: "Registro de Estatus 8",
        titleAttr: "Descargar archivo de Excel",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
          format: {
            header: function (d, columnIdx) {
              return " " + titulos[columnIdx - 1] + " ";
            },
          },
        },
      },
    ],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
      url: `${general_base_url}static/spanishLoader_v2.json`,
      paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>",
      },
    },
    destroy: true,
    ordering: false,
    columns: [
      {
        className: "details-control",
        orderable: false,
        data: null,
        defaultContent:
          '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>',
      },
      {
        data: function (d) {
          return `<span class="label lbl-green">${d.tipo_venta}</span>`;
        },
      },
      {
        data: function (d) {
          return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreResidencial + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreCondominio.toUpperCase();
          +"</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreLote + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.gerente + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreCliente + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.descripcion + "</p>";
        },
      },

      {
        data: function (d) {
          return `<span class="label lbl-azure">${d.nombreSede}</span>`;
        },
      },
        {
            orderable: false,
            data: function (data) {
                if (id_rol_general != 53 && id_rol_general != 54 && id_rol_general != 63) { // ANALISTA DE COMISIONES Y SUBDIRECTOR CONSULTA (POPEA)

                    var cntActions;
                    if (data.vl == '1') {
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    }
                    else {
                        if (data.idStatusContratacion == 7 && data.idMovimiento == 64 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17 || data.perfil == 70)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-orangeYellow editReg2" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '"  ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else if ((data.idStatusContratacion == 7 && data.idMovimiento == 37 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 7 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 77 && data.perfil == 15)
                            || (data.idStatusContratacion == 11 && data.idMovimiento == 41)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '"  ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else if (data.idStatusContratacion == 7 && data.idMovimiento == 66 && data.perfil == 11) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-violetBoots editLoteTo8" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '"  ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else {
                            cntActions = 'N/A';
                        }
                    }
                    return '<div class="d-flex justify-center">' + cntActions + '</div>';
                }
                else {
                    return  `<span class="label lbl-warning">N/A</span>`;
                }
            }
       }],
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0
        }] ,
        ajax: {
            url: `${general_base_url}Asistente_gerente/getStatus8ContratacionAsistentes`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
    });

  $("#Jtabla").on("draw.dt", function () {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: "hover",
    });
  });

  const idStatusContratacion = [7, 11];
  const idMovimiento = [7, 37, 64, 66, 77, 41];

  $("#Jtabla tbody").on("click", "td.details-control", function () {
    var tr = $(this).closest("tr");
    var row = tabla_6.row(tr);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass("shown");
      $(this)
        .parent()
        .find(".animacion")
        .removeClass("fas fa-chevron-up")
        .addClass("fas fa-chevron-down");
    } else {
      var status;
      var fechaVenc;

      if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 37
      ) {
        status = "ESTATUS 7 LISTO (JURÍDICO)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 7
      ) {
        status = "ESTATUS 7 LISTO CON MODIFICACIONES (JURÍDICO)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 64
      ) {
        status = "ESTATUS 8 RECHAZADO (CONTRALORIA)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 66
      ) {
        status = "ESTATUS 8 RECHAZADO (ADMINISTRACIÓN)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 77
      ) {
        status = "ESTATUS 2 ENVIADO REVISIÓN (VENTAS)";
      } else if (
        row.data().idStatusContratacion == 11 &&
        row.data().idMovimiento == 41
      ) {
        status = "ESTATUS 11 VALIDACIÓN DE ENGANCHE (ADMINISTRACIÓN)";
      }

      if (
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 37) ||
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 7) ||
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 64) ||
        (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 77)
      ) {
        fechaVenc = row.data().fechaVenc;
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 66
      ) {
        fechaVenc = "VENCIDO";
      }

      var informacion_adicional =
        '<div class="container subBoxDetail bottom"><div class="row">' +
        '<div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">' +
        "<label><b>INFORMACIÓN ADICIONAL</b></label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Estatus: </b>" +
        status +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Comentario: </b>" +
        row.data().comentario +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Fecha de vencimiento: </b>" +
        fechaVenc +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Fecha de realizado: </b>" +
        row.data().modificado +
        "</label> " +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Coordinador: </b>" +
        row.data().coordinador +
        "</label> " +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Asesor: </b>" +
        row.data().asesor +
        "</label>" +
        "</div>" +
        "</div>" +
        "</div>";

      row.child(informacion_adicional).show();
      tr.addClass("shown");
      $(this)
        .parent()
        .find(".animacion")
        .removeClass("fas fa-chevron-down")
        .addClass("fas fa-chevron-up");
    }
  });

    $("#Jtabla tbody").on("click", ".editReg", async function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        getInfo1[8] = $(this).attr("data-idMov");
        getInfo1[9] = $(this).attr("data-perfil");
        getInfo1[10] = 0; // Tiene complemento de pago 

        $(".lote").html($(this).attr("data-nomLote"));

        const docData = new FormData();
        docData.append("idLote", getInfo1[5]);
        let result = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Contraloria/getComplementoPago`,
            data: docData,
            contentType: false,
            cache: false,
            processData: false,
        });
        result = JSON.parse(result);
        console.log("Complemento", result);

        let content = '';
        if (result.length >= 1) {
          getInfo1[10] = 1; // Con complemento de pago
          content = `
            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
                <label>Compemento de pago:</label>
                <div id="selectFileSection">
                    <div class="file-gph">
                        <input type="file" accept=".pdf" id="archivo_complemento">
                        <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn m-0" for="archivo_complemento">
                          <span>Seleccionar</span>
                          <i class="fas fa-folder-open"></i>
                        </label>
                    </div>
                </div>
                <span><label class='pt-1'>NOTA: Si ya existe un complemento de pago, el mismo se remplazara con el nuevo.</label></span>
            </div>`;
        // Embebemos el contenido extra
        }
        $('#extra-content-accion-modal').html(content);  

        $('#save1').prop('disabled', false); // Deshabilitamos botón
        $('#rev').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelReg", function (e) {
        e.preventDefault();
        getInfo2[0] = $(this).attr("data-idCliente");
        getInfo2[1] = $(this).attr("data-nombreResidencial");
        getInfo2[2] = $(this).attr("data-nombreCondominio");
        getInfo2[3] = $(this).attr("data-idcond");
        getInfo2[4] = $(this).attr("data-nomlote");
        getInfo2[5] = $(this).attr("data-idLote");
        getInfo2[6] = $(this).attr("data-fecven");
        getInfo2[7] = $(this).attr("data-code");

        $(".lote").html($(this).attr("data-nomLote"));
        $('#rechReg').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelAs", function (e) {
        e.preventDefault();
        getInfo3[0] = $(this).attr("data-idCliente");
        getInfo3[1] = $(this).attr("data-nombreResidencial");
        getInfo3[2] = $(this).attr("data-nombreCondominio");
        getInfo3[3] = $(this).attr("data-idcond");
        getInfo3[4] = $(this).attr("data-nomlote");
        getInfo3[5] = $(this).attr("data-idLote");
        getInfo3[6] = $(this).attr("data-fecven");
        getInfo3[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechazoAs').modal('show');
    });
});

$(document).on('click', '#save1', async function (e) {
    e.preventDefault();
    var comentario = $("#comentario1").val();
    var validaComentario = (document.getElementById("comentario1").value.trim() == '') ? 0 : 1;

    if (validaComentario == 0) {
      return alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");
    }
    if ( getInfo1[10] == 1){
      console.log('Claro que si');
      const archivo = $("#archivo_complemento");
      // Input sin archivo
      if (archivo.val().length === 0) {
        return alerts.showNotification("top", "right", "Seleccione el archivo a adjuntar.", "warning");
      }
      // Archivo incorrecto
      else if (!validateExtension(archivo[0].files[0].name.split('.').pop(), 'pdf, PDF')) {
        return alerts.showNotification("top", "right", "El tipo de archivo es incorrecto", "warning");
      }
    }

    $('#save1').prop('disabled', true); // Deshabilitamos botón

    // Borramos el complemento de pago en caso de tener uno y actualizamos los registros de historial_documento 
    const docData = new FormData();
    docData.append("idLote", getInfo1[5]);

    let result = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contraloria/getComplementoPago`,
        data: docData,
        contentType: false,
        cache: false,
        processData: false,
    });

    result = JSON.parse(result);
    console.log("Complemento", result);
    
    if (getInfo1[10] == 1 ) { // Verificamos si el lote cuenta con la opción de anexa complemento de pago activo.
      if (result.length >= 1 && result.expediente) {
        const docData = new FormData();
        docData.append("idDocumento", result[0].idDocumento);
        docData.append("tipoDocumento", result[0].tipo_doc);
        let rs1 = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Documentacion/eliminarArchivo`,
            data: docData,
            contentType: false,
            cache: false,
            processData: false,
        });
        rs1 = JSON.parse(rs1);
        console.log('Eliminar archivo', rs1);
        if (rs1.code == 500 ){
            alerts.showNotification("top", "right", 'Surgió un error al sustituir el archivo', "warning");
            return;
        } 
      }
      
      const expediente = generarTituloDocumento(getInfo1[1], getInfo1[4], getInfo1[5], getInfo1[0], 55); // nombreResidencial, nombreLote, idLote, idCliente, tipoDoc.
 
      const ndata = new FormData();
      ndata.append("expediente", expediente); // Nombre del archivo CCSPQ-15005-PPYUC-ETC.pdf
      ndata.append("idDocumento", result[0].idDocumento);
      let res = await $.ajax({
          type: 'POST',
          url: `${general_base_url}Contraloria/actualizaRamaComplementoPago`,
          data: ndata,
          contentType: false,
          cache: false,
          processData: false,
      });
      res = JSON.parse(res);
      console.log('Actualiza rama complemento', res);

      const xdata = new FormData();
      xdata.append("idLote", getInfo1[5]);
      xdata.append("idDocumento", result[0].idDocumento);
      xdata.append("tipoDocumento", 55);
      xdata.append("tituloDocumento", expediente);
      xdata.append("uploadedDocument", $("#archivo_complemento")[0].files[0]);
      let rs = await $.ajax({
          type: 'POST',
          url: `${general_base_url}Documentacion/subirArchivo`,
          data: xdata,
          contentType: false,
          cache: false,
          processData: false,
      });
      rs = JSON.parse(rs);
      console.log('Subir archivo', rs);
      if (rs.code == 500 ){
          alerts.showNotification("top", "right", 'Surgió un error al remplazar el archivo', "warning");
          return;
      } 
    }

    const dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    dataExp1.append("numContrato", getInfo1[7]);
    dataExp1.append("idMovimiento", getInfo1[8]);
    dataExp1.append("perfil", getInfo1[9]);
    $.ajax({
        url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentes_proceso8`,
        data: dataExp1,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            response = JSON.parse(data);
            if (response.status)
                alerts.showNotification("top", "right", response.message, "success");
            else
                alerts.showNotification("top", "right", response.message, "danger");
            $('#save1').prop('disabled', false);
            $('#rev').modal('hide');
            $('#Jtabla').DataTable().ajax.reload();
        },
        error: function () {
            $('#save1').prop('disabled', false);
            $('#rev').modal('hide');
            $('#Jtabla').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

$(document).on('click', '#save2', function (e) {
    e.preventDefault();
    var comentario = $("#comentario2").val();
    var validaComentario = (document.getElementById("comentario2").value.trim() == '') ? 0 : 1;

    var dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo2[0]);
    dataExp2.append("nombreResidencial", getInfo2[1]);
    dataExp2.append("nombreCondominio", getInfo2[2]);
    dataExp2.append("idCondominio", getInfo2[3]);
    dataExp2.append("nombreLote", getInfo2[4]);
    dataExp2.append("idLote", getInfo2[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2[6]);
    dataExp2.append("numContrato", getInfo2[7]);

    if (validaComentario == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    else{
        $('#save2').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazo_asistentes_proceceso8`,
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.status)
                    alerts.showNotification("top", "right", response.message, "success");
                else
                    alerts.showNotification("top", "right", response.message, "danger");

                $('#save2').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
            },
            error: function () {
                $('#save2').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function (e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComentario = (document.getElementById("comentario3").value.trim() == '') ? 0 : 1;

    var dataExp3 = new FormData();
    dataExp3.append("idCliente", getInfo3[0]);
    dataExp3.append("nombreResidencial", getInfo3[1]);
    dataExp3.append("nombreCondominio", getInfo3[2]);
    dataExp3.append("idCondominio", getInfo3[3]);
    dataExp3.append("nombreLote", getInfo3[4]);
    dataExp3.append("idLote", getInfo3[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo3[6]);
    dataExp3.append("numContrato", getInfo3[7]);

    if (validaComentario == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    else{
        $('#save3').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazoAstatus2_asistentes_proceceso8/`,
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);

                if (response.status)
                    alerts.showNotification("top", "right", response.message, "success");
                else
                    alerts.showNotification("top", "right", response.message, "danger");

                $('#save3').prop('disabled', false);
                $('#rechazoAs').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
            },
            error: function () {
                $('#save3').prop('disabled', false);
                $('#rechazoAs').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

// Función para colocar el nombre del archivo en el input de texto que comparte con el input de archivo
$(document).on("change", "#archivo_complemento", function () {
  const target = $(this);
  const relatedTarget = target.siblings(".file-name");
  const fileName = target[0].files[0].name;
  relatedTarget.val(fileName);
});

const generarTituloDocumento = (abreviaturaNombreResidencial, nombreLote, idLote, idCliente, tipoDocumento) => {
  let rama = '';
  if (tipoDocumento === 55) rama = 'COMPLEMENTO DE PAGO';

  const DATE = new Date();
  const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
  const TITULO_DOCUMENTO = `${abreviaturaNombreResidencial}_${nombreLote}_${idLote}_${idCliente}_TDOC${tipoDocumento}${rama.slice(0, 4)}_${DATE_STR}`;
  return TITULO_DOCUMENTO;
}

const newButton = (btnClass, title, action = '', data, icon) => {
  const CUSTOM_BTN = `<button class='${btnClass}'
      data-toggle='tooltip' 
      data-placement='top'
      title='${title.toUpperCase()}'
      data-accion='${action}'
      data-data='${JSON.stringify(data)}'>
          <i class='${icon}'></i>
      </button>`;

  return CUSTOM_BTN;
}

const datatableButtons = (d, type) => {
  const BTN_VER_DOC = newButton('btn-data btn-sky btn-archivo', 'VISUALIZAR ARCHIVO', 'VER-ARCHIVO', d, 'fas fa-eye');
  
  let NO_BTN = '';

  if (type === 2) {
      if (d.expediente) return BTN_VER_DOC ;
  }

  return NO_BTN;
}

$(document).on('click', '.btn-archivo', function () {
  $('.btn-archivo').attr('disabled', true);  // Lo vuelvo a activar
  $('#spiner-loader').removeClass('hide'); // Aparece spinner
  Shadowbox.init();
  const d = JSON.parse($(this).attr("data-data"));
  let filePath = `${general_base_url}Documentacion/archivo/${d.expediente}`;
  Shadowbox.open({
      content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${filePath}"></iframe></div>`,
      player: "html",
      title: `Visualizando archivo: ${d.movimiento}`,
      width: 985,
      height: 660
  });

  $('.btn-archivo').attr('disabled', false);  // Lo vuelvo a activar
  $('#spiner-loader').addClass('hide'); // Quito spinner  
});

jQuery(document).ready(function () {
    jQuery('#rev').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario1').val('');
        jQuery(this).find('#archivo_complemento').val('');
        
    })

    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
    })

    jQuery('#rechazoAs').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
});
