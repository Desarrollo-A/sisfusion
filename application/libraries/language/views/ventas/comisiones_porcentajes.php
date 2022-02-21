<body>
<div class="wrapper">
    <?php
    if($this->session->userdata('id_rol')=="13")//contraloria
    {        
 
         $dato = array(
        'home'           => 0,
        'listaCliente'   => 0,
        'expediente'     => 0,
        'corrida'        => 0,
        'documentacion'  => 0,
        'historialpagos' => 0,
        'inventario'     => 0,
        'estatus20'      => 0,
        'estatus2'       => 0,
        'estatus5'       => 0,
        'estatus6'       => 0,
        'estatus9'       => 0,
        'estatus10'      => 0,
        'estatus13'      => 0,
        'estatus15'      => 0,
        'enviosRL'       => 0,
        'estatus12'      => 0,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 1,
        'comnuevas'      => 0,
        'comhistorial'   => 0,
        'integracionExpediente' => 0,
        'expRevisados' => 0,
        'estatus10Report' => 0,
        'rechazoJuridico' => 0
    );


        //$this->load->view('template/contraloria/sidebar', $dato);
        $this->load->view('template/sidebar', $dato);
    }
    else
    {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <style type="text/css">
        ::-webkit-input-placeholder { / Chrome/Opera/Safari /
            color: white;
            opacity: 0.4;

            ::-moz-placeholder { / Firefox 19+ /
                color: white;
                opacity: 0.4;
            }

            :-ms-input-placeholder { / IE 10+ /
                color: white;
                opacity: 0.4;
            }

            :-moz-placeholder { / Firefox 18- /
                color: white;
                opacity: 0.4;
            }
        }
        .modal-backdrop.in {
            opacity: .8;
            filter: alpha(opacity=80); / Para versiones anteriores de IE /
        }
        .card-config{
            float: right;
            margin: 5px 5px 0 0;
            padding: 0 4px;
            color: gray;
        }
        .card-config:hover{
            color: #103f75;
        }
        .btn-conf{
            border:none;
            background-color: #fff;
            padding:0px;
        }
        .input-con:focus{
            box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(189, 189, 189);
        }
        .quantity input {
        width: 45px;
        height: 42px;
        line-height: 1.65;
        float: left;
        display: block;
        padding: 0;
        margin: 0;
        padding-left: 20px;
        border: 1px solid #eee;
        }
        .quantity input:focus {
        outline: 0;
        }
    </style>

    <div class="content">
        <div class="container-fluid">   
            <div class="row">            
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="primary">
                            <b>NORMAL</b>
                        </div>
 
                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_comisiones(0)" title="Agregar nuevo plan venta NORMAL">
                            <i class="fa fa-cogs" aria-hidden="true" style="color: #3CB371;"></i>
                        </button>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_historial(0)" title="Ver historial">
                            <!-- <i class="fa fa-cogs" aria-hidden="true"></i> -->
                            <i class="fa fa-history" aria-hidden="true" style="color: #6A5ACD;"></i>

                        </button>
                        </div>



                        <div class="card-footer" style="border-top:none">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Porcentajes correspondientes a venta <b>normal.</b><br>

                                <p>Fecha inicio: <b><?php echo $fecha_MAX[0]->fecha_apartadado; ?></b></p>
                                
                                <p>Fecha fin: <b><?php echo $fecha_normal;?></b></p>

                            </div>
<!-- 
                             <div>
                            </div> -->


                        </div>
                        <div class="card-content" style="display:grid; height: 270px; padding:10px 0; font-size:13px">
                            <?php
                            $limite = $count_normal[0]->limit_normal;
                            if($limite>0){
                                for ($i = 0; $i <= $limite-1; $i++) {
                                    echo '<div class=""box-info-com" style="display:inline-flex; width:100%;  justify-content:space-evenly; align-items:center; font-weight: bold; color: gray; border-top:1px solid #eee; padding: 0 15px">
                                    <div class="box-rol" style="text-align: initial; width:100%">'.$porcentaje_normal[$i]->nombre.'</div>
                                    <div class="box-porcentaje style="text-align: initial;">'.$porcentaje_normal[$i]->porcentaje.'%</div></div>';
                                }
                            }
                            else{
                                echo '<center><div class="col-lg-12 col-md-12 col-sm-12">Sin datos a mostrar.</div></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="primary">
                            <b>CLUB MAD.</b>
                        </div>
                
                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_comisiones(12)" title="Agregar nuevo plan CLUB MAD.">
                            <i class="fa fa-cogs" aria-hidden="true" style="color: #3CB371;"></i>
                        </button>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_historial(12)" title="Ver historial">
                            <i class="fa fa-history" aria-hidden="true" style="color: #6A5ACD;"></i>

                        </button>
                        </div>



                        <div class="card-footer" style="border-top:none">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Porcentajes correspondientes a venta en conjunto con <b>CLUB MAD.</b>
                            </div>
                           
                        </div>
                        <div class="card-content" style="display:grid; height: 270px; padding:0 0 10px; font-size:11px">                        
                            <?php
                            $limite = $count_Club[0]->limit_Club;
                            if($limite>0){
                                for ($i = 0; $i <= $limite-1; $i++) {
                                    echo '<div class=""box-info-com" style="display:inline-flex; width:100%; justify-content:space-evenly; align-items:center; font-weight: bold; color: gray; border-top:1px solid #eee; padding: 0 15px">
                                    <div class="box-rol" style="text-align: initial; width:100%">'.$porcentaje_Club[$i]->nombre.'</div>
                                    <div class="box-porcentaje style="text-align: initial;">'.$porcentaje_Club[$i]->porcentaje.'%</div></div>';
                                }
                            }
                            else{
                                echo '<center><div class="col-lg-12 col-md-12 col-sm-12">Sin datos a mostrar.</div></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="primary">
                            <b>MKTD.</b>
                        </div>
                           <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_comisiones(6)" title="Agregar nuevo plan MKTD.">
                            <i class="fa fa-cogs" aria-hidden="true" style="color: #3CB371;"></i>
                        </button>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_historial(6)" title="Ver historial">
                            <i class="fa fa-history" aria-hidden="true" style="color: #6A5ACD;"></i>

                        </button>
                        </div>
                        <div class="card-footer" style="border-top:none">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Porcentajes correspondientes a venta en conjunto con <b>MKTD.</b>
                            </div>
                        </div>
                        <div class="card-content" style="display:grid; height: 270px; padding:10px 0; font-size:13px">                        
                            <?php
                            $limite = $count_Mktd[0]->limit_mktd;
                            if($limite>0){
                                for ($i = 0; $i <= $limite-1; $i++) {
                                    echo '<div class=""box-info-com" style="display:inline-flex; width:100%; justify-content:space-evenly; align-items:center; font-weight: bold; color: gray; border-top:1px solid #eee; padding: 0 15px">
                                        <div class="box-rol" style="text-align: initial; width:100%">'.$porcentaje_Mktd[$i]->nombre.'</div>
                                        <div class="box-porcentaje style="text-align: initial;">'.$porcentaje_Mktd[$i]->porcentaje.'%</div></div>';                                        
                                }
                            }
                            else{
                                echo '<center><div class="col-lg-12 col-md-12 col-sm-12">Sin datos a mostrar.</div></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6"> 
                    <div class="card card-stats" >
                        <div class="card-header" data-background-color="primary">
                            <b>CLUB MAD. + MKTD.</b>
                        </div>
        

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_comisiones(14)" title="Agregar nuevo plan CLUB MAD. + MKTD.">
                            <i class="fa fa-cogs" aria-hidden="true" style="color: #3CB371;"></i>
                        </button>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_historial(14)" title="Ver historial">
                            <!-- <i class="fa fa-cogs" aria-hidden="true"></i> -->
                            <i class="fa fa-history" aria-hidden="true" style="color: #6A5ACD;"></i>

                        </button>
                        </div>


                        <div class="card-footer" style="border-top:none">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Porcentajes correspondientes a venta en conjunto con <b>CLUB MAD. y MKTD.</b>
                            </div>
                        </div>
                        <div class="card-content" style="display:grid; height: 270px; padding:10px 0; font-size:11px">
                            <?php
                            $limite = $count_ClubMktd[0]->limit_clubmktd;
                            if($limite>0){
                                for ($i = 0; $i <= $limite-1; $i++) {
                                    echo '<div class=""box-info-com" style="display:inline-flex; width:100%;  justify-content:space-evenly; align-items:center; font-weight: bold; color: gray; border-top:1px solid #eee; padding: 0 15px">
                                        <div class="box-rol" style="text-align: initial; width:100%">'.$porcentaje_ClubMktd[$i]->nombre.'</div>
                                        <div class="box-porcentaje style="text-align: initial;">'.$porcentaje_ClubMktd[$i]->porcentaje.'%</div></div>';
                                }
                            }
                            else{
                                echo '<center><div class="col-lg-12 col-md-12 col-sm-12">Sin datos a mostrar.</div></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="primary">
                            <b>USA</b>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_comisiones(13)" title="Agregar nuevo plan USA">
                            <i class="fa fa-cogs" aria-hidden="true" style="color: #3CB371;"></i>
                        </button>
                        </div>

                        <div class="card-config">
                        <button class="btn-conf" onclick="mostrar_historial(13)" title="Ver historial">
                            <!-- <i class="fa fa-cogs" aria-hidden="true"></i> -->
                            <i class="fa fa-history" aria-hidden="true" style="color: #6A5ACD;"></i>

                        </button>
                        </div>

                        <div class="card-footer" style="border-top:none">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Porcentajes correspondientes a venta en conjunto con <b>asesor USA.</b>
                            </div>
                        </div>
                        <div class="card-content" style="display:grid; height: 270px; padding:10px 0; font-size:11px">                        
                            <?php
                            $limite = $count_Usa[0]->limit_usa;
                            if($limite>0){
                                for ($i = 0; $i <= $limite-1; $i++) {
                                    echo '<div class=""box-info-com" style="display:inline-flex; width:100%;  justify-content:space-evenly; align-items:center; font-weight: bold; color: gray; border-top:1px solid #eee; padding: 0 15px">
                                        <div class="box-rol" style="text-align: initial; width:100%">'.$porcentaje_Usa[$i]->nombre.'</div>
                                        <div class="box-porcentaje style="text-align: initial;">'.$porcentaje_Usa[$i]->porcentaje.'%</div></div>';
                                }
                            }
                            else{
                                echo '<center><div class="col-lg-12 col-md-12 col-sm-12">Sin datos a mostrar.</div></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
    </div>
</div>

</div><!--main-panel close-->
<!-- MODAL DINÁMICO CONF. COMISIONES -->
<div class="modal fade modal-alertas" id="modal_conf_com" role="dialog">
    <div class="modal-dialog modal-sm" style="width:400px; margin-top:40px">
        <div class="modal-content">
            <div class="modal-header bg-olive">
            <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>  
            <form method="post" id="confComisiones">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL DINÁMICO CONF. COMISIONES -->

</body>
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

function mostrar_comisiones(id_relacion){
    $.getJSON(url + "Comisiones/getComisiones/"+id_relacion).done( function( data ){
        $("#modal_conf_com .modal-body").html("");

        var elemento = "";

         elemento += '<div class="row" style="margin-bottom:10px;">';
         elemento += '<div class="col-md-12">';
         elemento += '<label>Fecha inicio plan de comisiones</label>';
         elemento += '<input type="date" name="fecha_apartado" class="form-control" min="<?php $hoy=date("Y-m-d"); echo $hoy;?>" />';
         elemento += '</div></div>';


               $.each( data, function( i, v){
            
            elemento += '<div class="row" style="margin-bottom:10px;">';
            elemento += '<div class="col-md-7">';
            elemento += '<p style="margin:0; color:#333">'+v.nombre+'</p>';
            elemento += '</div>';
            elemento += '<div class="col-md-5" style="display:flex; align-items:center">';
            elemento += '<input type="hidden" name="valor_rol[]" value="'+v.id_rol+'">';
            elemento += '<input type="hidden" name="valor_medio" value="'+v.medio_comision+'">';
            elemento += '<input type="hidden" name="id_rel" id="id_rel" value="'+v.relacion_prospeccion+'">';
            elemento += '<div class="quantity">';
            elemento += '<input type="text" readonly value="'+v.porcentaje+'" style="background-image:none; background-color: #fff; border-radius:none; padding: 0 10px; height:30px; width:100%" required/>';
            elemento += '</div>';
            elemento += '<div class="quantity">';
            elemento += '<input type="number"  min="1" max="100" step="any" name="comisiones[]" value="" style="background-image:none; background-color: #eee; border-radius:5px; padding: 0 10px; height:30px; width:100%" required/>';
            elemento += '</div>';
            elemento += '<p style="margin:0; padding-left:3px">%</p>';
            elemento += '</div>';
            // elemento += '<div class="col-md-1">';
            // elemento += '</div>';    
            elemento += '</div>';
            
        }); 



        $("#modal_conf_com .modal-body").append(elemento);


        if (id_relacion == 0){
            $(".modal-title").text("COMISIONES NORMALES");
        }
        if (id_relacion == 6){
            $(".modal-title").text("COMISIONES MKTD");
        }
        if (id_relacion == 12){
            $(".modal-title").text("COMISIONES CLUB MAD.");
        }
        if (id_relacion == 13){
            $(".modal-title").text("COMISIONES USA");
        }
        if (id_relacion == 14){
            $(".modal-title").text("COMISIONES CLUB MAD. + MKTD");
        }
        $("#modal_conf_com .modal-body").append('<div class="box-btn-c text-center" style="width:100%"><input type="submit" class="btn btn-primary" value="AGREGAR NUEVO PLAN"></input></div>');
        
        $("#modal_conf_com").modal();
    });     
}

$("#confComisiones").submit( function(e) {
    e.preventDefault();
    // valor = $("#id_rel").val();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + "Comisiones/setComisiones",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9

            success: function(data){
            if( data[0] ){           
                // document.getElementById("confComisiones").submit();
                $('#modal_conf_com').modal('toggle');
                alerts.showNotification("top", "right", "Se han modificado los porcentajes, verifica tu tabla.", "success");
                setTimeout(function() {
                    document.location.reload()
                }, 3000);
            }else{
                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
            }
        },error: function( ){
            alert("ERROR EN EL SISTEMA");
        }
    });
}
});

jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
</script>