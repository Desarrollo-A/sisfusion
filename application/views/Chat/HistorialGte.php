<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        /*-------------------------------------------------------*/
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;  
        $this->load->view('template/sidebar', $datos);
        /*--------------------------------------------------------*/

        if($this->session->userdata('id_rol') != 28 && $this->session->userdata('id_rol') != 18){
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>

        <style type="text/css">
            .flat-icon li {
                display: inline-block;
                padding: 0px 8px;
                vertical-align: middle;
                position: relative;
                top: 7px;
            }
            .flat-icon a img {
                width: 22px;
                border-radius: unset !important;
            }
            ul.list-inline.text-left.d-inline-block.float-left {
                margin-bottom: 0;
            }
            .asesor_message{
                margin: 30px 20px 25px 20%;
                border-radius: 15px;
                background: #3c4858;
                color: #fff;
                padding: 10px;
                display: inline-block;
                position: relative;
                text-align: left;
                max-width: 65%;
                float: right;
                word-wrap: break-word;
            }
            .cliente_message{
                margin: 5px 0px 24px 20px;
                border-radius: 15px;
                background: #0070d0;
                color: #fff;
                padding: 15px;
                display: inline-block;
                position: relative;
                text-align: left;
                max-width: 65%;
                word-wrap: break-word;
            }
            .sb14:before {
                content: "";
                width: 0px;
                height: 0px;
                position: absolute;
                border-left: 11px solid transparent;
                border-right: 16px solid #0070d0;
                border-top: 9px solid #0070d0;
                border-bottom: 21px solid transparent;
                left: -16px;
                top: 0px;
            }
            .li_time{
                position: absolute;
                margin: 3px 24px;
                font-size: 0.7em;
                bottom: 0%;
                list-style: none;

            }
            .sb15:before {
                content: "";
                width: 0px;
                height: 0px;
                position: absolute;
                border-top: 22px solid #3c4858;
                border-bottom: 0px solid transparent;
                border-right: 0px solid #3c4858;
                border-left: 25px solid transparent;
                right: -10px;
                top: -11px;
                transform: rotate(135deg);
            }
            .right_position{
                right: 0%;
            }
            .padding0 {
                padding: 0px;
            }
            .list-inline li{
                display: block!important;
            }
            .msg-box li{
                display:inline-block;
                padding-left: 2px;
                line-height: 0px;
                margin: 0px;
                margin-bottom: 0px;
            }

            .msg-box ul li{
                margin: 0px !important;
                margin-bottom: 0px !important;
            }
            .msg-box ul .list-inline {
                margin: 0px !important;
                margin-bottom: 0px !important;
                margin-left: 0px !important;
            }

            .msg-box img{
                border-radius:90px;
                width: 55px;
                height: 55px;
                margin: 0px;
                margin-bottom: 0px;
            }
            .msg-box li span{
                padding-left:4px;
                color:#545454;
                font-weight:550;
            }
            #Scr{
                resize: none;
                font-size: 13px;
            }

            #Scr::-webkit-scrollbar {
            width: 10px;
            }

            /* Track */
            #Scr::-webkit-scrollbar-track {
            background: #f1f1f1;
            }

            /* Handle */
            #Scr::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
            }

            /* Handle on hover */
            #Scr::-webkit-scrollbar-thumb:hover {
            background: #555;
            }
            #perfil{
                padding: 0px 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #103f75;
                border-radius: 5px 5px 0 0;
                font-weight: 400;
                color: white;
                height:140%;
            }      
        </style>

        <!-- Modals -->
        <div class="modal fade modal-fullscreen" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Evidencia</h4>
                    </div>
                    <div class="modal-body">
                        <div id="fotoevi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <center>
                            <div id="btn-dow" class="text-left"></div>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="consultaModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 450px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="cargar();" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLongTitle">Chat</h5> 
                        <div id="down"></div>
                    </div>
                    <div class="modal-body">
                        <div class="container" >
                            <div class="row  mb-4">
                                <div class="col-lg-4">
                                    <div class="card" id="Scr2">
                                        <div id="perfil" style="padding-left:6%;padding-top:1%;"></div>
                                        <div class="card-body messages-box" style="height: 400px;" id="Scr">
                                            <div class="" id="mensajesid"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->
        
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <input type="hidden" name="nom" id="nom" value="<?=$this->session->userdata('nombre')?>">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-comments fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Historial de prospecciones</h3>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0" id="textPros" name="textPros">Prospecciones: 0</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <input type="date" name="fecha1" id="fecha1" class="form-control input-gral pr-2">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <input type="date" name="fecha2" id="fecha2" class="form-control input-gral pr-2">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <select  name="sede" id="sede" class="selectpicker select-gral m-0">
                                                        <option value='99' selected disabled>Selecciona una sede.</option>
                                                        <option value="1">San Luis Potosí</option>
                                                        <option value='2'>Querétaro</option>
                                                        <option value='3'>Península</option>
                                                        <option value='4'>Ciudad de México</option>
                                                        <option value='5'>León</option>
                                                        <option value='6'>Cancún</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tabla_chats" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ESTATUS</th>
                                                        <th>ID</th>
                                                        <th>SEDE</th>
                                                        <th>EVIDENCIA</th>
                                                        <th>ASESOR</th>
                                                        <th>FECHA CREACIÓN</th>
                                                        <th>ACCIONES</th>
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
            </div><!-- END container-fluid -->
        </div><!-- END container-fluid principal-->
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <script type="text/javascript">
        let url = "<?=base_url()?>";
        let v2;
        $("#file-uploadE").on('change', function(e){        
            v2 = document.getElementById("file-uploadE").files[0].name; 
        });

        let titulos = [];
        $('#tabla_chats thead tr:eq(0) th').each( function (i) {
            if( i != 6){
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (chatsTable.column(i).search() !== this.value ) {
                        chatsTable
                        .column(i)
                        .search(this.value)
                        .draw();
                        
                        var total = 0;
                        var index = chatsTable.rows({ selected: true, search: 'applied' }).indexes();
                        var data = chatsTable.rows( index ).data();
                        let c=0;
                        $.each(data, function(i, v){
                            c++;
                        });
                        document.getElementById("textPros").innerHTML = 'Prospecciones: ' + c;
                    }
                } );
            }
        });

        $('#sede').change(function(){
            var fecha1 = $('#fecha1').val();
            var fecha2 = $('#fecha2').val();
            var sede = $(this).val();
            console.log(sede);
            if(fecha1 != '' && fecha2 != '' && (sede != '' || sede != '99')){
                historialChat(fecha1, fecha2, sede);
            }
        });

        function historialChat(fecha1,fecha2, sede){
            $('#tabla_chats').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                let c=1;
                $.each(json.data, function(i, v){
                    c=c+1;
                });
                document.getElementById("textPros").innerHTML = 'Prospecciones: ' + json.data.length;
            });

            chatsTable = $('#tabla_chats').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DINAMIC COBRANZA APARTADOS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ESTATUS';
                                }else if(columnIdx == 1){
                                    return 'ID';
                                }
                                else if(columnIdx == 2){
                                    return 'SEDE';
                                }
                                else if(columnIdx == 3){
                                    return 'EVIDENCIA';
                                }
                                else if(columnIdx == 4){
                                    return 'ASESOR';
                                }
                                else if(columnIdx == 5){
                                    return 'FECHA';
                                }
                            }
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
                    data: function (d) {
                        return '<center><span class="label label-warning" >Cerrado</span><center>';        
                    }
                },
                { 
                    data: function (d) {
                        return d.idgenerado;
                    }
                },
                { 
                    data: function (d) {
                        if(d.id_sede == 1){
                            return '<p>San Luis Potosí</p>';
                        }else  if(d.id_sede == 2){
                            return '<p>Querétaro</p>';
                        }else  if(d.id_sede == 3){
                            return '<p>Península</p>';
                        }else  if(d.id_sede == 4){
                            return '<p>Ciudad de México</p>';
                        }else  if(d.id_sede == 5){
                            return '<p>León</p>';
                        }else  if(d.id_sede == 6){
                            return '<p>Cancún</p>';
                        }else  if(d.id_sede == 7){
                            return '<p>United States</p>';
                        }
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        return d.asesor;
                    }
                },
                { 
                    data: function (d) {
                    let fecha = d.fecha_creacion.split('.');
                        return fecha[0];
                    }
                },
                { 
                    data: function (d) {
                        return `<div class="d-flex justify-content-center"><button class="btn-data btn-sky consulta_chat" data-id-usuario="${d.idgenerado},${d.id_usuario},${d.idchat},${d.foto},${d.asesor}" title="Consultar"><i class="fas fa-eye"></i></button>
                        <button class="btn-data btn-green ver-evidencia" title="Ver evidencia" data-img="${d.nombre}"><i class="fas fa-cloud-download-alt"></i></button></div>`;
                    }
                }],
                ajax: {
                    "url": "historialAdminPros/"+fecha1+'/'+fecha2+'/'+sede,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){ }
                }
            });
        }

        function recargar_chats() {
            $('#tabla_chats').DataTable().ajax.reload(null, false);
        }

        function cargar() {
            document.getElementById("mensajesid").innerHTML = '' ;
            document.getElementById("perfil").innerHTML = '';
            document.getElementById("down").innerHTML = '';    
        }


        $(document).on('click', '.ver-evidencia', function(e){
            document.getElementById("fotoevi").innerHTML = '';
            document.getElementById("btn-dow").innerHTML = '';

            path = $(this).attr("data-img");
            $("#myModal").modal();
            $('#fotoevi').append(`<img src='<?=base_url()?>static/documentos/cliente/evidencia/${path}' style="width:100%;height:450px;"><br>`);
            $('#btn-dow').append(`<a href="${url}static/documentos/cliente/evidencia/${path}" target="_blank" class="btn btn-success" download><i class="material-icons" data-toggle="tooltip" data-placement="right" title="Evidencia">cloud_download</i> Descargar</a>`);
        });

        $(document).on('click', '.consulta_chat', function(e){
            idgenerado2 = $(this).attr("data-id-usuario");
            var datos = idgenerado2.split(",");
            let idgenerado = datos[0];
            let id_asesor = datos[1];
            let idchat = datos[2];
            let foto = datos[3];
            let nombre = datos[4];

            $('#down').append(`
            <button class="btn btn-round" data-toggle="tooltip" data-placement="top" title="Descargar" onclick="captura('${idgenerado}')"><i class="large material-icons" style="font-size: 20px;">image</i></button>
            `);

            $('#perfil').append(`
            <ul class="msg-box list-inline text-left d-inline-block float-left" style="margin-bottom:0px;color:white;">
                        <li> <img src="${url}static/images/perfil/${id_asesor}/${foto}" > <span id="namease" style="color:white;font-size:12px;"> ${nombre} </span>  </li> 
                        <br><li>ID: ${idgenerado}</li><br>
                    </ul>
            `);

            var parametros = {
                "id" : idgenerado
            };
            $.ajax({
                type: 'POST',
                url: 'getMischats',
                data: parametros,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(datos) {
                        
                    console.log(JSON.parse(datos));
                    let elements = JSON.parse(datos);

                    for (var x = 0; x < elements.length; x++) {


                    if(elements[x]['de'] == id_asesor){
                    $('#mensajesid').append(`
                    <div class="col-xs-12 padding0">
                    <div class="asesor_message sb15">${elements[x]['mensaje']}</div>
                    <li class="li_time right_position">${elements[x]['fecha_creacion']}</li>
                    </div>   
                    `);
                    }else{
                    $('#mensajesid').append(`<div class="col-xs-12 padding0"><li class="cliente_message sb14">${elements[x]['mensaje']}</li>
                    <li class="li_time">${elements[x]['fecha_creacion']}</li>
                    </div>`);
                    }
                    }
                    /*--------FIN DE CODIGO PARA CONSTRUIR EL CHAT----------------*/
                }
                
            });
            $("#consultaModal").modal();
        });

        $("#btnenviar").on('click', function(e){ 
            if ($('#estatusA').val() == 4 && $('#estatusE').val() == 1) {
                let val=0;
                if (v2 == undefined || v2 == '') { val =1; }
                else{ val=2; }

                e.preventDefault();
                var formData = new FormData(document.getElementById("EditarPerfilForm"));
                formData.append("dato", "valor");   
                $.ajax({
                    type: 'POST',
                    url: 'UpdatePerfilAs/'+val,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        // Actions before send post
                    },
                    success: function(data) {
                        if (data == 1) {
                            $("#EditarMiPerfil").modal('hide'); 
                            alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                            $allUsersTable.ajax.reload();
                        } else {
                            $("#EditarMiPerfil").modal('hide'); 
                            $allUsersTable.ajax.reload();
                            alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                        }
                    },
                    error: function(){
                        $("#EditarMiPerfil").modal('hide'); 
                        $allUsersTable.ajax.reload();
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
            else{
                $("#AlertaPermiso").modal('show');
            }
        });

        (($ => {
            $(() => {
                $.prototype.fullscreen = function(){
                    var $e = $(this);
                    if(!$e.hasClass('modal-fullscreen')) return;
                    bind($e);
                }
                
                function cssn($e, props) {
                    let sum = 0;
                    props.forEach(p => {
                        sum += parseInt($e.css(p).match(/\d+/)[0]);
                    });
                    return sum;
                }

                function g($e){
                    return {
                        width: cssn($e, ['margin-left', 'margin-right', 'padding-left', 'padding-right', 'border-left-width', 'border-right-width']),
                        height: cssn($e, ['margin-top', 'margin-bottom', 'padding-top', 'padding-bottom', 'border-top-width', 'border-bottom-width']),
                    };
                }

                function calc($e){
                    const wh = $(window).height();
                    const ww = $(window).width();
                    const $d = $e.find('.modal-dialog');
                    $d.css('width', '1200px');
                    $d.css('aling-items', 'center');
                    $d.css('justify-content', 'center');
                            $d.css('padding-left', '200px');
                    $d.css('height', '200px');
                    $d.css('max-width', '1200px');
                    $d.css('margin', '5px');
                    const d = g($d);
                    const $h = $e.find('.modal-header');
                    const $f = $e.find('.modal-footer');
                    const $b = $e.find('.modal-body');
                    $b.css('overflow-y', 'scroll');
                    const bh = wh - $h.outerHeight() - $f.outerHeight() - ($b.outerHeight()-$b.height()) - d.height;
                    $b.height(bh);
                }

                function bind($e){
                    $e.on('show.bs.modal', e => {
                        const $e = $(e.currentTarget).css('visibility', 'hidden');
                    });
                    $e.on('shown.bs.modal', e => {
                        calc($(e.currentTarget));
                        const $e = $(e.currentTarget).css('visibility', 'visible');   
                    });
                }

                $(window).resize(() => {
                    calc($('.modal.modal-fullscreen.in'));
                });

                bind($('.modal-fullscreen'));
            });
        }))(jQuery);

    /*---------------------------------CAPTURA DE PANTALLA-----------------------------------------*/
        function captura(id){
            var div = document.getElementById("Scr");
            div.style.maxHeight = "100%";    
            div.style.height="100%";     
            $objetivo = document.querySelector("#Scr2");
            html2canvas($objetivo) 
            .then(enviarCapturaAServidor); 
            alerts.showNotification("top", "right", "Captura correctamente", "info");           
        } 

        const enviarCapturaAServidor = canvas => {
            let enlace = document.createElement('a');
            enlace.download = "Captura de página web - Parzibyte.me.png";
            
            enlace.href = canvas.toDataURL();
            enlace.click();
                    
            var div = document.getElementById("Scr");
            div.style.maxHeight = "400px";    
            div.style.height="400px";          

        };
    /*-----------------------------FIN DE CAPTURA---------------------------------------*/

    </script>
</body>
</html>