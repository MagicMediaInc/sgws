<form method="POST" action="">
    <table>
        <tr>
            <td>
                <label>Ano</label>&nbsp;
                <select id="by_ano" name="ano">
                    <?php foreach ($anos as $key => $value): ?>
                      <option value="<?php echo $key ?>" <?php echo $anoSelected == $key ? 'selected="selected"' : '' ?>  ><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="vertical-align: bottom; padding-bottom: 4px;">
                <input type="submit" value="Filtrar" />
            </td>
        </tr>
    </table>
</form>
