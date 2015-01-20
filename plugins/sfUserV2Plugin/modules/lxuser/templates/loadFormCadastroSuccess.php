<?php if($sf_request->getParameter('type') == 2): ?>
    <?php include_partial('cadastroFisica',  array('form' => $form)) ?>
<?php elseif($sf_request->getParameter('type') == 3):?>
    <?php include_partial('cadastroJuridica',  array('form' => $form)) ?>
<?php endif; ?>

