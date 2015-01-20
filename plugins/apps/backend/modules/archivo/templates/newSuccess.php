<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('archivo/index') ?>"><?php echo __('Arquivo')  ?></a> - <?php echo __('Novo arquivo') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

