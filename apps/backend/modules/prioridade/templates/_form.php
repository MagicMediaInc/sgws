<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#prioridade").validationEngine()
})
</script>

<form id="prioridade" action="<?php echo url_for('prioridade/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_prioridade='.$form->getObject()->getIdPrioridade() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=prioridade&action=index&'.$sf_user->getAttribute('uri_prioridade'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew() && aplication_system::esUsuarioRoot()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'prioridade/delete?id_prioridade='.$form->getObject()->getIdPrioridade(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                      <td><?php echo $form['nome']->renderLabel() ?><br />
                        <?php echo $form['nome'] ?>
                        <?php echo $form['nome']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
