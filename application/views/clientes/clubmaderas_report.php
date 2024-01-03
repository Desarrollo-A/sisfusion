
<body class="">
<div class="wrapper ">
	<?php  $this->load->view('template/sidebar'); ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Ventas CLUB MADERAS</h4><br><br>
                            <div class="table-responsive">
                                <table id="cmTable" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th><center>Proyecto</center></th>
                                            <th><center>Condominio</center></th>
                                            <th><center>Lote</center></th>
                                            <th><center>Cliente</center></th>
                                            <th><center>Asesor</center></th>
                                            <th><center>Fecha generación DS</center></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script>

    var miArray = new Array(6)

    $(document).ready (function() {

        var table;
        table = $('#cmTable').DataTable( {
            dom: 'Bfrtip',
            ordering: false,
            "buttons": [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                } ,
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],
            "scrollX": true,
            "pageLength": 10,
            language: {
                /*url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"*/
                url: "../../static/spanishLoader.json"
            },

            ajax: "<?=base_url()?>index.php/Clientes/getClubMaderasSales/",
            columns: [
                { "data": "residencial" },
                { "data": "condominio" },
                { "data": "lote" },
                { "data": "cliente" },
                { "data": "asesor" },
                { "data": "fecha" }
            ]
        });
    });



</script>
