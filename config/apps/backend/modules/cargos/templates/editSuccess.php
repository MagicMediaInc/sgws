<h1 class="icono_projeto"><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('cargos/index') ?>" ><?php echo __('Cargos')  ?></a> - <?php echo __('Editar cargo') ?> </h1>
<div id="title_module">
    <?php include_partial('form', array('form' => $form)) ?>
</div>
