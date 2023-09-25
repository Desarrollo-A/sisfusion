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
        <h2>Solicitud de reubicación.</h2>
        <p style="font-size: 14px;">A quien corresponda.</p>
    </div>
    <div>
        <p style="text-align: justify; font-size: 14px;">
            Por medio de este conducto, el suscrito(a) <u><?=$nombreCliente?></u> manifiesto mi solicitud de rescisión de contrato,
            correspondiente al lote <u><?=$loteAnterior?></u> del condominio <u><?=$condAnterior?></u> en el desarrollo <u><?=$desarrolloAnterior?></u>.
        </p>
    </div>
    <div>
        <p style="text-align: justify; font-size: 14px;">
            El motivo de la cancelación de este contrato es por reubicación al lote <u><?=$loteNuevo?></u> del condominio <u><?=$condNuevo?></u>
            en el desarrollo de <u><?=$desarrolloNuevo?></u>. Sin más por el momento, quedo al pendiente del seguimiento de mi trámite.
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