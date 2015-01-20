<script type="text/javascript"> 
    $(document).ready(function() {
        $('.button').click(function() {
              var id = $(this).attr("id");
              var preco = $("#preco-" + id).val();
              $('.last_msg_loader-' +  id).html('Processamento');
              $.post("<?php echo url_for('@default?module=preco_funcionario&action=salvaPrecio') ?>", 
                  {id : id , preco : preco},
              function(data){
                  if (data != "") {
                      $("#preco-" + id).val(data);			
                  }
                  $('.last_msg_loader-'  +  id).empty();
              });
        });
        formatInputMoneda($(".preco"));
    })
</script>
<h1 class="icono_projeto"><?php echo __('Funcionarios preço / hora') ?></h1>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
        &nbsp;
    </th>
  
    <th style="width: 266px">
        Funcionario
    </th>
    <th style="width: 266px">
        Cargo
    </th>
    <th style="width: 85px">
        Preço por hora
    </th>
    <th>

    </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($funcionarios): ?>
    <?php foreach ($funcionarios as $funcionario): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;&nbsp;</td>
        <td class="borderBottomDarkGray">
            <?php echo $funcionario['nome'] ?>
        </td>
        <td class="borderBottomDarkGray">
            <?php echo $funcionario['cargo'] ?>
        </td>
        <td class="borderBottomDarkGray">
            <input class="preco" type="text" size="10" name="preco-<?php echo $funcionario['id'] ?>" id="preco-<?php echo $funcionario['id'] ?>" value="<?php echo $funcionario['preco'] ?>" /> 
        </td>
        <td class="borderBottomDarkGray">
            <button class="button" id="<?php echo $funcionario['id'] ?>">Salvar</button>
            <span class="last_msg_loader-<?php echo $funcionario['id'] ?>"></span>
        </td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
</table>
    <?php else: ?>
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong><?php echo __('Sua busca não gerou resultados') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
  

