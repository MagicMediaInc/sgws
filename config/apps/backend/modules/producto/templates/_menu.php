<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
<?php $shopping_cart       = $sf_user->getShoppingCart(); ?>

<table width="100%" border="0" cellspacing="5" cellpadding="0" style="margin-top: 0px; border-bottom:  1px dotted #CCC; margin-bottom: 25px; padding-bottom: 15px;">
    <tr>
        <td >
            <a href="<?php echo url_for('@productos') ?>">
                <div class="opcoe-menu <?php echo $module == 'producto'  ? 'opcoe-menu-active' : '' ?>"  >
                <img src="/images/icons/list_pessoas.png"><br>
                Listagem de Produtos
                </div>
            </a>
            <a href="<?php echo url_for('@default?module=pedido&action=index') ?>">
                <div class="opcoe-menu <?php echo $module == 'pedido' && $action=='index' ? 'opcoe-menu-active' : '' ?>"  >
                    <?php echo image_tag('icons/articles') ?><br />
                    Meus Pedidos
                </div>
            </a>
            <?php if(aplication_system::esGerente()): ?>
                <a href="<?php echo url_for('@cart') ?>">
                    <div class="opcoe-menu <?php echo $module == 'cart' && $action=='index' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/car_shop') ?><br />
                        Carrinho (<?php echo $shopping_cart->getNbItems() ?>) items
                    </div>
                </a>
            <?php endif; ?>
        </td>
    </tr>
</table>

