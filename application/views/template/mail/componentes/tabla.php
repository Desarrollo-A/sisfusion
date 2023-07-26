<?php
    $estiloTabla = (count($encabezados) > 7) ? 'tabla-lg' : 'tabla';
?>

<div class="d-flex justify-center">
    <table class="<?=$estiloTabla?>" cellpadding="0" cellspacing="0">
        <tr class="tr-encabezados">
            <?php
            foreach ($encabezados as $encabezado) {
                ?>

                <th><?=$encabezado?></th>

                <?php
            }
            ?>
        </tr>

        <?php
            foreach ($contenido as $values) {
                ?>
                <tr class="tr-contenido">

                    <?php
                        foreach (array_keys($encabezados) as $encabezado) {
                            ?>

                            <td class="encabezados text-center"><?=$values[$encabezado]?></td>

                            <?php
                        }
                    ?>

                </tr>
                <?php
            }
        ?>
    </table>
</div>