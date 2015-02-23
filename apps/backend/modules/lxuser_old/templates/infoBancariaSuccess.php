<script type="text/javascript"> 
$(function(){
    tabla = $('#tabla');
    tr = $('tr:first', tabla);
    $('#agregarFila').live('click', function (){
        //tr.clone().appendTo(tabla).find(':text, :hidden').val('');
        tr.clone().appendTo(tabla);
        $('table#tabla tr:last td input[id=titular]').val('');
        $('table#tabla tr:last td input[id=id_info_banco]').val('');
        $('table#tabla tr:last td input[id=agencia]').val('');
        $('table#tabla tr:last td input[id=conta]').val('');
    });
 
    $(".eliminarFila").live('click', function (){
        var tr = $(this).closest('tr')
        if ( $('[name=id_info_banco[]]', tr).val() )
            $.ajax({
                type: "POST",
                url: "deleteInfoBanco?id_info=" + $('[name=id_info_banco[]]', tr).val(),
                dataType: "script"
              });
        tr.remove();
    });
 
});
</script>
<h1 class="icono_user"><?php echo __('Pessoas')?> </h1>
<div id="title_module">
    <div id="renglon">
        <?php include_partial('menu') ?>
    </div>
    <div id="info_pessoais">
        <h1 class="titulo"><?php echo __('Informações Bancaria') ?></h1>
        <div id="message"></div>
        <form action="" method="post">            
            <table id="body" style="background-color: #006599; color: #FFF; width: 75%; padding: 5px; margin-top: 15px;">
                <tr>
                    <td width="30%">Titular</td>
                    <td>Banco</td>
                    <td>Agência</td>
                    <td>N° Conta</td>
                </tr>                
            </table>
            <table id="tabla" style="border: 1px solid #ccc; width: 75%;">
                <?php if($contasPessoa): ?>
                    <?php foreach ($contasPessoa as $conta): ?>
                        <tr>
                            <td><input type="hidden" id="id_info_banco" name="id_info_banco[]" value="<?php echo $conta['id_info'] ?>"></td>
                            <td><input type="text" id="titular" name="titular[]" value="<?php echo $conta['titular'] ?>"></td>
                            <td>
                                <select name="id_banco[]" id="id_banco">
                                    <?php foreach ($bancos as $banco): ?>
                                        <?php if($banco->getIdBanco() == $conta['id_banco'] ): ?>
                                            <?php $selected = 'selected="selected"'; ?>
                                        <?php else: ?>
                                            <?php $selected = ""; ?>
                                        <?php endif; ?>
                                    <option value="<?php echo $banco->getIdBanco() ?>" <?php echo $selected; ?>accesskey=""><?php echo $banco->getNombreBanco() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="agencia[]" id="agencia" value="<?php echo $conta['agencia'] ?>"></td>
                            <td><input type="text" name="conta[]" id="conta" value="<?php echo $conta['conta'] ?>"></td>
                            <td><?php echo image_tag('icons/delete','class="eliminarFila"') ?> </td>
                        </tr>                
                    <?php endforeach; ?>
                <?php else: ?>
                        <tr>
                            <td><input type="hidden" id="id_info_banco" name="id_info_banco[]" value=""></td>
                            <td><input type="text" id="titular" name="titular[]" value=""></td>
                            <td>
                                <select name="id_banco[]" id="id_banco">
                                    <?php foreach ($bancos as $banco): ?>
                                        <option value="<?php echo $banco->getIdBanco() ?>"><?php echo $banco->getNombreBanco() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="agencia[]" id="agencia" value=""></td>
                            <td><input type="text" name="conta[]" id="conta" value=""></td>
                            <td><?php echo image_tag('icons/delete','class="eliminarFila"') ?> </td>
                        </tr>                
                <?php endif; ?>                
            </table>
            <br />
            <input type="button" value="Adicionar" id="agregarFila">
            <input type="submit" value="Enviar dados"/>
        </form>
    </div>    
</div>

