
var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";

$("#tabla_envio_RL").ready( function(){

$('#tabla_envio_RL thead tr:eq(0) th').each( function (i) {

   if(i != 0){
    var title = $(this).text();
    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if (tabla_corrida.column(i).search() !== this.value ) {
            tabla_corrida
            .column(i)
            .search(this.value)
            .draw();
        }
    } );
}
});


    tabla_corrida = $("#tabla_envio_RL").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Envío contrato a RL',
                title:"Envío contrato a RL",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5,6,7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'TIPO VENTA';
                                    break;
                                case 1:
                                    return 'PROYECTO'
                                case 2:
                                    return 'CONDOMINIO';
                                    break;
                                case 3:
                                    return 'LOTE';
                                    break;
                                case 4:
                                    return 'CLIENTE';
                                    break;
                                    
                                case 5:
                                    return 'CÓDIGO';
                                    break;
                                case 6:
                                    return 'RL';
                                    break;
                                case 7:
                                    return 'UBICACIÓN';
                                    break;
                                        
                            }
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Envío contrato a RL',
                title: "Envío contrato a RL",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5,6,7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'TIPO VENTA';
                                    break;
                                case 1:
                                    return 'PROYECTO'
                                case 2:
                                    return 'CONDOMINIO';
                                    break;
                                case 3:
                                    return 'LOTE';
                                    break;
                                case 4:
                                    return 'CLIENTE';
                                    break;
                                case 5:
                                    return 'CÓDIGO';
                                    break;
                                case 6:
                                    return 'RL';
                                break;
                                case 7:
                                    return 'UBICACIÓN';
                                break;

                            }
                        }
                    }
                }
            }
        ],
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "bAutoWidth": false,
        "fixedColumns": true,
        "ordering": false,
        "columns": [
            {
                "width": "10%",
                "data": function (d) {
                    var lblStats;

                    if (d.tipo_venta == 1) {
                        lblStats = '<span class="label label-danger">Venta Particular</span>';
                    } else if (d.tipo_venta == 2) {
                        lblStats = '<span class="label label-success">Venta normal</span>';
                    } else if (d.tipo_venta == 3) {
                        lblStats = '<span class="label label-warning">Bono</span>';
                    } else if (d.tipo_venta == 4) {
                        lblStats = '<span class="label label-primary">Donación</span>';
                    } else if (d.tipo_venta == 5) {
                        lblStats = '<span class="label label-info">Intercambio</span>';
                    }else if(d.tipo_venta==6) {
                        lblStats ='<span class="label label-info">Reubicación</span>';
                    }else if(d.tipo_venta==7) {
                        lblStats ='<span class="label label-info">Venta especial</span>';
                    }

                    return lblStats;
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>';
                }
            },
            {
                "width": "25%",
                "data": function (d) {
                    return '<p class="m-0">' + (d.nombreCondominio).toUpperCase();
                    +'</p>';

                }
            },
            {
                "width": "20%",
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';
                }
            },
            {
                "width": "20%",
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreCliente + '</p>';
                }
            },
            {
                "width": "15%",
                "data": function (d) {
                    var numeroContrato;

                    if (d.vl == '1') {
                        numeroContrato = 'En proceso de Liberación';

                    } else {

                        if (d.numContrato == "" || d.numContrato == null) {
                            numeroContrato = "<p><i>Sin número de contrato</i></p>";
                        } else {
                            numeroContrato = d.numContrato;
                        }

                    }
                    return numeroContrato;
                }
            },

            {
                width: "17%",
                data: function( d ){
                    let ubicacionExpediente;
                    if (d.ubicacionSe == "1")
                        ubicacionExpediente = `<span class="label" style="background: #F1948A; color: #78281F">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "2")
                        ubicacionExpediente = `<span class="label" style="background: #C39BD3; color: #512E5F">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "3")
                        ubicacionExpediente = `<span class="label" style="background: #7FB3D5; color: #154360">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "4")
                        ubicacionExpediente = `<span class="label" style="background: #76D7C4; color: #0E6251">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "5")
                        ubicacionExpediente = `<span class="label" style="background: #82E0AA; color: #186A3B">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "6")
                        ubicacionExpediente = `<span class="label" style="background: #F7DC6F; color: #7D6608">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "7")
                        ubicacionExpediente = `<span class="label" style="background: #85C1E9; color: #1B4F72">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "8")
                        ubicacionExpediente = `<span class="label" style="background: #E59866; color: #6E2C00">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "9")
                        ubicacionExpediente = `<span class="label" style="background: #D7DBDD; color: #626567">${d.nombreSede}</span>`;
                    else if (d.ubicacionSe == "10")
                        ubicacionExpediente = `<span class="label" style="background: #5D6D7E; color: #1B2631">${d.nombreSede}</span>`;
                    else
                        ubicacionExpediente = `<span class="label" style="background: #F8C471; color: #7E5109">${d.nombreSede}</span>`;
                    return ubicacionExpediente;
                }
            },

            {
                "width": "15%",
                "data": function (d) {
                    if (d.RL == null || d.RL == ''  ){
                        return '<p class="m-0"> No definido  </p>';
                    }else{
                        return '<p class="m-0">' + d.RL + '</p>';
                    }
                
                }
            }
        ],

        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": 0
            },

        ],

        "ajax": {
            "url": general_base_url + "Contraloria/getrecepcionContratos",
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function (d) {
            }
        },
        "order": [[1, 'asc']]

    });
}); 

var num=1;
function saltoLinea(value) {
    if(value.length >= 13 * num) {
        document.getElementById('contratos').value=value;
        ++num;
    }
}






$(document).on('click', '.sendCont', function () {
$('#enviarContratos').modal();
});
$(document).ready(function(){
    $("#btn_show").click(function () {

        var validaCont = $('#contratos').val();


        if (validaCont.length <= 0) {

            alerts.showNotification('top', 'right', 'Ingresa los contratos.', 'danger')

        } else {

        $('#btn_show').prop('disabled', true);

         var arr = $('#contratos').val().split('\n');

        var arr2= new Array();
        ini = 0;
        fin = 1;
        indice = 0;
        for( var i = 0; i < arr.length; i+=1) {
            arr2[indice++] = arr.slice(ini,fin);
            ini+=1;
            fin+=1;
        }

        /////////////////////////////////////////////////////////

        var descartaVacios2 = function(obj){
            return Object
                .keys(obj).map( el => obj[el] )
                .filter( el => el.length )
                .length;
        }



        var filtrado2 = arr.filter(descartaVacios2);


        function multiDimensionalUnique2(arr) {
            var uniques = [];
            var itemsFound = {};
            for(var i = 0, l = filtrado2.length; i < l; i++) {
                var stringified = JSON.stringify(filtrado2[i]);
                if(itemsFound[stringified]) { continue; }
                uniques.push(filtrado2[i]);
                itemsFound[stringified] = true;
            }
            return uniques;
        }



        var duplicadosEliminados2 = multiDimensionalUnique2(filtrado2);

        ///////////////////ARREGLO IMPORTANTE ////////////////////////
        var descartaVacios = function(obj){
            return Object
                .keys(obj).map( el => obj[el] )
                .filter( el => el.length )
                .length;
        }



        var filtrado = arr2.filter(descartaVacios);

        function multiDimensionalUnique(arr) {
            var uniques = [];
            var itemsFound = {};
            for(var i = 0, l = filtrado.length; i < l; i++) {
                var stringified = JSON.stringify(filtrado[i]);
                if(itemsFound[stringified]) { continue; }
                uniques.push(filtrado[i]);
                itemsFound[stringified] = true;
            }
            return uniques;
        }


        var duplicadosEliminados = multiDimensionalUnique(filtrado);
        arrw = JSON.stringify(duplicadosEliminados);
        fLen = duplicadosEliminados2.length;
        text = "<ul>";
        for (i = 0; i < fLen; i++) {
            var hey = text += "<li>" + duplicadosEliminados2[i] + "</li>";
        }

        text += "</ul>";
        $.ajax({
            data:  "datos=" + arrw,
            url: general_base_url + "Contraloria/registro_lote_contraloria_proceceso10",
            type:  'post',
          success: function(data){
          response = JSON.parse(data);

            if(response.message == 'OK') {
                $('#btn_show').prop('disabled', false);
                $('#enviarContratos').modal('hide');
                $('#tabla_envio_RL').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Contratos enviado.", "success");
            } else if(response.message == 'VOID'){
                $('#btn_show').prop('disabled', false);
                $('#enviarContratos').modal('hide');
                $('#tabla_envio_RL').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "No hay contratos por registrar.", "danger");
            } else if(response.message == 'ERROR'){
                $('#btn_show').prop('disabled', false);
                $('#enviarContratos').modal('hide');
                $('#tabla_envio_RL').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            } else if(response.message == 'NODETECTED'){
                $('#btn_show').prop('disabled', false);
                $('#enviarContratos').modal('hide');
                $('#tabla_envio_RL').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "No se encontro el número de contrato.", "danger");
            }
          },
          error: function( data ){
            $('#btn_show').prop('disabled', false);
                $('#enviarContratos').modal('hide');
                $('#tabla_envio_RL').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
          }

        });

      }

    });

});


// jQuery(document).ready(function(){

// jQuery('#enviarContratos').on('hidden.bs.modal', function (e) {
// jQuery(this).removeData('bs.modal');    
// jQuery(this).find('#contratos').val('');
// })

// })


