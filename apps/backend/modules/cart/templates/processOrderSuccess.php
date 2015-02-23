<?php use_javascript('jq/jQuery.print.js') ?>
<script type="text/javascript">
    $(function() {
        $("#hrefPrint").click(function() {
        // Print the DIV.
        $("#printdiv").print();
        return (false);
        });
    });
</script>

<?php use_helper('Date') ?>
<?php use_stylesheet('cart.css') ?>
<style type="text/css">
    @import url("/css/main.css");
    @import url("/css/cart.css");
    
</style>
<div id="printdiv" class="printable">
<h1 class="icono_projeto">Meu carrinho de compras</h1>
<div id="internalContent">
        <div id="centercol" style="width: 98%; " >
            <?php if ($nbItemsCart > 0): ?>
                <?php if ($shopping_cart->isEmpty()): ?>
                <div id="" style="width: 98%; display: inline;" >
                    <h1><?php echo __('AGRADECEMOS A SUA COMPRA NA ENVIROMAQ.') ?></h1>
                    <h2><?php echo __('Seu pedido foi recebido com sucesso!') ?></h2>
                    <div style="font-weight: bold; font-size: 16px;">
                        <br />
                        Número do Pedido: <?php echo $sf_user->getAttribute('lastNumOrder') ?><br />

                    </div>
                    <div class="description" style="font-size: 11px; color: #222222;">
                      Utilize o número do pedido para acompanhar a sua compra.
                    </div>
                </div>
                <table style="width: 100%;margin-top: 25px">
                    <tr>
                        <td style="width: 10%;"><label>Data da Compra</label><br /><?php echo date("d-m-Y", strtotime($infoPedido['data_compra'])) ?></td>
                        <td style="width: 25%;"><label>Código do Projeto</label> <br /><?php echo $infoPedido['codigo_projeto'] ?> <?php echo $infoPedido['nome_projeto'] ?></td>
                        <td><label>Gerente Responsável </label><br /><?php echo $infoPedido['gerente'] ?> </td>
                    </tr>
                </table>
                <div class="cart" style="margin-top: 15px;">
                    <table id="cart" class="cart" cellspacing="0">
                    <caption>Seu resumo do pedido</caption>
                    <thead>
                    <tr>
                        <th align="left" class="firstColum"></th>
                        <th align="left"><?php echo __('Referência')?></th>
                        <th class="desc"><?php echo __('Descrição')?></th>
                        <th><?php echo __('Quantidade') ?></th>
                        <th align="right"><?php echo __('Valor unitário') ?></th>
                        <th align="right"><?php echo __('Valor total') ?></th>
                        <th class="lastColumn"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $nbArticles =  count($detailsOrder);  ?>
                    <?php $subtotal = 0; foreach($detailsOrder as $item): ?>
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
                        <td align="center"><?php echo $item['qty'] ?></td>
                        <td align="right"><?php echo $item['price'] ?></td>
                        <td align="right"><?php echo $total ?></td>
                        <td align="center" class="lastColumn">&nbsp;</td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr id="subtotal">
                            <td class="sum" colspan="5">Subtotal (<?php echo $nbArticles ?> itens):</td>
                            <td class="totales">$<?php echo $subtotal ?></td>
                            <td class="amt">&nbsp;</td>
                        </tr>
                        <tr id="total">
                            <td class="sum" colspan="5"><?php echo __('Grand Total') ?>:</td>
                            <td class="totales">$<?php echo $subtotal + $iva ?></td>
                            <td class="amt">&nbsp;</td>
                        </tr>
                    </tfoot>
                    </table>
                    </div>
                <?php else: ?>
                    <div class="msgErrorSystem">
                        <?php echo __('Você não selecionou nenhum produto para comprar.') ?>
                    </div>

                <?php endif; ?>
        <?php else: ?>
            <div class="msgErrorSystem">
                    Você não selecionou nenhum produto para comprar.
            </div>
            <div id="cart-foot" style="text-align: center; border: 0px; margin-top: 15px; ">
                <?php echo button_to('Voltar', '@default_index?module=producto','class="button red big"') ?>
            </div>
    <?php endif; ?>    
    </div>
    
</div>
<?php if ($nbItemsCart > 0): ?>
<div id="cart-foot" style="text-align: center; border: 0px;">
    <?php //echo link_to(__('PRINT ORDER'),'@default?module=orderemployee&action=printOrder&id_order='.$newOrder->getIdHeaderOrder(),'class="button white big" style="color:#333;"') ?>
    <?php echo button_to(__('Continuar Comprando'), '@homepage','class="button red small"') ?>
    
    <?php // echo link_to(__('LOGOUT'),'@default?module=lxlogin&action=close','class="button red big" style="top:0px; padding: 4px 14px;"');?>
</div>
<?php endif; ?>

</div>
<div class="space-print">
    <a href="#" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>
</div>