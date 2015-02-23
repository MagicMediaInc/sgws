<?php
/*
    Document   : menu
    Created on : 23/03/2010, 11:29:47 AM
    Author     : hvallenilla
    Description:
        Menu Horizontal
*/

?>
<div id="topMenu" >
    <div id="myslidemenu" class="jqueryslidemenu">
        <?php echo html_entity_decode($html); ?>
        <div style="height: 23px; position: relative; top: -6px; right: 55px; float: right;">
        <?php if($notis > 0): ?>
        
            <a href="<?php echo url_for('@default_index?module=notificacion') ?>" >
                <?php echo image_tag('icons/bell','style="width: 17px;"') ?>
            </a>    
            <a href="<?php echo url_for('@default_index?module=notificacion') ?>" style="color: white; font-weight: bold; position: relative; top: -4px; font-size: 14px;">        
                <?php echo $notis ?>
            </a>
            <?php endif; ?>
        </div>
        <?php if($shopping_cart->getNbItems()> 0): ?>
        <div style="height: 23px; position: relative; top: -6px; right: 75px; float: right;">
            <a href="<?php echo url_for('@cart') ?>" style="color: white; font-weight: bold; position: relative; top: -4px; font-size: 14px;">        
            <?php echo image_tag('icons/cart_shoop') ?>
            </a>
            <a href="<?php echo url_for('@cart') ?>" style="color: white; font-weight: bold; position: relative; top: -18px; font-size: 14px;">        
            <?php echo $shopping_cart->getNbItems() ?>
            </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="float:none; clear:both;"></div>

