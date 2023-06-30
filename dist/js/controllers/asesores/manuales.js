$(document).ready(function () {
    $.post(`${general_base_url}index.php/asesor/getAllFoldersManual`,  function(data) {
        if(data.length > 0) {
            for(var i=0; i < data.length; i++) {
                var classActive = (data[i]['id_archivo'] == 1) ? 'active' : '';
                //construte las tabs para navegar en tabs
                var html_code = '<li class="'+classActive+' "style="margin-right: 50px;">';
                    html_code += '	<a href="#carpeta'+(i+1)+'" role="tab" data-toggle="tab">';
                    html_code += '		<strong>'+ (i+1) +'- </strong> '+  data[i]['nombre'];
                    html_code += '	</a>';
                    html_code += '</li>';
                $('#navbartabs').append(html_code);
                //codigo embebido del PDF
                var url_file = `${general_base_url}static/documentos/manuales/`+data[i]['archivo'];
                var embebed_code = '<embed src="'+url_file+'#toolbar=0" frameborder="0" width="100%" height="770em">'
                //construye los contenedores de las tabs
                var html_contenedor_tabs = '';
                html_contenedor_tabs += '<div class="tab-pane '+classActive+'" id="carpeta'+(i+1)+'">';
                html_contenedor_tabs += '	<div class="content">';
                html_contenedor_tabs += '		<div class="container-fluid">';
                html_contenedor_tabs += '			<div class="row">';
                html_contenedor_tabs += '				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                html_contenedor_tabs += '					<h3>'+ data[i]['nombre'] +'</h3>';
                html_contenedor_tabs += '					'+embebed_code;
                html_contenedor_tabs += '				</div>';
                html_contenedor_tabs += '			</div>';
                html_contenedor_tabs += '		</div>';
                html_contenedor_tabs += '	</div>';
                html_contenedor_tabs += '</div>';

                $('#paneles-tabs').append(html_contenedor_tabs);
            }
        }
        else {
            $('#msg').append('<center><h2 style="color: #a0a0a0;font-weight: 100">No hay Carpetas disponibles</h2></center>');
        }
    }, 'json');
});
