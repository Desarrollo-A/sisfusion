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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado comisiones:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="pagadas_mktd" id="pagadas_mktd"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM" id="totalM"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM2" id="totalM2"></b></p>
                      </div>
                    </div>                        
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN" id="totalN"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN2" id="totalN2"></b></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="material-datatables">
                  <div class="form-group">
                    <div class="table-responsive">
                      <table class="table-striped table-hover"  id="tabla_bonos" name="tabla_bonos">
                        <thead>
                          <tr>
                            <th>USUARIO</th>
                            <th>COMISIÓN TOTAL</th>
                            <th>Bono NUSKAH</th>
                            <th># PAGO</th>
                            <th>MONTO BONO</th>
                            <th>PAGADO NUSKAH</th>
                            <th>Bono MKTD</th>
                            <th># PAGO</th>
                            <th>MONTO BONO</th>
                            <th>PAGADO MKTD</th>
                            <th>TOTAL</th>
                          </tr>
                          <tr style="background:#003D82 !important;font-size: .7em;line-height:10px;" >
                            <th style="font-size: 1em;"></th>                
                            <th style="font-size: 1em;background-color:#FE9F3F;">MONTO GENERAL DE COMISIÓN</th>
                            <th style="font-size: 1em;background-color:#6393C4;line-height:10px;" colspan="4">BONO NUSKAH - MKTD 5 MENSUALIDADES</th>
                            <th style="font-size: 1em;background-color:#9863C4;line-height:10px;" colspan="4">BONO MARKETING - COMISIONES SIN EVIDENCIA DISPERSADO A 12 MESES ENTRE TODOS LOS INVOLUCRADOS</th>
                            <th style="font-size: 1em;background-color:#37B617;">TOTAL</th>
                          </tr>
                        </thead>
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

    $('#mes').change( function(){
      mes = $('#mes').val();
      anio = $('#anio').val();
      if(anio == ''){
      }
      else{
        getComisionesPasadas(mes, anio, 0, 0);
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

        getComisionesPasadas(mes, anio, 0, 0);
      }      
    });

    let titulos = [];
    $('#tabla_bonos thead tr:eq(0) th').each( function (i) {
      if(i != 10 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text"  class="textoshead"  placeholder="'+title+'"/>');
        $('input', this).on('keyup change', function() {
          if (tabla_bonos1.column(i).search() !== this.value) {
            tabla_bonos1.column(i).search(this.value).draw();

            var total = 0;
            var index = tabla_bonos1.rows({
              selected: true,
              search: 'applied'
            }).indexes();

            var data = tabla_bonos1.rows(index).data();
            let SumaNus=0;
            let SumaMKTD=0;
            let com=0;
            let pagado1=0;
            let pagado2=0;
            let pagado_mktd=0;

            $.each(data, function(i, v) {
              total += parseFloat(v.Total);
              SumaNus += parseFloat(v.sumaBono1);
              SumaMKTD += parseFloat(v.sumaBono2);
              com += parseFloat(v.comision);
              if(v.pagadoBono1 != null || v.pagadoBono1 != undefined){
                pagado1 += parseFloat(v.pagadoBono1);
              }
              
              if(v.pagadoBono2 != null || v.pagadoBono2 != undefined){
                pagado2 += parseFloat(v.pagadoBono2);
              }

              if(v.pagado_mktd != null || v.pagado_mktd != undefined){
                pagado_mktd += parseFloat(v.pagado_mktd);
              }        
            });

            var NUS = formatMoney(SumaNus);
            document.getElementById("totalN").innerHTML = '$'+NUS;
            var MK = formatMoney(SumaMKTD);
            document.getElementById("totalM").innerHTML = '$'+MK;
            var comi = formatMoney(com);
            document.getElementById("totalC").innerHTML = '$'+comi;
            var pag1 = formatMoney(pagado1);
            document.getElementById("totalN2").innerHTML = '$'+pag1;
            var pag2 = formatMoney(pagado2);
            document.getElementById("totalM2").innerHTML = '$'+pag2;
            var pagado_mktdT = formatMoney(pagado_mktd);
            document.getElementById("pagadas_mktd").innerHTML = '$'+pagado_mktdT;
          }
        });
      }  
    });

    getComisionesPasadas(0,0);
    function getComisionesPasadas(mes,anio){
      let sumaT=0;

      $('#tabla_bonos').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        let SumaNus=0;
        let SumaMKTD=0;
        let com=0;
        let pagad1=0;
        let pagad2=0;
        let pagado_mktd=0;

        $.each(json.data, function(i, v) {
          total += parseFloat(v.Total);
          SumaNus += parseFloat(v.sumaBono1);
          SumaMKTD += parseFloat(v.sumaBono2);
          com += parseFloat(v.comision);

          if(v.pagadoBono1 != null || v.pagadoBono1 != undefined){
            pagad1 += parseFloat(v.pagadoBono1);
          }
          
          if(v.pagadoBono2 != null || v.pagadoBono2 != undefined){
            pagad2 += parseFloat(v.pagadoBono2);
          }

          if(v.pagado_mktd != null || v.pagado_mktd != undefined){
            pagado_mktd += parseFloat(v.pagado_mktd);
          }              
        });
        
        var NUS = formatMoney(SumaNus);
        document.getElementById("totalN").innerHTML = '$'+NUS;
        var MK = formatMoney(SumaMKTD);
        document.getElementById("totalM").innerHTML = '$'+MK;
        var comi = formatMoney(com);
        document.getElementById("totalC").innerHTML = '$'+comi;
        var pag1 = formatMoney(pagad1);
        document.getElementById("totalN2").innerHTML = '$'+pag1;
        var pag2 = formatMoney(pagad2);
        document.getElementById("totalM2").innerHTML = '$'+pag2;
        var pagado_mktdT = formatMoney(pagado_mktd);
        document.getElementById("pagadas_mktd").innerHTML = '$'+pagado_mktdT;
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
          title: 'REPORTE COMISIONES',
          exportOptions: {
            columns: [0,1,2,3,4,5,6,7,8,9,10],
            format: {
              header:  function (d, columnIdx) {
                if(columnIdx==10){
                  return ' TOTAL '; 
                }
                else{
                  return ' '+titulos[columnIdx] +' '; 
                }        
              },
            }
          }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
          "width": "8%",
          "data": function( d ){
            return '<p class="m-0"><center>'+d.nombre+'</center></p>';
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            return '<p class="m-0"><b style="color:green;">$'+formatMoney(d.comision)+'</b></p>';
            sumaT=sumaT+parseFloat(d.comision);
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            return '<p class="m-0"><b>$'+formatMoney(d.bono1)+'</b></p>';
          }
        },
        {
          "width": "2%",
          "data": function( d ){
            let a='';
            d.bono_1.forEach((element, index, array) => {
              if(index == (d.bono_1.length -1)){
                a = a +  `<p class="m-0"><b> ${element.n_p}/${element.num_pagos}</b></p>`;
              }
            });
            
            return a;
          }
        },
        {
          "width": "4%",
          "data": function( d ){
            let a='';
            let suma=0;
            d.bono_1.forEach((element, index, array) => {
              suma = suma + parseFloat(element.impuesto1);
              if(index == (d.bono_1.length -1)){
                a = a + `<p class="m-0"><b style="color:green;">$${formatMoney(suma)}</b></p>`;
              }
            });

            return a;
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            let pagado = 0;
            if(d.forma_pago == 3){
                pagado = d.pagadoBono1 - (d.pagadoBono1 * (d.impuesto / 100));
            }
            else{
              pagado=d.pagadoBono1;
            }
            return '<p class="m-0"><b>$'+formatMoney(pagado)+'</b></p>';
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            return '<p class="m-0"><b>$'+formatMoney(d.bono2)+'</b></p>';
          }
        },
        {
          "width": "2%",
          "data": function( d ){
            let a='';
            d.bono_2.forEach((element, index, array) => {
              if(index == (d.bono_2.length -1)){
                a = a +  `<p class="m-0"><b>${element.n_p}/${element.num_pagos}</b></p>`;
              }
            });
            
            return a;
          }
        },
        {
          "width": "4%",
          "data": function( d ){
            let a='';
            let suma=0;
            d.bono_2.forEach((element, index, array) => {
              suma = suma + parseFloat(element.impuesto1);
              if(index == (d.bono_2.length -1)){
                a = a + `<p class="m-0"><b style="color:green;">$${formatMoney(suma)}</b></p>`;
                sumaT=sumaT+parseFloat(suma);
              }
            });
            
            return a;
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            let pagado = 0;
            if(d.forma_pago == 3){
              pagado = d.pagadoBono2 - (d.pagadoBono2 * (d.impuesto / 100));
            }
            else{
              pagado=d.pagadoBono2;
            }

            return '<p class="m-0"><b>$'+formatMoney(pagado)+'</b></p>';
          }
        },
        {
          "width": "3%",
          "data": function( d ){
            return '<p class="m-0"><b  style="color:green;">$'+formatMoney(d.Total)+'</b></p>';
            sumaT=0;
          }
        }],
        columnDefs: [{
          "searchable": true,
          "orderable": false,
          "targets": 0
        }], 
        ajax: {
          url: url2 + "Comisiones/ReporteTotalMktd/"+mes+"/"+anio,
          type: "POST",
          cache: false,
          data: function( d ){
          },
        },
      });
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
  </script>
</body>