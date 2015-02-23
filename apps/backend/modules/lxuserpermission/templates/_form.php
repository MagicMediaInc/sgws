<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#lxprofile").validationEngine()
})
</script>

<form id="lxprofile" action="<?php echo url_for('lxprofile/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_profile='.$form->getObject()->getIdProfile() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
        <td>
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td colspan="2">
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Voltar à lista'), $sf_request->getReferer(), array('class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php 
                    //El administrador se puede editar pero no se puede borrar
                    if (!$form->getObject()->isNew() and $form->getObject()->getIdProfile()!=2):
                    ?>

                    <td>
                        <div class="button">
                                <?php echo link_to(__('Eliminar'), 'lxprofile/delete?id_profile='.$form->getObject()->getIdProfile(), array('method' => 'Eliminar', 'confirm' => __('Are you sure you want to Eliminar the selected data?'), 'class' => 'button')) ?>
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
        <td colspan="2">
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Voltar à lista'), $sf_request->getReferer(), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                     <?php
                    //El administrador se puede editar pero no se puede borrar
                    if (!$form->getObject()->isNew() and $form->getObject()->getIdProfile()!=2):
                    ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'lxprofile/delete?id_profile='.$form->getObject()->getIdProfile(), array('method' => 'Eliminar', 'confirm' => __('Are you sure you want to Eliminar the selected data?'), 'class' => 'button')) ?>
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
                      <td><?php echo $form['name_profile']->renderLabel() ?> <span class="required">*</span><br />
                        <?php echo $form['name_profile'] ?>
                        <?php echo $form['name_profile']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['id_secretaria']->renderLabel() ?> <br />
                        <?php echo $form['id_secretaria'] ?>
                        <?php echo $form['id_secretaria']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
