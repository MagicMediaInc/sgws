<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#lxmodule").validationEngine()
})
</script>

<form id="lxmodule" action="<?php echo url_for('lxmodule/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_module='.$form->getObject()->getIdModule() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="center">
  <table width="100%">
      <tr>
        <td colspan="2">
            &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td colspan="2">
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Voltar na lista'), '@default?module=lxmodule&action=index&'.$sf_user->getAttribute('uri_lxmodule'), array('class' => 'button')) ?>
                        </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                        <?php if($form->getObject()->getDelete()):?>
                        <td>
                            <div class="button">
                                <?php echo link_to(__('Eliminar'), 'lxmodule/delete?id_module='.$form->getObject()->getIdModule(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                            </div>
                        </td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Save') ?>" />
                    </td>
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td colspan="2">
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Voltar na lista'), '@default?module=lxmodule&action=index&'.$sf_user->getAttribute('uri_lxmodule'), array('class' => 'button')) ?>
                        </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                        <?php if($form->getObject()->getDelete()):?>
                            <td>
                                <div class="button">
                                                    <?php echo link_to(__('Eliminar'), 'lxmodule/delete?id_module='.$form->getObject()->getIdModule(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                                 </div>
                            </td>
                        <?php endif; ?>
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
                      <td><?php echo $form['name_module']->renderLabel() ?><br />
                        <?php echo $form['name_module'] ?>
                        <?php echo $form['name_module']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['sf_module']->renderLabel() ?><br />
                        <?php echo $form['sf_module'] ?>
                        <?php echo $form['sf_module']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['credential']->renderLabel() ?><br />
                        <?php echo $form['credential'] ?>
                        <?php echo $form['credential']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['id_parent']->renderLabel() ?><br />
                        <?php echo $form['id_parent'] ?>
                        <?php echo $form['id_parent']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['delete']->renderLabel() ?><br />
                        <?php echo $form['delete'] ?>
                        <?php echo $form['delete']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
