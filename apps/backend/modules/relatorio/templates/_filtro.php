<form method="POST" action="">
    <table>
        <tr>
            <td>
                <label>Status</label><br />
                <select id="proposta_status" name="proposta_status">
                    <?php foreach ($status as $key => $value): ?>
                      <option value="<?php echo $key ?>" <?php echo $statusSelected == $key ? 'selected="selected"' : '' ?>  ><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <label>Cliente ou Gerente</label><br />
                <input type="text" name="buscador" size="45" value="<?php echo $sf_request->getParameter('buscador') ?>" />
            </td>
            <td style="vertical-align: bottom; padding-bottom: 4px;">
                <input type="submit" value="Filtrar" />
            </td>
        </tr>
    </table>
</form>
