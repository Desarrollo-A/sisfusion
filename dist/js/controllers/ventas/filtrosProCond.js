$('.selectpicker.proyecto').change( function(){
    const estatusPagos = $(this).attr("data-estatus");
    idTablaGlobal = datosTablas.filter(tablas => tablas.estatus == estatusPagos);
    index_proyecto = $(this).val();
    $(".selectpicker.condominio").html("");
            let condominiosPorResiden = datosCondominios.filter(condominios => condominios.idResidencial == index_proyecto);
            for( var i = 0; i<condominiosPorResiden.length; i++){
                var id = condominiosPorResiden[i].idCondominio;
                var name = condominiosPorResiden[i].nombre;
                $(".selectpicker.condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $(".selectpicker.condominio").selectpicker('refresh');
            $(`#${idTablaGlobal[0].id}`).removeClass('hide');
¿            if(estatusPagos != 0)
            getPagosEstatus(idTablaGlobal[0].id,index_proyecto, 0,estatusPagos);
        
});
$('.selectpicker.condominio').change( function(){
    const estatusPagos = $(this).attr("data-estatus");
    let idProyecto = datosTablas.filter(datosTb => datosTb.estatus == estatusPagos);
    index_proyecto = $(`${idProyecto[0].idSelect}`).val();
    index_condominio = $(this).val();
    if(estatusPagos != 0)
        getPagosEstatus(idTablaGlobal[0].id,index_proyecto, index_condominio,estatusPagos);
    else
    comisionesTableSinPago (index_proyecto, index_condominio)
});