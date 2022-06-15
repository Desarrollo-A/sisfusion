const showModal = () => {
    $('#blank-modal').modal();
}

const appendBodyModal = (body) => {
    $('#blank-modal .modal-body').html("");
    $('#blank-modal .modal-body').append(body);
}

const changeSizeModal = (className = '') => {
    if (className !== '') {
        $('#blank-modal-div').removeClass();
        $('#blank-modal-div').addClass(`modal-dialog ${className}`);
    }
}

const hideModal = () => {
    $('#blank-modal').modal('hide');
}