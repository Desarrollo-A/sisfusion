<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
  <div class="wrapper">
    <?php
    if($this->session->userdata('id_rol')=="8" || $this->session->userdata('id_rol')=="18"){
      //contraloria
      $this->load->view('template/sidebar');
      
    }
    else{
      echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <div class="content boxContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header card-header-icon" data-background-color="goldMaderas">
                <i class="fas fa-chart-pie fa-2x"></i>
              </div>
              <div class="card-content">
                <div class="encabezadoBox">
                  <h3 class="card-title center-align" >REPORTE COMISIONES</h3>
                  <p class="card-title pl-1">Reporte de todos los bonos y comisiones enviados a contraloría y pagados</p>
                </div>
                <div class="toolbar">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label className="m-0" for="proyecto">Mes</label>
                        <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona mes" data-size="7" required>
                          <?php
                            setlocale(LC_ALL, 'es_ES');
                            for ($i=1; $i<=12; $i++) {
                              $monthNum  = $i;
                              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                              $monthName = strftime('%B', $dateObj->getTimestamp());
                              echo '<option value="'.$i.'">'.$monthName.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label className="m-0">Año</label>
                        <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona año" data-size="7" required>
                          <?php
                            setlocale(LC_ALL, 'es_ES');
                            for ($i=2019; $i<=2021; $i++) {
                                $yearName  = $i;
                                echo '<option value="'.$i.'">'.$yearName.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>         
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente comisiones:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalC" id="totalC"></b></p>
                      </div>
                    </div>
                    <!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado comisiones:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="pagadas_mktd" id="pagadas_mktd"></b></p>
                      </div>
                    </div>-->
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN" id="totalN"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM" id="totalM"></b></p>
                      </div>
                    </div>
                   <!--- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM2" id="totalM2"></b></p>
                      </div>
                    </div>     -->                   
                   
                  <!--  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN2" id="totalN2"></b></p>
                      </div>
                    </div>--->
                  </div>
                </div>
                <div class="material-datatables">
                  <div class="form-group">
                    <div class="table-responsive">
                      <table class="table-striped table-hover text-center"  id="tabla_bonos" name="tabla_bonos">
                        
                      </table>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
  </div>
  </div><!--main-panel close-->
  <?php $this->load->view('template/footer');?>
  <!--DATATABLE BUTTONS DATA EXPORT-->
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var tr;
    var tabla_bonos2 ;
    var totaPen = 0;
    let numNUS ;
        let numMKTD ;
        let titulos = [];
        let NewHeader=[];
        let aaaa = [3,5,7];
        var columns = [
    { "title":"One" },
    { "title":"Two" }, 
    { "title":"cuatro" },
        { "title":"cinco" }

];
console.log(columns);

let TodosDatos=[];
var contador=0;
EjecutarFuncion(0,0)
async function EjecutarFuncion(mes,anio){
  if(mes != 0){
    contador=1;
  }
   
    $.ajax({
      type: 'POST',
      url: '<?=base_url()?>index.php/Comisiones/ReporteTotalMktdFINAL/'+mes+"/"+anio,
      dataType: 'json',
      beforeSend: function(){
      },
      
      success: function(data) {
                var NUS = formatMoney(data['sumaBono1']);
                document.getElementById("totalN").innerHTML = '$'+NUS;
                var MK = formatMoney(data['sumaBono2']);
                document.getElementById("totalM").innerHTML = '$'+MK;
                var comi = formatMoney(data['sumaTotalComision']);
                document.getElementById("totalC").innerHTML = '$'+comi;

        $('#tabla_bonos').empty();
        $('#qlv').empty();
        NewHeader = [];
        TodosDatos = [];
        titulos = [];
    
        TodosDatos = data['data'];
        numNUS = data['numeroMayorNUS'];
         numMKTD = data['numeroMayorMKTD'];
          NewHeader[0] = {'title':'Usuario'};
          if(mes != 0){
            let mesActual = $('select[name="mes"] option:selected').text();

            NewHeader[1] = {'title':'Comisión '+mesActual};
          }else{
            NewHeader[1] = {'title':'Comisión total'};
          }
          console.log(data['data'])
         let NumeroTotal = (numNUS + numMKTD) + 3;
        for (let index = 2; index < ((numNUS * 2) + (numMKTD *2)) +2; index++) {
            if(index%2 == 0){
              NewHeader[index] = {'title':'# Pago'};
            }else{
              NewHeader[index] = {'title':'Monto'};
            }
        }
        NewHeader[NewHeader.length] = {'title':'Total'};

if(contador == 0){
  CrearTable();
}else{
  $('#tabla_bonos').DataTable().destroy();
  $('#tabla_bonos thead').empty();

$('#tabla_bonos tbody').empty();
  CrearTable();
}
      },
      complete: function(data){
      },
      
      async: false 
    })
}
$( document ).ajaxStop(function(){
  LlamarTable();
});

/*async function CambiarMes(mes){
  alert(mes)
  NewHeader[1]={'title':''+mes+''};
  console.log(NewHeader[1])
  titulos[1]=mes;
}*/
    console.log(TodosDatos);
    $('#mes').change( function(){
      mes = $('#mes').val();
      anio = $('#anio').val();
      let mesActual = $('select[name="mes"] option:selected').text();
      if(anio == ''){
      }
      else{
        EjecutarFuncion(mes, anio);
      }
    });
    $(document).ready(function(){
      $('#anio').html("");
      var d = new Date();
      var n = d.getFullYear();
      for (var i = n; i >= 2020; i--){
        var id = i;
        $("#anio").append($('<option>').val(id).text(id));
      }
      $("#anio").selectpicker('refresh');
    });

    $('#anio').change( function(){
      $("#plaza").html("");
      $("#gerente").html("");

      mes = $('#mes').val();
      if(mes == ''){
        mes =0;
      }
      else{
        anio = $('#anio').val();

    EjecutarFuncion(mes, anio);
      }      
    });
    function CrearTable() {
      let Posiciones = [];
let impares = [];
let pares = [];
let ultimo = NewHeader.length -1;
//console.log(ultimo)
      for (let h = 0; h < NewHeader.length; h++) {
            if(h%2 != 0){
              impares.push(h);
            }else{
              if(h != NewHeader.length-1){
                pares.push(h);
              } 
            } 
            Posiciones.push(h);
      }
    tabla_bonos1 = $('#tabla_bonos').DataTable({
    dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'REPORTE COMISIONES',
                exportOptions: {
                    columns: Posiciones,
                    format: {
                        header:  function (d, columnIdx) {
                              if(columnIdx==Posiciones.length -1){
                                return ' TOTAL '; 
                              }else{
                                return ' '+titulos[columnIdx] +' '; 
                              }       
                        },
                    }
                }
            }],
            width: 'auto',
    destroy: true,
    language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
    "searching": true,
    ordering: false,
    "data": TodosDatos,
    "columns": NewHeader,
    
    columnDefs: [
    {
     "targets": pares,
     "render": function(data, type, full, meta) {
                 return  '<p class="m-0"><center><b>'+data+'</b></center></p>';
             }
   },
    {
      "targets": impares,
      "render": function(data, type, full, meta) {
                  return  '<p class="m-0"><b style="color:green;">$'+formatMoney(data)+'</b></p>';
              }
    },
    {
     "targets": ultimo,
     "render": function(data, type, full, meta) {
                 return  '<p class="m-0"><b style="color:green;">$'+formatMoney(data)+'</b></p>';
             }
   },
  ]
  });
    }
    async function LlamarTable(){
      $('#tabla_bonos thead tr:eq(0) th').each( function (i) {
    if(i != 10 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text"  class="textoshead"  placeholder="'+title+'"/>');
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
console.log(data)
                var data = tabla_bonos1.rows(index).data();
                let SumaNus=0;
                            let SumaMKTD=0;
                            let com=0;
                            let pagado1=0;
                            let pagado2=0;
                            let pagado_mktd=0;

                            $.each(data, function(i, v) {
                              console.log(v.length -2)
                              console.log(v.length -1)
                                 SumaNus += parseFloat(v[v.length -2]);
                                SumaMKTD += parseFloat(v[v.length -1]);
                                com += parseFloat(v[1]);            
                });
                var comi = formatMoney(com);
                document.getElementById("totalC").innerHTML = '$'+comi;
                var NUS = formatMoney(SumaNus);
                document.getElementById("totalN").innerHTML = '$'+NUS;
                var MK = formatMoney(SumaMKTD);
                document.getElementById("totalM").innerHTML = '$'+MK;
            }
        });
    }  
});
    }

    function formatMoney( n ) {
      var c = isNaN(c = Math.abs(c)) ? 3 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
  </script>
</body>