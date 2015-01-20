<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('lxmodule/index') ?>"><?php echo __('Módulos') ?></a> - <?php echo __('Novo Módulo') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

