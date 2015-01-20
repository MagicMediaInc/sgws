<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('pedido/index') ?>"><?php echo __('pedido')  ?></a> - <?php echo __('Adicionar novo pedido') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

