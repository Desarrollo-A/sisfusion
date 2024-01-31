$('.selectpicker.proyecto').change( function(){
    const estatusPagos = $(this).attr("data-estatus");
    idTablaGlobal = datosTablas.filter(tablas => tablas.estatus == estatusPagos);
    index_proyecto = $(this).val();
    $("#condominioNuevas").html("");
            let condominiosPorResiden = datosCondominios.filter(condominios => condominios.idResidencial == index_proyecto);
            for( var i = 0; i<condominiosPorResiden.length; i++){
                var id = condominiosPorResiden[i].idCondominio;
                var name = condominiosPorResiden[i].nombre;
                $("#condominioNuevas").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominioNuevas").selectpicker('refresh');
            $(`#${idTablaGlobal[0].id}`).removeClass('hide');
            //$(`${idTablaGlobal[0].id}`).removeClass('hide');
            getPagosEstatus(idTablaGlobal[0].id,index_proyecto, 0,estatusPagos);
});
$('.selectpicker.condominio').change( function(){
    const estatusPagos = $(this).attr("data-estatus");
    index_proyecto = $('#condominioNuevas').val();
    index_condominio = $(this).val();
    getPagosEstatus(idTablaGlobal[0].id,index_proyecto, index_condominio,estatusPagos);
});