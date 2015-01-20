<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('album/index') ?>"><?php echo __('Álbum de fotos')  ?></a> - <?php echo __('Novo álbum de fotos') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

