<?php use_helper('Date') ?>
<?php use_stylesheet('cart.css') ?>
<script type="text/javascript"> 
    $(document).ready(function() {
        $("#frmCart").validationEngine();
    })
</script>
<p><?php echo$notTienda?></p>
<h1 class="icono_projeto">Meu carrinho de compras</h1>
<?php include_partial('producto/menu') ?>
<div class="column span-15 " style="padding-left: 20px; margin-top: 10px;">

<?php if($sf_user->getAttribute('id_projeto')):?>
    <h2 style="font-weight: bold; text-transform: uppercase;">
        <?php $projSelected = PropostaPeer::retrieveByPK($sf_user->getAttribute('id_projeto')) ?>
        Projeto selecionado: <?php echo $projSelected->getCodigoSgwsProjeto()?> - <?php echo $projSelected->getNomeProposta() ?>
    </h2>
    Se você quiser alterar o Projeto, clique <a href="<?php echo url_for('@cart?action=envio')?>" >aqui</a>
    <br /><br />
<?php endif; ?>
<?php if($nbArticles > 0):?>
<h2>
    Você tem <?php echo $nbArticles ?> iten<?php echo $nbArticles > 1 ? __('s') : '' ?> em seu CARRINHO
</h2>
<?php endif; ?>
<br /><br />
<?php if ($shopping_cart->isEmpty()): ?>
<br /><br /><br /><br />
    <div class="erro_no_data center" style="font-size: 24px;">
        Você não selecionou nenhum produto para comprar.
    </div>
    <div id="cart-foot" style="text-align: center; border: 0px; margin-top: 15px; ">
        <?php echo button_to(__('Voltar'), '@default_index?module=producto','class="button red big"') ?>
    </div>
    

<?php else: ?>
<div style="text-align: left;">
    <a href="<?php echo url_for('@default_index?module=producto')?>" class="btn secondary back"><?php echo __('Comprar mais produtos') ?></a>
</div>
<br /><br />

<form name="frmCart" id="frmCart" action="<?php echo url_for('@cart?action=actualizar') ?>" method="post">
<div class="cart">
<table id="cart" class="cart" cellspacing="0">
    <caption><?php echo __('Atualmente em seu Carrinho de Compras') ?></caption>
    <thead>
        <tr>
            <th align="left" class="firstColum"></th>
            <th align="left"><?php echo __('Referência')?></th>
            <th class="desc"><?php echo __('Descrição do produto')?></th>
            <th><?php echo __('Quantidade') ?></th>
            <th align="right"><?php echo __('Valor unitário') ?></th>
            <th align="right"><?php echo __('Valor total') ?></th>
            <th class="lastColumn"></th>
        </tr>
    </thead>
<tbody>
<?php $subtotal = 0; foreach($items as $item): ?>
<?php $total = $item->getQuantity() * $item->getPrice() ?>
<?php $subtotal += $total ?>
<tr>
    <td class="firstColum imagecolumn">
        <a href="<?php echo url_for('@default?module=producto&action=detalhe&id='.$item->getParameter('id'))?>">
        <?php $uploadDir = sfConfig :: get( 'sf_upload_dir' ).'/productos/big_'.$item->getParameter('foto'); ?>
        <?php if( file_exists( $uploadDir ) ): ?>
            <?php echo image_tag('/uploads/productos/big_'.$item->getParameter('foto'),'align=left width=70')  ?>
        <?php else: ?>
            <?php echo image_tag('semfoto.jpg',' border=0 title='.$item->getParameter('description').'') ?>
        <?php endif; ?>
        </a>
    </td>
    <td class="reference">
        <?php echo link_to($item->getParameter('referencia'), '@default?module=producto&action=detalhe&id='.$item->getParameter('id')) ?>
    </td>
    <td align="left" style="text-align: left !important; padding-left: 35px;">
                
                <?php echo $item->getParameter('description')?><br />
                <?php echo $item->getParameter('color')?>
    </td>
    <td align="center">
        <input class="validate[optional,custom[onlyNumber]] " autocomplete="off" type="text" name="cantidad_<?php echo $item->getId() ?>" id="cantidad_<?php echo $item->getId() ?>" value="<?php echo $item->getQuantity() ?>" size="5"  />
    </td>
    <td align="right">R$ <?php echo $item->getPrice() ?></td>
    <td align="right">R$ <?php echo $total ?></td>
    <td align="center" class="lastColumn"><?php echo link_to(image_tag('delete','border=0'), '@cart?action=eliminar&id='.$item->getId()) ?></td>
</tr>
<?php endforeach ?>
</tbody>
<tfoot>
    <tr id="subtotal">
        <td class="sum" colspan="5">SubTotal (<?php echo $nbArticles ?> <?php echo __('Itens')?>):</td>
        <td class="totales">R$ <?php echo $subtotal ?></td>
        <td class="amt">&nbsp;</td>
    </tr>
    <tr id="total">
        <td class="sum" colspan="5"><?php echo __('Total') ?>:</td>
        <td class="totales">R$ <?php echo $subtotal ?></td>
        <td class="amt">&nbsp;</td>
    </tr>
</tfoot>
</table>
</div>




<div id="cart-foot">
    <input type="submit" value="Atualizar" class="button red medium" />
    <?php echo button_to('Deletar tudo', '@cart?action=vaciar','class="button red medium') ?>
    <?php if($sf_user->getAttribute('id_projeto')):?>
        <?php echo button_to('Finalizar Compra &gt;&gt;', '@cart?action=processOrder','class="button red medium"') ?>
    <?php else: ?>
        <?php echo button_to('Selecione o projeto que receberá os recursos &gt;&gt;', '@cart?action=envio','class="button red medium"') ?>
    <?php endif; ?>
</div>

</form>

<?php endif; ?>
</div>
