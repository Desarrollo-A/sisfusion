<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>

<div class="modal fade" id="modalChart" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
            </div> -->
            <div class="container-fluid h-100">
                <div class="row h-30 pl-2 pr-2 pt-3">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="boxModalTitle">
                            <div class="title"></div>
                            <div class="total"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-end">
                        <div class="form-group d-flex m-0 p-0">
                            <input type="text" class="form-control datepicker text-center pl-1" id="beginDate"/>
                            <span>-</span>
                            <input type="text" class="form-control datepicker text-center " id="endDate"/>
                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                <span class="material-icons update-dataTable">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row p-0 h-70">
                    <input type="text" id="type" hidden/>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 h-100">
                        <div id="boxModalChart" class="h-100 d-flex justify-center align-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>