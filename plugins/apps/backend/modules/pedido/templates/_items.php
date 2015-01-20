<?php use_stylesheet('cart.css') ?>
<table id="cart" class="cart" cellspacing="0">
    <caption>Resumo do pedido</caption>
    <thead>
    <tr>
        <th align="left" class="firstColum"></th>
        <th align="left"><?php echo __('Referência')?></th>
        <th class="desc"><?php echo __('Descrição')?></th>
        <th><?php echo __('Quantidade') ?></th>
        <th align="right"><?php echo __('Preço unitário') ?></th>
        <th align="right"><?php echo __('Preço') ?></th>
        <th class="lastColumn"></th>
    </tr>
    </thead>
    <tbody>
    <?php $nbArticles =  count($items);  ?>
    <?php $subtotal = 0; ?>
    <?php foreach($items as $item): ?>
    <?php $total = $item['qty'] * $item['price'] ?>
    <?php $subtotal += $total ?>
    <tr>
        <td class="firstColum imagecolumn">
            <a href="<?php echo url_for('@default?module=producto&action=detalhe&id='.$item['id_producto'])?>">
            <?php $uploadDir = sfConfig :: get( 'sf_upload_dir' ).'/productos/big_'.$item['foto']; ?>
            <?php if( file_exists( $uploadDir ) ): ?>
                <?php echo image_tag('/uploads/productos/big_'.$item['foto'],'align=left width=70')  ?>
            <?php else: ?>
                <?php echo image_tag('semfoto.jpg',' border=0 title='.$item['nome'].'') ?>
            <?php endif; ?>
            </a>
        </td>
        <td class="reference">
            <?php echo link_to($item['id_producto'], '@default?module=producto&action=detalhe&id='.$item['id_producto']) ?>
        </td>
        <td align="left" style="text-align: left !important; padding-left: 35px;">
            <?php echo $item['nome']?><br />
            <?php echo $item['color']?>
        </td>
        <td align="center">
            <?php if($edit): ?>
                <input class="validate[optional,custom[onlyNumber]] " autocomplete="off" type="text" name="cantidad_<?php echo $item['id'] ?>" id="cantidad_<?php echo $item['id'] ?>" value="<?php echo $item['qty'] ?>" size="5"  />
            <?php else: ?>
                <?php echo $item['qty'] ?>
            <?php endif; ?>
        </td>
        <td align="right"><?php echo aplication_system::monedaFormat($item['price']) ?></td>
        <td align="right"><?php echo aplication_system::monedaFormat($total)  ?></td>
        <td align="center" class="lastColumn">
            <?php if($edit): ?>
                <?php echo link_to(image_tag('delete','border=0'), '@default?module=pedido&action=deleteItem&id='.$item['id'], array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Are you sure you want to delete the selected data?'))) ?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach ?>
    <?php if($edit): ?>
    <tr>
        <td colspan="5">
            <div id="cart-foot">
                <input type="submit" value="Atualizar" name="actualiza_pedido" class="button red medium" />

            </div>
        </td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
        <tr id="subtotal">
            <td class="sum" colspan="5">Subtotal (<?php echo $nbArticles ?> items):</td>
            <td class="totales">R$ <?php echo aplication_system::monedaFormat($subtotal) ?></td>
            <td class="amt">&nbsp;</td>
        </tr>
        <tr id="total">
            <td class="sum" colspan="5"><?php echo __('Grand Total') ?>:</td>
            <td class="totales" style="width: 72px;">R$ <?php echo aplication_system::monedaFormat($subtotal + $iva) ?></td>
            <td class="amt">&nbsp;</td>
        </tr>
    </tfoot>
</table>
