<table id="u_content_text_3" style="font-family:'Raleway',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 45px;font-family:'Raleway',sans-serif;" align="left">

        <div class="v-text-align v-font-size" style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
          <p style="line-height: 140%;">Hola <?= $nombreAsesor; ?>, se ha encontrado que la siguiente cantidad de lotes necesitan atención: </p>
        </div>

      </td>
    </tr>
  </tbody>
</table>

<table id="u_content_heading_3" class="tabla" style="font-family:'Raleway',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="1">
    <tr class="tr-encabezados">
      <th>Cantidad</th>
      <th>Concepto</th>
    </tr>
  <tbody>

    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:3px 3px 3px 3px;font-family:'Raleway',sans-serif;" align="center">
        <?= $cantidadProceso6; ?>
      </td>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:3px 3px 3px 3px;font-family:'Raleway',sans-serif;" align="center">
        Lote(s) en pendientes de selección de propuesta final
      </td>
    </tr>
  </tbody>
</table>