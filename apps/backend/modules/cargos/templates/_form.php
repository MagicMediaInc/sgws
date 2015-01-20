<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#cargos").validationEngine()
})
</script>

<form id="cargos" action="<?php echo url_for('cargos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=cargos&action=index&'.$sf_user->getAttribute('uri_cargos'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'cargos/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                              <tr>
                      <td><?php echo $form['meta']->renderLabel() ?><br />
                        <?php echo $form['meta'] ?>
                        <?php echo $form['meta']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
