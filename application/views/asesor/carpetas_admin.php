
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<body>
    <div class="wrapper">

        <?php
        if ($this->session->userdata('id_rol') == "4" || $this->session->userdata('id_rol') == "53") //contratacion
        {
        $this->load->view('template/sidebar');
        } else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>

        <style type="text/css">
            input[type="file"] {
                display: none;
            }
            .custom-file-upload {
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;

            }
        </style>

        <!-- Modals -->
        <div class="modal fade" id="carpetasE" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 >Agregar nueva carpeta</h5>
                    </div>
                    <form  enctype="multipart/form-data" id="formAdminE">
                        <div class="form-group col-lg-10">
                            <label for="nombreE">Nombre</label>
                            <input type="text" name="nombreE" class="form-control" id="nombreE" >
                            <p id="nom" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-10">
                            <label for="descripcionE">Descripción</label>
                            <textarea class="form-control"  rows="2" name="descripcionE" id="descripcionE" required=""></textarea>
                            <p id="des" style="color: red;"></p>
                        </div>
                        <input type="hidden" name="idCarpeta" id="idCarpeta">
                        <div style="padding-left: 20px;padding-top: 100px;">
                            <label for="file-uploadE" class="custom-file-upload">
                            <i class="fa fa-cloud-upload"></i> Subir archivo
                            </label>
                            <input id="file-uploadE" name="file-uploadE" accept=".pdf" type="file"/>
                            <input type="hidden" id="filename" name="filename">
                            <p id="archivoE"></p>
                        </div>
                        <div class="form-group col-lg-10">
                            <label for="estatus">Estatus</label>
                            <select id="estatus" name="estatus" class="form-control">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                    <div class="modal-footer"><br><br>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnsave" onclick="update();" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carpetasP" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                                            
                    <div class="modal-footer"><br><br>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carpetas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 >Agregar nueva carpeta</h5>
                    </div>
                    <form  enctype="multipart/form-data" id="formAdmin">
                        <div class="form-group col-lg-10">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre de la carpeta" required="">
                            <p id="nom" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-10">                            
                            <textarea class="form-control" placeholder="Descripción de las carpetas" rows="2" name="desc" id="desc" required=""></textarea>
                            <p id="des" style="color: red;"></p>
                        </div>
                        <div style="padding-left: 20px;padding-top: 100px;">
                            <label for="file-upload" class="custom-file-upload">
                                <i class="fa fa-cloud-upload"></i> Subir archivo
                            </label>
                            <input id="file-upload" name="file-upload" accept=".pdf" type="file"/>
                            <p id="archivo" style="color: red;"></p>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnsave" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-folder-open fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Carpetas</h3>
                                <?php 
                                    if($this->session->userdata('id_rol')!=53){
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 com-md-4 col-lg-4">
                                        <button class="btn-data-gral btn-success mb-3" data-toggle="modal" data-target="#carpetas">Agregar carpeta</button>
                                    </div>
                                </div>
                                
                                <?php } ?>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="tableCarpetas" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>CARPETA</th>
                                                    <th>DESCRIPCIÓN</th>
                                                    <th>ARCHIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th>USUARIO</th>
                                                    <th>FECHA CREACIÓN</th>
                                                    <th>FECHA MODIFICACIÓN</th>
                                                    <?php 
                                                    if($this->session->userdata('id_rol')!=53){
                                                    ?>
                                                    <th>ACCIONES</th>
                                                    <?php 
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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

    <script type="text/javascript">
        let v;
        let v2;
        
        $("#file-upload").on('change', function(e){ 
            v = document.getElementById("file-upload").files[0].name; 
            let p = document.getElementById("archivo");
            document.getElementById("archivo").style.color = "black";
            p.innerHTML = v;
        });

        $("#file-uploadE").on('change', function(e){ 		
            v2 = document.getElementById("file-uploadE").files[0].name; 
            let a = document.getElementById("archivoE");
            document.getElementById("archivoE").style.color = "black";
            a.innerHTML = v2;
        });

        $("#nombre").keypress(function(){
            document.getElementById("nom").innerHTML ='';
        });

        $("#btnsave").on('click', function(e){ 
            if ($('#nombre').val().length == 0 && v == "" || v == undefined) {
                document.getElementById("nom").innerHTML ='Requerido';
                document.getElementById("archivo").innerHTML ='Requerido';	
                
            }
            else if ($('#nombre').val().length != 0 && v == "" || v == undefined) {
                document.getElementById("archivo").innerHTML ='Requerido';	
                
            }
            else if ($('#nombre').val().length == 0 && v !== "" && v !== undefined) {
                document.getElementById("nom").innerHTML ='Requerido';
            }
            else if($('#nombre').val().length != 0 && v !== "" && v !== undefined){
                save();
            }
        }); 

        function save() {
            var formData = new FormData(document.getElementById("formAdmin"));
            formData.append("dato", "valor");
            $.ajax({
                type: 'POST',
                url: 'saveCarpetas',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        $("#carpetas").modal('hide');
                        alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                        $tableCarpetas.ajax.reload();
                    } else {
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        typeTransaction = 1;

        $(document).ready(function () {

            $('#tableCarpetas thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                if(i != 0 && i != 8){
                    $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if ($('#tableCarpetas').DataTable().column(i).search() !== this.value ) {
                            $('#tableCarpetas').DataTable()
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                }
            });

            $tableCarpetas = $('#tableCarpetas').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                dom: "<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end'l>rt>"+"<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
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
                columns: [
                    { 
                        data: function (d) {
                            return d.id_archivo;
                        }
                    },
                    { 
                        data: function (d) {
                            return d.nombre;
                        }
                    },
                    { 
                        data: function (d) {
                            return d.descripcion;
                        }
                    },
                    { 
                        data: function (d) {
                            return d.archivo;
                        }
                    },
                    { 
                        data: function (d) {
                            if (d.estatus == 1) {
                                return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                            } else {
                                return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
                            }
                        }
                    },
                    { 
                        data: function (d) {
                            return d.usuario;
                        }
                    },
                    { 
                        data: function (d) {
                            return d.fecha_creacion;
                        }
                    },
                    { 
                        data: function (d) {
                            return d.fecha_modificacion;
                        }
                    },
                    <?php 
                    if($this->session->userdata('id_rol')!=53){
                    ?>
                        { 
                            data: function (d) {
                                return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas editarCarpeta" data-id-carpeta="' + d.id_archivo +'"><i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-deepGray preview" data-id-carpeta="' + d.id_archivo +'"><i class="far fa-eye"></i></button></div>';
                            }
                        }
                    <?php 
                    }
                    ?>
                ],
                columnDefs: [{
                    "searchable": true,
                    "orderable": false,
                    "targets": 0
                }],
                ajax: {
                    "url": "getCarpetas",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },
            });

            $(document).on('click', '.editarCarpeta', function(e){
                $('#spiner-loader').removeClass('hide');
                id_carpeta = $(this).attr("data-id-carpeta");

                //alert(id_carpeta);
                $.getJSON("getInfoCarpeta/"+id_carpeta).done( function( data ){
                    $('#spiner-loader').addClass('hide');
                    $.each( data, function(i, v){
                    // getLeadersListForEdit(v.id_sede, v.id_rol, v.id_lider);
                        $("#carpetasE").modal();
                        fillFields(v);
                        //validateEmptyFields(v);
                    });
                });
            });

            $(document).on('click', '.preview', function(e){
                id_carpeta = $(this).attr("data-id-carpeta");

                //alert(id_carpeta);
                $.getJSON("getInfoCarpeta/"+id_carpeta).done( function( data ){
                    $.each( data, function(i, v){
                    // getLeadersListForEdit(v.id_sede, v.id_rol, v.id_lider);
                        $("#carpetasP").modal();
                        var htmlModalPreview = '';
                    
                        var url_file = '<?=base_url()?>static/documentos/carpetas/'+v.archivo;
                        var embebed_code = '<embed src="'+url_file+'#toolbar=0" frameborder="0" width="100%" height="400em">';
                        htmlModalPreview += '<h3>'+ v.nombre + ': ' + v.descripcion + '</h3>';
                        htmlModalPreview += ' ' + embebed_code;
                        $('#carpetasP').find('.modal-header').html(htmlModalPreview);
                        //validateEmptyFields(v);
                    });
                });
            });

            function fillFields (v) {
                $("#idCarpeta").val(v.id_archivo);
                $("#nombreE").val(v.nombre);
                document.getElementById("archivoE").innerHTML = v.archivo;
                $("#descripcionE").val(v.descripcion);
                $("#filename").val(v.archivo);
                $("#estatus").val(v.estatus);
            }
        });

        function update() {
            let val=0;
            if (v2 == undefined) {
                val =1;
            }
            else{
                val=2;
            }
    
            var formData = new FormData(document.getElementById("formAdminE"));
            formData.append("dato", "valor");
            $.ajax({
                type: 'POST',
                url: 'updateCarpetas/'+val,
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        $("#carpetasE").modal('hide');
                        alerts.showNotification("top", "right", "El registro se actualizo exitosamente.", "success");
                        $tableCarpetas.ajax.reload();
                    } else {
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    </script>
</body>