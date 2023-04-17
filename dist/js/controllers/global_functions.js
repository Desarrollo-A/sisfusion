$(document).ready(function() 
{
    $.getJSON("fillSelects").done(function(data) {
        $(".advertising").append($('<option disabled selected>').val("0").text("Seleccione una opción"));

        $("#estatus_particular2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 5) // SALES PLAZA SELECT
            $("#sales_plaza").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 7) // ADVERTISING SELECT
                $(".advertising").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 9){ // PROSPECTING PLACE SELECT
                //$(".prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                if (data[i]['id_opcion'] == 6 || data[i]['id_opcion'] == 31) { // SON LOS DOS LP DE MKTD
                    $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).addClass("boldtext")).selectpicker('refresh');
                } else { // SON OTROS LP
                    $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                }
            }
            if (data[i]['id_catalogo'] == 10) // LEGAL PERSONALITY SELECT
                $("#legal_personality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 11) // NATIONALITY SELECT
                $("#nationality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 18) // CIVIL STATUS SELECT
                $("#civil_status").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 19) // MATRIMONIAL REGIME SELECT
                $("#matrimonial_regime").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 38) { // STATUS PARTICULAR 2 SELECT
                $("#estatus_particular").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#estatus_particular2").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#estatus_particular").selectpicker('refresh');
                $("#estatus_particular2").selectpicker('refresh');
            }
        }
    });

});