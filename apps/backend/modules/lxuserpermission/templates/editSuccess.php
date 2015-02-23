<div id="title_module">
        <div class="frameForm" >
        <h1><?php //echo __($moduleParent['parent_name'])?>  <a href="<?php echo url_for('lxprofile/index') ?>" ><?php echo __('Núcleos')  ?></a> - <?php echo __('Editar Núcleo') ?> </h1>
        
        </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>
