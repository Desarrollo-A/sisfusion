<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet" />

<style>
.tab-selected {
  display: flex;
  justify-content: space-around;
  top: 20px;
  left: 20px;
}

.tab-selected {
  width: 200px;
  height: 50px;
  background-color: #2E75BD;
  margin: 20px;
  color: white;
  position: relative;
  overflow: hidden;
  font-size: 14px;
  letter-spacing: 1px;
  font-weight: 500;
  text-transform: uppercase;
  transition: all 0.3s ease;
  cursor: pointer;
  border: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 3px;
  border: 1px solid black;
}

.tab-selected .tab-selected:before, .tab-selected:after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  background-color: #0a548b;
  transition: all 0.3s cubic-bezier(0.35, 0.1, 0.25, 1);
}

.tab-selected:before {
  right: 0;
  top: 0;
  transition: all 0.5s cubic-bezier(0.35, 0.1, 0.25, 1);
}

.tab-selected:after {
  left: 0;
  bottom: 0;
}


.tab-selected p {
  padding: 0;
  margin: 0;
  transition: all 0.4s cubic-bezier(0.35, 0.1, 0.25, 1);
  position: absolute;
  width: 100%;
  height: 100%;
  
}

.tab-selected p:before, .tab-selected p:after {
  position: absolute;
  width: 100%;
  transition: all 0.4s cubic-bezier(0.35, 0.1, 0.25, 1);
  z-index: 1;
  left: 0;
}

.tab-selected p:before {
  content: attr(data-title);
  top: 50%;
  transform: translateY(-50%);
}



.worko-tabs {
  
    .state{
      position: absolute;
      left: -10000px;
    }
  
    .flex-tabs{
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
        
        .tab{
          flex-grow: 1;
          max-height: 40px;
        }
      
        .panel {
          display: none;
          flex-basis: auto;
      }
    }

    .tab {
      display: inline-block;
      padding: 10px;
      vertical-align: top;
      background-color: #eee;
      cursor: hand;
      cursor: pointer;
      border-left: 10px solid #ccc;
      
        &:hover{
          background-color: #fff;
        }
    }  
}

#tab-one:checked ~ .tabs #tab-one-label,
#tab-two:checked ~ .tabs #tab-two-label,
#tab-three:checked ~ .tabs #tab-three-label{
    background-color: #0e4377;
    cursor: default;
    border-left-color: #96843d;
    color: white;
}

#tab-one:checked ~ .tabs #tab-one-panel,
#tab-two:checked ~ .tabs #tab-two-panel,
#tab-three:checked ~ .tabs #tab-three-panel{
    display: block;
}

@media (max-width: 600px){
  .flex-tabs{
    flex-direction: column;
    
    .tab{
      background: #fff;
      border-bottom: 1px solid #ccc;
      
        &:last-of-type{
          border-bottom: none;
        }
    }
    
    #tab-one-label{order:1;}
    #tab-two-label{order: 3;}
    #tab-three-label{order: 5;};
    #tab-four-label{order: 7;};
    #tab-one-panel{order: 2;}
    #tab-two-panel{order: 4;}
    #tab-three-panel{order: 6;}
  }
  
    #tab-one:checked ~ .tabs #tab-one-label,
    #tab-two:checked ~ .tabs #tab-two-label,
    #tab-three:checked ~ .tabs #tab-three-label{
      border-bottom: none;
    }
  
  #tab-one:checked ~ .tabs #tab-one-panel,
  #tab-two:checked ~ .tabs #tab-two-panel,
  #tab-three:checked ~ .tabs #tab-three-panel{
    border-bottom: 1px solid #ccc;
  }
}

.dateReq{
  color: red;
}
</style>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/pj80dBMw6y4" class="align-center justify-center u2be"
                                    target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial"
                                        style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <div class="material-datatables">
                                    <table id="prospects-datatable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>ACCIONES</th>
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

        <?php $this->load->view('template/footer_legend');
        ?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <script src="<?=base_url()?>dist/js/moment.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/prospectos/prospectosConsulta.js?v=1.1.17"></script>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
</body>