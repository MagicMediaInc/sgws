<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#user_form").validationEngine()
})
</script>
<h1 class="icono_user"><a href="<?php echo url_for('lxuser/index') ?>"><?php echo __('Usuários')  ?></a> - <?php echo __('Adicionar novo usuário') ?> </h1>
<div id="title_module">
    <div id="renglon">
        <?php include_partial('menu') ?>
    </div>
    <form id="user_form" action="<?php echo url_for('lxuser/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_user='.$form->getObject()->getIdUser() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <div id="info_pessoais">
            <?php include_partial('form', array('form' => $form, 'html' => $html)) ?>
        </div>
    </form>
</div>

