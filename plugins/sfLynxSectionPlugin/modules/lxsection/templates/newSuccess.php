<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('lxsection/index') ?>"><?php echo __('Se&ccedil;&otilde;es')  ?> do <?php echo $nombreNucleo->getNameProfile() ?></a> - <?php echo __('Adicionar novo sess&atilde;o') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

