<table id="u_content_text_3" style="font-family:'Raleway',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 45px;font-family:'Raleway',sans-serif; text-align: center;" align="left">

        <div class="v-text-align v-font-size" style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
          <p style="line-height: 140%;">Se ha cargado la orden de compra </p>
          <br>
          <div>
            <?php
            $this->load->view('template/mail/componentes/tabla', [
              'encabezados' => $encabezados,
              'contenido' => $contenido
            ])
            ?>
          </div>
        </div>

      </td>
    </tr>
  </tbody>
</table>