<div id="renglon" style="min-height: 140px;">
    <div class="propiedades" >
        <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
        Listagem de<br />
        Pessoas
    </div>
    <div class="propiedades propiedades-extend" style="width: 450px; border-left: 1px #ccc dotted; height: 80px;">
        <?php if($sf_context->getActionName() == 'index' ): ?>
            <?php echo form_tag('banco/index',array('name' => 'bancos', 'id' => 'bancos','style'=>'margin:0px')) ?>
            <h2 class="titulo"><?php echo __('Consulta de Bancos') ?></h2>
            <br /><br />
            <input type="text" style="width: 290px;" name="buscador" id="funkystyling" />
            <input type="submit" name="search" id="busca" value="Buscar" />
            <br />
            <a href="<?php echo url_for('banco/index') ?> "><?php echo __('Veja todo') ?></a>
            </form>
        <?php endif;?>
    </div>
</div>
    