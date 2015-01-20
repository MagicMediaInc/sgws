<div id="title_module">
        <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('seguranca/index') ?>" ><?php echo __('seguranca')  ?></a> - <?php echo __('Editar seguranca') ?> </h1>
        
        </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>
