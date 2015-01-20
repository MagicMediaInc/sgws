<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#seguranca").validationEngine()
})
</script>

<form id="seguranca" action="<?php echo url_for('seguranca/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_log='.$form->getObject()->getIdLog() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
      <tr>
          <td>
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Voltar à lista'), '@default?module=seguranca&action=index&'.$sf_user->getAttribute('uri_seguranca'), array('class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Eliminar'), 'seguranca/delete?id_log='.$form->getObject()->getIdLog(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
    <tfoot>
      <tr>
        <td>
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=seguranca&action=index&'.$sf_user->getAttribute('uri_seguranca'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'seguranca/delete?id_log='.$form->getObject()->getIdLog(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                      <td><?php echo $form['id_user']->renderLabel() ?><br />
                        <?php echo $form['id_user'] ?>
                        <?php echo $form['id_user']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['ip']->renderLabel() ?><br />
                        <?php echo $form['ip'] ?>
                        <?php echo $form['ip']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['modulo']->renderLabel() ?><br />
                        <?php echo $form['modulo'] ?>
                        <?php echo $form['modulo']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['fecha']->renderLabel() ?><br />
                        <?php echo $form['fecha'] ?>
                        <?php echo $form['fecha']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['hora']->renderLabel() ?><br />
                        <?php echo $form['hora'] ?>
                        <?php echo $form['hora']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
