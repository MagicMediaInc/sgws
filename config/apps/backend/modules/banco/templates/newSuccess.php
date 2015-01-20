<h1 class="icono_banco"><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('banco/index') ?>"><?php echo __('banco')  ?></a> - <?php echo __('Adicionar novo banco') ?> </h1>
<div id="title_module">
<?php include_partial('menu') ?>
<?php include_partial('form', array('form' => $form)) ?>
</div>

