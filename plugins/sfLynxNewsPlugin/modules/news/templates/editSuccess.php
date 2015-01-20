<h1 class="icono_seguranca"><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('news/index') ?>" ><?php echo __('Notícias')  ?></a> - <?php echo __('Editar notícia') ?> </h1>
<div id="title_module">
  <?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php include_partial('form', array('form' => $form)) ?>
</div>
