<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>

<div class="modal" id="modalChart" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-end">
                        <div class="boxModalTitle"></div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-end">
                        <div class="form-group d-flex">
                            <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2022" />
                            <input type="text" class="form-control datepicker" id="endDate" value="01/01/2022" />
                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                <span class="material-icons update-dataTable">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <div class="boxModalChart"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>