<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      var href = $(location).attr('href');
      var res = href.substring(href.length - 2 , href.length);
      var idCodigoUltimo = $('#idCodigoUltimo').val();
      var suma = 0;
      suma = eval(idCodigoUltimo) + 1;
      if( $('#tcEmpresa').val() == 2){
        $("#cadastro_juridica_codigo_cliente").val("C"+suma);
        }else{
        $("#cadastro_juridica_codigo_cliente").val("F"+suma);
        }
      $("#user_form").validationEngine();
})
</script>
<input type="hidden" id="idCodigoUltimo" value="<?php echo $lastCodigoCliente?>">
<input type="hidden" id="tcEmpresa" value="<?php echo $sf_user->getAttribute('tc_empresa')?>">
<h1 class="icono_user"><a href="<?php echo url_for('lxuser/index') ?>"><?php echo __('Usuários')  ?></a> - 
    <?php echo __('Adicionar novo ').($sf_user->getAttribute('tc_empresa') == 2 ? 'Cliente' : 'Fornecedor' ) ?> 
</h1>
<div id="title_module">
    <div id="renglon">
        <?php include_partial('menuCliente') ?>
    </div>
    <form id="user_form" action="<?php echo url_for('lxuser/'.($form->getObject()->isNew() ? 'createJuridico' : 'update').(!$form->getObject()->isNew() ? '?id_user='.$form->getObject()->getIdUser() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <div id="info_pessoais">
            <?php include_partial('formCliente', array('form' => $form, 'html' => $html)) ?>
        </div>
    </form>
</div>

