<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#subtipo").validationEngine()
})
</script>

<form id="subtipo" action="<?php echo url_for('subtipo/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_subtipo='.$form->getObject()->getIdSubtipo() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
  <table width="100%">
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      
    <tfoot>
      <tr>
        <td>
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=subtipo&action=index&'.$sf_user->getAttribute('uri_subtipo'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew() && aplication_system::esUsuarioRoot()): ?>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Eliminar'), 'subtipo/delete?id_subtipo='.$form->getObject()->getIdSubtipo(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                  <tr>
                      <td>
                            <?php if($sf_request->hasParameter('id_subtipo')): ?>
                                <?php $id_sub= "'&id_subtipo=' + ".$sf_request->getParameter('id_subtipo'); ?>
                            <?php else: ?>
                                <?php $id_sub = "'&id_subtipo=' + this.form.id"; ?>
                            <?php endif; ?>
                            <?php echo $form['id_tipo_cadastro']->renderLabel() ?><br />
                            <?php echo $form['id_tipo_cadastro']->render(array('onchange' =>
                              jq_remote_function(array(
                                'update' => 'subtipo_parent',
                                'before' => '$("#subtipo_parent > option").remove(); $("#subtipo_parent").append("<option>Carregando...</option>");',
                                'url'    => 'ajax/getSubTiposByTipoCadastro',
                                'with'   => " 'id=' + this.value + ".$id_sub,
                              ))))
                            ?>
                            <?php echo $form['id_tipo_cadastro']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['id_parent']->renderLabel() ?><br />
                        <?php echo $form['id_parent'] ?>
                        <?php echo $form['id_parent']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['subtipo']->renderLabel() ?><br />
                        <?php echo $form['subtipo'] ?>
                        <?php echo $form['subtipo']->renderError() ?>
                    </td>
                  </tr>
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
