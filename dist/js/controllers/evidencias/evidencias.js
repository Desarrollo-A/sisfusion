
$(document).on('change', "#residenciales", function () {
    getCondominios($(this).val());
});

$(document).on('change', "#condominios", function () {
    getLotes($(this).val());
});

function cleanSelects(action) {
    if (action == 1) { // MJ: CHANGE RESIDENCIALES
        $("#condominios").selectpicker("refresh");
        $("#lotes").empty().selectpicker('refresh');
        $("#columns").val('');
    } else if (action == 2 || action == 3 || action == 4) {
        $("#columns").val('');
        $("#columns").selectpicker("refresh");
    }
}

