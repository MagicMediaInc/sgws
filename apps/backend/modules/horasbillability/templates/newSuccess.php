<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('horasbillability/index') ?>"><?php echo __('horasbillability')  ?></a> - <?php echo __('Adicionar novo horasbillability') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

