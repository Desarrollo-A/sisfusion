$("#tabla_bonos").prop("hidden", true);
$('#roles').change(function(ruta){
  roles = $('#roles').val();
  param = $('#param').val();
  $("#users").empty().selectpicker('refresh');
  $.ajax({
    url: general_base_url+'Comisiones/getUsuariosRolBonos/'+roles,
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var id = response[i]['id_usuario'];
          var name = response[i]['name_user'];
          $("#users").append($('<option>').val(id).text(name));
      }

      $("#users").selectpicker('refresh');
    }
  });
});

$('#roles').change(function(ruta){
  roles = $('#roles').val();
  users = $('#users').val();
  if(users == '' || users == null || users == undefined){
      users = 0;
  }

  getBonusCommissions(roles, users);
});

$('#users').change(function(ruta){
  roles = $('#roles').val();
  users = $('#users').val();
  if(users == '' || users == null || users == undefined){
      users = 0;
  }
  else{
    getBonusCommissions(roles, users);
  }
});

var tr;
var tabla_bonos2 ;
var totaPen = 0;

//INICIO TABLA QUERETARO*********************************************
let titulos = [];
$('#tabla_bonos thead tr:eq(0) th').each( function (i) {
  if(i != 0 ){
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_bonos1.column(i).search() !== this.value) {
          tabla_bonos1
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_bonos1.rows({
            selected: true,
            search: 'applied'
        }).indexes();

            var data = tabla_bonos1.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.pago);

            });

            var to1 = formatMoney(total);
            document.getElementById("totalp").textContent = to1;
        }
    });
  }  
});

function getBonusCommissions(roles, users){
  $("#tabla_bonos").prop("hidden", false);
  $('#tabla_bonos').on('xhr.dt', function(e, settings, json, xhr) {
      var total = 0;
      $.each(json.data, function(i, v) {
          total += parseFloat(v.pago);
      });
      var to = formatMoney(total);
      document.getElementById("totalp").textContent = '$' + to;
  });
  $("#tabla_bonos").prop("hidden", false);

  tabla_bonos1 = $("#tabla_bonos").DataTable({
    dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
    width: 'auto',
    buttons: [{
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
      className: 'btn buttons-excel',
      titleAttr: 'Descargar archivo de Excel',
      title: 'HISTORIAL BONOS - PAGOS LIQUIDADOS',
      exportOptions: {
        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
        format: {
          header:  function (d, columnIdx) {
            if(columnIdx == 0){
              return '';
            }else if(columnIdx == 1){
              return 'ID PAGO';
            }else if(columnIdx == 2){ 
              return 'ID BONO';
            }else if(columnIdx == 3){
              return 'USUARIO';
            }else if(columnIdx == 4){
              return 'RFC';
            }else if(columnIdx == 5){
              return 'ROL ';
            }else if(columnIdx == 6){
              return 'MONTO BONO';
            }else if(columnIdx == 7){
              return 'ABONDADO';
            }else if(columnIdx == 8){
              return 'PENDIENTE';
            }else if(columnIdx == 9){
              return 'NÚMERO PAGO';
            }else if(columnIdx == 10){
              return 'PAGO INDIVIDUAL';
            }else if(columnIdx == 11){
              return 'IMPUESTO';
            }else if(columnIdx == 12){
              return 'TOTAL A PAGAR';
            }else if(columnIdx == 13){
              return 'FECHA REGISTRO';
            }else if(columnIdx == 14){
              return 'ESTATUS';
            }else if(columnIdx != 15 && columnIdx !=0){
              return ' '+titulos[columnIdx-1] +' ';
            }
          }
        }
      },
    }],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url +"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [{
      "width": "4%",
      "data": function( d ){
        return '<p class="m-0"><center>'+d.id_pago_bono+'</center></p>';
      }
    },  
    {
      "width": "5%",
      "data": function( d ){
        return '<p class="m-0"><center>'+d.id_bono+'</center></p>';
      }
    },
    {
      "width": "8%",
      "data": function( d ){
        return '<p class="m-0"><b>'+d.nombre+'</b></p>';
      }
    },
     {
      "width": "7%",
      "data": function( d ){
        return '<p class="m-0"><b>'+d.rfc+'</b></p>';
      }
    },
    {
      "width": "7%",
      "data": function( d ){
        return '<p class="m-0">'+d.id_rol+'</p>';
      }
    },
    {
      "width": "7%",
      "data": function( d ){
        if(d.estatus == 2){
          return '<p class="m-0"><center>$'+formatMoney(d.monto)+'</center></p><p style="font-size: .8em"><span class="label" style="background:#5FD482;">LIQUIDADO</span></p>';
        }else{
          return '<p class="m-0"><center>$'+formatMoney(d.monto)+'</center></p>';
        }
      }
    },
    {
      "width": "7%",
      "data": function(d) {
        let abonado = d.n_p*d.pago;
        if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
          abonado = d.monto;
        }else{
          abonado =d.n_p*d.pago;
        }
        return '<p class="m-0"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
      }
    },
    {
      "width": "7%",
      "data": function(d) {
        let pendiente = d.monto - (d.n_p*d.pago);
        if(pendiente < 1){
          pendiente = 0;
        }else{
          pendiente = d.monto - (d.n_p*d.pago);
        }

        if(d.estatus == 2){
          return '<p class="m-0"><center>$ 0.00</center></p>';
        }else{
          return '<p class="m-0"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
        }
      }
    },
    {
      "width": "7%",
      "data": function( d ){
        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
      }
    },
    {
      "width": "7%",
      "data": function( d ){
        return '<p class="m-0"><center><b>$'+formatMoney(d.pago)+'</b></center></p>';
      }
    },
    {
      "width": "7%",
      "data": function(d) {
        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
          return '<p class="m-0"><center><b>0%</b></center></p>';
        }else{
          return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
        }
      }
    },
    {
      "width": "7%",
      "data": function(d) {
        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
          return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
        }else{
          let iva = ((parseFloat(d.impuesto)/100)*d.pago);
          let pagar = parseFloat(d.pago) - iva;
          return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
        }
      }
    },
    {
      "width": "8%",
      "data": function( d ){
        return '<p class="m-0"><center>'+d.fecha_abono+'</center></p>';
      }
    },
    {
      "width": "7%",
      "data": function( d ){
        if(d.estado == 1){
          estatus = d.est;
          color='29A2CC';
        }else if(d.estado == 2){
          estatus=d.est;
          color='9129CC';
        }else if(d.estado == 3){
          estatus=d.est;
          color='05A134';
        }else if(d.estado == 4){
          estatus=d.est;
          color='9129CC';
        }else if(d.estado == 5){
          estatus=d.est;
          color='red';
        }else if(d.estado == 6){
          estatus=d.est;
          color='4D7FA1';
        }
        return '<span class="label label-danger" style="background:#'+color+'">'+estatus+'</span>';
      }
    },
    {
      "width": "5%",
      "orderable": false,
      "data": function( d ){
          return '<button class="btn-data btn-blueMaderas consulta_abonos" value="'+d.id_pago_bono+'" title="Historial"><i class="fas fa-info"></i></button>';
      }
    }],
    columnDefs: [{
      orderable: false,
      className: 'select-checkbox',
      targets: 0,
      searchable:false,
      className: 'dt-body-center'
    }], 
    ajax: {
      url: general_base_url + "Comisiones/getBonosAllUser/" + roles + "/" + users,
      type: "POST",
      cache: false,
      data: function( d ){
      }
    },
  });

  $("#tabla_bonos tbody").on("click", ".consulta_abonos", function(e){
    e.preventDefault();
    e.stopImmediatePropagation();

    id_pago = $(this).val();
    lote = $(this).attr("data-value");

    $("#modal_bonos").modal();
    $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE BONO</b></h5></p>');
    $.getJSON(general_base_url+"Pagos/getHistorialAbono2/"+id_pago).done( function( data ){
      $.each( data, function(i, v){
        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">'+v.comentario+'<br><b style="color:#3982C0;font-size:0.9em;">'+v.date_final+'</b><b style="color:gray;font-size:0.9em;"> - '+v.nombre_usuario+'</b></p></div>');
      });
    });
  });
}

/**--------------------------------------------------------- */

$("#form_bonos").on('submit', function(e){ 
  e.preventDefault();
  let formData = new FormData(document.getElementById("form_bonos"));
  formData.append("dato", "valor");
  $.ajax({
    url: 'saveBono',
    data: formData,
    method: 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data) {
      if (data == 1) {
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
        document.getElementById("form_bonos").reset();
      } else if(data == 2) {
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
      }else if(data == 3){
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
      }
    },
    error: function(){
      $('#miModalBonos').modal('hide');
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  });
});

function filterFloat(evt,input){
  var key = window.Event ? evt.which : evt.keyCode;   
  var chark = String.fromCharCode(key);
  var tempValue = input.value+chark;
  var isNumber = (key >= 48 && key <= 57);
  var isSpecial = (key == 8 || key == 13 || key == 0 ||  key == 46);
  if(isNumber || isSpecial){
    return filter(tempValue);
  }        
  
  return false;    
}

function filter(__val__){
  var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
  return (preg.test(__val__) === true);
}

function closeModalEng(){
  document.getElementById("form_abono").reset();
  a = document.getElementById('inputhidden');
  padre = a.parentNode;
  padre.removeChild(a);
  $("#modal_abono").modal('toggle');
}

// FUNCTION MORE
$(window).resize(function(){
  tabla_bonos1.columns.adjust();
});

function formatMoney( n ) {
  var c = isNaN(c = Math.abs(c)) ? 3 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function cleanCommentsAsimilados() {
  var myCommentsList = document.getElementById('comments-list-asimilados');
  var myCommentsLote = document.getElementById('nameLote');
  myCommentsList.innerHTML = '';
  myCommentsLote.innerHTML = '';
}