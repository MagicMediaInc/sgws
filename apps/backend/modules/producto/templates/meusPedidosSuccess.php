<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>
<h1 class="icono_projeto"><?php echo __('Meus Pedidos') ?></h1>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php include_partial('producto/menu') ?>
    
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Número Pedido</th>
            <th>Data do Pedido</th>
            <th>Status</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($pedidos): ?>
            <?php foreach ($pedidos as $item) : ?>
                <tr>
                    <td>&nbsp;<a href="<?php echo url_for('@default?module=pedido&action=edit&id='.$item->getId()) ?>" class="titulo"><?php echo image_tag('icons/zoom', 'width="16"') ?> Detalhe Pedido</a></td>
                    <td><?php echo $item->getNumeroPedido() ?></td>
                    <td><?php echo date("d-m-Y", strtotime($item->getData())) ?></td>
                    <td><?php echo $status[$item->getStatus()]  ?></td>
                    <td>R$ <?php echo number_format(($item->getValor() + $item->getDesconto()),2,',','.'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
 </table>
    

