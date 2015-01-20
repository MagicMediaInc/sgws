<h1 class="icono_projeto"><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('tipoprojeto/index') ?>"><?php echo __('Tipos de Projetos')  ?></a> - <?php echo __('Adicionar novo tipo de projeto') ?> </h1>
<div id="title_module">
    <?php include_partial('form', array('form' => $form)) ?>
</div>

