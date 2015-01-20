<h1 class="tit-principal">
    INFORMAÇÕES DO PROJETO <?php echo $tit ?>
</h1>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php include_partial('form', array('form' => $form,'edit' => $edit, 'responsables' => $responsables)) ?>
