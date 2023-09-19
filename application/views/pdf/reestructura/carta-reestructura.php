<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Ciudad Maderas</title>

    <style>
        .fecha {
            text-align: right;
        }
    </style>
</head>
<body>
<div>
    <img src="https://www.ciudadmaderas.com/assets/img/logo.png" style="width: 250px; height: auto;" alt="logo">
</div>
<div class="fecha" id="fecha">
    <p style="font-size: 14px;">
        Fecha: <?=$dia?> de <?=$mes?> del <?=$anio?>.
    </p>
</div>
<div>
    <h2>Solicitud de reestructura.</h2>
    <p style="font-size: 14px;">A quien corresponda.</p>
</div>
<div>
    <p style="text-align: justify; font-size: 14px;">
        Por medio de este conducto, el suscrito(a) <u><?=$nombreCliente?></u> manifiesto mi solicitud de reestructura, mi tabla
        de pagos y fecha de entrega de mi contacto, correspondiente al lote <u><?=$lote?></u> del condominio
        <u><?=$cond?></u> en el desarrollo <u><?=$desarrollo?></u>.
    </p>
</div>
<div style="text-align: center; margin-top: 40px;">
    <h3>ATENTAMENTE.</h3>
</div>
<div style="text-align: center">
    <p>Nombre y firma titular</p>
</div>
</body>
</html>