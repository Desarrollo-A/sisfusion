<table class="tabla-etiquetas">
    <tr>
        <?php
            foreach($data as $key => $item) {
                if ($key !== 'comentario') {
                    ?>

                    <td>
                        <label class="label-etiquetas">
                            <b><?=strtoupper(str_replace('_', ' ', $key))?></b> <?=$item?>
                        </label>
                    </td>

                    <?php
                }
            }
        ?>
    </tr>
</table>
