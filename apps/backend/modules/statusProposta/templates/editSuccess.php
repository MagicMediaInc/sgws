<h1 class="icono_seguranca"><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('statusProposta/index') ?>" ><?php echo __('Status de Proposta')  ?></a> - <?php echo __('Editar Status') ?> </h1>
<div id="title_module">
    <?php include_partial('form', array('form' => $form)) ?>
</div>
